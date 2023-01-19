<?php

namespace App\Characters;

use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;
use SlavaWins\EasyAnalitics\Library\EasyAnaliticsHelper;


/**
 * @implements Character<PlayerCharacterDataStructure>
 */
class PlayerCharacter extends Character
{
    public $icon = "🧑‍";
    public $baseName = "Игрок";

    protected $casts = [
        'characterData' => PlayerCharacterDataStructure::class
    ];

    public function GetSkillPrice($skillInd, $skillCurrentValue)
    {
        return [
            'money' => ($skillCurrentValue + 1) * 10,
            'score_level' => 1
        ];
    }


    public function GetHeader()
    {
        $text = "";

        $calc = $this->GetStatsCalculate();
        $text .= $calc->money->RenderLine();
        $text .= "  " . $calc->level->RenderLine();
        if ($calc->score_level->value) {
            $text .= "  " . $calc->score_level->RenderLine();
        }
        $text .= "\n\n";

        return $text;
    }

    public function AddMoney($amount)
    {
        $tex = "\n " . $this->GetStats()->money->icon . " Вы получили деньги: +" . number_format($amount) . " ₽ ";
        $this->characterData->money += $amount;
        EasyAnaliticsHelper::Increment("money_plus", $amount, "Игроки заработали", "Сколько всего денег заработали игроки");
        return $tex;
    }

    public function AddExpa($amount)
    {
        $tex = "\n Вы получили опыт: +" . $amount . " " . $this->GetStats()->expa->icon;
        $this->characterData->expa += $amount;
        $needExpa = $this->GetStats()->expa->max;

        if ($this->characterData->expa > $needExpa) {
            $this->characterData->level += 1;
            $this->characterData->expa -= $needExpa;
            EasyAnaliticsHelper::Increment("level_plus", 1, "Игрок левелапнулись", "Сколько всего левелапов было сделано");
            $tex = "\n 🌟🌟 У ВАС НОВЫЙ УРОВЕНЬ: " . $this->characterData->level . " 🌟🌟 ";
        } else {
          //  $tex .= "\n До след уровня: \n";
            $tex .="\n". $this->GetStats()->expa->RenderLine(false, false, $this->characterData->expa);
        }
        return $tex;
    }

}
