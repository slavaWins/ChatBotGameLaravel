<?php

namespace App\Services;

use App\Characters\GarageCharacter;
use App\Models\Bot\Character;
use App\Models\User;

class InventoryCharacterService
{

    /**
     * Найти всех Чарактеров у которых есть пустые слоты, в которые можно положить что-то.
     * В качества вложения считается parent_id
     * @param User $user
     * @param $className
     * @param int|null $ignoreId игнорировать этот чарактер
     * @return \Illuminate\Support\Collection
     */
    public static function GetCharactersHaveFreeSlots(User $user, $className, $ignoreId = null)
    {
        $garages = collect($user->GetAllCharacters($className))
            ->filter(function (GarageCharacter $item) use ($ignoreId) {
                if ($item->id == $ignoreId) return false;
                $item->characterData->storage_childs = $item->GetChildldren()->count();
                return $item->GetChildldren()->count() < $item->characterData->storage_size;
            });

        return $garages;
    }

    /**
     * Рафасовать коллекцию предметов(чарактеров) по инвертарям(чарактерам)
     * @param User $user
     * @param Character[] $items Collection чарактеров которых нужно фасануть
     * @param string $className Класс инвартарей, по которым будет раскидана коллекция
     * @param int|null $ignoreId Игнорировать этот чарактер как место куда можно что-то положить
     * @return bool
     */
    public static function MoveItemsForOtherCharacters(User $user, $items, $className, $ignoreId = 0)
    {
        $garages = InventoryCharacterService::GetCharactersHaveFreeSlots($user, $className, $ignoreId);
        if (!$garages->count()) return false;

        /** @var Character $item */
        /** @var GarageCharacter $garage */
        foreach ($items as $K => $item) {
            foreach ($garages as $garage) {
                if ($garage->characterData->storage_childs >= $garage->characterData->storage_size) {
                    continue;
                }
                $item->parent_id = $garage->id;
                $item->save();
                unset($items[$K]);
                $garage->characterData->storage_childs++;
            }
        }

        return count($items) == 0;
    }

    public static function MoveToOther()
    {


    }
}
