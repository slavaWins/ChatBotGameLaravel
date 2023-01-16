<?php

    namespace app\Models\Trash;

    use app\Models\Trash\Product;
    use app\Models\Trash\Shop;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Rennokki\QueryCache\Traits\QueryCacheable;

    /**
     * @property string $name
     * @property int $item_count
     * @property User $user
     * @property Product $product
     * @property Shop $shop
     * @property int $id
     * @property int $shop_id
     * @property int $product_id
     * @property int $user_id
     * @property int $order_id
     * @property int order_price
     * @property int order_mass
     * @property boolean is_order_remove
     * @property boolean is_order_add
     */
    class BasketItem extends Model
    {
        use HasFactory;
        //use QueryCacheable;
       // protected $cacheFor = 180;

        protected $with = ['product']; //подгружаем сразу модели товаров

        protected $fillable = [
            'created_at',
            'product_id',
            'user_id',
            'shop_id',
            'name',
            'item_count',
            'order_mass',
            'order_id',
            'order_price',
            'is_order_add',
            'is_order_remove',
        ];

        public function client() {
            return $this->belongsTo(User::class, "user_id");
        }

        public function product() {
            return $this->belongsTo(Product::class, "product_id");
        }

        /**
         * @param $uid
         * @return BasketItem[]
         */
        public static function GetBusketItemsByUserId($uid) {
            $basketItems = BasketItem::where("user_id", $uid)->whereNull("order_id")->get();

            return $basketItems;
        }

        public function shop() {
            return $this->belongsTo(Shop::class, "shop_id");
        }
    }
