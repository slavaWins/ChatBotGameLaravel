<?php

namespace App\Characters\Struct;

use App\Library\Bot\BaseCharacterDataCast;
use App\Library\Structure\StatStructure;

class PlayerCharacterDataStructure extends BaseCharacterDataCast
{

    public $money;

    public $level;
    public $expa;
    public $score_level;
    public $skill_manager;
    public $skill_torg;
    public $skill_drive;


    public function __construct($characterData = [])
    {

        $maxExpa = ($characterData->level ?? 1) * 3 * 3;

        $this->money = StatStructure::Make("Ваш баланс")->SetDefault(20000)->SetIcon("💵")->SetPostfix(' ₽')->FormatMoney();

        $this->level = StatStructure::Make("Уровень")->SetIcon("⭐")->SetShowInShort(true)->SetDefault(1);

        $this->expa = StatStructure::Make("Опыт")->SetIcon("🌟")->SetMax($maxExpa)->SetShowInShort(false)->ShowProgressBar()->SetDescr("Когда вы набираете полный опыт, вы получаете очки прокачки.");

        $this->score_level = StatStructure::Make("Очки навыков")->SetDefault(0)
            ->SetIcon("🔸")->SetShowInShort(false)->SetDescr("На них можно улучшать свои умения");

        $this->skill_manager = StatStructure::Make("Навык менеджмента")->SetDefault(1)
            ->SetIcon("🔸")->SetMax(10)->SetShowInShort(false)->SetDescr("Позволяет лучше управлять компанией");

        $this->skill_torg = StatStructure::Make("Навык торговли")->SetDefault(1)
            ->SetIcon("🔸")->SetMax(10)->SetShowInShort(false)->SetDescr("Чем выше этот навык, тем лучше вы торгуетесь");

        $this->skill_drive = StatStructure::Make("Навык вождения")->SetDefault(1)
            ->SetIcon("🔸")->SetMax(10)->SetShowInShort(false)->SetDescr("Чем выше этот навык, тем лучше вы водите");

        $this->UpdateValuesFromData($characterData);;

        return $this;
    }
}
