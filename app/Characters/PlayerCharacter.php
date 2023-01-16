<?php

namespace App\Characters;

use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;


class PlayerCharacter extends Character
{
    public $icon = "🧑‍";
    public $baseName = "Игрок";

    public function GetSkillPrice($skillInd, $skillCurrentValue)
    {
        return [
            'money' => ($skillCurrentValue + 1) * 10,
            'score_level' => 1
        ];
    }
    protected  function  GetStatsTemplate()
    {

        $maxExpa = ($this->characterData['level'] ?? 1) * 3 * 3;

        $res = [
            'money' => StatStructure::Make("Ваш баланс")->SetDefault(20000)->SetIcon("💵")->SetPostfix(' ₽')->FormatMoney(),
            'level' => StatStructure::Make("Уровень")->SetIcon("⭐")->SetShowInShort(true)->SetDefault(1),
            'expa' => StatStructure::Make("Опыт")->SetIcon("🌟")->SetMax($maxExpa)->SetShowInShort(false)->ShowProgressBar()->SetDescr("Когда вы набираете полный опыт, вы получаете очки прокачки."),

            'score_level' => StatStructure::Make("Очки навыков")->SetDefault(0)
                ->SetIcon("🔸")->SetShowInShort(false)->SetDescr("На них можно улучшать свои умения"),

            'skill_manager' => StatStructure::Make("Навык менеджмента")->SetDefault(1)
                ->SetIcon("🔸")->SetMax(10)->SetShowInShort(false)->SetDescr("Позволяет лучше управлять компанией"),

            'skill_torg' => StatStructure::Make("Навык торговли")->SetDefault(1)
                ->SetIcon("🔸")->SetMax(10)->SetShowInShort(false)->SetDescr("Чем выше этот навык, тем лучше вы торгуетесь"),

            'skill_drive' => StatStructure::Make("Навык вождения")->SetDefault(1)
                ->SetIcon("🔸")->SetMax(10)->SetShowInShort(false)->SetDescr("Чем выше этот навык, тем лучше вы водите"),

        ];

        return $res;
    }
}
