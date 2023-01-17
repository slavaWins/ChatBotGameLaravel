<?php

namespace App\Characters;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;

/**
 * @implements Character<GarageCharacterDataStructure>
 */
class GarageCharacter extends Character
{
    public $icon = "💒‍";
    public $baseName = "Гараж";

    protected $casts = [
        'characterData' => GarageCharacterDataStructure::class
    ];


    function RenderAppend($isShort = false, $isShowDescr = false, $showSkill = false)
    {
        $c = WorkbenchCharacter::where("parent_id", $this->id)->count();
        if ($c) {
            return "\n 🛠️ Верстаков: " . $c;
        } else {
            return "\n Нет верстаков";
        }
    }

    /**
     * Получить стоимость проккачки скила
     * @param $skillInd
     * @param $skillCurrentValue
     * @return int
     */
    public function GetSkillPrice($skillInd, $skillCurrentValue)
    {
        return [
            'money' => ($skillCurrentValue + 1) * 1000 * 2
        ];
    }


}
