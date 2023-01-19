<?php

namespace Tests\Feature;

use App\Scene\WorkRoom;
use App\Services\Bot\ParserBotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SceneTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_room_routes()
    {
        $path = app_path("/Scene") . '/';
        foreach (scandir($path) as $KK => $name) {
            if ($KK < 2) continue;
            if ($name == "Core") continue;

            $mypath = $path . $name;
            $className = str_replace('.php', '', $name);
            $className = "App\Scene\\" . $className;
            if (!class_exists($className)) {
                return $this->assertTrue(false, "Не найден класс сцены " . $className);
            }

            $routes = ParserBotService::GetRoutesScene($className);
            if (!count($routes)) return $this->assertTrue(false, "Нет не одного шага, нет роутов в " . $className);
            if (!isset($routes[0])) return $this->assertTrue(false, "Нет стартового шага Step0_XX в " . $className);

            $this->assertTrue(true);
        }
    }
}
