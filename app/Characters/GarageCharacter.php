<?php

namespace App\Characters;

use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;

/**
 * @property GarageCharacterDataStructure $characterData
 */
class GarageCharacter extends Character
{
    public $icon = "💒‍";
    public $baseName = "Гараж";

    protected $casts = [
        'characterData' => GarageCharacterDataStructure::class
    ];

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

        $data = new GarageCharacterDataStructure();

        $data->skill_size = StatStructure::Make("Размер гаража")->SetDefault(1)
            ->SetIcon("📙🕳")->SetMax(10)->SetShowInShort(false)->SetDescr("Чем больше гараж тем больше техники и машин можно в нем разместить");

        $data->skill_teh = StatStructure::Make("Технологии гаража")->SetDefault(1)
            ->SetIcon("📙")->SetMax(10)->SetShowInShort(false)->SetDescr("Улучшайте технические возможности гража");

        return (array)$data;
    }
}
