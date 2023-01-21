<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\GarageCharacter;
use App\Characters\PlayerCharacter;
use App\Characters\Shop;
use App\Characters\Shop\CarItemCharacterShop;
use App\Helpers\PaginationHelper;
use App\Library\Mp3Builder;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;
use App\Models\Bot\ItemCharacterShop;
use App\Models\Bot\Scene;
use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\ShopRoom;
use App\Scene\Core\SkillRoom;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Log;

class RaceRoom extends BaseRoomPlus
{


    public ?CarCharacter $enemy;
    public ?CarCharacter $car;
    private ?Shop\RaceTrackShop $track;


    public function Step0_StoList()
    {
        $this->response->Reset();


        $this->response->message = "Список гонок:";
        //$this->response->message .= $this->car->RenderStats();


        $tracks = Shop\RaceTrackShop::GetItmes();

        $isRedirect = $this->PaginateCollection($tracks, 3, function (Shop\RaceTrackShop $track) {

            $this->response->message .= "\n\n  " . $track->name . ': ';
            $this->response->message .= " " . $track->RenderStats();


            if ($this->user->player->characterData->money > $track->characterData->price) {
                if ($this->AddButton($track->name)) {
                    $this->scene->SetData("id", $track->id);
                    return $this->NextStep();
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

    public function Step1_CarSelect()
    {

        $this->response->Reset()->message = $this->track->icon . ' ' . $this->track->name;
        $items = $this->user->GetAllCharacters(\App\Characters\CarCharacter::class);

        $selectCharacter = $this->PaginateSelector($items);

        if ($selectCharacter) {
            $this->scene->SetData('car', $selectCharacter->id);
            $this->scene->save();
            $this->user->player->characterData->money -= $this->track->characterData->price;
            $this->user->player->save();
            return $this->NextStep();
        }

        if ($this->AddButton("Назад")) {
            return $this->PrevStep();
        }

        return $this->response;
    }

    public function Step2_Preview()
    {

        $this->response->Reset()->message = "Превью гонки:";


        $carData = Shop\CarItemCharacterShop::GetItmes()->random();

        if (!isset($this->scene->sceneData['enemy'])) {
            $enemy = new CarCharacter();
            $enemy->name = $carData->name;
            $enemy->characterData = $carData->characterData;
            $enemy->characterData->power += $enemy->characterData->power* ( $this->track->characterData->level / 11);
            $enemy->characterData->maxSpeed += $enemy->characterData->maxSpeed* ( $this->track->characterData->level / 11);
            $enemy->characterData->razgon -= $enemy->characterData->razgon* ( $this->track->characterData->level / 18);


            $enemy->save();
            $this->scene->SetData('enemy', $enemy->id);
            $this->scene->save();
            $this->enemy = $enemy;
        }


        $this->response->message .= "\n\nВы уже заплатили взнос: " . $this->track->characterData->price . ' RUB';

        $this->response->message .= "\nВаш соперник:";
        $this->response->message .= $this->enemy->Render(true);

        $this->response->message .= "\n\n\nВаша машина:";
        $this->response->message .= $this->car->Render(true);


        if ($this->AddButton("Назад")) {
            return $this->PrevStep();
        }

        if ($this->AddButton("Гонка")) {
            return $this->NextStep();
        }
        return $this->response;

    }

    function dates($init)
    {

        $day = floor($init / 86400);
        $hours = floor(($init - ($day * 86400)) / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;
        if (strlen($minutes) == 1) $minutes = '0' . $minutes;
        if (strlen($seconds) == 1) $seconds = '0' . $seconds;

        return "$minutes:$seconds";
    }

    public function Step3_Race()
    {

        $this->response->Reset()->message = "Итог гонки:";


        $this->response->AttachSound(Mp3Builder::GenRandFile(2));

        $timeEnemy = $this->enemy->GetTrackData($this->track->characterData->track_len);
        $timePlayer = $this->car->GetTrackData($this->track->characterData->track_len);

        $this->response->message .= "\nВаш соперник:";
        $this->response->message .= $this->enemy->GetName();
        $this->response->message .= "\nПроехал трассу за \n" . $this->dates($timeEnemy['time_to_track']);

        $this->response->message .= "\n\nВаш :";
        $this->response->message .= $this->car->GetName();
        $this->response->message .= "\nПроехал трассу за \n" . $this->dates($timePlayer['time_to_track']);

        if ($timeEnemy < $timePlayer) {
            $this->response->message .= "\n\n Вы проиграли!";
        } else {
            $this->response->message .= "\n\n ПОБЕДА!";
            $this->response->message .= $this->user->player->AddMoney($this->track->characterData->gift_money);
            $this->response->message .= $this->user->player->AddExpa(6);
            $this->user->player->save();
        }

        $this->scene->SetData('enemy', null);
        $this->scene->step = 0;
        $this->scene->save();

        if ($this->AddButton("Другая гонка")) {

        }

        return $this->response;

    }

    public function Boot()
    {

        if (isset($this->scene->sceneData['id'])) {
            $this->track = Shop\RaceTrackShop::FindById($this->scene->sceneData['id']);
        }

        if ($this->scene->sceneData['car'] ?? false) {
            $this->car = CarCharacter::LoadCharacterById($this->scene->sceneData['car']);
        }

        if ($this->scene->sceneData['enemy'] ?? false) {
            $this->enemy = CarCharacter::LoadCharacterById($this->scene->sceneData['enemy']);
        }
    }


}
