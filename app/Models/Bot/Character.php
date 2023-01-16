<?php

namespace App\Models\Bot;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Library\Structure\StatStructure;
use App\Models\user;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property CharDataType $characterData
 * @property int $id
 * @property int $user_id
 * @property user $user
 * @property string className
 * @property string name
 * @template CharDataType
 */
class Character extends Model
{
    use HasFactory;


    public $icon = "✨";
    public $baseName = "Предмет";


    protected $casts = [
        'characterData' => PlayerCharacterDataStructure::class
    ];

    protected $table = 'characters';


    /**
     * Вовзращает калькулируемую дату данных. Всякие шансы хуянсы и прочее
     * @return CharDataType
     */
    public function GetStatsCalculate()
    {
        return $this->GetStats();
    }

    /**
     * Получить стоимость проккачки скила
     * @param $skillInd
     * @param $skillCurrentValue
     * @return int
     */
    public function GetSkillPrice($skillInd, $skillCurrentValue)
    {
        return [
            'money' => ($skillCurrentValue + 1) * 100
        ];
    }


    /**
     * Это публичный метод, он выводит уже реальные скилы с валую правильньыми
     * @return CharDataType
     */
    public function GetStats()
    {

        $AR = new $this->casts['characterData']($this->characterData);;
        foreach ($AR as $K => $V) {
            $V->value = $this->characterData->$K ?? $V->value;
        }
        return $AR;
    }

    public function Render($isShort = false)
    {
        $txt = $this->baseName;
        if (!empty($this->name)) {
            $txt .= ' ' . $this->name;
        }

        $txt .= $this->RenderStats();
        return $txt;
    }

    /**
     * Обновить данные в статсах
     * @return void
     */
    public function StatsUpdateData()
    {
        $isChange = false;
        foreach ($this->GetStats() as $K => $V) {
            if (!isset($this->characterData->$K)) {
                $this->$K->value = $V->default;
                $isChange = true;
            }
        }
        if ($isChange) {
            $this->save();
        }
    }

    public function ReCalc()
    {

    }

    public function RenderStats($isShort = false, $isShowDescr = false, $showSkill = false)
    {
        $this->StatsUpdateData();
        $this->ReCalc();

        $statsTemplate = $this->GetStats();
        $txt = '';


        foreach ($statsTemplate as $K => $V) {
            if (!isset($this->characterData->$K)) continue;
            if (!$showSkill && substr_count($K, "skill_")) continue;
            $txt .= "\n " . $V->RenderLine($isShort, $isShowDescr);
        }
        return $txt;
    }


    public function InitCharacter()
    {
        if (empty($this->characterData)) {
            $this->className = (new \ReflectionClass($this))->getName();

            $data = [];
            foreach ($this->GetStats() as $K => $V) {
                $data[$K] = $V->value;
            }
            $this->characterData = $data;
            //$this->save();
        }
    }

    /**
     * Загрузить чарактера по ид. Но вернуть его правильный класс
     * @param $id
     * @return Character
     */
    public static function LoadCharacterById($id)
    {
        /** @var Character $character */
        $character = Character::find($id);
        return $character->className::find($id);
    }

    public static function LoadFristCharacterByUser($user_id, $createIfNot = false)
    {

        $className = get_called_class(); //для статик класа так получается
        /** @var Character $character */
        $character = Character::where('user_Id', $user_id)->where('className', $className)->first();
        if (!$character) {
            if ($createIfNot) {
                /** @var Character $character */
                $character = new $className();
                $character->user_id = $user_id;
                $character->ReCalc();
                $character->refresh();
                $character->InitCharacter();
                $character->save();
                return $character;
            }
            return null;
        }
        return $character->className::find($character->id);
    }

}
