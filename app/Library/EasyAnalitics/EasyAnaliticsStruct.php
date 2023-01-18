<?php

namespace App\Library\EasyAnalitics;


use App\Models\EasyAnalitics\EasyAnalitics;
use App\Models\EasyAnalitics\EasyAnaliticsSetting;
use Carbon\Carbon;

/**
 * @property EasyAnalitics[] $data
 */
class EasyAnaliticsStruct
{

    public $data;
    public EasyAnaliticsSetting $setting;
    public int $min;
    public int $max;


}
