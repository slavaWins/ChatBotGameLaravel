<?php

namespace App\Scene;

use App\Scene\Core\BaseRoom;
use Illuminate\Support\Facades\Validator;

class RegistrationRoom extends BaseRoom
{

    public function Step1_Start()
    {
        $this->response->Reset();
        $this->response->message = "Добро пожаловать в игру! Здесь вы сможете покупать в игре автомобили из Дрома. Что бы участвовать на них в гонках, или заниматься грузоперевозками. Или быть перекупом. Возможностей много!";

        if ($this->AddButton("Далее")) {
            $this->request->message = "";
            return $this->SetStep(2);
        }

        return $this->response;
    }

    public function Step2_Info()
    {
        $this->response->Reset();
        $this->response->message = "Введите ваше имя:";

        $this->AddButton("Ричерд Хамонд");

        if (!empty($this->request->message)) {
            $this->request->message = trim($this->request->message);
            $validator = Validator::make(['name' => $this->request->message], ['name' => 'required|string|min:4|max:17',]);

            if ($validator->fails()) {
                return $this->response->AddWarning($validator->errors()->first());
            }

            $this->user->name = $this->request->message;
            $this->user->save();

            return $this->SetStep(3);
        }

        return $this->response;
    }

    public function Step3_Info()
    {
        $this->response->Reset();
        $this->response->message = "Итак " . $this->user->name . ' Вы готовы?';

        if ($this->AddButton("Ну да")) {
            return $this->SetRoom(StartHistoryRoom::class);
        }
/*
        if ($this->AddButton("Сначала")) {
            return $this->SetStep(1);
        }
*/
        return $this->response;
    }


    public function Handle()
    {
        if ($this->GetStep() == 1 || $this->GetStep() == 0) return $this->Step1_Start();
        if ($this->GetStep() == 2) return $this->Step2_Info();
        if ($this->GetStep() == 3) return $this->Step3_Info();

        return $this->response;
    }


}
