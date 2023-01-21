<?php

namespace App\Models\Bot;

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
 * @property mixed|string btn_scene_name
 * @property mixed|string btn_scene_class
 * @property mixed|string btn_shop_name
 * @property mixed|string btn_shop_class
 * @property mixed|string render_character
 * @property mixed|string btn_shop_parent
 * @property mixed|string $name
 * @property mixed|string $ind
 */
class VirtualStep extends Model
{
    use HasFactory;

    /**
     * @var mixed|string
     */

    public function GetBtns($btns=[])
    {

        if ($this->btn_next) $btns[$this->btn_next] = 0;
        if ($this->btn_back) $btns[$this->btn_back] = 0;
        if ($this->btn_exit) $btns[$this->btn_exit] = 0;
        if ($this->btn_scene_name) $btns[$this->btn_scene_name] = 0;
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
