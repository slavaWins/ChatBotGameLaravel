<?php

namespace App\Models\Bot;

use App\Library\PropertyBuilder\PropertyBuilderStructure;
use App\Models\PropertyBuilder\PropertyBuilderModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed $className
 * @property int|mixed $step
 * @property mixed $id
 * @property mixed|string $start_message
 * @property mixed|string $selector_character
 * @property mixed|string selector_character_filter
 * @property mixed|string selector_character_to_varible
 * @property mixed|string $btn_next
 * @property mixed|string $btn_back
 * @property mixed|string $btn_exit
 * @property mixed|string btn_scene_name1
 * @property mixed|string btn_scene_name2
 * @property mixed|string btn_scene_input2
 * @property mixed|string btn_scene_class1
 * @property mixed|string btn_scene_class2
 * @property mixed|string btn_scene_input1
 * @property mixed|string btn_shop_name
 * @property mixed|string btn_shop_class
 * @property mixed|string render_character
 * @property mixed|string btn_shop_parent
 * @property mixed|string $name
 * @property mixed|string $ind
 */
class VirtualStep extends PropertyBuilderModel
{
    use HasFactory;


    public function GetPropertys()
    {
        return [
            'selector_character_enabled' => PropertyBuilderStructure::Checkbox("Селектор чарактера")
                ->SetDescr("Вывести все чары определенного типа, и сохр в переменные комнаты"),

            'selector_character' => PropertyBuilderStructure::Select("Селектор чаров")->SetOptions(['Garage', 'Room', 'Enemy'])
                ->SetDescr("Выводим чаректер селектор на этом шаге, и сейвет результат в id"),

            'selector_character_filter' => PropertyBuilderStructure::Select("Фильтр чаров")->SetOptions(['Принадлежит игроку', 'Переменная 1', 'Перменная 2'])
                ->SetDescr("Фильтр для выбора чара"),

            'selector_character_to_varible' => PropertyBuilderStructure::Select("Сохр в")->SetOptions(['Никуда', 'В перемен1', 'Перменная 2'])
                ->SetDescr("После выбора чара куда сохранить выбранное?"),

            'render_character_enabled' => PropertyBuilderStructure::Checkbox("Рендерить переменную")->SetDefault(true)
                ->SetDescr("Отрендерить чарактера сохраненного в комнате?"),

            'render_character' => PropertyBuilderStructure::Select("Рендерить переменную")->SetOptions(['Не рендерить', 'Garage', 'Player'])
                ->SetDescr("Этот чарактер будет отрендерен"),

            'user_id' => PropertyBuilderStructure::Int("Пользователь")
                ->SetMax(10)
                ->SetMin(1)->Comment("Поле пользователя")
                ->SetDescr("Описание поля")->SetIcon("🌟"),
            'message' => PropertyBuilderStructure::String("описание")
                ->SetMin(3)->SetMax(6)->Comment("Поле с описание типа")
                ->SetDescr("Описание поля")->SetIcon("🌟")->AddTag('test'),
        ];
    }


    /**
     * @var mixed|string
     */

    public function GetBtns($btns = [])
    {

        if ($this->btn_next) $btns[$this->btn_next] = 0;
        if ($this->btn_back) $btns[$this->btn_back] = 0;
        if ($this->btn_exit) $btns[$this->btn_exit] = 0;
        if ($this->btn_scene_name1) $btns[$this->btn_scene_name1] = 0;
        if ($this->btn_scene_name2) $btns[$this->btn_scene_name2] = 0;
        if ($this->btn_shop_name) $btns[$this->btn_shop_name] = 0;
        return $btns;
    }

    public function GetStepFunctionName()
    {
        if ($this->selector_character) return "Select" . basename($this->selector_character);
        if ($this->render_character) return "Show" . basename($this->render_character);
        if ($this->btn_shop_name) return "Shop" . basename($this->btn_shop_class);

        return "Text";
    }

}
