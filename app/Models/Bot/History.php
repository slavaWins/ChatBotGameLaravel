<?php

namespace App\Models\Bot;

use Illuminate\Database\Schema\Blueprint;
use App\Library\MrProperter\PropertyBuilderStructure;
use App\Models\PropertyBuilder\MPModel;
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
 * @property string message_response
 * @property array buttons
 * @property boolean isFromBot
 * @property string|null $attachment_sound
 */
class History extends MPModel
{


    public static $STATUS = ['create' => "Толькол Создан", 'moder' => "На модерации", 'moderCheck' => "На уточнение", 'edit' => "Редактируется", 'active' => "Работает",];


    public function GetPropertys()
    {
        return [
            'user_id' => PropertyBuilderStructure::Int("Пользователь")->AddTag(['home', 'test'])
                ->SetMax(10)
                ->SetMin(1)->Comment("Поле пользователя")
                ->SetDescr("Описание поля")->SetIcon("🌟"),
            'message' => PropertyBuilderStructure::String("описание")
                ->SetMin(3)->SetMax(6)->Comment("Поле с описание типа")
                ->SetDescr("Описание поля")->SetIcon("🌟")->AddTag('test'),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");

    }

}
