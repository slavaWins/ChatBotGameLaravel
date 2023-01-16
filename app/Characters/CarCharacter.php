<?php

namespace App\Characters;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;


/**
 * @implements Character<CarCharacterDataStructure>
 */
class CarCharacter extends Character
{
    public $icon = "🚘";
    public $baseName = "Автомобиль";

    protected $casts = [
        'characterData' => CarCharacterDataStructure::class
    ];

    public function GetSkillPrice($skillInd, $skillCurrentValue)
    {
        return [
            'money' => ($skillCurrentValue + 1) * 250,
        ];
    }


    public function GetStatsCalculate()
    {
        $res = $this->GetStats();

        $basePower = $res->power->value;
        $res->power->value += ($basePower * $res->skill_engine) / 10;
        $res->power->value += ($basePower * $res->skill_kpp) / 14;

        $res->razgon->value = $res->mass->value / $res->power->value;

        return $res;
    }

}
