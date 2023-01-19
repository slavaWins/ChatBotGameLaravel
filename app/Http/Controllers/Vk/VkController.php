<?php


namespace App\Http\Controllers\Vk;


use App\BotTutorials\StartTutorial;
use App\Http\Controllers\Bot\BotLogicController;
use App\Http\Controllers\Controller;
use App\Library\Structure\BotRequestStructure;
use App\Library\Vk\VkAction;
use App\Models\ResponseApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use SlavaWins\EasyAnalitics\Library\EasyAnaliticsHelper;
use Throwable;


class VkController extends Controller
{


    const secret = "j4qZJJ5d5mtxakY86kV1UqNtm6tM3wIw_arwdwAM1FhsYzaLA";
    const group_id = 98092574;
    const confirmation_token = "2f7a85a6";
    const token = "vk1.a.c20tV0uMRbk2CnmHr4VVJPN-cq69ExOEScuCPc8NA8S1-H2lRJb-y7CHl8e3AuZraAVx5Ow9KG8Pk53bjhZPFSFzFMuvjv6IGjd8QLjFgI9HdhlRgp7inPL0InPqRHNxTbWV3pFGUsILQPIZNjNgQgBRqw9ppn4fSvSZLLurI1G74V73a3RrU25JBe6cczocYZ-0Nw8TPPEeO6tONNJDAg";

    public function VkEvent(Request $request)
    {
        $validator = Validator::make(
            $request->toArray(),
            [
                'group_id' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
                'type' => 'required|string|min:1|max:120',
                'secret' => 'required|string|min:1',
            ],
            [
            ],
            [
            ]
        );

        if ($validator->fails()) {
            return ResponseApi::Error($validator->errors()->first());
        }

        if ($request['secret'] <> self::secret) {
            return ResponseApi::Error("bad token");
        }


        $actionType = $request['type'] ?? "none";

        if ($request['type'] == "confirmation") {
            return self::confirmation_token;
        }

        if ($request['type'] == "message_new") {
            $data = $request['object']['message'];
            $from_id = $data['from_id'];
            $text = $data['text'];
            $dateUnix = $data['date'];

            $user = User::where("vk_id", $from_id)->first();
            if (!$user) {
                $user = new User();
                $user->vk_id = $from_id;
                $user->name = "Игрок";
                $user->tutorial_class = StartTutorial::class . '';
                $user->tutorial_step = 0;
                $user->save();

                EasyAnaliticsHelper::Increment("user_new", 1, "Новый пользователь", "Новый пользователь впервые написал боту");
                EasyAnaliticsHelper::Increment("user_new_vk", 1, "Новый пользователь VK", "Новый пользователь с ВК");
            }

            if ($user->last_message_time > $dateUnix) {
                die("ok");
            }

            $user->last_message_time = $dateUnix;
            $user->save();


            $botRequest = new BotRequestStructure();
            $botRequest->message = $text;
            $botRequest->user = $user;
            $botRequest->messageFrom = 'vk';

            $botLogic = new BotLogicController();
            $botResponse = $botLogic->Message($user, $botRequest);


            VkAction::SendMessage($from_id, $botResponse->message, $botResponse->btns, $botResponse->attach_sound ?? null);

            try {
                BotLogicController::MakeSceneTimerCronAction();
            } catch (Throwable  $e) {
                return false;
            }


            die("ok");
        }

        Log::info($request);

        die("ok");
    }


}
