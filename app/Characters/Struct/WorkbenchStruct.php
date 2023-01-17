<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class WorkbenchStruct extends BaseCharacterDataCast
{
    public $skill_hp = 10;
    public $workTo = "wheel";

    public function __construct($characterData = [])
    {
        $this->skill_hp = StatStructure::Make("Состояние")->SetDefault(10)
            ->SetIcon("⚙️")->SetMax(10)->SetShowInShort(true)->SetDescr("Техническое состояние верстака. Иногда его нужно чинить.");

        $this->workTo = StatStructure::Make("Назначение")->SetDefault("Шиномонтаж")
            ->SetOptions(["Шиномонтаж", "Исправление дефектов", "Исправление вмеятин", "Покрасочный цех"])
            ->SetIcon("☢️")->SetTypeString()->SetShowInShort(true)->SetDescr("Назначение верстка. Например шиномонатаж.");

        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
