<?php

namespace App\Services\Bot;

use App\BotTutorials\StartTutorial;
use App\Models\Bot\Character;
use App\Models\Bot\History;
use App\Models\Bot\Scene;
use App\Models\User;

class ResetService
{

    public static function UserRestContent(User $user)
    {
        History::where('user_id', $user->id)->delete();
        Character::where('user_id', $user->id)->delete();
        Scene::where('user_id', $user->id)->delete();
        $user->is_registration_end = false;
        $user->tutorial_step = 0;
        $user->tutorial_class = StartTutorial::class . '';
        $user->save();
    }

}
