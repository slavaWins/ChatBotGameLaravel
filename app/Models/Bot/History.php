<?php

namespace App\Models\Bot;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * @property int id
 * @property int user_id
 * @property User user
 * @property string attachment
 * @property string message
 * @property array buttons
 * @property boolean isFromBot
 * @property string|null $attachment_sound
 */
class History extends Model {


    public static $STATUS = ['create' => "Толькол Создан", 'moder' => "На модерации", 'moderCheck' => "На уточнение", 'edit' => "Редактируется", 'active' => "Работает",];


    public function user() {
        return $this->belongsTo(User::class, "user_id");

    }

}
