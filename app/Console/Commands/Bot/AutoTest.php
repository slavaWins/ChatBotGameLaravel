<?php

namespace App\Console\Commands\Bot;

use App\Http\Controllers\Bot\Dev\MessageBoxController;
use App\Models\Bot\Character;
use app\Models\Trash\Product;
use app\Models\Trash\Shop;
use App\Services\MoneyAnalizService;
use App\Services\SnoUSNService;
use App\Sno;
use App\TaxTransaction;
use http\Client\Curl\User;
use Illuminate\Console\Command;

class AutoTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:test {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Бот играет сам в себя';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function GetUserHaves(\App\Models\User $user)
    {
        $text = "\n\n" . $user->name;
        $text .= "\n " . $user->player->Render(true, false, true);
        $text .= "\n Имеет: ";

        /** @var Character $character */
        foreach ($user->GetAllCharacters() as $character) {
            $text .= "\n " . $character->GetName();
        }
        $text .= "\n";
        return $text;
    }

    public function handle()
    {

        $userId = $this->argument("userId");

        /** @var \App\Models\User $user */
        $user = \App\Models\User::find($userId);
        if (!$user) dd("Игрок нен айден");

        $money = MoneyAnalizService::GetUserMoneyState($user);
        $this->info($this->GetUserHaves($user));
        $time = microtime(true);


        for ($i = 1; $i < 5; $i++) {
            $text = MessageBoxController::MakeAutoTest($user, 10);
            $this->info($text);
        }

        $time = microtime(true) - $time;


        $this->info("\n Время выполнения: ".number_format($time,2).' sec.');

        $this->info($this->GetUserHaves($user));

        $user->refresh();
        $money2 = MoneyAnalizService::GetUserMoneyState($user);
        $this->info("Фин.Сост игрока на момент запуска " . number_format($money) . ' RUB');
        $this->info("Фин.Сост игрока после " . number_format($money2) . ' RUB');
        $money = $money2 - $money;
        $this->info("Игрок заработал за тест, в активах:\n " . number_format($money) . ' RUB');


    }
}
