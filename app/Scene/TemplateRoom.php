<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\EnginePartCharacter;
use App\Scene\Core\BaseRoomPlus;

class TemplateRoom extends BaseRoomPlus
{

    public ?CarCharacter $car;

    /**  @var EnginePartCharacter $items */
    public $items = [];


    public function Step0_List()
    {
        $this->response->Reset();
        $this->response->message = "Выберите машину:";


        $this->items = $this->user->GetAllCharacters(CarCharacter::class);
        $selectCharacter = $this->PaginateSelector($this->items);

        if (count($this->items) == 1) {
            $selectCharacter = $this->items->first();
        } elseif (count($this->items) == 0) {
            $this->response->AddWarning("У вас нет подходящей машины");
        }

        if ($selectCharacter) {
            $this->scene->SetData('id', $selectCharacter->id);
            return $this->NextStep();
        }

        if ($this->AddButton("Назад")) {
            $this->DeleteRoom();
            return null;
        }

        return $this->response;
    }


    public function Step1_Show()
    {
        $this->response->Reset();

        $this->response->message = "Хотите начать гонку?";
        $this->response->message .= "\n" . $this->car->Render(true);


        if ($this->AddButton("Выход")) {
            $this->DeleteRoom();
            return null;
        }

        return $this->response;
    }


    public function Step2_Info()
    {
        $this->response->Reset();

        if ($this->AddButton("Выход")) {
            $this->DeleteRoom();
            return null;
        }

        if ($this->AddButton("Назад")) {
            return $this->PrevStep();
        }

        return $this->response;
    }


    function Boot()
    {
        if ($this->scene->sceneData['id'] ?? false) {
            $this->car = CarCharacter::LoadCharacterById($this->scene->sceneData['id']);
        }
    }


}
