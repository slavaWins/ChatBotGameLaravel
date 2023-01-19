<?php

namespace Tests\Feature;

use App\Http\Controllers\Bot\Dev\MessageBoxController;
use App\Scene\WorkRoom;
use App\Services\Bot\ParserBotService;
use App\Services\Bot\ResetService;
use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BotLiveTest extends TestCase
{


    public \App\Models\User $user;

    public function test_bot_live()
    {
        $user = new \App\Models\User();
        $this->user = $user;
        $user->name = "BotLive";
        $user->save();


        MessageBoxController::MakeAutoTest($user, 8, false);

        $this->assertTrue(($user->player->characterData->money > 1000), "У игрока меньше косаря дененг в начале игры " . $user->player->characterData->money . ' RUB.');

        for ($i = 0; $i < 5; $i++) {
            MessageBoxController::MakeAutoTest($user, 8, false);
        }

        //$user->refresh();
        $this->assertTrue($user->player <> null, "У игрока не создается player");
        $this->assertTrue($user->GetAllCharacters()->count() >= 2, "У игрока меньше 2 сущеностей. Он ничем не обжился!");


        ResetService::UserRestContent($user);
        $user->delete();


        $this->assertTrue(true);
    }

}
