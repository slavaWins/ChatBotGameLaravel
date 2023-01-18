<?php

namespace App\Console\Commands\EasyAnalitics;

use App\Library\EasyAnalitics\EasyAnaliticsHelper;
use App\Models\EasyAnalitics\EasyAnalitics;
use App\Models\EasyAnalitics\EasyAnaliticsSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenereateExample extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easyanalitics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Гнереация тестовых данных аналитики';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function randText($data)
    {
        return $data[rand(0, count($data) - 1)];
    }


    public function handle()
    {


        $easyAnaliticsSetting = new EasyAnaliticsSetting();
        $easyAnaliticsSetting->name = $this->randText(['Доходы', 'Запросы', 'Покупки', 'Авторизации', 'Выходы', 'Регистрации',]);
        $easyAnaliticsSetting->name .= ' ' . $this->randText(['пользователей', 'новостей', 'товаров', 'сущностей', 'заказов', 'инструментов',]);
        $easyAnaliticsSetting->descr = "Рандомно созданая аналитика и все её данные, для того что бы быстро затестить функции пакета.";
        $easyAnaliticsSetting->ind = "analitics_" . time() . '_example';

        $easyAnaliticsSetting->save();


        $maxVal = rand(10, 1900);

        for ($i = 0; $i < rand(12, 42); $i++) {
            EasyAnaliticsHelper::Increment($easyAnaliticsSetting->ind, rand($maxVal / 2, $maxVal), Carbon::now()->addDays(-$i));
        }

        $this->info($easyAnaliticsSetting->name);
        $this->info("Процесс успешно выполнен!");
    }
}
