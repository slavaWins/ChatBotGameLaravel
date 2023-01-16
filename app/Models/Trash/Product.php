<?php

namespace app\Models\Trash;

use app\Models\Trash\Shop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * @property mixed $descr
 * @property int $id
 * @property int $price
 * @property int $shop_id
 * @property Shop $shop
 * @property int $mass  массс в граммах
 * @property int $stock  на складе
 * @property int $orders_count  сколько было всего заказов
 * @property int $time_work  сколько времени нужно что бы приготовить товар, в секундах. Типа суши 3600.
 * @property string $name  на складе
 * @property string $img  название картинки
 * @property string $category  название категории
 * @property string $sub_category  название категории
 */
class Product extends Model
{
    use HasFactory;



    use QueryCacheable;
    protected $cacheFor = 180;

    protected $fillable = [
        'created_at',
        'price',
        'shop_id',
        'descr',
        'name',
        'mass',
        'stock',
        'img',
        'time_work',
        'category',
        'sub_category',
        'orders_count',
    ];


    public function shop()
    {
        return $this->belongsTo(Shop::class, "shop_id");
    }

}
