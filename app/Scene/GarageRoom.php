<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\GarageCharacter;
use App\Characters\PlayerCharacter;
use App\Characters\Shop;
use App\Characters\Shop\CarItemCharacterShop;
use App\Characters\WorkbenchCharacter;
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


        $this->response->message = "Вы смотрите гараж: " . $car->GetName();

        $this->response->message .= "\n " . $car->RenderStats(false, true, true);
        $this->response->message .=  $car->RenderAppend(false);



        if ($this->AddButton("Верстаки")) {
            return $this->SetStep(2);
        }


        if ($this->AddButton("Назад")) {
            return $this->SetStep(0);
        }

        if ($this->AddButton("Выход")) {
            return $this->SetRoom(HomeRoom::class);
        }

        return $this->response;
    }

    public function Step2_Workbrencs()
    {
        $this->response->Reset();

        if ($this->AddButton("Купить верстак")) {
            $room = ShopRoom::CreateShopRoomByCharacterType($this->user, WorkbenchCharacter::class, Shop\WorkbenchShop::class, $this->scene->sceneData['id']);
            return $this->SetRoom($room, null, true);
        }

        /** @var WorkbenchCharacter[] $items */
        $items = collect($this->user->GetAllCharacters(WorkbenchCharacter::class))->filter(function ($item) {
            return $item->parent_id == $this->scene->sceneData['id'];
        });

        $this->response->message = "Верстаки в гараже" . " (" . (count($items)) . " шт): \n";

        $isRedirect = $this->PaginateCollection($items, 4, function ($item) {
            $this->response->message .= "\n\n" . $item->Render(true, false, false);


            if ($this->AddButton($item->name ?? $item->baseName)) {
                // $this->scene->SetData('id', $item->id);
                // $this->scene->save();
                return $this->SetStep(1);
            }

        });

        if ($isRedirect) return $isRedirect;


        if ($this->AddButton("< Назад")) {
            return $this->SetStep($this->scene->step - 1);
        }


        return $this->response;
    }


    public function Handle()
    {
        if ($this->GetStep() == 0) return $this->Step0_List();
        if ($this->GetStep() == 1) return $this->Step1_Show();
        if ($this->GetStep() == 2) return $this->Step2_Workbrencs();

        return $this->response;
    }


}
