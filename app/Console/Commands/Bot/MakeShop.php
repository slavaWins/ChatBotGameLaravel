<?php

namespace App\Console\Commands\Bot;

use App\Http\Controllers\Bot\Dev\MessageBoxController;
use App\Library\ProgressBarEmoji;
use App\Models\Bot\Character;
use App\Services\MoneyAnalizService;
use Illuminate\Console\Command;

class MakeShop extends Command
{

    protected $signature = 'make:shop {ind}';

    protected $description = 'Создать новый магазин и его структуру';


    public function handle()
    {

        $ind = $this->argument("ind");
        $ind = trim($ind);
        if ($ind == "Template") die("Иди нахуй");


        $list = [];
        $list[] = app_path("/Characters/Struct/TemplateStructure.php");
        $list[] = app_path("/Characters/Shop/TemplateShop.php");


        foreach ($list as $P) {
            $result = MakeCharacter::MakeFile($P, $ind, false);
            if ($result[0]) {
                $this->info("" . str_replace(app_path(), "", $result[1]));
            } else {
                $this->error("Уже есть такой! " . str_replace(app_path(), "", $result[1]));
            }
        }


    }
}
