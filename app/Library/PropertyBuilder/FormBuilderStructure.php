<?php

namespace App\Library\PropertyBuilder;

use App\Models\PropertyBuilder\PropertyBuilderModel;
use App\Models\User;

class FormBuilderStructure
{
    public string $name;
    public string $descr = "";
    public $tags = null;
    public string $icon = "";
    public $default = 0;
    public $max = null;
    public $min = 0;
    public $value = 0;
    public $url = null;

    public array $options;
    public $comment;
    public PropertyBuilderModel $model;
    public array $row_list = [];
    public $row_id = 0;

    /**
     * @return PropertyBuilderStructure
     */

    public static function New(PropertyBuilderModel $model)
    {
        $s = new FormBuilderStructure();
        $s->model = $model;
        return $s;
    }

    public function Row()
    {
        $this->row_id += 1;
        $this->row_list[$this->row_id] = [];
        return $this;
    }

    public function Route($url)
    {

        $this->url = $url;

        return $this;
    }

    public function Input($ind)
    {
        $props = $this->model->GetPropertys();
        if (!isset($props[$ind])) return $this;

        $this->row_list[$this->row_id][$ind] = true;
        return $this;
    }

    public function Submit($name)
    {
        $ind = "submit";
        $this->row_list[$this->row_id][$ind] = $name;
        return $this;
    }

    public function RenderHtml()
    {


        $view = view("property-builder.builder", ['fb' => $this]);
        echo $view . '';
        return $this;
    }

}


