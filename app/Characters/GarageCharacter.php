<?php

namespace App\Characters;

use App\Library\Structure\StatStructure;
use App\Models\Character;


class GarageCharacter extends Character
{
    public $icon = "💒‍";
    public $baseName = "Гараж";

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

    protected function GetStatsTemplate()
    {

        return [

            'skill_size' => StatStructure::Make("Размер гаража")->SetDefault(1)
                ->SetIcon("📙🕳")->SetMax(10)->SetShowInShort(false)->SetDescr("Чем больше гараж тем больше техники и машин можно в нем разместить"),

            'skill_teh' => StatStructure::Make("Технологии гаража")->SetDefault(1)
                ->SetIcon("📙")->SetMax(10)->SetShowInShort(false)->SetDescr("Улучшайте технические возможности гража"),

        ];
    }
}
