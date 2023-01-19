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
class TemplateCharacter extends Character
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


}
