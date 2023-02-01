<?php

namespace App\Models\Bot;

use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MrProperter\Library\PropertyBuilderStructure;
use MrProperter\Library\PropertyConfigStructure;
use MrProperter\Models\MPModel;
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



    public function PropertiesSetting()
    {
        $config = new PropertyConfigStructure($this);

        $config->Checkbox("selector_character_enabled")->SetLabel("Селектор чарактера")
            ->SetDescr("Вывести все чары определенного типа, и сохр в переменные комнаты");

        $config->Select("selector_character")->SetLabel("Чарактер")->SetOptions(['Garage', 'Room', 'Enemy'])
            ->SetDescr("Выводим чаректер селектор на этом шаге, и сейвет результат в id");

        $config->Select("selector_character_filter")->SetLabel("Фильтр чаров")->SetOptions(['Принадлежит игроку', 'Переменная 1', 'Перменная 2'])
            ->SetDescr("Фильтр для выбора чара");

        $config->Select("selector_character_to_varible")->SetLabel("Сохр в ")->SetOptions(['Никуда', 'В перемен1', 'Перменная 2'])
            ->SetDescr("После выбора чара куда сохранить выбранное?");

        $config->Checkbox("render_character_enabled")->SetLabel("Включить рендер?")->SetDefault(true)
            ->SetDescr("Отрендерить чарактера сохраненного в комнате?");

        $config->Select("render_character")->SetLabel("Рендерить переменную")->SetOptions(['Не рендерить', 'Garage', 'Player'])
            ->SetDescr("Этот чарактер будет отрендерен");

        $config->Int("render_character")->SetLabel("Пользователь")
            ->SetDescr("Этот чарактер будет отрендерен")->SetMax(10)
            ->SetMin(1)->Comment("Поле пользователя")
            ->SetDescr("Описание поля");

        $config->String("message")->SetLabel("Пользователь")
            ->SetDescr("Поле с описание типа")->SetMin(3)->SetMax(6)->Comment("Поле с описание типа")
            ->SetDescr("Описание поля")->AddTag('test');

        return $config->GetConfig();
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");

    }

}
