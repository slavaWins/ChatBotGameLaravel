<?php

namespace App\Http\Controllers\Bot;


use App\BotTutorials\BotTutorialBase;
use App\BotTutorials\StartTutorial;
use App\Http\Controllers\Controller;
use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\Bot\History;
use App\Models\Bot\Scene;
use App\Models\User;
use App\Scene\Core\BaseRoom;
use App\Scene\HomeRoom;
use App\Scene\RegistrationRoom;
use Illuminate\Support\Facades\Auth;
use SlavaWins\EasyAnalitics\Library\EasyAnaliticsHelper;


/**
 * @property BaseRoom $sceneRoom
 */
class BotLogicController extends Controller
{
    public $repeatNullResponse = 0; //количество возвратов null в респонсе
    private User $user;
    public History $history;

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

    public function GetDebugInfo(): string
    {
        if (!$this->sceneRoom) {
            return "НЕТ КОМНАТЫ";
        }
        $text = "";
        $text .= " " . get_class($this->sceneRoom);
        $text .= "\n Название: " . $this->sceneRoom->name;
        $text .= "\n roomType: " . $this->sceneRoom->roomType;
        $text .= "\n ID: " . ($this->sceneRoom->scene->id ?? "N/A");
        $text .= "\n step: " . ($this->sceneRoom->scene->step ?? "N/A");

        if ($this->sceneRoom->scene) {
            if ($this->sceneRoom->scene->sceneData) {
                $text .= "\n sceneData: \n " . json_encode($this->sceneRoom->scene->sceneData);
            }
        }


        $text .= "\n\n Туториал: ";
        $text .= "\n Этап: " . ($this->user->tutorial_step ?? "НЕТ");
        $text .= "\n Класс: " . ($this->user->tutorial_class ?? "НЕТ");

        return $text;

    }

    /**
     * @param User $user
     * @param BotRequestStructure $botRequestStructure
     * @return BotResponseStructure
     */
    public function Message(User $user, BotRequestStructure $botRequestStructure)
    {
        $textFromRequest = $botRequestStructure->message;

        if ($botRequestStructure->message == "Назад") EasyAnaliticsHelper::Increment("btn_back", 1, "Пользователь нажал - назад");
        if ($botRequestStructure->message == "Перегнать") EasyAnaliticsHelper::Increment("peregon", 1, "Пользователь перегнал тачку");
        if ($botRequestStructure->message == "Закончить обучение") EasyAnaliticsHelper::Increment("tutorial_stop", 1, "Попытался заончить обучение");


        $this->user = $user;

        $response = new BotResponseStructure();
        $response->message = "ERROR BOT";


        if (!$user->scene()) {
            $response->message = "У вас нет сцены";


            Scene::where("user_id", $user->id)->delete();

            $scene = null;
            if ($user->is_registration_end) {
                $scene = new HomeRoom($botRequestStructure);
            } else {
                $scene = new RegistrationRoom($botRequestStructure);
            }
            $user->refresh();


            if ($user->is_registration_end) {
                $response->Reset()
                    ->AddWarning("Ошибка бота. Потеряна игровая сцена. Сейчас ошибка будет автоматически исправлена.")
                    ->AddButton("Исправить");
            }

            if ($botRequestStructure->messageFrom == "local") {
                $user->buttons = $response->btns;
                $user->save();
            }
            //  return $response;
        }

        /** @var BaseRoom $sceneRoom */
        $cnm = $user->scene()->className;
        $sceneRoom = null;

        if (!class_exists($cnm)) {

            $response->Reset()
                ->AddWarning("Ошибка. Бот не может найти игровую сцену " . $user->scene()->className)
                ->AddButton("Исправить");

            $user->scene()->delete();

        } else {

            $sceneRoom = new $cnm($botRequestStructure, $user->scene());
            $this->sceneRoom = $sceneRoom;

            $response = $sceneRoom->Handle();

        }

        if ($response == null) {
            $this->repeatNullResponse += 1;
            if ($this->repeatNullResponse > 2) {
                Scene::where("user_id", $user->id)->delete();
                return $response->Reset()
                    ->AddWarning("Ошибка бота. Бот ушел в бесконечный цикл. Сейчас бот попробует исправить проблему самостоятельно. ")
                    ->AddButton("Исправить проблему");
            }
            return $this->Message($user, $botRequestStructure);
        }

        if ($user->tutorial_class) {
            if (class_exists($user->tutorial_class)) {
                $response = $user->tutorial_class::Run($user, $sceneRoom, $botRequestStructure, $response);
            }
        }

        if (count($response->btns) == 0) {
            $response->AddButton("...");
        }


        if ($botRequestStructure->messageFrom == "local") {
            $user->buttons = $response->btns;
            $user->save();
        }

        /** @var History $history */
        $history = new History();
        $history->user_id = $user->id;
        $history->message = $textFromRequest;
        $history->message_response = $response->message;
        $history->attachment_sound = $botResponse->attach_sound ?? null;
        $history->isFromBot = false;
        $history->save();
        $this->history = $history;

        return $response;
    }


}
