<?php

    namespace app\Models\Trash;

    use app\Models\Trash\Product;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Rennokki\QueryCache\Traits\QueryCacheable;

    /**
     * @property mixed|string $name
     * @property mixed $owner_id
     * @property int|mixed $status
     * @property int $min_price
     * @property int $min_time_work мин время подготовки заказа в МИНУТАХ
     * @property User $owner
     * @property Product[] $products
     * @property int $id
     * @property string $descr
     * @property string $image
     * @property string $address
     */
    class Shop extends Model
    {
        use HasFactory;

        use QueryCacheable;

        protected $cacheFor = 180;

        public static $STATUS = [
            'create'     => "Толькол Создан",
            'moder'      => "На модерации",
            'moderCheck' => "На уточнение",
            'edit'       => "Редактируется",
            'active'     => "Работает",
        ];

        protected $fillable = [
            'owner_id',
            'created_at',
            'name',
            'descr',
            'status',
            'min_time_work',
            'min_price',
            'address',
            'image',
        ];


        public function owner() {
            return $this->belongsTo(User::class, "owner_id");

        }

        public function products() {
            return Product::where('shop_id', $this->id)->get();
        }


        public function GetCategoryMap() {

            $map = [];
            foreach ($this->products() as $K => $product) {
                $catName = $product->category;

                if (!$product->category) {
                    $catName = "Асортимент";
                }

                if (!isset($map[$catName])) {
                    $map[$catName] = ['inner' => [], 'count' => 0, 'subcats' => []];
                }
                $map[$catName]['count']++;


                if ($product->sub_category <> null) {
                    if (!isset($map[$catName]['subcats'][$product->sub_category])) {
                        $map[$catName]['subcats'][$product->sub_category] = [];
                    }

                    $map[$catName]['subcats'][$product->sub_category][$K] = $product;

                }else {
                    $map[$catName]['inner'][] = $product;
                }
            }

            return $map;
        }
    }
