<?php

namespace App\Library\Structure;

use App\Models\User;

class BotRequestStructure
{
    /**
     * Это маркер, никуда не отправляется. Используется для пометки действия, чтоб в туторе чекать
     * @var string
     */
    public string $marker ="";

    public string $message ="";
    public int $user_id;
    public User $user;
    public string $messageFrom = "local";

}


