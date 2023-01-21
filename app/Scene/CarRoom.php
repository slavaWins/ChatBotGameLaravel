<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\GarageCharacter;
use App\Characters\PlayerCharacter;
use App\Characters\Shop;
use App\Characters\Shop\CarItemCharacterShop;
use App\Helpers\PaginationHelper;
use App\Models\Bot\ItemCharacterShop;
use App\Models\Bot\Scene;
use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\ShopRoom;
use App\Scene\Core\SkillRoom;

class CarRoom extends BaseRoomPlus
{

    public CarCharacter $car;

    public function Step0_Show()
    {
        $this->response->Reset();


        $this->response->message = "Вы смотрите машину: " . $this->car->GetName();

        $this->response->message .= "\n \n " . $this->car->Render(false, false, true);

        if ($this->AddButton("Назад")) {
            $this->DeleteRoom();
            return null;
        }

        if ($this->AddButton("Перегнать")) {
            return $this->SetStep(2);
        }

        if ($this->AddButton("Запчасти")) {
            return $this->SetStep(2);
        }

        if ($this->AddButton("Таксовать")) {
            return $this->SetRoom(WorkRoom::class, ['step' => 1]);
        }

        if ($this->AddButton("На СТО")) {
            return $this->SetRoom(StoRoom::class, ['id' => $this->car->id]);
        }

        return $this->response;
    }


    public function Step1_MoveToGarage()
    {

        /** @var CarCharacter[] $items */
        $items = collect($this->user->GetAllCharacters(GarageCharacter::class))->filter(function (GarageCharacter $item) {
            if ($this->car->parent_id == $item->id) return false;
            return $item->GetChildldren()->count() < $item->characterData->storage_size;
        });

        $this->response->message = "В какой гараж вы хотите перегнать " . $this->car->GetName() . " ? \n";

        if (!$items->count()) {
            return $this->SetStep(0)->AddWarning("У вас нет свободных гаражей!");
        }

        $isRedirect = $this->PaginateCollection($items, 4, function (GarageCharacter $item) {
            $this->response->message .= "\n\n В " . $item->Render(true, false, false);

            if ($this->AddButton($item->name ?? $item->baseName)) {
                $this->car->SetParent( $item->id);
                $this->car->save();

                /** @var Scene $garage */
                $garage = Scene::where('user_id', $this->user->id)->where("className", GarageRoom::class)->first();
                if ($garage) {
                    $garage->SetData("id", $item->id)->save();
                }

                return $this->SetStep(0)->AddWarning("Вы перегнали машину в другой гараж.", true);
            }

        });

        if ($isRedirect) return $isRedirect;


        if ($this->AddButton("Назад")) {
            return $this->SetStep(0);
        }
        return $this->response;


    }


    public function Step2_Parts()
    {

        $this->response->Reset();

        if ($this->car->GetEngineParts()->count() > 0) {
            $this->response->message = "Какую запчасть вы хотите снять?";
        } else {
            $this->response->message = "В машине не установлено модификаций.";
        }

        $select = $this->PaginateSelector($this->car->GetEngineParts());

        if ($select) {
            $select->SetParent( 0);
            $select->save();
            $this->request->message="";

            $this->response->AddWarning("Запчасть снята.", true);
            $this->_selectorData=null;
            return $this->Handle();
        }

        if ($this->AddButton("Назад")) {
            return $this->SetStep(0);
        }

        if ($this->AddButton("Установить")) {
            return $this->SetRoom(EnginePartRoom::class, ['id' => $this->car->id], true);
        }

        return $this->response;

    }

    public function Boot()
    {
        $this->car = CarCharacter::LoadCharacterById($this->scene->sceneData['id']);
    }


}
