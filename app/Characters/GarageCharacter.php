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


    function GetStatsCalculate()
    {

        if (!$this->id) return $this->GetStats();

        $stats = $this->GetStats();
        $stats->inner->max = $stats->size->value;

        $c = Character::where("parent_id", $this->id)->count();
        $stats->inner->value = $c;

        return $stats;
    }



    function RenderAppend($isShort = false, $isShowDescr = false, $showSkill = false)
    {
        $items = $this->GetChildldren();

        $c = $items->filter(function ($item) {
            return $item->className == "App\Characters\WorkbenchCharacter";
        })->count();

        $text = "";
        if ($c) {
            $text .= "\n 🛠️ Верстаков: " . $c;
        } else {
            $text .= "\n Нет верстаков";
        }

        $c = $items->filter(function ($item) {
            return $item->className == "App\Characters\CarCharacter";
        })->count();
        if ($c) {
            $text .= "\n 🚘 Машин: " . $c;
        } else {
            $text .= "\n Нет машин";
        }

        return $text;
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
