<?php

namespace App\Http\Controllers\Bot;


use App\BotTutorials\BotTutorialBase;
use App\BotTutorials\StartTutorial;
use App\Http\Controllers\Controller;
use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Library\Vk\VkAction;
use App\Models\Bot\History;
use App\Models\Bot\Scene;
use App\Models\User;
use App\Scene\Core\BaseRoom;
use App\Scene\HomeRoom;
use App\Scene\RegistrationRoom;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use SlavaWins\EasyAnalitics\Library\EasyAnaliticsHelper;
use Throwable;


/**
 * @property BaseRoom $sceneRoom
 */
class BotLogicController extends Controller
{
    public $repeatNullResponse = 0; //количество возвратов null в респонсе
    private User $user;
    public ?History $history;

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

        if ($this->user->player) {
            $text .= "\n\n Player: ";
            $text .= "\n UserId: " . $this->user->id;
            $text .= "\n bot:test " . $this->user->id;
            $text .= "\n  " . json_encode($this->user->player->characterData);
        }

        return $text;

    }

    /**
     * @param User $user
     * @param BotRequestStructure $botRequestStructure
     * @return BotResponseStructure
     */
    public function Message(User $user, BotRequestStructure $botRequestStructure, $isSaveBtns = true, $isSaveHistory = true)
    {
        $textFromRequest = $botRequestStructure->message;
        $botRequestStructure->user = $user;

        if ($botRequestStructure->message == "...") EasyAnaliticsHelper::Increment("btn_empty", 1, "Пустая кнопка", "Пользователю была предложена пустая кнопка - многоточие.");


        $this->user = $user;

        $response = new BotResponseStructure();
        $response->message = "ERROR BOT";

        $userScene = $user->scene() ?? null;

        if (!$userScene) {
            $response->message = "У вас нет сцены";


            Scene::where("user_id", $user->id)->delete();

            $scene = null;
            if ($user->is_registration_end) {
                $scene = new HomeRoom($botRequestStructure);
            } else {
                $scene = new RegistrationRoom($botRequestStructure);
            }
            $userScene = $user->scene();


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
        $cnm = $userScene->className;
        $sceneRoom = null;

        if (!class_exists($cnm)) {

            $response->Reset()
                ->AddWarning("Ошибка. Бот не может найти игровую сцену " . $userScene->className)
                ->AddButton("Исправить");

            $userScene->delete();

        } else {

            $sceneRoom = new $cnm($botRequestStructure, $userScene);
            $this->sceneRoom = $sceneRoom;

            $response = $sceneRoom->Handle();

        }

        if ($response == null) {
            $this->repeatNullResponse += 1;

            if ($this->repeatNullResponse > 2) {
                Scene::where("user_id", $user->id)->delete();
                $response = new BotResponseStructure();
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

        if($isSaveBtns) {
            if ($botRequestStructure->messageFrom == "local") {
                $user->buttons = $response->btns;
                $user->save();
            }
        }

        if($isSaveHistory) {
            /** @var History $history */
            $history = new History();
            $history->user_id = $user->id;
            $history->message = $textFromRequest;
            $history->message_response = $response->message;
            $history->attachment_sound = $response->attach_sound ?? null;
            $history->isFromBot = false;
            if ($user->player) {
                $history->money = $user->player->characterData->money;
            }
            $history->save();
            $this->history = $history;
        }

        return $response;
    }


    public function SceneTimerCronAction()
    {
        try {
            BotLogicController::MakeSceneTimerCronAction();
        } catch (Throwable  $e) {
            return false;
        }
    }

    public static function MakeSceneTimerCronAction()
    {
        /** @var Scene[] $scenes */
        $scenes = Scene::where("timer_to", ">", 0)->where("timer_to", "<", time())->limit(3)->get();
        if (!count($scenes)) return null;

        foreach ($scenes as $scene) {
            $cnm = $scene->className;
            if (!class_exists($cnm)) continue;

            $botRequestStructure = new BotRequestStructure();
            $botRequestStructure->user = User::find($scene->user_id);
            $botRequestStructure->user_id = $botRequestStructure->user->id;

            /** @var BaseRoom $sceneRoom */
            $sceneRoom = new $cnm($botRequestStructure, $scene);
            //        $sceneRoom->scene->timer_to = 0;
            //          $sceneRoom->scene->timer_from = 0;
            //         $sceneRoom->scene->save();
            $response = $sceneRoom->Handle();


            /** @var History $history */
            $history = new History();
            $history->user_id = $botRequestStructure->user->id;
            $history->message = "CRON";
            $history->message_response = $response->message;
            $history->attachment_sound = $response->attach_sound ?? null;
            $history->isFromBot = false;
            if ($botRequestStructure->user->player) {
                $history->money = $botRequestStructure->user->player->characterData->money;
            }
            $history->save();

            if ($botRequestStructure->user->vk_id) {
                VkAction::SendMessage($botRequestStructure->user->vk_id, $response->message, $response->btns, $response->attach_sound ?? null);
            }

            echo "x";
        }


    }

}
