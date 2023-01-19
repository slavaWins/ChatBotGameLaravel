<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class StoCharacterDataStructure extends BaseCharacterDataCast
{
    public $price = 1;
    public $repairToValue = 1;

    public function __construct($characterData = [])
    {

        $this->price = StatStructure::Make("Коэф.Цены")->SetDefault(0)->SetIcon("💵")->SetPostfix(' ₽')->FormatMoney()->SetShowInShort(false);

        $this->repairToValue = StatStructure::Make("Ремонт до")->SetDefault(1)
            ->SetIcon("⚙")->SetShowInShort(false)->SetDescr("СТО может ремонтировать машины только до такого состояния.")->SetPostfix(' HP');


        $this->UpdateValuesFromData($characterData);

        return $this;
    }
}

