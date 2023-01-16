<?php

    namespace App\Console\Commands;

    use app\Models\Trash\Product;
    use app\Models\Trash\Shop;
    use App\Services\SnoUSNService;
    use App\Sno;
    use App\TaxTransaction;
    use Illuminate\Console\Command;

    class GenereateShop extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'genshop';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Гнереация товаров и магазинов из картинок';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct() {
            parent::__construct();
        }


        public function randText($data) {
            return $data[rand(0, count($data) - 1)];
        }

        public function randProdImg($cat = 'product') {
            $list = scandir(public_path('img/'.$cat));
            $i = rand(1, count($list) - 1);

            return $list[$i];
        }

        public function handle() {

            $shop = new Shop();
            $shop->name = $this->randText(['Донская', 'Мясобойня', 'Подвальная', 'Домашняя', 'ИП Ардуев', 'ИП Фальский',]);
            $shop->name .= ' - '.$this->randText(['ферма', 'слабода', 'огород', 'деревня', 'фазенда', 'березовка',]);
            $shop->image = $this->randProdImg('shop');
            $shop->descr = "Слобода на берегу   Объ. Выращиваем скот с 2008 года.  Так же овощи.";
            $shop->min_price = rand(12, 210) * 10;
            $shop->min_time_work = rand(12, 210);
            $shop->address = "Новосибирская облость,  ".$this->randText(['г. Новосибирск', 'с. Подноевское', 'с. Люпское', 'с. Вяземское', 'с. Нижняя вясь']);
            $shop->address .= " ул ".$this->randText(['Добрянская', 'Ленина', 'Зоевское шосе', 'Альмнова', 'Калинино']);
            $shop->address .= " ".rand(11, 555);
            $shop->status .= 'active';
            $shop->owner_id = 1;
            $shop->save();

            for ($i = 0; $i < rand(12, 42); $i++) {
                $product = new Product();
                $product->name = $this->randText([
                    'Курица '.$this->randText(['тущка', 'голень', 'цельная', 'в консервах']),
                    'Утка '.$this->randText(['тущка', 'домашняя', 'копченая']),
                    'Говяжий '.$this->randText(['стейк', 'суповой набор', 'реберный вырез']),
                    'Свиной '.$this->randText(['жоп', 'стейк', 'обрез']),
                    'Ягода '.$this->randText(['консервированая', 'охлажденая', 'свежая']),
                    'Колбаса '.$this->randText(['вяленая', 'варенка', 'вареная', 'кишковая', 'нарезаная'])]);

                $product->price = rand(32, 210) * 10;
                $product->mass = rand(10, 510) * 10;
                $product->shop_id = $shop->id;
                $product->stock = rand(1, 6);
                $product->orders_count = max(0, rand(-5, 12));
                $product->time_work = rand(1, 40);
                $product->category = $this->randText(['Мясо', 'Напитки', 'Готовая еда', 'Консервы']);
                $product->sub_category = $this->randText(['Готовое', 'Охлажденное', 'Свежее', 'С грядки']);
                $product->img = $this->randProdImg();
                $product->save();
            }

            $this->info($shop->name);
            $this->info("Процесс успешно выполнен!");
        }
    }
