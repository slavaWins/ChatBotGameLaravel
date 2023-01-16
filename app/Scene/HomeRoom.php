<?php

namespace App\Scene;

use App\Characters\GarageCharacter;
use App\Characters\PlayerCharacter;
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

        if ($isFullInfo) {
            $this->AddButton("Убрать описание");
        } else {
            $this->AddButton("?");
        }
        return $this->response;
    }

    public function Step1_Info()
    {
        $stats = [
            'Менеджер' => [
                'descr' => "Умеете управлять командой",
                'par' => [
                    'skill_manager' => 2,
                    'money' => 35000,
                ]
            ],
            'Торговец' => [
                'descr' => "Умеет сбивать цену, и находить более выгодные предложения",
                'par' => [
                    'skill_torg' => 2,
                    'money' => 40000,
                ]
            ],
            'Водитель' => [
                'descr' => "Понимание устройства машины и навыки вождения",
                'par' => [
                    'skill_drive' => 2,
                    'money' => 20000,
                ]
            ],
        ];

        $this->response->message = "Нужно понять ваши стартовые навыки. \n";

        $select = null;
        foreach ($stats as $K => $V) {
            $this->response->message .= "\n" . $K . " - " . $V['descr'];
            if ($this->AddButton($K)) {
                $select = $K;
            }
        }

        if ($select) {
            $player = new  PlayerCharacter();
            $player->user_id = $this->user->id;
            $player->InitCharacter();

            foreach ($stats[$select]['par'] as $K => $V) {
                $player->$K=$V;
            }

            $player->save();


            $this->user->player_id = $player->id;
            $this->user->save();
            $this->user->fresh();
            return $this->NextStep();
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
        if ($this->GetStep() == 1) return $this->Step1_Info();
        if ($this->GetStep() == 2) return $this->Step2_Info();

        return $this->response;
    }


}
