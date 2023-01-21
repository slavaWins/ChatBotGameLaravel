<?php

namespace App\Http\Controllers\Bot\Dev;


use App\BotTutorials\StartTutorial;
use App\Http\Controllers\Bot\BotLogicController;
use App\Http\Controllers\Controller;
use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\Bot\Character;
use App\Models\Bot\History;
use App\Models\ResponseApi;
use App\Models\Bot\Scene;
use App\Models\User;
use App\Services\Bot\ResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class MessageBoxController extends Controller
{


    public function SendMessage(Request $request)
    {

        $validator = Validator::make($request->toArray(),
            [
                'text' => 'required|string|min:1',
            ]);

        if ($validator->fails()) {
            return ResponseApi::Error($validator->errors()->first());
        }

        /** @var User $user */
        $user = Auth::user();

        $data = $validator->validate();

        $botRequest = new BotRequestStructure();
        $botRequest->message = $data['text'];
        $botRequest->messageFrom = 'local';


        $botLogic = new BotLogicController();
        $botResponse = $botLogic->Message($user, $botRequest);


        $html = "Нет ответа";
        /** @var History $history */
        $history = $botLogic->history ?? null;
        if ($history) {
            $html = view("messagebox.mess", compact('history', 'user'));
        }

        if ($request->has('onlytext')) {
            return nl2br($botResponse->message);
        }

        $buttons = $user->buttons;
        //  $buttons = ['xz'=>3];

        $buttons_html = view("messagebox.keyboard", compact('buttons')) . ' ';
        // return $buttons_html;

        $debugInfoBot = nl2br($botLogic->GetDebugInfo());

        return ResponseApi::Data(
            [
                'debugInfoBot' => $debugInfoBot,
                'buttons_html' => $buttons_html,
                'html' => $html . '',
            ]
        );
    }

    public function Resetuser()
    {

        /** @var User $user */
        $user = Auth::user();
        ResetService::UserRestContent($user);
        return redirect()->back();
    }

    public static function MakeAutoTest(User $user, $countRepeats = 8, $writeHistrory = false)
    {

        $response = new BotResponseStructure();
        $response->AddButton("Начать");

        for ($i = 1; $i < $countRepeats; $i++) {

            $botLogic = new BotLogicController();
            $botRequest = new BotRequestStructure();

            $mess = "Начать";
            if (!empty($response->btns) && count($response->btns) > 0) {
                $option = [];
                foreach ($response->btns as $K => $V) if ($K <> "Закончить обучение") $option[] = $K;


                if (count($option) > 1) {
                    $mess = $option[rand(0, count($option) - 1)];
                } else {
                    $mess = $option[0] ?? "Нет вариантов";
                }
            }

            $botRequest->message = $mess;
            $botRequest->messageFrom = 'local';
            $response = $botLogic->Message($user, $botRequest, $writeHistrory, $writeHistrory);

            if ($botLogic->sceneRoom) {
                if ($botLogic->sceneRoom->IsTimer()) {
                    $botLogic->sceneRoom->scene->timer_from = 0;
                    $botLogic->sceneRoom->scene->timer_to = 0;
                    $botLogic->sceneRoom->scene->save();
                    $mess = "[QA Bot] Я офнул таймер!";
                    //$response = $botLogic->Message($user, $botRequest);
                    //return redirect()->back();
                }
            }


            unset($botRequest);
        }


        return "Теперь у игрока: " . number_format($user->player->characterData->money) . " RUB ";
    }

    public function AutoTest()
    {

        $response = new BotResponseStructure();
        $response->AddButton("Начать");
        /** @var User $user */
        $user = Auth::user();

        self::MakeAutoTest($user, 10, true);

      //  return "OK";
        return redirect()->back();
    }

    public function ClearHistory()
    {
        $user = Auth::user();
        History::where('user_id', $user->id)->delete();
        return redirect()->back();
    }

    public function index()
    {

        //  Auth::user()->GetBasketShortData();

        $user = Auth::user();

        $historys = History::where('user_id', $user->id)->orderByDesc('id')->limit(30)->get()->reverse();
        return view('messagebox.index', compact('historys', 'user'));

    }


}
