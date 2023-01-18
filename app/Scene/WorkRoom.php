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

class WorkRoom extends BaseRoomPlus
{

    public \App\Models\Bot\Character $car;

    const  tarifs = [
        'eco' => [
            'name' => "Эконом",
            'money' => 1400,
            'expa' => 1,
            'carPrice' => 12000,
            'carHp' => 5,
            'cars' => [],
        ],
        'comfort' => [
            'name' => "Комфорт",
            'money' => 2600,
            'expa' => 2,
            'carPrice' => 38000,
            'carHp' => 50,
            'cars' => [],
        ],
        'comfortPlus' => [
            'name' => "Комфорт+",
            'money' => 3100,
            'expa' => 4,
            'carPrice' => 48000,
            'carHp' => 65,
            'cars' => [],
        ],
    ];

    public function Step0_Show()
    {
        $this->response->Reset();


        $this->response->message = "И так надо подзаработать.";

        if ($this->AddButton("Такси")) {
            $this->SetStep(1);
            return null;
        }

        if ($this->AddButton("Назад")) {
            $this->DeleteRoom();
            return null;
        }

        return $this->response;
    }

    public static function FilterCarByTarifData($cars, $tarif)
    {
        $cars = $cars->filter(function (CarCharacter $car) use ($tarif) {
            if ($car->characterData->price < $tarif['carPrice']) return false;
            if ($car->GetHpPercent() * 100 < $tarif['carHp']) return false;
            return true;
        });
        return $cars;
    }

    public function Step1_Show()
    {
        $this->response->Reset();
        $this->response->message = "Для такси требуются машины";


        $cars = $this->user->GetAllCharacters(CarCharacter::class);

        foreach (self::tarifs as $K => $tarif) {
            $tarifs[$K]['cars'] = self::FilterCarByTarifData($cars, $tarif);

            $this->response->message .= "\n\n Для тарифа " . $tarif['name'] . ': ';
            $this->response->message .= "\n 💵 Нужна машина от " . number_format($tarif['carPrice']) . '₽ ';
            $this->response->message .= "\n ⚙ В состояние не меньше: " . number_format($tarif['carHp']) . '% ';

            if (!$tarifs[$K]['cars']->count()) {
                $this->response->message .= "\n У вас нет подходящей машины.";
            } else {
                $this->response->message .= "\n 🚘 Подходит машин: " . $tarifs[$K]['cars']->count() . ' шт.';

                if ($this->AddButton($tarif['name'])) {
                    $this->scene->SetData("tarif", $K);
                    return $this->NextStep();
                }

            }
        }


        if ($this->AddButton("Назад")) {
            return $this->PrevStep();
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
        $this->response->message = "Работа выполнена!";

        $tarif = self::tarifs[$this->scene->sceneData['tarif']];
        $this->response->message .= $this->user->player->AddMoney($tarif['money']);
        $this->response->message .= $this->user->player->AddExpa($tarif['expa']);
        $this->user->player->save();


        $this->scene->step = 2;
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
        if ($this->GetStep() == 1) return $this->Step1_Show();
        if ($this->GetStep() == 2) return $this->Step2_SelectCar();
        if ($this->GetStep() == 3) return $this->Step3_Taxi();

        return $this->response;
    }


}
