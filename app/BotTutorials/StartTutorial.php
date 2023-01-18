<?php


namespace App\BotTutorials;

use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\User;
use App\Scene\Core\BaseRoom;
use App\Scene\Core\ShopRoom;
use App\Scene\GarageRoom;
use App\Scene\RegistrationRoom;
use App\Scene\StartHistoryRoom;

class StartTutorial extends BotTutorialBase
{

    public function Handle(): BotResponseStructure
    {
        //  $this->response->message .= "\n\n Вы проходите обучение!";


        if ($this->step == 0) {

            if ($this->IsScene(StartHistoryRoom::class)) {
                if ($this->room->scene->step == 2) $this->NextStep();
            }
        }

        if ($this->step == 1) {
            if ($this->IsScene(ShopRoom::class)) {
                $this->RemoveBtn("Выход")->RemoveBtn("Доступные товары");
                if ($this->sceneCurrent->step == 1) $this->AddMessage("Теперь вы должны купить свой первый гараж! У каждого товара есть номер. Вы можете нажать кнопку, или просто ввести номер товара.");
                if ($this->sceneCurrent->step == 2) $this->AddMessage("Вы можете посмотреть характеристики гаража прежде чем его купить. Для начала стоит арендовать гараж по дешевле!");

            }
            if ($this->IsScene(GarageRoom::class)) {
                $this->NextStep();
            }
        }


        if ($this->step == 2) {
            if ($this->IsScene(GarageRoom::class)) {
                $this
                    ->RemoveExitBtns()
                    ->RemoveBtn("Арендовать гараж")
                    ->RemoveBtn("Верстаки");

                if ($this->sceneCurrent->step == 0) $this->AddMessage("Теперь перейдите в ваш гараж!");
                if ($this->sceneCurrent->step == 1) $this->AddMessage("Здесь вы можете посмотреть состояние своего гаража. Какие в нем есть машины, верстаки и запасы. \n\n Теперь перейдите в раздел Машины.");
                if ($this->sceneCurrent->step == 3) $this->NextStep();

            }


        }

        if ($this->step == 3) {
            if ($this->IsScene(GarageRoom::class)) {
                $this->RemoveExitBtns();

                $this->AddMessage("Сейчас у вас нет машин. Но когда-то у вас будет целый автопарк. Теперь купите машину.");

            }

            if ($this->IsScene(ShopRoom::class)) {
                $this->NextStep();
            }
        }

        if ($this->step == 4) {
            if ($this->IsScene(ShopRoom::class)) {
                $this->RemoveBtn("Выход")->RemoveBtn("Доступные товары");


                if ($this->sceneCurrent->step == 0) $this->AddMessage("Для удобной покупки машин, можно пользоваться фильтром.");
                if ($this->sceneCurrent->step <> 2) $this->RemoveExitBtns();

                if ($this->sceneCurrent->step == 2) $this
                    ->AddMessage("Перед покупкой, можно посмотреть характеристики автомобиля и увидеть некоторые дефекты.")
                    ->AddMessage("Для начала вам подойдет любая машина, покупайте.");

            }

            if ($this->IsScene(GarageRoom::class)) {
                $this->NextStep();
            }
        }


        if ($this->step == 5) {
            if ($this->IsScene(GarageRoom::class)) {
                $this->RemoveExitBtns()->RemoveBtn("Купить машину");

                if ($this->sceneCurrent->step == 3) $this
                    ->AddMessage("Отличично теперь в вашем гараже есть первая машина!")
                    ->AddMessage("Перейдите в вашу машину");


            }

            if ($this->IsScene(ShopRoom::class)) {
                // $this->NextStep();
            }
        }

        return $this->response;
    }

}
