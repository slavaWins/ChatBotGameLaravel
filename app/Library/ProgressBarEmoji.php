<?php

namespace App\Library;

class ProgressBarEmoji
{

    public static function Render($percent, $iconOn = "▰", $iconOff = "▱", $len = 9)
    {
        if ($percent > 1) $percent = $percent / 100;

        if ($percent < 0) $percent = 0;
        $filble = round($len * $percent);

        $text = "\n" . str_repeat($iconOn, $filble) . str_repeat($iconOff, $len - $filble);

        return $text;
    }
}
