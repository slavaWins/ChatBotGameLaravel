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

    public \App\Models\Bot\Character $car;

    public function Step0_Show()
    {
        $this->response->Reset();


        $this->response->message = "Вы смотрите машину: " . $this->car->GetName();

        $this->response->message .= "\n " . $this->car->RenderStats(false, false, true);

        if ($this->AddButton("Назад")) {
            $this->DeleteRoom();
            return null;
        }

        if ($this->AddButton("Перегнать")) {
            return $this->SetStep(2);
        }

        if ($this->AddButton("Таксовать")) {
            return $this->SetRoom(WorkRoom::class,['step'=>1]);
        }

        if ($this->AddButton("На СТО")) {
            return $this->SetRoom(StoRoom::class, ['id'=>$this->car->id]);
        }

        return $this->response;
    }

    public function Step1_Show()
    {

    }

    public function Step2_MoveToGarage()
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
                $this->car->parent_id = $item->id;
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


    public function Route()
    {
        $this->car = CarCharacter::LoadCharacterById($this->scene->sceneData['id']);
        if ($this->GetStep() == 0) return $this->Step0_Show();
        if ($this->GetStep() == 1) return $this->Step1_Show();
        if ($this->GetStep() == 2) return $this->Step2_MoveToGarage();

        return $this->response;
    }


}
