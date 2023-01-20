<?php

namespace App\Models\Bot;

use App\Characters\Struct\CarCharacterDataStructure;
use App\Characters\Struct\PlayerCharacterDataStructure;
use App\Characters\WorkbenchCharacter;
use App\Library\Structure\StatStructure;
use App\Models\user;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * @property CharDataType $characterData
 * @property int $id
 * @property int $user_id
 * @property int $parent_id родитель объекта. Например машина в гараже
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
     * Вовзращает калькулируемую дату данных. Всякие шансы хуянсы и прочее учитывается.
     * Например если речь о машине, то может мощность вывестись уже с учетом скилов
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
     * Является ли этот чарактер инвартерем или хранилищем?
     * @return bool
     */
    public function IsStorage()
    {
        return isset($this->characterData->storage_size) && isset($this->characterData->storage_childs);
    }

    /**
     * Получить список всех машин
     * @return Collection<Character>
     */
    function GetChildldren($byClass = null)
    {
        //if(!$this->IsStorage())return [];
        if ($this->id == 0) return [];
        //$items = Character::where("parent_id", $this->id)->get();

        $items = [];
        if ($byClass) {
            $items = $byClass::where("parent_id", $this->id);
        } else {
            $items = Character::where("parent_id", $this->id);
        }

        if ($byClass) {
            $items = $items->where("className", $byClass);
        }
        $items = $items->get();

        return $items;
    }

    function GetFreeSlotsCount()
    {
        if (!$this->IsStorage()) return 0;
        return $this->characterData->storage_size - $this->GetStatsCalculate()->storage_childs->value;
    }

    /**
     * Это публичный метод, он выводит уже реальные скилы с валую правильньыми
     * @return CharDataType
     */
    public function GetStats()
    {

        $AR = new $this->casts['characterData']($this->characterData);;


        foreach ($AR as $K => $V) {
            if (!is_object($V)) {
                Log::error("В структуре чара " . $this->casts['characterData'] . ' Параметр ' . $K . ' Не правильно прописан! Там его в констуктор класса надо занести!');
                continue;
            }
            $V->value = $this->characterData->$K ?? $V->value;
        }
        return $AR;
    }

    public function GetName()
    {
        return $this->icon . ' ' . ($this->name ?? $this->baseName);
    }

    public function Render($isShort = false, $isShowDescr = false, $showSkill = false)
    {
        $txt = $this->GetName();

        $txt .= $this->RenderStats($isShort, $isShowDescr, $showSkill);

        $txt .= $this->RenderAppend($isShort, $isShowDescr, $showSkill);
        return $txt;
    }

    /**
     * Добавить в конец рендера эту строку
     * @return string
     */
    public function RenderAppend($isShort = false, $isShowDescr = false, $showSkill = false)
    {
        return "";
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
                if (!is_object($V)) continue;
                $this->characterData->$K = $V->default;
                $isChange = true;
            }
        }
        if ($isChange) {
            $this->save();
        }
    }


    public function RenderStats($isShort = false, $isShowDescr = false, $showSkill = false)
    {
        $this->StatsUpdateData();


        /** @var StatStructure[] $statsTemplate */
        $statsTemplate = $this->GetStatsCalculate();
        $txt = '';


        foreach ($statsTemplate as $K => $V) {
            if (!isset($this->characterData->$K)) continue;
            if ($V->is_hidden_property) continue;
            if ($isShort && !$V->isShowShort) continue;
            if (!$showSkill && substr_count($K, "skill_")) continue;

            if ($V->preapendLabel) {
                $txt .= "\n\n " . $V->preapendLabel;
            }
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
        }
    }

    /**
     * Загрузить чарактера по ид. Но вернуть его правильный класс
     * @param $id
     * @return Character
     */
    public static function LoadCharacterById($id)
    {
        if (!$id) return null;

        /** @var Character $character */
        $character = Character::select(['id', 'className'])->find($id);

        if (!$character) return null;

        return $character->className::find($id);
    }

    public static function CreateCharacter($user_id = 0, $characterData = null)
    {
        $className = get_called_class(); //для статик класа так получается

        /** @var Character $character */
        $character = new $className();

        $character->user_id = $user_id ?? 0;
        $character->refresh();
        $character->InitCharacter();

        if ($characterData) {
            $character->characterData = $characterData;
        }

        $character->save();

        return $character;
    }

    public static function LoadFristCharacterByUser($user_id, $createIfNot = false)
    {

        $className = get_called_class(); //для статик класа так получается

        /** @var Character $character */
        $character = $className::where('user_Id', $user_id)->where('className', $className)->first();

        if (!$character) {
            if ($createIfNot) {
                /** @var Character $character */
                $character = new $className();
                $character->user_id = $user_id;

                $character->refresh();
                $character->InitCharacter();
                $character->save();
                return $character;
            }
            return null;
        }

        return $character;
    }


    public function Damage($amount)
    {
        $this->characterData->hp -= $amount;
        if ($this->characterData->hp <= 0) $this->characterData->hp = 0;
        $tex = "  " . $this->GetStats()->hp->icon . " Получен урон: -" . number_format($amount) . " " . $this->GetStats()->hp->postfix;
        $tex .= "\n " . $this->GetStatsCalculate()->hp->RenderLine(true);
        return $tex;
    }

    public function GetHpPercent()
    {
        if (!isset($this->characterData->hp)) return null;
        if (!isset($this->characterData->hpMax)) return null;
        return $this->GetStatsCalculate()->hp->value / $this->characterData->hpMax;
    }
}
