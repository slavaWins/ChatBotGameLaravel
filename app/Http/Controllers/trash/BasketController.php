<?php

    namespace app\Http\Controllers\trash;


    use App\Actions\OpenHomePage;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\NotifyBallController;
    use app\Models\Trash\BasketItem;
    use App\Models\Offer;
    use app\Models\Trash\Product;
    use App\Models\User;
    use App\Repositories\OperationsRepository;
    use Illuminate\Support\Facades\Auth;


    class BasketController extends Controller
    {

        public static function GetCardData($userId) {
            /** @var BasketItem[] $basketItems */
            $basketItems = BasketItem::GetBusketItemsByUserId($userId);

            $data['basketItems'] = $basketItems;

            $data['amount_delivery'] = 150;
            $data['amount_products'] = 0;
            $data['amount_service'] = 25;

            foreach ($basketItems as $K => $item) {
                if (!$item->product) {
                    unset($basketItems[$K]);
                    $item->delete();
                    continue;
                }
                $data['amount_products'] += $item->product->price * $item->item_count;
            }

            $data['amount_all'] = $data['amount_delivery'] + $data['amount_products'] + $data['amount_service'];

            return $data;
        }


        public function cardRaw() {
            if (!Auth::user()) {
                return "No auth";
            }

            return view('basket.basket', self::GetCardData(Auth::user()->id));
        }

        public function clear() {
            /** @var User $user */
            $user = Auth::user();

            if (!$user) return redirect()->back();

            NotifyBallController::SendToUid($user->id, "Корзина очищена. В корзине были товары с этого магазина ", route('shop.show', $user->current_shop ));

            BasketItem::where("user_id", $user->id) ->whereNull('order_id') ->delete();
            $user->current_shop = 0;
            $user->save();

            return redirect()->back()->with('success', "Корзина удалена! ");
        }

        public function add(Product $product, $increment) {

            /** @var User $user */
            $user = Auth::user();

            $increment = intval($increment);


            if ($user->current_shop <> $product->shop->id && $user->current_shop <> 0) {
                return ['response' => 'current_shop'];
            }

            if ($increment <> -1 && $increment <> 1) return ['response' => 'error'];

            /** @var BasketItem $basketItem */
            $basketItem = BasketItem::where("user_id", $user->id)->where('product_id', $product->id)->first();

            if (!$basketItem && $increment == -1) {
                return ['response' => 'ok', 'item_count' => 0];
            }

            if (!$basketItem) {
                $basketItem = new BasketItem();
                $basketItem->user_id = $user->id;
                $basketItem->product_id = $product->id;
                $basketItem->shop_id = $product->shop->id;
                $basketItem->item_count = 0;
            }
            $basketItem->item_count += $increment;

            if ($product->stock < $basketItem->item_count) {
                return ['response' => 'stock', 'error' => "Вы скупили весь товар!"];
            }


            if ($basketItem->item_count <= 0) {
                $basketItem->delete();
            }else {
                $basketItem->save();
            }

            $resp = ['response' => 'ok', 'item_count' => $basketItem->item_count];

            if ($product->stock - $basketItem->item_count < 3) {
                $resp['warning'] = "Осталось менее 3 товаров. Нужно сделать заказ быстрее.";
            }

            if ($user->current_shop <> $product->shop->id) {
                $user->current_shop = $product->shop->id;
                $user->save();
            }

            return $resp;
        }

    }
