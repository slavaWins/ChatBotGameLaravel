<?php

namespace App\Scene\Core;

use App\Characters\CarCharacter;
use App\Characters\PlayerCharacter;
use App\Helpers\PaginationHelper;
use App\Library\Structure\BotRequestStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;
use App\Models\Bot\ItemCharacterShop;
use App\Models\User;
use App\Scene\BaseRoom;
use App\Scene\HomeRoom;
use Illuminate\Support\Facades\Validator;
use PhpParser\Builder\Class_;

class ShopRoom extends BaseRoom
{

    /** @var Character $character */
    public $character;
    private $itemShopClass;
    private $characterClass;


    public function Step0_Setting()
    {
        $this->response->Reset();

        $this->response->message = "МАГАЗИН МАШИН \n";
        $this->response->message .= $this->user->player->GetStats()->money->RenderLine(false, false);
        $this->response->message .= "\n Выберите по каким параметрам отображать товары.";


        if ($this->AddButton('Доступные товары')) {
            $this->scene->SetData('showMyPrice', !$this->scene->sceneData['showMyPrice']);
            $this->scene->save();
        }

        $clasExample = new $this->itemShopClass();

        $catKey = $clasExample->filter_by;

        if (!empty($clasExample->filter_by)) {

            $cats = [];
            $itemsToCat = $this->GetItems(true);
            foreach ($itemsToCat as $V) {
                if (!isset($cats[$V->characterData->$catKey])) {
                    $cats[$V->characterData->$catKey] = 0;
                }
                $cats[$V->characterData->$catKey]++;
            }

            if ($this->scene->sceneData['filter_val'] <> "") {
                if ($this->IsBtn("Без фильтра")) {
                    $this->scene->SetData('filter_val', "");
                    $this->scene->save();
                } else {
                    $this->AddButton("Без фильтра");
                }
            }

            $this->response->message .= "\n\n Категории:";
            foreach ($cats as $K => $V) {
                if ($this->IsBtn($K)) {
                    $this->scene->SetData('filter_val', $K);
                    $this->scene->save();
                    continue;
                }
                if ($this->scene->sceneData['filter_val'] == $K) continue;
                $this->AddButton($K);
            }


            foreach ($cats as $K => $V) {
                $this->response->message .= "\n";
                if ($this->scene->sceneData['filter_val'] == $K) {
                    $this->response->message .= "☑️";
                } else {
                    $this->response->message .= "☐";
                }
                $this->response->message .= "$K ($V шт.)";

            }

        }

        $items = $this->GetItems();

        $this->response->message .= "\n\n Только доступные товары: ";
        if ($this->scene->sceneData['showMyPrice']) {
            $this->response->message .= "Да (" . $items->count() . ")";
        } else {
            $this->response->message .= "Все товары (" . $items->count() . ")";
        }

        if ($this->AddButton("Выход")) {
            return $this->SetRoom(HomeRoom::class);
        }

        if ($this->AddButton("Показать")) {
            $this->scene->SetData('page', 1);
            $this->scene->save();
            return $this->NextStep();
        }

        return $this->response;

    }

    public function Step1_ShopList()
    {
        $this->response->Reset();

        $this->response->message = "МАГАЗИН МАШИН \n";
        $this->response->message .= $this->user->player->GetStats()->money->RenderLine(false, false);
        $this->response->message .= "\n Выберите машину которые вы хотите посмотреть";
/*
        $items = $this->GetItems();
        $isRefreshPage = $this->PaginateCollection(collect($items), 2, function (CarCharacter $car) {
            $this->response->message .= "\n\n" . $car->Render(true, false, false);

            if ($this->AddButton($car->name)) {
            }
        });

        if ($isRefreshPage) return $this->Handle();
      */
        $pageCurent = $this->scene->sceneData['page'];

        $inPage = 6;
        $items = $this->GetItems();
        $pageCountMax = ceil($items->count() / $inPage);


        /** @var ItemCharacterShop[] $paginated */
        $paginated = PaginationHelper::paginate($this->GetItems(), $inPage, $pageCurent);

        foreach ($paginated as $K => $V) {
            $this->response->message .= "\n\n";
            $this->response->message .= $V->icon . ' [' . $V->id . '] ' . $V->name;
            $this->response->message .= ' 💵 ' . number_format($V->price) . ' ₽' . "\n";

            /** @var Character $character */
            $character = new $this->characterClass();
            $character->characterData = $V->characterData;

            /** @var StatStructure[] $stat */
            $stat = $character->GetStatsCalculate();
            foreach ($V->showInShopPreview as $ind) {
                if (!isset($stat->$ind)) continue;
                $this->response->message .= "  " . $stat->$ind->RenderLine(true, false);
            }

            if ($this->AddButton('[' . $V->id . ']')) {
                $this->scene->SetData('selectId', $V->id);
                return $this->NextStep();
            }
        }


        if ($pageCountMax > 1) {
            if ($pageCurent > 1) {
                if ($this->AddButton("<")) {
                    $this->scene->SetData('page', $pageCurent - 1);
                    $this->scene->save();
                    $this->request->message = "";
                    return $this->Handle();
                }
            }
        }

        if ($this->AddButton("⚙️")) {
            return $this->SetStep(0);
        }

        if ($pageCountMax > 1) {
            if ($pageCurent < $pageCountMax) {
                if ($this->AddButton(">")) {
                    $this->scene->SetData('page', $pageCurent + 1);
                    $this->scene->save();
                    $this->request->message = "";
                    return $this->Handle();
                }
            }
            $this->response->message .= "\n\n Страница " . ($pageCurent) . " / " . ($pageCountMax) . "";
        }

        if ($this->AddButton("Выход", true)) {
            return $this->SetRoom(HomeRoom::class);
        }
        return $this->response;
    }

