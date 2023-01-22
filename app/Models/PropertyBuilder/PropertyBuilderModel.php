<?php

namespace App\Models\PropertyBuilder;

use App\Library\PropertyBuilder\PropertyBuilderStructure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use SlavaWins\Formbuilder\Library\FElement;


class PropertyBuilderModel extends Model
{


    public static function GetValidateRules($tag = null)
    {
        /** @var PropertyBuilderModel $cl */
        $cln = get_called_class();
        $cl = new $cln();
        $props = $cl->GetByTag($tag);

        $rules = [];

        /**
         * @var  $K
         * @var PropertyBuilderStructure $prop
         */
        foreach ($props as $K => $prop) {
            $text = $prop->typeData;
            if ($prop->max) $text .= "|max:" . $prop->max;
            if ($prop->min) $text .= "|min:" . $prop->min;
            $rules[$K] = $text;
        }

        return $rules;
    }

    /**
     * @param $tag
     * @return PropertyBuilderStructure[]
     */
    public function GetByTag($tag = null)
    {
        return collect($this->GetPropertys())->filter(function (PropertyBuilderStructure $e) use ($tag) {
            if ($tag == null) return true;
            if (isset($e->tags[$tag])) return true;
            return false;
        });
    }

    public function BuildInputAll($tag = null)
    {
        $p = $this->GetPropertys();

        $html = "";
        foreach ($this->toArray() as $K => $V) {
            if (!isset($p[$K])) continue;

            if ($tag) {
                if (!$p[$K]->tags) continue;
                if (!isset($p[$K]->tags[$tag])) continue;
            }
            $html .= $this->BuildInput($K);
        }
    }

    public function BuildInput($ind)
    {
        $p = $this->GetPropertys();
        if (!isset($p[$ind])) return null;
        $prop = $p[$ind];
        $inp = FElement::NewInputTextRow()
            ->SetLabel($prop->name)
            ->SetPlaceholder($prop->descr ?? null)
            ->SetName($ind)
            ->SetDescr($prop->descr ?? null); //->FrontendValidate()->String(0, 75)

        if ($prop->typeData == "string") {
            $inp->FrontendValidate()->String($prop->min, $prop->max ?? 999999);
        }

        $html = $inp->SetValue(old($ind, $this->$ind ?? ""))
            ->RenderHtml(true);

    }

    /**
     * @return PropertyBuilderStructure[]
     */
    public function GetPropertys()
    {
        return [
            'name' => PropertyBuilderStructure::New("Название")
                ->SetDescr("Описание поля")->SetIcon("🌟"),
            'className' => PropertyBuilderStructure::New("Название класса")->SetDescr("Описание поля")->SetIcon("🌟"),
        ];
    }

}
