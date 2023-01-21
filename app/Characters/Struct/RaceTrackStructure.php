<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class RaceTrackStructure extends BaseCharacterDataCast
{
    public $price = 1;
    public $gift_money = 1;

    public $members = 0;
    public $storage_size = 1;//size

    public $price = 1;
    public $hp = 1;
    public $hpMax = 23;

    public function __construct($characterData = [])
    {

        $this->price = StatStructure::Make("Стоимость участия")->SetDefault(0)
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);


        $this->gift_money = StatStructure::Make("Призовой фонд")->SetDefault(4000)
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);

        $this->gift_money = StatStructure::Make("Призовой фонд")->SetDefault(4000)
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);

        $this->members = StatStructure::Make("Участники")->SetDefault(1)
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);


        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
