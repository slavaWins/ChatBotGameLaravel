<?php

    namespace app\Http\Controllers\trash;


    use App\Actions\OpenHomePage;
    use App\Http\Controllers\Controller;
    use app\Models\Trash\BasketItem;
    use App\Models\Offer;
    use app\Models\Trash\Order;
    use app\Models\Trash\Shop;
    use App\Repositories\OperationsRepository;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;


    class OrderController extends Controller
    {


        public function show(Order $order) {

        }

        public function history() {

            $orders = Order::where("user_id", Auth::user()->id)->get();

            return view('order.history', compact('orders'));
        }

        public function create() {

            $shop_id = Auth::user()->current_shop;

            if ($shop_id == 0) return redirect()->back()->with("Корзина пуста");

            $shop = Shop::find($shop_id);

            if (!$shop) die("no shop");

            /** @var BasketItem[] $basketItems */
            $basketItems = BasketItem::GetBusketItemsByUserId(Auth::user()->id);

            $cardData = BasketController::GetCardData(Auth::user()->id);

            $convenient_delivery_timeOptions = Order::$convenientTimeOptions;
            $convenient_delivery_timeOptions['now'] = "Сегодня 60-120 мин";


            $data = compact('shop', 'basketItems', 'convenient_delivery_timeOptions');
            $data = array_merge($data, $cardData);

            return view('order.order-create', $data);

        }

        public function store(Request $request) {

            $data = $request->toArray();

            $validator = Validator::make(
                $data,
                [
                    'message'                  => 'nullable|string|min:0|max:99',
                    'convenient_delivery_time' => 'required|string|min:2|max:99',
                ],
                [
                ],
                [
                    'convenient_delivery_time' => 'Время доставки',
                    'message'                  => 'Комментарий',
                ]
            );

            $data = $validator->validate();

            $shop_id = Auth::user()->current_shop;
            if ($shop_id == 0) return redirect()->back()->withErrors("Корзина пуста");

            $cardData = BasketController::GetCardData(Auth::user()->id);

            /** @var Shop $shop */
            $shop = Shop::find($shop_id);

            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->shop_id = $shop->id;
            $order->amount_all = $cardData['amount_all'];
            $order->amount_delivery = $cardData['amount_delivery'];
            $order->amount_products = $cardData['amount_products'];
            $order->amount_service = $cardData['amount_service'];
            $order->status = 'create';
            $order->message = $data['message'] ?? "";
            $order->convenient_delivery_time = Order::$convenientTimeOptions[$data['convenient_delivery_time'] ?? "now"] ?? "Не определено";

            if (!$order->save()) {
                return redirect()->back()->withErrors("Сервис временно не доступен");
            }


            $q = DB::table('basket_items')
                ->where('user_id', Auth::user()->id)
                ->whereNull('order_id')
                //->toSql();
                ->update(['order_id' => $order->id]);  // update the record in the DB.

          //  dd($q);

            Auth::user()->current_shop = 0;
            Auth::user()->save();

            return redirect()->route("order.show", $order);
        }
    }
