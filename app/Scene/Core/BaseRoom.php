<?php

namespace App\Scene\Core;

use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\Bot\Scene;
use App\Models\User;

class BaseRoom
{

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
        $name= mb_substr($name, 0, 25);
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
            $this->user = User::find($request->user_id);
        }

        if (!$scene) {
            $scene = new Scene();
            $scene->user_id = $this->user->id;
            $scene->className = (new \ReflectionClass($this))->getName();
            $scene->step = 0;

            $scene->sceneData = $this->data;
            $scene->save();
            $this->user->scene_id = $scene->id;
            $this->user->save();
        }

        $this->scene = $scene;

        $this->request = $request;
        $this->response = new BotResponseStructure();

    }

    public function NextStep()
    {
        return $this->SetStep($this->scene->step + 1);
    }

    public function SetRoom($roomName, $data = []): BotResponseStructure
    {
        if (is_object($roomName)) {
            $this->DeleteRoom();

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

        $this->DeleteRoom();

        /** @var BaseRoom $sceneRoom */
        $sceneRoom = new $roomName($this->request);

        if (!empty($data)) {
            foreach ($data as $K => $V) $sceneRoom->scene->SetData($K, $V);
            $sceneRoom->scene->save();
        }

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
    public function Handle()
    {
        $this->response->message = "Кажется у нас ошибка!";
        $this->response->btns = [
            'Повтор' => 1
        ];

        return $this->response;
    }


}
