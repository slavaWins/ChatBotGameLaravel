<?php

namespace App\Characters;

use App\Characters\Struct\CarCalculateDataStructure;
use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;


/**
 * @property CarCharacterDataStructure $characterData
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


    public function GetCalculateParameters()
    {
        $res = $this->GetStats();

        $res->razgon->value = $res->mass->value / $res->razgon->value;

        return $res;
    }

}
