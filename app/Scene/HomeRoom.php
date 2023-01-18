<?php

namespace App\Scene;

use App\Characters\GarageCharacter;
use App\Scene\Core\BaseRoom;
use App\Scene\Core\SkillRoom;

class HomeRoom extends BaseRoom
{

    public function Step0()
    {
        $this->response->Reset();
        $this->response->message = "Сейчас вы дома. \n";

        $isFullInfo = $this->IsBtn("?");

        $this->response->message .= $this->user->player->RenderStats(false, $isFullInfo, $isFullInfo);


        /** @var GarageCharacter $garageCharacter */
        $garageCharacter = GarageCharacter::LoadFristCharacterByUser($this->user->id, true);
        $this->response->message .= "\n\n " . $garageCharacter->icon . " Гараж";

        $this->response->message .= $garageCharacter->RenderStats(false, $isFullInfo, true);


        if ($this->AddButton("Прокачка персонажа")) {
            $room = SkillRoom::CreateSkillRoomByCharacter($this->user, $this->user->player);
            return $this->SetRoom($room, [], true);
        }

        if ($this->AddButton("Мои гаражи")) {
            return $this->SetRoom(GarageRoom::class);
        }

        if ($this->AddButton("Работа")) {
            return $this->SetRoom(WorkRoom::class);
        }


        if ($isFullInfo) {
            $this->AddButton("Убрать описание");
        } else {
            $this->AddButton("?");
        }

        return $this->response;
    }


    public function Step1_Xz()
    {

    }

    public function Step2_Info()
    {
    }


    public function Route()
    {
        if ($this->GetStep() == 0) return $this->Step0();
        if ($this->GetStep() == 1) return $this->Step1_Xz();
        if ($this->GetStep() == 2) return $this->Step2_Info();

        return $this->response;
    }


}
