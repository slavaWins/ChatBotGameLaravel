<?php

namespace App\Library;

class Mp3Builder
{


    public static function GenRandFile($len = 5)
    {
        $list = self::GetFiles();

        $file = "";
        for ($i = 0; $i <= 5; $i++) {
            $sound = $list[rand(0, count($list) - 1)];
            $file .= file_get_contents($sound);
        }
        $nameBuild = time() . '_ra' . rand() . '.mp3';
        $p = public_path('sound/build/').$nameBuild;

        file_put_contents($p, $file);
        return '/build/'.$nameBuild;
    }

    public static function GetFiles()
    {
        $list = [];
        $p = public_path('/sound/race/');
        foreach (scandir($p) as $K => $V) if ($K > 1) {
            $list[] = $p . '' . $V;
        }
        return $list;
    }
}
