<?php

namespace App\Library\Bot;

class BaseCharacterDataCast
{


    public function get($model, $key, $value, $attributes)
    {

        return json_decode($value);
    }

    public function set($model, $key, $value, $attributes)
    {
        return [$key => json_encode($value)];
    }

    public function UpdateValuesFromData($characterData)
    {
        $characterData = (array)$characterData;

        foreach ((array)$this as $K => $V) {
            if (!isset($characterData[$K])) continue;
            $this->$K->value = $characterData[$K];
        }
    }
}
