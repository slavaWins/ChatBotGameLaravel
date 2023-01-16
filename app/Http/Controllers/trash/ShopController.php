<?php

    namespace app\Http\Controllers\trash;


    use App\Actions\OpenHomePage;
    use App\Http\Controllers\Controller;
    use App\Models\Offer;
    use app\Models\Trash\Order;
    use app\Models\Trash\Shop;
    use App\Repositories\OperationsRepository;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;


    class ShopController extends Controller
    {


        public function show(Shop $shop) {

            $basketItemShortData = [];
            $basketData = [];

            if (Auth::user()) {
                $basketItemShortData = Auth::user()->GetBasketShortData();
                $basketData = BasketController::GetCardData(Auth::user()->id) ?? [];
            }

            $productsTop = $shop->products()->where('orders_count', '>', 0)->sortByDesc('orders_count')->take(4);


            return view('shop.shop-show', compact('shop', 'productsTop', 'basketItemShortData', 'basketData'));
        }

        public function list() {


            $orders = Order::all();

            return view('order.list', compact('orders'));

        }


        public function store(Request $request) {
            $validator = Validator::make(
                $request->toArray(),
                [
                    'budget' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
                    'title'  => 'required|string|min:15|max:120',
                    'descr'  => 'required|string|min:5|max:320',
                ],
                [
                ],
                [
                    'budget' => 'Бюджет',
                    'title'  => 'Название',
                    'descr'  => 'Описание',
                ]
            );

            $validator->validate();

            if ($request->toArray()['budget'] < 500) {

                return redirect()->back()->withErrors(['budget' => 'Минимальный бюджет 500 руб!'])->withInput();
            }

            $order = new Order();
            $order->title = $request->toArray()['title'];
            $order->descr = $request->toArray()['descr'];
            $order->budget = $request->toArray()['budget'];
            $order->client_id = Auth::user()->id;
            $order->status = 0;

            $res = $order->save();

            if (!$res) {
                return redirect()->back()->withErrors(['Ошибка создания заказа, попробуйте позже'])->withInput();
            }

            return redirect(route("order.show", $order->id));
        }


        public function create() {

            $xz = [];

            return view('order.create', compact('xz'));

        }
    }
