<?php

namespace App\Console\Commands\Bot;

use App\Http\Controllers\Bot\Dev\MessageBoxController;
use App\Library\ProgressBarEmoji;
use App\Models\Bot\Character;
use App\Services\MoneyAnalizService;
use Illuminate\Console\Command;

class MakeCharacter extends Command
{

    protected $signature = 'make:character {ind}';

    protected $description = 'Создать модель чарактера и его структуры';


    public function handle()
    {

        $ind = $this->argument("ind");

        $this->info($ind);
        


        //$this->info("Игрок заработал за тест, в активах:\n " . number_format($money) . ' RUB');


    }
}