    public function Step2_Show()
    {
        $this->response->Reset();


        /** @var ItemCharacterShop $item */
        $item = $this->GetItems()[$this->scene->sceneData['selectId']] ?? null;

        $this->response->message = $this->user->player->GetStats()->money->RenderLine(false, false);


        $this->response->message .= "\n ВЫ СМОТРИТЕ ТОВАР:";
        $this->response->message .= "\n" . $item->name;

        /** @var Character $character */
        $character = new $this->characterClass();
        $character->characterData = $item->characterData;

        $this->response->message .= "\n" . $character->RenderStats(false, false, true);


        if ($this->user->player->characterData->money >= $item->price) {
            if ($this->AddButton('Купить')) {
                $this->user->player->characterData->money -= $item->price;
                $this->user->player->save();
                $character = $this->characterClass::CreateCharacter($this->user->id, $item->characterData);
                $character->name = $item->name;
                $character->parent_id = $this->scene->sceneData['forParentId'];
                $character->save();

                $this->response->Reset()->AddWarning("Покупка выполнена", "✅");
                $this->SetRoom(HomeRoom::class);
                return $this->response;
            }
        }

        if ($this->AddButton("< Назад")) {
            return $this->SetStep(1);
        }

        if ($this->AddButton("Выход")) {
            return $this->SetRoom(HomeRoom::class);
        }

        return $this->response;
    }

    /**
     * @return ItemCharacterShop[]
     */
    public function GetItems($ignoreFilter = false)
    {
        $items = [];
        foreach (ItemCharacterShop::where("className", $this->itemShopClass)->get() as $V) {
            $items[$V->id] = $this->itemShopClass::find($V->id);
        }


        $items = collect($items);

        if (!$ignoreFilter) {
            if ($this->scene->sceneData['showMyPrice']) {
                $items = $items->filter(function ($item) {
                    return $item->price <= $this->user->player->characterData->money;
                });
            }
        }

        $clasExample = new $this->itemShopClass();
        if (empty($clasExample->filter_by)) {
            $ignoreFilter = true;
        }

        if (!$ignoreFilter) {

            if ($this->scene->sceneData['filter_val'] <> "") {
                $keyNeed = $clasExample->filter_by;
                $valNeed = $this->scene->sceneData['filter_val'];

                $items = $items->filter(function ($item) use ($keyNeed, $valNeed) {
                    return $item->characterData->$keyNeed == $valNeed;
                });
            }

        }

        return $items;
    }

    public function Handle()
    {
        $this->itemShopClass = $this->scene->sceneData['itemShopClass'];
        $this->characterClass = $this->scene->sceneData['characterClass'];

        if ($this->GetStep() == 0) return $this->Step0_Setting();
        if ($this->GetStep() == 1) return $this->Step1_ShopList();
        if ($this->GetStep() == 2) return $this->Step2_Show();

        return $this->response;
    }


    /**
     * Создать комнату магазина по товарам
     * @param User $user для игрока
     * @param Class_ $characterClass товар будет этого класса, Character
     * @param Class_ $itemShopClass это представление для товара, оно содержит инфу о товаре. ItemCharacterShop
     * @param int $forParentId после покупки чарактера, владельцем будет так же числится этот Чарактер как родитель
     * @return ShopRoom
     */
    public static function CreateShopRoomByCharacterType(User $user, $characterClass, $itemShopClass, $forParentId = 0): ShopRoom
    {

        $request = new BotRequestStructure();
        $request->user = $user;
        $request->user_id = $user->id;
        $skillRoom = new ShopRoom($request);

        $skillRoom->scene->sceneData = [
            'page' => 1,
            'characterClass' => $characterClass,
            'itemShopClass' => $itemShopClass,
            'selectId' => 0,
            'forParentId' => $forParentId,
            'showMyPrice' => true, //показывать только досутпные мне по цене
            'filter_val' => "", //по значению поля makra = Nissan
        ];

        $skillRoom->scene->save();
        $skillRoom->scene->refresh();
        return $skillRoom;
    }


}
