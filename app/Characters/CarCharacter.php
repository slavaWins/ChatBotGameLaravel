<?php

namespace App\Characters;

use App\Characters\Shop\EnginePartShop;
use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\GarageCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Library\Structure\StatStructure;
use App\Models\Bot\Character;


/**
 * @implements Character<CarCharacterDataStructure>
 */
class CarCharacter extends Character
{
    public $icon = "🚘";
    public $baseName = "Автомобиль";

    protected $casts = [
        'characterData' => CarCharacterDataStructure::class
    ];

    public function GetSkillPrice($skillInd, $skillCurrentValue)
    {
        return [
            'money' => ($skillCurrentValue + 1) * 250,
        ];
    }

    public function GetTrackData($len)
    {

        //time_to_max-время до макс скорости
        //len_to_100- метров до 100кмч
        //time_to_track- время до всего трека

        $stats = $this->GetStats();

        $res = [];

        $res['time_to_max'] = (max(1, $stats->maxSpeed->value - 100) * $stats->razgon->value * 0.18) - $stats->razgon->value;
        $res['len_to_100'] = (30 / 6 * $stats->razgon->value);
        $res['time_to_track'] = 0;

        $res['time_to_track'] += $res['time_to_max'];
        if ($len < $res['len_to_100']) {
            $res['time_to_track'] = $res['time_to_track'] * ($len / $res['len_to_100']);
        } else {
            $len -= $res['len_to_100'];

            $res['time_to_track'] += $len * (($stats->maxSpeed->value / 3600) * 1);
        }

        return $res;
    }

    public function GetPriceOneHpRepair()
    {
        $stats = $this->GetStatsCalculate();

        return round(($stats->price->value / $stats->hpMax->value) * 0.3);
    }


    /**
     * @param $partType
     * @return EnginePartCharacter|null
     */
    public function IssetEnginePart($partType)
    {

        $list = $this->GetEngineParts();

        if (!$list) return null;

        return $list->filter(function (EnginePartCharacter $item) use ($partType) {
            return $item->characterData->partType == $partType;
        })->first() ?? null;
    }


    /** @var */
    private $enginePartsList = -1;

    /**
     * @return EnginePartCharacter[]
     */
    public function GetEngineParts()
    {
        if ($this->enginePartsList === -1) {
            $this->enginePartsList = $this->GetChildldren(EnginePartCharacter::class) ?? null;
        }
        return $this->enginePartsList;
    }

    public function GetStatsCalculate()
    {
        $res = $this->GetStats();

        $basePower = $res->power->value;
        $baseSpeed = $res->maxSpeed->value;

        $res->power->value += ($basePower * $res->skill_engine->value) / 10;
        $res->power->value += ($basePower * $res->skill_kpp->value) / 14;

        $res->razgon->value = $res->mass->value / $res->power->value;


        $res->hp->max = $res->hpMax->value;
        $res->hp->value = min($res->hp->value, $res->hpMax->value);


        $parts = $this->GetEngineParts();

        if ($parts) foreach ($parts as $part) {
            $res->power->value += $basePower * ($part->characterData->boostPower / 100);
            $res->razgon->value -= $res->razgon->value * ($part->characterData->boostRazgon / 100);
            $res->maxSpeed->value += $baseSpeed * ($part->characterData->boostSpeed / 100);
            //$res->price->value += $part->characterData->price;

        }
        $res->razgon->value = round($res->razgon->value, 2);
        $res->maxSpeed->value = round($res->maxSpeed->value);

        return $res;
    }

    function RenderAppend($isShort = false, $isShowDescr = false, $showSkill = false)
    {

        if ($isShort) return "";

        $text = "";
        $parts = $this->GetEngineParts();

        if (!$parts) {
            return "Нет модификаций";
        }

        foreach ($parts as $part) {
            $text .= "\n\n" . $part->Render(true);
        }

        return $text;
    }

}
