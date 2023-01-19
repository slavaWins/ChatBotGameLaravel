<?php

namespace App\BotTutorials;

use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\Bot\Scene;
use App\Models\User;
use App\Scene\Core\BaseRoom;
use App\Scene\GarageRoom;
use App\Scene\RegistrationRoom;
use SlavaWins\EasyAnalitics\Library\EasyAnaliticsHelper;

class BotTutorialBase
{

    public BaseRoom $room;
    public BotRequestStructure $request;
    public User $user;
    public BotResponseStructure $response;
    public string $roomClass;
    public int $step;
    public Scene $sceneCurrent;


    public function IsScene($scene)
    {

        if ($this->sceneCurrent) {
            if ($this->sceneCurrent->className == $scene) return true;
        }

        //if (get_class($this->room) == $scene) return true;
        return false;
    }

    public function RemoveExitBtns()
    {
        $this
            ->RemoveBtn("Выход")
            ->RemoveBtn("< Назад")
            ->RemoveBtn("Назад");
        return $this;
    }

    public function RemoveBtn($text)
    {
        if (isset($this->response->btns[$text])) {
            unset($this->response->btns[$text]);
        }
        return $this;
    }

    public function AddMessage($text)
    {
        $this->response->message .= "\n\n ‼️  " . $text;
        return $this;
    }


    public function Stop()
    {
        $this->user->tutorial_step = 0;
        $this->user->tutorial_class = null;
        $this->user->save();
    }

    public function NextStep()
    {
        $this->step++;
        $this->user->tutorial_step++;
        $this->user->save();
    }


    public function OnlyBtn($name)
    {
        $ok = false;
        foreach ($this->response->btns as $K => $V) {
            if ($K == $name) {
                $ok = true;
                break;
            }
        }
        if ($ok) foreach ($this->response->btns as $K => $V) {
            if ($K != $name) {
                unset($this->response->btns[$K]);
            }
        }
    }

    public function Handle(): BotResponseStructure
    {
        return $this->response;
    }

    public static function Run(User $user, BaseRoom $room, BotRequestStructure $request, BotResponseStructure $response): BotResponseStructure
    {
        $className = get_called_class();

        $sceneCurrent = $user->scene();

        /** @var BotTutorialBase $tutorial */
        $tutorial = new $className();
        $tutorial->user = $user;
        $tutorial->step = $user->tutorial_step ?? 0;
        $tutorial->room = $room;
        $tutorial->sceneCurrent = $sceneCurrent;
        $tutorial->request = $request;
        $tutorial->response = $response;
        $tutorial->roomClass = get_class($room);

        if ($tutorial->roomClass == RegistrationRoom::class) {
            return $response;
        }


        if ($tutorial->request->message == "Закончить обучение!") {
            EasyAnaliticsHelper::Increment("tutorial_exit", 1, "Остановил тутуориал",  "Пользователь остановил обучающий туториал.");
            $user->tutorial_class = null;
            $user->tutorial_step = 0;
            $user->save();
            return $response;
        }

        $response = $tutorial->Handle();

        if(!$tutorial->room->IsTimer()) {
            $tutorial->response->AddButton("Закончить обучение");
        }

        if ($tutorial->request->message == ("Закончить обучение")) {
            $response->btns = [];
            $response->message = "Вы уверены что хотите закончить обучение? \n\n В игре много интересных вещей которые мы хотели бы показать.";
            $tutorial->response->AddButton("Закончить обучение!");
            $tutorial->response->AddButton("Продолжить обучение...");
        }

        return $response;
    }
}
