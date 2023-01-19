<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class TemplateStructure extends BaseCharacterDataCast
{
    public $storage_childs = 0;
    public $storage_size = 1;//size

    public $price = 1;
    public $hp = 1;
    public $hpMax = 23;

    public function __construct($characterData = [])
    {
        $this->hp = StatStructure::Make("Состояние")->SetDefault(1)->SetProgressBarIcons('⚙', '⛭')->ShowProgressBar()
            ->SetIcon("⚙")->SetMax(100)->SetShowInShort(true);

        $this->hpMax = StatStructure::Make("Макс.состояние")->SetDefault(24)->SetIcon("")->SetShowInShort(false)->Hidden();

        $this->storage_size = StatStructure::Make("Размер")->SetDefault(2)->Hidden()
            ->SetIcon("📏")->SetShowInShort(true);

        $this->storage_childs = StatStructure::Make("Места")->SetDefault(0)
            ->SetIcon("⬜")->SetShowInShort(true)->SetDescr("Сколько сейчас сейчас свободного места");

        $this->price = StatStructure::Make("Цена")->SetDefault(7000)
            ->SetIcon("💵")->SetPostfix(' ₽.')->FormatMoney()->SetShowInShort(true);


        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
