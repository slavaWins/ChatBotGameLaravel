<?php

namespace App\Scene;

use App\Scene\Core\BaseRoom;
use Illuminate\Support\Facades\Validator;
use SlavaWins\EasyAnalitics\Library\EasyAnaliticsHelper;

class RegistrationRoom extends BaseRoom
{

    public function Step0_Start()
    {
        $this->response->Reset();
        $this->response->message = "Добро пожаловать в игру! Здесь вы сможете покупать в игре автомобили из Дрома. Что бы участвовать на них в гонках, или заниматься грузоперевозками. Или быть перекупом. Возможностей много!";


        if ($this->AddButton("Далее")) {

            EasyAnaliticsHelper::Increment("user_tracking_frist", 1, "Пользователь. Первый ответ", "Пользователь впервые ответил на сообщение бота");
            $this->request->message = "";
            return $this->NextStep();
        }

        return $this->response;
    }

    public function Step1_Info()
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

            return $this->SetRoom(StartHistoryRoom::class);
        }

        return $this->response;
    }


}
