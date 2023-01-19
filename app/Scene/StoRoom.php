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

    const  tarifs = [
        'ameran' => [
            'name' => "Стошка у Азамата",
            'price' => 1,
            'repairToValue' => 30,
        ],
        'mid' => [
            'name' => "СТО Последний день",
            'price' => 1.2,
            'repairToValue' => 38,
        ],
        'comfortPlus' => [
            'name' => "СТО ПРЕМИУМ",
            'price' => 3,
            'repairToValue' => 130,
        ],
    ];


    public static function FilterCarByTarifData($cars, $tarif)
    {
        $cars = $cars->filter(function (CarCharacter $car) use ($tarif) {
            if ($car->characterData->price < $tarif['carPrice']) return false;
            if ($car->GetHpPercent() * 100 < $tarif['carHp']) return false;
            return true;
        });
        return $cars;
    }

    public function Step0_Show()
    {
        $this->response->Reset();
        $this->response->message = "Вот какие СТО доступны для машины " . $this->car->GetName();
        $this->response->message .= $this->car->RenderStats();


        //$cars = $this->user->GetAllCharacters(CarCharacter::class);
        $stats = $this->car->GetStatsCalculate();
        foreach (self::tarifs as $K => $tarif) {
            // $tarifs[$K]['cars'] = self::FilterCarByTarifData($cars, $tarif);

            if ($stats->hp->value > $tarif['repairToValue']) continue;


            $canRepairCount = $stats->hpMax->value - $stats->hp->value;
            $priceRepair = $canRepairCount * $tarif['price'] * $this->car->GetPriceOneHpRepair();

            $this->response->message .= "\n\n  " . $tarif['name'] . ': ';
            //$this->response->message .= "\n 💵 Ценн " . number_format($tarif['carPrice']) . '₽ ';
            $this->response->message .= "\n ⚙ Ремонт до: " . number_format($tarif['repairToValue']) . ' HP. ';
            $this->response->message .= "\n 💵 Сделает ремонт за : " . number_format($priceRepair) . ' ₽ ';

            if ($this->user->player->characterData->money > $priceRepair) {
                if ($this->AddButton($tarif['name'])) {

                }

            }
        }


        if ($this->AddButton("Выход")) {
            $this->DeleteRoom();
            return null;
        }

        return $this->response;
    }

    public function Step2_SelectCar()
    {
        $tarif = self::tarifs[$this->scene->sceneData['tarif']];

        $this->response->Reset()->message = "Выберите машину для такси:";

        $cars = $this->user->GetAllCharacters(CarCharacter::class);
        $cars = self::FilterCarByTarifData($cars, $tarif);


        $selectCharacter = $this->PaginateSelector($cars);

        if (count($cars) == 1) {
            $selectCharacter = $cars->first();
        }

        if ($selectCharacter) {
            $this->StartTimer(6);

            $this->scene->SetData('id', $selectCharacter->id);
            return $this->NextStep();
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
        if ($this->scene->sceneData['id'] ?? false) {
            $this->car = CarCharacter::LoadCharacterById($this->scene->sceneData['id']);
        }
    }

    public function Route()
    {
        if ($this->GetStep() == 0) return $this->Step0_Show();
        if ($this->GetStep() == 1) return $this->Step0_Show();
        if ($this->GetStep() == 2) return $this->Step2_SelectCar();
        if ($this->GetStep() == 3) return $this->Step3_Taxi();

        return $this->response;
    }


}
