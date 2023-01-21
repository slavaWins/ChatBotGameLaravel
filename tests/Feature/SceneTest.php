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
        $rooms= ParserBotService::GetRoomClasses();

        foreach ($rooms as $KK => $name) {



            $className = $name;

            echo "   ✓".$name."\n";

            $this->assertTrue(class_exists($className), "Не найден класс сцены " . $className);


            $routes = ParserBotService::GetRoutesScene($className);
            $this->assertTrue(count($routes) > 0, "Нет не одного шага, нет роутов в " . $className);

            $this->assertTrue(isset($routes[0]), "Нет стартового шага Step0_XX в " . $className);

            $this->assertTrue(true);
        }
    }
}
