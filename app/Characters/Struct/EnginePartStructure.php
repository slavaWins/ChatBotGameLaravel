<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class EnginePartStructure extends BaseCharacterDataCast
{


    public $partType = "turbo";
    public $boostPower = 0;
    public $boostSpeed = 0;
    public $boostRazgon = 0;
    public $price = 1;
    public $hp = 1;
    public $hpMax = 23;

    public static function EnginePartsTypes()
    {
        $listTypes = [];

        $listTypes["Турбонаддув"] = "Турбонаддув";
        $listTypes["Зажигание"] = "Зажигание";
        $listTypes["КПП"] = "КПП";

        return $listTypes;
    }

    public function __construct($characterData = [])
    {


        $this->partType = StatStructure::Make("Тип")->SetDefault("turbo")->SetOptions(self::EnginePartsTypes())->SetShowInShort(true)->Hidden();


        $this->hp = StatStructure::Make("Состояние")->SetDefault(1)->SetProgressBarIcons('⚙', '⛭')->ShowProgressBar()
            ->SetIcon("⚙")->SetMax(100)->SetShowInShort(true);

        $this->hpMax = StatStructure::Make("Прочность")->SetDefault(24)->SetIcon("")->SetShowInShort(false)->Hidden();


        $this->price = StatStructure::Make("Цена")->SetDefault(7000)->Hidden()
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);


        $this->boostRazgon = StatStructure::Make("Буст ускорения")->SetDefault(0)
            ->SetIcon("🚥")->SetPostfix(' %')->SetShowInShort(true);

        $this->boostSpeed = StatStructure::Make("Буст скорости")->SetDefault(0)
            ->SetDescr("На сколько бустит максимальную скорость машины")
            ->SetIcon("🚥")->SetPostfix(' %')->SetShowInShort(true);

        $this->boostPower = StatStructure::Make("Буст мощности")->SetDefault(0)
            ->SetIcon("🚥")->SetPostfix(' %')->SetShowInShort(true);


        $this->UpdateValuesFromData($characterData);;


        return $this;
    }
}
