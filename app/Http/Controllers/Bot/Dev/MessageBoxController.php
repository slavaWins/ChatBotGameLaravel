<?php

namespace App\Http\Controllers\Bot\Dev;


use App\Http\Controllers\Bot\BotLogicController;
use App\Http\Controllers\Controller;
use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\Bot\Character;
use App\Models\Bot\History;
use App\Models\ResponseApi;
use App\Models\Bot\Scene;
use App\Models\User;
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
        $botRequest->user_id = $user->id;
        $botRequest->messageFrom = 'local';


        $botLogic = new BotLogicController();
        $botResponse = $botLogic->Message($user, $botRequest);

        if($request->has('onlytext')){
            return nl2br($botResponse->message);
        }

        /** @var History $history */
        $history = new History();
        $history->user_id = Auth::user()->id;
        $history->message = $data['text'];
        $history->isFromBot = false;
        $history->save();

        $html = view("messagebox.mess", compact('history', 'user'));

        $history = new History();
        $history->user_id = Auth::user()->id;
        $history->message = $botResponse->message;
        $history->attachment_sound = $botResponse->attach_sound ?? null;
        $history->isFromBot = true;
        $history->save();
        $html .= view("messagebox.mess", compact('history', 'user'));


        $buttons = $user->buttons;
        //  $buttons = ['xz'=>3];

        $buttons_html = view("messagebox.keyboard", compact('buttons')) . ' ';
        // return $buttons_html;


        return ResponseApi::Data(
            [
                'buttons_html' => $buttons_html,
                'html' => $html,
            ]
        );
    }

    public function Resetuser()
    {

        /** @var User $user */
        $user = Auth::user();
        History::where('user_id', $user->id)->delete();
        Character::where('user_id', $user->id)->delete();
        Scene::where('user_id', $user->id)->delete();
        $user->scene_id = 0;
        $user->is_registration_end = false;
        $user->save();
        return redirect()->back();
    }

    public function AutoTest()
    {

        $response = new BotResponseStructure();
        $response->AddButton("Начать");
        /** @var User $user */
        $user = Auth::user();
        for ($i = 1; $i < 20; $i++) {

            $botLogic = new BotLogicController();
            $botRequest = new BotRequestStructure();

            $mess = "Начать";
            if (!empty($response->btns) && count($response->btns) > 0) {
                $option = [];
                foreach ($response->btns as $K => $V) $option[] = $K;

                if (count($option) > 1) {
                    $mess = $option[rand(0, count($option) - 1)];
                } else {
                    $mess = $option[0];
                }
            }

            $botRequest->message = $mess;
            $botRequest->user_id = $user->id;
            $botRequest->messageFrom = 'local';
            $response = $botLogic->Message($user, $botRequest);
            $user->refresh();

            /** @var History $history */
            $history = new History();
            $history->user_id = Auth::user()->id;
            $history->message = $mess;
            $history->isFromBot = false;
            $history->save();


            $history = new History();
            $history->user_id = Auth::user()->id;
            $history->message = $response->message;
            $history->attachment_sound = $response->attach_sound ?? null;
            $history->isFromBot = true;
            $history->save();


            unset($botRequest);
        }

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
