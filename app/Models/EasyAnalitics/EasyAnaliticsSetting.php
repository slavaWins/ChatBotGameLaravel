<?php

namespace App\Models\EasyAnalitics;

use App\Library\EasyAnalitics\EasyAnaliticsStruct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int id
 * @property string ind
 * @property string name
 * @property string descr
 *
 **/
class EasyAnaliticsSetting extends Model
{
    use HasFactory;

    /**
     * @param $ind
     * @param $forDays
     * @return EasyAnaliticsStruct|null
     */
    public static function GetAnaliticsData($ind, $forDays = 30)
    {

        $setting = self::FindByInd($ind);
        if (!$setting) return null;

        /** @var EasyAnaliticsStruct $sturctdata */
        $sturctdata = new EasyAnaliticsStruct();
        $sturctdata->setting = $setting;
        $sturctdata->data = $setting->GetAnalitics($forDays);

        $sturctdata->max = 0;
        $sturctdata->min = 100000000000;
        foreach ($sturctdata->data as $V) {
            $sturctdata->max = max($V->amount, $sturctdata->max);
            $sturctdata->min = min($V->amount, $sturctdata->min);
        }

        return $sturctdata;
    }

    public static function FindByInd($ind)
    {
        return EasyAnaliticsSetting::where('ind', $ind)->first();
    }

    public function GetAnalitics($forDays = 30)
    {
        $list = EasyAnalitics::where("ind", $this->ind)->orderBy("id")->get();
        return $list;
    }
}
