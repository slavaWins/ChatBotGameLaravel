<?php

namespace App\Console\Commands\Bot;

use App\Http\Controllers\Bot\Dev\MessageBoxController;
use App\Library\ProgressBarEmoji;
use App\Models\Bot\Character;
use App\Services\MoneyAnalizService;
use Illuminate\Console\Command;

class MakeCharacter extends Command
{

    protected $signature = 'make:character {ind} {isPasteFileNoDouble?}';

    protected $description = 'Создать модель чарактера и его структуры';


    public static function MakeFile($originalPath, $ind, $isOnlyCheckFileExist = false)
    {
        $fname = basename($originalPath);
        $f = file_get_contents($originalPath);
        $f = str_replace("Template", $ind, $f);
        $fnameNew = str_replace("Template", $ind, $fname);

        $originalPath = str_replace($fname, $fnameNew, $originalPath);

        if ($isOnlyCheckFileExist) {
            return [file_exists($originalPath), $originalPath];
        }

        if (file_exists($originalPath)) {
            return [false, "Файл " . $fnameNew . ' Уже существует!'];
        }

        file_put_contents($originalPath, $f);

        return [true, $originalPath];
    }


    public function handle()
    {

        $ind = $this->argument("ind");
        $ind = trim($ind);
        if ($ind == "Template") die("Иди нахуй");

        $isPasteFileNoDouble = $this->argument("isPasteFileNoDouble") ?? false; //мы дописываем файлы просто

        $this->info($ind);

        $list = [];
        $list[] = app_path("/Characters/TemplateCharacter.php");
        $list[] = app_path("/Characters/Struct/TemplateStructure.php");
        $list[] = app_path("/Characters/Shop/TemplateShop.php");

        $can = true;
        foreach ($list as $P) {
            $result = self::MakeFile($P, $ind, true);
            if ($result[0]) {
                $this->warn("Чар уже существует " . str_replace(app_path(), "", $result[1]));
                $can = false;
            }
        }

        if (!$isPasteFileNoDouble) {
            if (!$can) {
                $this->warn("Нельзя перезаписать");
                $this->alert("Напшите  make:character " . $ind . " 1  что бы дописать нехватающие файлы");

                return false;
            }
        }

        foreach ($list as $P) {
            $result = self::MakeFile($P, $ind, false);
            if ($result[0]) {
                $this->info("" . str_replace(app_path(), "", $result[1]));
            }
        }
        //$this->info("Игрок заработал за тест, в активах:\n " . number_format($money) . ' RUB');


    }
}
