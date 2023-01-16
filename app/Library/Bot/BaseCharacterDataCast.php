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

}
