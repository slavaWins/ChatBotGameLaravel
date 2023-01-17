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

class CarRoom extends BaseRoomPlus
{

    public function Step0_List()
    {
        $this->response->Reset();

        if ($this->AddButton("Купить машину")) {
            $room = ShopRoom::CreateShopRoomByCharacterType($this->user, CarCharacter::class, CarItemCharacterShop::class);
            return $this->SetRoom($room, null, true);
        }


        $this->response = $this->RenderMyCharactersList(CarCharacter::class, "Мои машины", 1);


        return $this->response;
    }


    public function Step1_Show()
    {
        $this->response->Reset();

        $car = CarCharacter::LoadCharacterById($this->scene->sceneData['id']);


        $this->response->message = "Вы смотрите машину: " . $car->icon . ' ' . $car->name;

        $this->response->message .= "\n " . $car->RenderStats(false, false, true);

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
