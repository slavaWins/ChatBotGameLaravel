<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\GarageCharacter;
use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\SkillRoom;

class TemplateRoom extends BaseRoomPlus
{

    public ?CarCharacter $car;


    public function Step0_List()
    {
        $this->response->Reset();
        $this->response->message = "Выберите машину:";


        $cars = $this->user->GetAllCharacters(CarCharacter::class);
        $selectCharacter = $this->PaginateSelector($cars);

        if (count($cars) == 1) {
            $selectCharacter = $cars->first();
        } elseif (count($cars) == 0) {
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
