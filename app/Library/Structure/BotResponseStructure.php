<?php

namespace App\Library\Structure;

class BotResponseStructure
{
    public $message = "";
    public $btns = [];

    public string $attach_sound;

    public function GetSoundAttach()
    {
        if (empty($this->attach_sound)) return null;
        $path = public_path("sound/" . $this->attach_sound);
        if (!file_exists($path)) return null;
        return $path;
    }

    public function AttachSound($soundLocalPath)
    {
        $path = public_path("sound/" . $soundLocalPath);
        if (!file_exists($path)) {
            return false;
        }

        $this->attach_sound = $soundLocalPath;
        return true;
    }


    public function AddWarning($text, $icon = "⚠️"){
        $text =$icon . $text;
        $this->message = $text . "\n\n" . $this->message;
        return $this;
    }

    public function AddButton($name){
        $this->btns[$name] = 1;
        return $this;
    }

    public function Reset()
    {
        $this->attach_sound = "";
        $this->message = "";
        $this->btns = [];
        return $this;
    }
}
