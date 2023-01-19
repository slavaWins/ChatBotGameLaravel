<?php

namespace App\Services\Bot;

use App\Models\Bot\Character;
use App\Models\User;

class ParserBotService
{

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
