<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\GarageCharacter;
use App\Characters\PlayerCharacter;
use App\Characters\Shop;
use App\Characters\Shop\CarItemCharacterShop;
use App\Characters\WorkbenchCharacter;
use App\Helpers\PaginationHelper;
use App\Models\Bot\Character;
use App\Models\Bot\ItemCharacterShop;
use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\ShopRoom;
use App\Scene\Core\SkillRoom;
use App\Services\InventoryCharacterService;

class GarageRoom extends BaseRoomPlus
{

    public ?GarageCharacter $garage;

    public function Step0_List()
    {
        $this->response->Reset();

        if ($this->AddButton("Арендовать гараж")) {
            $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  Shop\GarageItemCharacterShop::class);
            return $this->SetRoom($room, null, true);
        }


        $this->response = $this->RenderMyCharactersList(GarageCharacter::class, "Мои гаржи", 1);


        return $this->response;
    }


    public function Step1_Show()
    {
        $this->response->Reset();


        $this->response->message = "Вы в гараже: \n " . $this->garage->GetName();

        $this->response->message .= "\n " . $this->garage->RenderStats(false, true, true);
        $this->response->message .= "\n". $this->garage->RenderAppend(false);


        if ($this->AddButton("Верстаки")) {
            return $this->SetStep(2);
        }


        if ($this->AddButton("Машины")) {
            return $this->SetStep(3);
        }

        if ($this->AddButton("Назад")) {
            return $this->SetStep(0);
        }

        if ($this->AddButton("Аренда")) {
            return $this->SetStep(4);
        }

        if ($this->AddButton("Выход")) {
            return $this->SetRoom(HomeRoom::class);
        }

        return $this->response;
    }

    public function Step2_Workbrencs()
    {
        $this->response->Reset();

        if ($this->garage->GetFreeSlotsCount()) {
            if ($this->AddButton("Купить верстак")) {
                $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  Shop\WorkbenchShop::class, $this->scene->sceneData['id']);
                return $this->SetRoom($room, null, true);
            }
        }

        /** @var WorkbenchCharacter[] $items */
        $items = collect($this->user->GetAllCharacters(WorkbenchCharacter::class))->filter(function ($item) {
            return $item->parent_id == $this->scene->sceneData['id'];
        });

        $this->response->message = $this->garage->GetName();
        $this->response->message .= "\n Верстаки в гараже" . " (" . (count($items)) . " шт): \n";

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
            return $this->SetStep(1);
        }


        return $this->response;
    }


    public function Step3_Cars()
    {
        $this->response->Reset();


        if ($this->garage->GetFreeSlotsCount()) {
            if ($this->AddButton("Купить машину")) {
                $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  CarItemCharacterShop::class, $this->scene->sceneData['id']);
                return $this->SetRoom($room, null, true);
            }
        }


        /** @var CarCharacter[] $items */
        $items = collect($this->user->GetAllCharacters(CarCharacter::class))->filter(function ($item) {
            return $item->parent_id == $this->scene->sceneData['id'];
        });

        $this->response->message = $this->garage->GetName();

        $this->response->message .= "\n Машины в этом гараже" . " (" . (count($items)) . " шт):  ";

        $isRedirect = $this->PaginateCollection($items, 4, function ($item) {
            $this->response->message .= "\n\n" . $item->Render(true, false, false);

            if ($this->AddButton($item->name ?? $item->baseName)) {
                return $this->SetRoom(CarRoom::class, ['id' => $item->id], true);
            }

        });

        if ($isRedirect) return $isRedirect;


        if ($this->AddButton("< Назад")) {
            return $this->SetStep(1);
        }

        return $this->response;
    }

    public function Step4_Rent()
    {
        $this->response->Reset();
        $this->response->message = "Этот гараж в аренде. \n";
        $this->response->message .= $this->garage->GetStatsCalculate()->price->RenderLine(false, true);


        $inner = $this->garage->GetChildldren();
        if ($inner->count()) {
            $this->response->message .= "\n\n Сейчас в этом гараже находится техника. " . $inner->count() . " шт.";

            $this->response->message .= "\n\n Переместить технику в другие гаражи?";


            if ($this->AddButton("Переместить")) {

                $try = InventoryCharacterService::MoveItemsForOtherCharacters($this->user, $inner, GarageCharacter::class, $this->garage->id);

                if ($try) {
                    return $this->response->AddWarning("Все вещи с гаража были перенесены в другие гаражи", true);
                } else {
                    return $this->response->AddWarning("Не удалось перенести все вещи.");
                }
            }

        } else {
            $this->response->message .= "\n\n Гараж пустой.";

            if ($this->AddButton("Съехать")) {
                $this->garage->delete();
                return $this->SetStep(0);
            }

        }

        if ($this->AddButton("< Назад")) {
            return $this->SetStep(1);
        }


        return $this->response;
    }

    public function Route()
    {
        if ($this->GetStep() > 0) {
            $this->garage = GarageCharacter::LoadCharacterById($this->scene->sceneData['id'] ?? 0);

            if (!$this->garage) {
                $this->SetStep(0);
            }
        }

        if ($this->GetStep() == 0) return $this->Step0_List();
        if ($this->GetStep() == 1) return $this->Step1_Show();
        if ($this->GetStep() == 2) return $this->Step2_Workbrencs();
        if ($this->GetStep() == 3) return $this->Step3_Cars();
        if ($this->GetStep() == 4) return $this->Step4_Rent();

        return $this->response;
    }


}
