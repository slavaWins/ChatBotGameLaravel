<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\GarageCharacter;
use App\Characters\PlayerCharacter;
use App\Characters\Shop;
use App\Characters\Shop\CarItemCharacterShop;
use App\Helpers\PaginationHelper;
use App\Models\Bot\ItemCharacterShop;
use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\ShopRoom;
use App\Scene\Core\SkillRoom;

class GarageRoom extends BaseRoomPlus
{

    public function Step0_List()
    {
        $this->response->Reset();

        if ($this->AddButton("Купить гараж")) {
            $room = ShopRoom::CreateShopRoomByCharacterType($this->user, GarageCharacter::class, Shop\GarageItemCharacterShop::class);
            return $this->SetRoom($room, null, true);
        }


        $this->response = $this->RenderMyCharactersList(GarageCharacter::class, "Мои гаржи", 1);


        return $this->response;
    }


    public function Step1_Show()
    {
        $this->response->Reset();

        $car = GarageCharacter::LoadCharacterById($this->scene->sceneData['id']);


        $this->response->message = "Вы смотрите гараж: " . $car->icon . ' ' . $car->name;

        $this->response->message .= "\n " . $car->RenderStats(false, false, true);

        if ($this->AddButton("Улчшить гараж")) {
            $room = SkillRoom::CreateSkillRoomByCharacter($this->user, $car);
            return $this->SetRoom($room);
        }


        if ($this->AddButton("Назад")) {
            return $this->SetStep(0);
        }

        if ($this->AddButton("Выход")) {
            return $this->SetRoom(HomeRoom::class);
        }

        return $this->response;
    }

    public function Step2_Info()
    {
    }


    public function Handle()
    {
        if ($this->GetStep() == 0) return $this->Step0_List();
        if ($this->GetStep() == 1) return $this->Step1_Show();
        if ($this->GetStep() == 2) return $this->Step2_Info();

        return $this->response;
    }


}
