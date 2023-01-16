<?php

namespace App\Characters;

use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;


/**
 * @property PlayerCharacterDataStructure $characterData
 */
class PlayerCharacter extends Character
{
    public $icon = "🧑‍";
    public $baseName = "Игрок";

    protected $casts = [
        'characterData' => PlayerCharacterDataStructure::class
    ];

    public function GetSkillPrice($skillInd, $skillCurrentValue)
    {
        return [
            'money' => ($skillCurrentValue + 1) * 10,
            'score_level' => 1
        ];
    }


}
