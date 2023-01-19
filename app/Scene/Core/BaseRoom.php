<?php

namespace App\Scene\Core;

use App\Library\ProgressBarEmoji;
use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\Bot\Scene;
use App\Models\User;

class BaseRoom
{

    public $usePlayerHeader = true;

    public $roomType = "scene";
    public $name = "Базовая сцена";
    public BotResponseStructure $response;
    public BotRequestStructure $request;
    public User $user;
    public Scene $scene;
    public array $data = [];

    public function IsBtn($name)
    {
        return $this->request->message == $name;
    }


    public function AddButton($name, $isNewLine = false)
    {
        if (!$name) return false;
        $name = mb_substr($name, 0, 25);
        if (isset($this->response->btns[$name])) {
            $name .= ' #2';
        }
        $this->response->AddButton($name, $isNewLine);

        return $this->IsBtn($name);
    }

    public function __construct(BotRequestStructure $request, Scene $scene = null)
    {


        if (isset($request->user)) {
            $this->user = $request->user;
        } else {
            dd("НЕТ ПОЛЬЗОВАТЕЛЯ!");
        }

        if (!$scene) {
            $scene = new Scene();
            $scene->user_id = $this->user->id;
            $scene->className = (new \ReflectionClass($this))->getName();
            $scene->step = 0;
            $scene->sceneData = $this->data;
            $scene->save();
        }

        $this->scene = $scene;

        $this->request = $request;
        $this->response = new BotResponseStructure();

    }

    public function NextStep()
    {
        return $this->SetStep($this->scene->step + 1);
    }

    public function PrevStep()
    {
        return $this->SetStep($this->scene->step - 1);
    }

    /**
     * Перенестись в другую команту. Либо создать и перенестись в неё по классу
     * @param mixed|string|class-string $roomName класс команты либо его название
     * @param array $data дата которую нужно вставить в данные комнаты
     * @param bool $isOverModal открыть комнату поверх текущей, типа не удалять
     * @return BotResponseStructure
     */
    public function SetRoom($roomName, $data = [], $isOverModal = false): BotResponseStructure
    {
        if (is_object($roomName)) {
            if (!$isOverModal) $this->DeleteRoom();

            if (!empty($data)) {
                foreach ($data as $K => $V) $roomName->scene->SetData($K, $V);
                $roomName->scene->save();
            }

            return $roomName->Handle();
        }

        $roomName = $roomName . '';

        if (!class_exists($roomName)) {
            $this->response->Reset()->AddWarning("Ошибка перехода сцен.");
            return $this->response;
        }

        if (!$isOverModal) $this->DeleteRoom();

        /** @var BaseRoom $sceneRoom */
        $sceneRoom = new $roomName($this->request);

        if (!empty($data)) {
            if (isset($data['step'])) $sceneRoom->scene->step = $data['step'];
            foreach ($data as $K => $V) $sceneRoom->scene->SetData($K, $V);
            $sceneRoom->scene->save();
        }

        $this->request->message = "";

        return $sceneRoom->Handle();
    }

    public function DeleteRoom()
    {
        $this->scene->delete();
    }

    public function SetStep($step): BotResponseStructure
    {
        $this->scene->step = $step;
        $this->scene->save();
        $this->request->message = "";
        $this->response->Reset();
        return $this->Handle();
    }

    public function GetStep()
    {
        return $this->scene->step;
    }

    /**
     * @return BotResponseStructure
     */
    public function Route()
    {
        $routes = [];
        foreach (get_class_methods($this) as $V) {
            if (strpos($V, "Step") !== 0) continue;
            $id = str_replace("Step", "", $V);
            $id = intval(substr($id, 0, 1));
            $routes[$id] = $V;
        }

        if (!isset($routes[0])) {
            throw new \Exception('Нет функции Step0_NAME без неё комната не запустится! В ' . __CLASS__);
        }

        if (!isset($routes[$this->GetStep()])) {
            return null;
        }

        $fun = $routes[$this->GetStep()];
        return $this->$fun();
    }


    /**
     * Запустить таймер на столько то секунд
     * @param $seconds
     * @return void
     */
    public function StartTimer($seconds)
    {
        $this->scene->timer_from = time();
        $this->scene->timer_to = time() + $seconds;
        $this->scene->save();
    }

    /**
     * Обратный отсчет сколько осталось до конца таймера
     * @return string
     */
    public function GetTimerFormat()
    {
        $text = " " . ($this->scene->timer_to - time()) . ' сек.';
        $percent = max(0, ($this->scene->timer_to - time())) / ($this->scene->timer_to - $this->scene->timer_from);
        $text .= "\n" . ProgressBarEmoji::Console(1 - $percent, 9);
        return $text;
    }

    /**
     * Стандартный ответ. Если включен таймер выводится этот ответ. Оверайд его что бы кастомизировать.
     * @return \App\Library\Structure\BotResponseStructure
     */
    public function TimerResponse()
    {
        $this->response->Reset();
        $this->response->message = "Осталось " . $this->GetTimerFormat();
        $this->response->AddButton("Обновить");

        return $this->response;
    }

    public function IsTimer()
    {
        return ($this->scene->timer_to ?? 0) > time();
    }

    /**
     * Эта функция вызывается перед вызовом Handle. В ней можно подгрузить нужные чарактеры например или обработать что-то
     * @return void
     */
    public function Boot()
    {

    }

    /**
     * @return BotResponseStructure
     */
    public function Handle()
    {
        $this->Boot();
        if ($this->IsTimer()) return $this->TimerResponse();

        if ($this->scene->timer_to > 0) {
            $this->scene->timer_to = 0;
            $this->scene->timer_from = 0;
            $this->scene->save();
        }

        $response = $this->Route();

        if ($response) {

            if ($this->user->player && !$response->issetHeader) {
                $response->issetHeader = true;

                if ($this->usePlayerHeader) {
                    $response->message = $this->user->player->GetHeader() . $response->message;
                }
            }
        }

        return $response;
    }


}
