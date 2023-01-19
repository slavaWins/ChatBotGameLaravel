<?php

namespace App\Library;

class ProgressBarEmoji
{

    public static function Console($percent, $len = 9)
    {
        return '|' . ProgressBarEmoji::Render($percent, "█", "-", 25) . '| ' . number_format($percent * 100, 1) . "% ";
    }

    public static function Render($percent, $iconOn = "▰", $iconOff = "▱", $len = 9)
    {
        if ($percent > 1) $percent = $percent / 100;

        if ($percent < 0) $percent = 0;
        $filble = round($len * $percent);

        $text = str_repeat($iconOn, $filble) . str_repeat($iconOff, $len - $filble);

        return $text;
    }
}
