<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\GarageCharacter;
use App\Characters\PlayerCharacter;
use App\Characters\Shop;
use App\Characters\Shop\CarItemCharacterShop;
use App\Helpers\PaginationHelper;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;
use App\Models\Bot\ItemCharacterShop;
use App\Models\Bot\Scene;
use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\ShopRoom;
use App\Scene\Core\SkillRoom;
use Illuminate\Support\Facades\Log;

class StoRoom extends BaseRoomPlus
{

    public ?CarCharacter $car;
    private ?Shop\StoShop $stoShop;


    public static function FilterCarByTarifData($cars, $tarif)
    {
        $cars = $cars->filter(function (CarCharacter $car) use ($tarif) {
            if ($car->characterData->price < $tarif['carPrice']) return false;
            if ($car->GetHpPercent() * 100 < $tarif['carHp']) return false;
            return true;
        });
        return $cars;
    }

    public function Step0_StoList()
    {
        $this->response->Reset();
        $this->response->message = "Вот какие СТО доступны для машины " . $this->car->GetName();
        $this->response->message .= $this->car->RenderStats();


        $stats = $this->car->GetStatsCalculate();

        $stoList = Shop\StoShop::GetItmes();


        $isRedirect = $this->PaginateCollection($stoList, 6, function (Shop\StoShop $stoItem) use ($stats) {

            if ($stats->hp->value < $stoItem->characterData->repairToValue) {


                $canRepairCount = $stoItem->characterData->repairToValue - $stats->hp->value;

                $priceRepair = $canRepairCount * ($stoItem->characterData->price / 100) * $this->car->GetPriceOneHpRepair();

                $this->response->message .= "\n\n  " . $stoItem->name . ': ';
                //$this->response->message .= "\n 💵 Ценн " . number_format($tarif['carPrice']) . '₽ ';
                $this->response->message .= "\n ⚙ Ремонт до: " . number_format($stoItem->characterData->repairToValue) . ' HP. ';
                $this->response->message .= "\n 💵 Сделает ремонт за : " . number_format($priceRepair) . ' ₽ ';

                if ($this->user->player->characterData->money > $priceRepair) {
                    if ($this->AddButton($stoItem->name)) {
                        $this->scene->SetData("stoId", $stoItem->id);
                        return $this->SetStep(1);
                    }

                }

            }
        });

        if ($isRedirect) return $isRedirect;


        if ($this->AddButton("Выход")) {
            $this->DeleteRoom();
            return null;
        }

        return $this->response;
    }

    public function Step1_Approve()
    {

        $this->response->Reset()->message = $this->stoShop->icon . ' ' . $this->stoShop->name;
        $this->response->message .= "\n " . $this->user->player->GetStats()->money->RenderLine(false);
        $this->response->message .= "\n\n " . $this->car->Render(true);

        foreach ((array)$this->stoShop->characterData as $K => $statka) {
            if ($K == 'price') continue;
            /** @var StatStructure $statka */
            $this->response->message .= "\n" . $this->stoShop->GetStatsStruct()->$K->RenderLine(false, true);
        }

        $stoItem = $this->stoShop;
        $stats = $this->car->GetStatsCalculate();
        if ($stats->hp->value < $stoItem->characterData->repairToValue && $stats->hp->value<$stats->hp->max) {

            $canRepairCount = $stoItem->characterData->repairToValue - $stats->hp->value;
            $priceRepair = $canRepairCount * ($stoItem->characterData->price / 100) * $this->car->GetPriceOneHpRepair();
            $this->response->message .= "\n\n 🔷 Услуга Ремонт:";
            $this->response->message .= "  💵 " . number_format($priceRepair) . ' ₽ ';

            if ($this->user->player->characterData->money > $priceRepair) {
                if ($this->AddButton("Ремонт")) {
                    $this->user->player->characterData->money -= $priceRepair;
                    $this->user->player->save();
                    $this->request->message = "";
                    $this->request->marker = "Ремонт";
                    $this->car->characterData->hp = $stoItem->characterData->repairToValue;
                    $this->car->save();
                    return $this->Handle()->AddWarning("Ремонт выполнен", true);
                }
            }
        }

        if ($this->AddButton("Назад")) {
            return $this->PrevStep();
        }

        return $this->response;
    }


    public function Step3_Taxi()
    {
        $this->response->Reset();
        $this->response->message = "Работа выполнена! \n";

        $tarif = self::tarifs[$this->scene->sceneData['tarif']];
        $this->response->message .= $this->user->player->AddMoney($tarif['money']);
        $this->response->message .= $this->user->player->AddExpa($tarif['expa']);
        $this->response->message .= "\n\n" . $this->user->player->GetStats()->money->RenderLine(false);

        $this->response->message .= "\n\n" . $this->car->GetName() . "  " . $this->car->Damage(3);

        $this->car->save();
        $this->user->player->save();


        $this->scene->step = 1;
        $this->scene->save();

        $this->response > $this->AddButton("Ок!");

        return $this->response;
    }


    public function Boot()
    {

        if (isset($this->scene->sceneData['stoId'])) {
            $this->stoShop = $stoList = Shop\StoShop::FindById($this->scene->sceneData['stoId']);
        }

        if ($this->scene->sceneData['id'] ?? false) {
            $this->car = CarCharacter::LoadCharacterById($this->scene->sceneData['id']);
        }
    }

    public function Route()
    {
        if ($this->GetStep() == 0) return $this->Step0_StoList();
        if ($this->GetStep() == 1) return $this->Step1_Approve();
        if ($this->GetStep() == 2) return $this->Step1_Approve();
        if ($this->GetStep() == 3) return $this->Step3_Taxi();

        return $this->response;
    }


}
