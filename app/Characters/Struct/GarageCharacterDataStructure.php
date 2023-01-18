<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class GarageCharacterDataStructure extends BaseCharacterDataCast
{
    public $childCount = 0;
    public $size = 1;

    public $price = 1;

    public function __construct($characterData = [])
    {
        $this->size = StatStructure::Make("Размер гаража")->SetDefault(2)->Hidden()
            ->SetIcon("📏")->SetShowInShort(true)->SetDescr("Чем больше гараж тем больше техники и машин можно в нем разместить");

        $this->childCount = StatStructure::Make("Места")->SetDefault(0)
            ->SetIcon("⬜")->SetShowInShort(true)->SetDescr("Сколько сейчас сейчас свободного места в гараже");

        $this->price = StatStructure::Make("Аренда")->SetDefault(7000)
            ->SetDescr("Каждый месяц вы платите аренду за этот гараж. Вы можете отказаться и съехать с этого гаража.")
            ->SetIcon("💵")->SetPostfix(' ₽/мес.')->FormatMoney()->SetShowInShort(true);


        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
