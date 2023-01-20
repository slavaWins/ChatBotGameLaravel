<?php

namespace App\Console\Commands\Bot;

use App\Http\Controllers\Bot\Dev\MessageBoxController;
use App\Library\ProgressBarEmoji;
use App\Models\Bot\Character;
use App\Services\MoneyAnalizService;
use Illuminate\Console\Command;

class MakeRoom extends Command
{

    protected $signature = 'make:room {ind}';

    protected $description = 'Создать новую комнату';


    public function handle()
    {

        $ind = $this->argument("ind");
        $ind = trim($ind);
        if ($ind == "Template") die("Иди нахуй");


        $list = [];
        $list[] = app_path("/Scene/TemplateRoom.php");

        foreach ($list as $P) {
            $result = MakeCharacter::MakeFile($P, $ind, false);
            if ($result[0]) {
                $this->info("" . str_replace(app_path(), "", $result[1]));
            }
        }


    }
}
