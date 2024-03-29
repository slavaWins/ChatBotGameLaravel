<?php

namespace App\Characters;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Characters\Struct\TemplateStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;


/**
 * @implements Character<TemplateStructure>
 */
class TemplateCharacter extends Character
{
    public $icon = "🚘";
    public $baseName = "Автомобиль";

    protected $casts = [
        'characterData' => TemplateStructure::class
    ];

    public function GetSkillPrice($skillInd, $skillCurrentValue)
    {
        return [
            'money' => ($skillCurrentValue + 1) * 250,
        ];
    }


}
