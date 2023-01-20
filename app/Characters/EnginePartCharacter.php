<?php

namespace App\Characters;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Characters\Struct\EnginePartStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;


/**
 * @implements Character<EnginePartStructure>
 */
class EnginePartCharacter extends Character
{
    public $icon = "💠";
    public $baseName = "Деталь";

    protected $casts = [
        'characterData' => EnginePartStructure::class
    ];

    function GetName()
    {
        return $this->icon . ' ' . $this->GetStats()->partType->value . ' ' . ($this->name ?? $this->baseName);
    }

    public function GetSkillPrice($skillInd, $skillCurrentValue)
    {
        return [
            'money' => ($skillCurrentValue + 1) * 250,
        ];
    }


}
