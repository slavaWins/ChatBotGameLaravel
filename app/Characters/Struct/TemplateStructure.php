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
            ->SetIcon("⚙")->SetMax(100)->SetShowInShort(true)->SetDescr("Состояние машины. Транспорт может ломаться при его использование.");

        $this->hpMax = StatStructure::Make("Макс.состояние")->SetDefault(24)->SetIcon("")->SetShowInShort(false)->Hidden();

        $this->storage_size = StatStructure::Make("Размер гаража")->SetDefault(2)->Hidden()
            ->SetIcon("📏")->SetShowInShort(true)->SetDescr("Чем больше гараж тем больше техники и машин можно в нем разместить");

        $this->storage_childs = StatStructure::Make("Места")->SetDefault(0)
            ->SetIcon("⬜")->SetShowInShort(true)->SetDescr("Сколько сейчас сейчас свободного места в гараже");

        $this->price = StatStructure::Make("Аренда")->SetDefault(7000)
            ->SetDescr("Каждый месяц вы платите аренду за этот гараж. Вы можете отказаться и съехать с этого гаража.")
            ->SetIcon("💵")->SetPostfix(' ₽/мес.')->FormatMoney()->SetShowInShort(true);


        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
