<?php

namespace App\Library\Structure;

use App\Models\User;

class StatStructure
{
    public string $name;
    public string $descr = "";
    public string $icon = "⚡";
    public $default = 0;
    public $max = null;
    public $value = 0;
    public string $typeData = "int";
    public bool $isShowShort = true;
    private $postfix;
    private string $format = "";
    private bool $isShowProgressBar = false;

    /**
     * @return StatStructure
     */
    public static function Make($name)
    {
        $s = new StatStructure();
        $s->name = $name;
        return $s;
    }

    public function SetDescr($val)
    {
        $this->descr = $val;
        return $this;
    }
    public function ShowProgressBar()
    {
        $this->isShowProgressBar = true;
        return $this;
    }

    public function SetTypeString()
    {
        $this->typeData = 'string';
        return $this;
    }

    public function SetTypeInt()
    {
        $this->typeData = 'int';
        return $this;
    }

    public function SetIcon($val)
    {
        $this->icon = $val;
        return $this;
    }


    public function SetDefault($val)
    {
        $this->default = $val;
        $this->value = $val;
        return $this;
    }

    public function SetShowInShort($val)
    {

        $this->isShowShort = $val;
        return $this;
    }

    public function SetMax($val)
    {
        $this->max = $val;
        return $this;
    }

    public function FormatMoney()
    {
        $this->format = 'money';
        return $this;
    }

    public function SetPostfix($val)
    {
        $this->postfix = $val;
        return $this;
    }

    public function RenderLine($isShort = true, $isShowDescr= false, $asValue = null)
    {
        $val = $this->value;
        if($asValue<>null){
            $val = $asValue;
        }

        $text = "";

        if (!$isShort && $isShowDescr && !empty($this->descr)) {
            $text .= "\n";
        }
        $text .= $this->icon;

        if (!$isShort) {
            $text .= " " . $this->name . ': ';
        }

        if ($this->format == "money") {
            $text .= " " . number_format($val);
        } else {
            $text .= " " . $val;
        }

        $text .= $this->postfix ?? '';

        if ($this->max) {
            $text .= "/" . $this->max;
        }

        if (!$isShort && $this->max && $this->isShowProgressBar) {
            $text .= " ";
            $percent = $val / $this->max * 10;
            $percent = floor($percent);
            $text .= str_repeat("▰", $percent);
            $text .= str_repeat("▱", 10 - $percent);
        }


        if (!$isShort && $isShowDescr && !empty($this->descr)) {
            $text .= "\n";
            $text .= $this->descr;
        }


        return $text;
    }
}


