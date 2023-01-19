<?php


namespace App\BotTutorials;

use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\BotResponseStructure;
use App\Models\User;
use App\Scene\CarRoom;
use App\Scene\Core\BaseRoom;
use App\Scene\Core\ShopRoom;
use App\Scene\GarageRoom;
use App\Scene\RegistrationRoom;
use App\Scene\StartHistoryRoom;
use App\Scene\StoRoom;
use App\Scene\WorkRoom;
use SlavaWins\EasyAnalitics\Library\EasyAnaliticsHelper;

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
                EasyAnaliticsHelper::Increment("reg_buy_garage", 1, "Первый гараж", "Пользователю купил первый гараж.");
                $this->NextStep();
            }
        }


        if ($this->step == 2) {
            if ($this->IsScene(GarageRoom::class)) {
                $this
                    ->RemoveExitBtns()
                    ->RemoveBtn("Арендовать гараж")
                    ->RemoveBtn("Аренда")
                    ->RemoveBtn("Верстаки");

                if ($this->sceneCurrent->step == 0) $this->AddMessage("Теперь перейдите в ваш гараж!");
                if ($this->sceneCurrent->step == 1) $this->AddMessage("Здесь вы можете посмотреть состояние своего гаража. Какие в нем есть машины, верстаки и запасы. \n\n Теперь перейдите в раздел Машины.");
                if ($this->sceneCurrent->step == 3) $this->NextStep();

            }


        }

        if ($this->step == 3) {
            if ($this->IsScene(ShopRoom::class)) {
                $this->NextStep();

            }elseif ($this->IsScene(GarageRoom::class)) {
                $this->RemoveExitBtns();

                $this->AddMessage("Сейчас у вас нет машин. Но когда-то у вас будет целый автопарк. Теперь купите машину.");

            }
        }

        if ($this->step == 4) {
            if ($this->IsScene(ShopRoom::class)) {
                $this->RemoveBtn("Выход");
                $this->RemoveBtn("Доступные товары");


                if ($this->sceneCurrent->step == 0) $this->AddMessage("Для удобной покупки машин, можно пользоваться фильтром.");
                if ($this->sceneCurrent->step <> 2) $this->RemoveExitBtns();

                if ($this->sceneCurrent->step == 1) $this
                    ->AddMessage("Перед покупкой, можно посмотреть характеристики автомобиля и увидеть некоторые дефекты.");

                if ($this->sceneCurrent->step == 2) $this
                    ->AddMessage("Для начала вам подойдет любая машина, покупайте.");

            }

            if ($this->IsScene(GarageRoom::class)) {
                EasyAnaliticsHelper::Increment("reg_buy_car", 1, "Первая машина", "Пользователю купил первую машину.");
                $this->NextStep();
            }
        }


        if ($this->step == 5) {
            if ($this->IsScene(GarageRoom::class)) {
                $this->RemoveExitBtns()->RemoveBtn("Купить машину");
                if ($this->sceneCurrent->step == 3) {
                    $this->AddMessage("Отличично теперь в вашем гараже есть первая машина!")
                        ->AddMessage("Перейдите в вашу машину");
                }
            }
            if ($this->IsScene(CarRoom::class)) {
                //  $this->RemoveExitBtns()->RemoveBtn("Купить машину");
                if ($this->sceneCurrent->step == 0) {
                    $this->OnlyBtn("Таксовать");
                    $this->AddMessage("Попробуем заработать первые деньги, с помощью машины. Теперь нажмите Таксовать");
                }
            }
            if ($this->IsScene(WorkRoom::class)) {
                $this->NextStep();
            }
        }

        if ($this->step == 6) {
            if ($this->IsScene(WorkRoom::class)) {
                $this->RemoveExitBtns();
                if ($this->sceneCurrent->step == 1) {
                    $this->AddMessage("Выберите тариф для такси! Чем лучше машина, тем более крутой тариф можно получить.");
                }
                if ($this->sceneCurrent->step == 2) {
                    $this->AddMessage("Выберите машину");
                }
                if ($this->sceneCurrent->step == 3) {
                    $this->AddMessage("Когда ваш персонаж выполняет работу, игра переходит в режим ожидания. Что бы посмотреть сколько осталось времени, вы можете нажимать Обновить. Либо бот сам отправит вам сообщение, когда время закончится. Но это может затянутся.");
                    $this->NextStep();
                }
            }
        }

        if ($this->step == 7) {

            if ($this->IsScene(WorkRoom::class)) {
                //   $this->RemoveExitBtns();
                if ($this->sceneCurrent->step == 1) {
                    $this->AddMessage("Отлично, вы заработали первые деньги! Такси это самый простой способ заработка в игре. Но таксование быстро портит машину.");
                    $this->NextStep();
                    return $this->response;
                }
            }
        }

        if ($this->step == 8) {
            if ($this->IsScene(WorkRoom::class)) {
                //   $this->RemoveExitBtns();
                if ($this->sceneCurrent->step == 1) {
                    $this->OnlyBtn("Назад");
                    $this->AddMessage("Вы научились зарабатывать. Теперь нужно научится ремонтировать машину. Нажмите Назад.");
                }
                if ($this->sceneCurrent->step == 0) {
                    $this->OnlyBtn("Назад");
                    $this->AddMessage("Нажмите Назад.");
                }
            }
            if ($this->IsScene(GarageRoom::class)) {
                $this->RemoveExitBtns()->RemoveBtn("Купить машину");
                if ($this->sceneCurrent->step == 3) {
                    $this->AddMessage("Выберите машину для ремонта");
                }
            }
            if ($this->IsScene(CarRoom::class)) {
                $this->RemoveExitBtns()->RemoveBtn("Купить машину");
                if ($this->sceneCurrent->step == 0) {
                    $this->OnlyBtn("На СТО");
                    $this->AddMessage("Нажмите На СТО");
                }
            }
            if ($this->IsScene(StoRoom::class)) {
                $this->NextStep();
            }
        }

        if ($this->step == 9) {
            if ($this->IsScene(StoRoom::class)) {

                if ($this->sceneCurrent->step == 0) {
                    $this->RemoveExitBtns();
                    $this->AddMessage("Теперь нужно выбрать СТО. Каждая СТО отличается ценой и своими возможностями. Дешманская СТОшка не сможет починить дорогую иномарку.");
                }

                if ($this->sceneCurrent->step == 1) {
                    if ($this->request->marker == "Ремонт") {
                        $this->NextStep();
                    } else {
                        $this->RemoveExitBtns();
                        $this->AddMessage("Выберите услугу Ремонт");
                    }
                }

            }
        }


        if ($this->step == 10) {
            if ($this->IsScene(StoRoom::class)) {
                $this->AddMessage("Теперь вы должны заработать денег, накупить машин и открыть свой гараж для ремонта.");
                $this->NextStep();
                $this->Stop();

                EasyAnaliticsHelper::Increment("start_tutorial_end", 1, "Закончил туториал 1", "Игрок закончил первый туториал!");
                return $this->response;
            }
        }

        return $this->response;
    }

}
