<?php

    namespace app\Models\Trash;

    use app\Models\Trash\BasketItem;
    use app\Models\Trash\Shop;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    /**
     * @property int $id
     * @property int amount_all
     * @property int amount_service
     * @property int amount_products
     * @property int amount_delivery
     * @property int $shop_id
     * @property string $status
     * @property string $address
     * @property string $message
     * @property string $convenient_delivery_time Клиент указал такое удобное для себя время доставки
     * @property Carbon $delivery_date_forecast Прогноз доставки
     * @property Shop $shop
     * @property int $user_id
     * @property User $user
     * @property BasketItem[] $basketitems
     */
    class Order extends Model
    {
        use HasFactory;

        public static $STATUS = [
            'create'        => "Заказ в обработке",
            'paywait'       => "Ожидает оплаты",
            'check'         => "На уточнение",
            'sbor'          => "Сборка",
            'delivery_wait' => "Ожидает курьера",
            'take_wait'     => "Ожидает забор",
            'delivery'      => "В пути",
            'end'           => "Заказ выполнен",
            'cancel'           => "Отменен",
        ];
        public static $convenientTimeOptions = [
            'now' => "Ближ. Время",
            'y1'  => "Завтра 10:00 - 12:00",
            'y2'  => "Завтра 12:00 - 15:00",
            'y3'  => "Завтра 15:00 - 20:00",
        ];

        protected $fillable = [
            'shop_id',
            'user_id',
            'status',
            'address',
            'message',
            'convenient_delivery_time',
            'delivery_date_forecast',
            'amount_all',
            'amount_products',
            'amount_service',
            'amount_all',
        ];


        public function user() {
            return $this->belongsTo(User::class, "user_id");
        }

        public function shop() {
            return $this->belongsTo(Shop::class, "shop_id");
        }
        public function basketitems() {
            return BasketItem::where('order_id', $this->id)->get();
        }



    }
