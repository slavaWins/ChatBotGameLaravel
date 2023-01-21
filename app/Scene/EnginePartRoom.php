<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\EnginePartCharacter;
use App\Characters\Shop\EnginePartShop;
use App\Characters\WorkbenchCharacter;
use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\ShopRoom;

class EnginePartRoom extends BaseRoomPlus
{

    public $usePlayerHeader = false;
    public ?EnginePartCharacter $partEngine;


    /**  @var EnginePartCharacter $items */
    public $items = [];
    private ?CarCharacter $car = null;


    public function Step0_List()
    {
        $this->response->Reset();
        $this->response->message = "Ваш склад запчастей:";
        if($this->car){
            $this->response->message = "\n Что установить в ".$this->car->GetName();
        }


        $this->items = $this->user->GetAllCharacters(EnginePartCharacter::class);
        $this->items = $this->items->filter(function ($item) {
            return $item->parent_id == 0;
        });

        $selectCharacter = $this->PaginateSelector($this->items);

        if (count($this->items) == 1) {
            // $selectCharacter = $this->items->first();
        } elseif (count($this->items) == 0) {
            $this->response->AddWarning("У вас нет запчастей");
        }

        if ($selectCharacter) {
            $this->scene->SetData('partId', $selectCharacter->id);
            return $this->NextStep();
        }


        if ($this->AddButton("Купить")) {
            $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  EnginePartShop::class);
            return $this->SetRoom($room, null, true);
        }

        if ($this->AddButton("Выход")) {
            $this->DeleteRoom();
            return null;
        }

        return $this->response;
    }


    public function Step1_Info()
    {
        //Если в комнату зашли сразу под тачку
        if ($this->car) {
            return $this->NextStep();
        }

        $this->response->Reset();
        $this->response->message .= $this->partEngine->GetName() . " - Куда установить? \n\n";

        $cars = $this->user->GetAllCharacters(CarCharacter::class);
        $selectCharacter = $this->PaginateSelector($cars, true);

        if (count($cars) == 0) {
            $this->response->AddWarning("Нет подходящих машин");
        }

        if ($selectCharacter) {
            $this->scene->SetData('id', $selectCharacter->id);
            return $this->NextStep();
        }

        if ($this->AddButton("Отмена")) {
            $this->DeleteRoom();
            return null;
        }

        if ($this->AddButton("Назад")) {
            return $this->PrevStep();
        }

        return $this->response;
    }

    public function Step2_PlaceCar()
    {
        if(!$this->car){
            $this->DeleteRoom();
            return null;
        }
        $this->response->Reset();
        $this->response->message .= "Установить " . $this->partEngine->GetName()
            . " в  " . $this->car->GetName() . "\n\n";
        $this->response->message .= $this->car->Render(true, true) . "   \n\n";


        $otherPart = $this->car->IssetEnginePart($this->partEngine->characterData->partType);

        if ($otherPart) {
            $this->response->message .= "\n\n В машине установлена другая деталь. Она будет заменена:";
            $this->response->message .= "\n " . $otherPart->characterData->partType;
            $this->response->message .= "\n\n " . $otherPart->name . ' | ' . $this->partEngine->name;
            foreach ($this->partEngine->characterData as $K => $V) {
                if ($otherPart->GetStats()->$K->is_hidden_property) continue;
                $this->response->message .= "\n " . $otherPart->GetStats()->$K->RenderLine(true) . ' | ' . $this->partEngine->GetStats()->$K->RenderLine(true);
            }
        }

        if ($this->AddButton("Установить")) {
            if ($otherPart) {
                $otherPart->parent_id = 0;
                $otherPart->save();
            }
            $this->partEngine->parent_id = $this->car->id;
            $this->partEngine->save();
            return $this->SetStep(0)->AddWarning("Деталь установлена!", true);
        }


        if ($this->AddButton("Назад")) {
            $this->scene->SetData('id', 0);
            $this->scene->save();
            $this->car =null;
            return $this->PrevStep();
        }

        if ($this->AddButton("Выход")) {
            $this->DeleteRoom();
            return null;
        }

        return $this->response;
    }


    function Boot()
    {
        if ($this->scene->sceneData['id'] ?? false) {
            $this->car = CarCharacter::LoadCharacterById($this->scene->sceneData['id']) ?? null;
        }

        if ($this->scene->sceneData['partId'] ?? false) {
            $this->partEngine = EnginePartCharacter::LoadCharacterById($this->scene->sceneData['partId']);
        }
    }


}
