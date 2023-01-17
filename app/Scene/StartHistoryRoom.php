<?php

namespace App\Scene;

use App\Characters\PlayerCharacter;
use App\Scene\Core\BaseRoom;

class StartHistoryRoom extends BaseRoom
{

    public function Step0()
    {
        $this->response->Reset();
        $this->response->message = "Ваша история начинается в далеком 2010.
         Вы студент, и подкопили денег на первую машину.";

        $this->response->AttachSound("start_history.ogg");

        if ($this->AddButton("Далее")) {
            return $this->NextStep();
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
            /** @var PlayerCharacter $player */
            $player = PlayerCharacter::LoadFristCharacterByUser($this->user->id, true);

            foreach ($stats[$select]['par'] as $K => $V) {
                $player->characterData->$K = $V;
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

        $this->user->is_registration_end = true;
        $this->user->save();

        if ($this->AddButton("Отлично!")) {
            return $this->SetRoom(HomeRoom::class);
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
