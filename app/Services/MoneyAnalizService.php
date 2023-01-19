<?php

namespace App\Services;

use App\Characters\GarageCharacter;
use App\Models\Bot\Character;
use App\Models\User;

class MoneyAnalizService
{

    /**
     * Посчитать все деньги и активы игрока. В деньгах
     * @param User $user
     * @return \App\Library\Structure\StatStructure|int
     */
    public static function GetUserMoneyState(User $user)
    {
        $money = $user->player->characterData->money ?? 0;

        /** @var Character $character */
        foreach ($user->GetAllCharacters() as $character) {
            if (isset($character->characterData->price)) {
                $money += $character->characterData->price;
            }
        }

        return $money;
    }


}
