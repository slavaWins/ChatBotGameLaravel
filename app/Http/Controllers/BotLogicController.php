<?php

namespace App\Http\Controllers;


use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\History;
use App\Models\Scene;
use app\Models\Trash\BaseRow;
use App\Models\User;
use App\Scene\BaseRoom;
use App\Scene\RegistrationRoom;
use Illuminate\Http\Request;
use App\Models\ResponseApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ParagonIE\Sodium\Core\Curve25519\H;


class BotLogicController extends Controller
{

    public static function Logic(User $user, $message)
    {
        $response = new BotResponseStructure();
        $response->message = "Не могу ответить";

        if ($message == "name") {
            $response->message = "Ваше имя: " . $user->name;
            $response->btns = [];
            $response->btns['Начать'] = 6;
            $response->btns['💵'] = 6;
            return $response;
        }

        if ($message == "n") {
            $response->message = "Ваше имя: " . $user->name;
            $response->btns['Ок'] = 12;
        }

        if ($message == "/a") {
            $response->message = "У вас нет таких прав";
            $response->btns['< Назад'] = 12;
        }

        return $response;

    }

    /**
     * @param User $user
     * @param BotRequestStructure $botRequestStructure
     * @return BotResponseStructure
     */
    public function Message(User $user, BotRequestStructure $botRequestStructure)
    {

        $response = new BotResponseStructure();
        $response->message = "ERROR BOT";


        if ($user->scene_id == 0 || !$user->scene) {
            $response->message = "У вас нет сцены";

            $scene = new RegistrationRoom($botRequestStructure);
            $user = User::find($user->id);
        }

        /** @var BaseRoom $sceneRoom */
        $cnm = "\App\Scene\\NoClassGavna";

        if ($user->scene) {
            $cnm =   $user->scene->className;
        }

        if (!class_exists($cnm)) {

            $response->Reset()
                ->AddWarning("Ошибка. Бот не может найти игровую сцену " . $user->scene->className)
                ->AddButton("Исправить");

            Scene::where("user_id", $user->id)->delete();

        } else {

            $sceneRoom = new $cnm($botRequestStructure, $user->scene);
            $response = $sceneRoom->Handle();

        }

        if (count($response->btns) == 0) {
            $response->AddButton("...");
        }
        $user->buttons = $response->btns;
        $user->save();

        return $response;
    }


}
