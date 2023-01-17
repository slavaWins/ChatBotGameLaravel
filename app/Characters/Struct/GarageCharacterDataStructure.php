<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class GarageCharacterDataStructure extends BaseCharacterDataCast
{
    public $inner = 0;
    public $size = 1;

    public function __construct($characterData = [])
    {
        $this->size = StatStructure::Make("Размер гаража")->SetDefault(2)->Hidden()
            ->SetIcon("📏")->SetShowInShort(true)->SetDescr("Чем больше гараж тем больше техники и машин можно в нем разместить");

        $this->inner = StatStructure::Make("Места")->SetDefault(0)
            ->SetIcon("⬜")->SetShowInShort(true)->SetDescr("Сколько сейчас сейчас свободного места в гараже");



        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
