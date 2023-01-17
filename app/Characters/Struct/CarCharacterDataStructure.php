<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class CarCharacterDataStructure extends BaseCharacterDataCast
{

    public $hp = 1;
    public $razgon = 13;
    public $power = 255;
    public $mass = 930;
    public $hpMax = 23;
    public $skill_engine = 0;
    public $skill_kpp = 0;
    public $price = 1;

    public $defect_kpp = 0;
    public $marka = "Car";

    public function __construct($characterData = [])
    {
        $this->hp = StatStructure::Make("Состояние")->SetDefault(1)->SetProgressBarIcons('⚙', '⛭')->ShowProgressBar()
            ->SetIcon("⚙")->SetMax(100)->SetShowInShort(true)->SetDescr("Состояние машины. Транспорт может ломаться при его использование.");

        $this->hpMax = StatStructure::Make("Макс.состояние")->SetDefault(24)->SetIcon("")->SetShowInShort(false)->Hidden();
        $this->mass = StatStructure::Make("Вес")->SetDefault(1200)->SetIcon("🛎️")->SetPostfix(' кг.');
        $this->power = StatStructure::Make("Мощность")->SetDefault(78)->SetIcon("🔩")->SetPostfix(' л.с.');
        $this->razgon = StatStructure::Make("Разгон 0-100км")->SetDefault(17.5)->SetIcon("🚥")->SetPostfix(' сек.');

        $this->price = StatStructure::Make("Цена")->SetDefault(0)->SetIcon("💵")->SetPostfix(' ₽')->FormatMoney()->SetShowInShort(false);

        $this->skill_engine = StatStructure::Make("Тюнинг двигателя")->SetDefault(1)
            ->SetIcon("🧰")->SetMax(10)->SetShowInShort(false)->SetDescr("Тюнинг")->SetPostfix(' lev.');

        $this->skill_kpp = StatStructure::Make("Тюнинг коробки передач")->SetDefault(1)
            ->SetIcon("🧰")->SetMax(10)->SetShowInShort(false)->SetDescr("Тюнинг")->SetPostfix(' lev.');


        $this->defect_kpp = StatStructure::Make("Дефект КПП")->SetDefault(0)->PreapendLabel("Дефекты:")
            ->SetIcon("⚠")->SetShowInShort(false)->SetDescr("Дефект машины, которые тяжело и долго чинить");


        $this->marka = StatStructure::Make("Марка")->SetDefault("Dolorian")->Hidden()->ShopCategory()->SetTypeString()
            ->SetShowInShort(false);



        $this->UpdateValuesFromData($characterData);

        return $this;
    }
}

