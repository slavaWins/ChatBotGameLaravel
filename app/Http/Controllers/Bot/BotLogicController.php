<?php

namespace App\Http\Controllers\Bot;


use App\Http\Controllers\Controller;
use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\Bot\Scene;
use App\Models\User;
use App\Scene\BaseRoom;
use App\Scene\HomeRoom;
use App\Scene\RegistrationRoom;


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

            $isSceneId = $user->scene_id>0;
            Scene::where("user_id", $user->id)->delete();

            $scene = null;
            if ($user->is_registration_end) {
                $scene = new HomeRoom($botRequestStructure);
            } else {
                $scene = new RegistrationRoom($botRequestStructure);
            }
            $user->refresh();

            if($isSceneId) {
                $response->Reset()
                    ->AddWarning("Ошибка бота. Потеряна игровая сцена. Сейчас ошибка будет автоматически исправлена.")
                    ->AddButton("Исправить");
                $user->buttons = $response->btns;
                $user->save();
                return $response;
            }
        }

        /** @var BaseRoom $sceneRoom */
        $cnm = "\App\Scene\\NoClassGavna";

        if ($user->scene) {
            $cnm = $user->scene->className;
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
