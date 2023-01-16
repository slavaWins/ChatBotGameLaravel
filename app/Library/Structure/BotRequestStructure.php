<?php

namespace App\Library\Structure;

use App\Models\User;

class BotRequestStructure
{
    public string $message ="";
    public int $user_id;
    public User $user;
    public string $messageFrom = "local";

}


