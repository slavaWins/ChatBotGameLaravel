<?php

namespace App\Scene;

use App\Characters\CarCharacter;
use App\Characters\GarageCharacter;
use App\Characters\PlayerCharacter;
use App\Characters\Shop\CarItemCharacterShop;
use App\Scene\Core\ShopRoom;
use App\Scene\Core\SkillRoom;

class HomeRoom extends BaseRoom
{

    public function Step0()
    {
        $this->response->Reset();
        $this->response->message = "Вы находитесь в гараже";

        $isFullInfo = $this->IsBtn("?");

        $this->response->message .= $this->user->player->RenderStats(false, $isFullInfo, $isFullInfo);


        /** @var GarageCharacter $garageCharacter */
        $garageCharacter = GarageCharacter::LoadFristCharacterByUser($this->user->id, true);
        $this->response->message .= "\n\n " . $garageCharacter->icon . " Гараж";

        $this->response->message .= $garageCharacter->RenderStats(false, $isFullInfo, true);


        if ($this->AddButton("Прокачка персонажа")) {
            $room = SkillRoom::CreateSkillRoomByCharacter($this->user, $this->user->player);
            return $this->SetRoom($room);
        }

        if ($this->AddButton("Прокачка гаража")) {
            $room = SkillRoom::CreateSkillRoomByCharacter($this->user, $garageCharacter);
            return $this->SetRoom($room);
        }

        if ($this->AddButton("Мои машины")) {
            return $this->SetStep(1);
        }


        if ($isFullInfo) {
            $this->AddButton("Убрать описание");
        } else {
            $this->AddButton("?");
        }

        return $this->response;
    }

    public function Step1_Cars()
    {

        $cars = $this->user->GetAllCharacters(CarCharacter::class);

        $this->response->message = "Ваши машины (".(count($cars))." шт.): \n";


        foreach ($cars as $K=>$V){
            $this->response->message .= "\n\n".$V->Render(true, false, false);
        }
        if ($this->AddButton("Назад")) {
            return $this->SetStep(0);
        }

        if ($this->AddButton("Купить машину")) {
            $room = ShopRoom::CreateShopRoomByCharacterType($this->user, CarCharacter::class, CarItemCharacterShop::class);
            return $this->SetRoom($room);
        }





        return $this->response;
    }

    public function Step2_Info()
    {
        $this->response->message = "Вот ваши стартовые данные:";
        $this->response->message .= $this->user->player->RenderStats(false, true);

        $this->response->AttachSound("start_history_1.opus");


        if ($this->AddButton("Отлично!")) {

        }


        if ($this->AddButton("Скилы")) {
            $room = SkillRoom::CreateSkillRoomByCharacter($this->user, $this->user->player);
            $this->DeleteRoom();
            $this->user->scene_id = $room->scene->id;
            $this->user->refresh();
            $this->response->Reset();
            $this->response->message = "Переход в скилы";
        }

        return $this->response;
    }


    public function Handle()
    {
        if ($this->GetStep() == 0) return $this->Step0();
        if ($this->GetStep() == 1) return $this->Step1_Cars();
        if ($this->GetStep() == 2) return $this->Step2_Info();

        return $this->response;
    }


}
