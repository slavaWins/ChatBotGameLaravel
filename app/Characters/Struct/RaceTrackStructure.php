<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class RaceTrackStructure extends BaseCharacterDataCast
{
    public $price = 1;
    public $gift_money = 1;
    public $members = 0;
    public $level = 1;
    public $track_len = 1;

    public $car_price = 1;
    public $power = 1;

    public function __construct($characterData = [])
    {

        $this->price = StatStructure::Make("Стоимость участия")->SetDefault(0)
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);


        $this->gift_money = StatStructure::Make("Призовой фонд")->SetDefault(4000)
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);


        $this->members = StatStructure::Make("Участников")->SetDefault(1)->Hidden()
            ->SetIcon("🚹")->SetShowInShort(true);

        $this->level = StatStructure::Make("Сложность")->SetDefault(1)->SetPostfix(" Lev.")
            ->SetIcon("❗ ")->SetShowInShort(true);

        $this->track_len = StatStructure::Make("Длинна трека")->SetDefault(1)->SetPostfix(" м.")
            ->SetIcon("⭕ ")->SetShowInShort(true);


        $this->car_price = StatStructure::Make("Машина от")->SetDefault(9000)->PreapendLabel("Требования к машине:")->Hidden()
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);

        $this->power = StatStructure::Make("Мощность от")->SetDefault(45)->Hidden()
            ->SetIcon("💵")->SetPostfix(' л.с')->FormatMoney()->SetShowInShort(true);

        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
