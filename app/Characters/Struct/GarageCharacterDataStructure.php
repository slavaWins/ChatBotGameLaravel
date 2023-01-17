<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class GarageCharacterDataStructure extends BaseCharacterDataCast
{
    public $size = 1;
    public $skill_size = 1;
    public $skill_teh = 1;

    public function __construct($characterData = [])
    {
        $this->skill_size = StatStructure::Make("Размер гаража")->SetDefault(2)
            ->SetIcon("📙")->SetShowInShort(true)->SetDescr("Чем больше гараж тем больше техники и машин можно в нем разместить");

        $this->skill_size = StatStructure::Make("Размер гаража")->SetDefault(1)
            ->SetIcon("📙🕳")->SetMax(10)->SetShowInShort(false)->SetDescr("Чем больше гараж тем больше техники и машин можно в нем разместить");

        $this->skill_teh = StatStructure::Make("Технологии гаража")->SetDefault(1)
            ->SetIcon("📙")->SetMax(10)->SetShowInShort(false)->SetDescr("Улучшайте технические возможности гража");

        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
