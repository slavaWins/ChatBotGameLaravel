<?php

namespace App\Services\Bot;

use App\Models\Bot\Character;
use App\Models\User;

class ParserBotService
{
    public static function GetShopItmesClasses()
    {
        $list = [];
        foreach (scandir(app_path("Characters/Shop")) as $K => $V) if ($K > 1) {
            $V = str_replace(".php", "", $V);
            if ($V == "TemplateShop") continue;
            $V = 'App\Characters\Shop\\' . $V;
            $list[] = new $V();
        }
        return $list;
    }
    public static function GetRoomClasses()
    {
        $list = [];

        foreach (scandir(app_path("Scene")) as $K => $V) if ($K > 1) {
            if (!substr_count($V, ".php")) continue;
            $V = str_replace(".php", "", $V);
            $V = 'App\Scene\\' . $V;
            $list[] = $V;
        }

        foreach (scandir(app_path("Scene/Virtual")) as $K => $V) if ($K > 1) {
            if (!substr_count($V, ".php")) continue;
            $V = str_replace(".php", "", $V);
            $V = 'App\Scene\Virtual\\' . $V;
            $list[] = $V;
        }
        return $list;
    }
    public static function GetCharacterClasses()
    {
        $list = [];
        foreach (scandir(app_path("Characters")) as $K => $V) if ($K > 1) {
            if (!substr_count($V, ".php")) continue;
            $V = str_replace(".php", "", $V);
            $V = 'App\Characters\\' . $V;
            $list[] = $V;
        }
        return $list;
    }

    public static function GetRoutesScene($myClass)
    {
        $routes = [];
        foreach (get_class_methods($myClass) as $V) {
            if (strpos($V, "Step") !== 0) continue;
            $id = str_replace("Step", "", $V);
            $id = intval(substr($id, 0, 1));
            $routes[$id] = $V;
        }
        return $routes;
    }

}
