<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use app\Models\Trash\Order;
    use app\Models\Trash\Shop;
    use Facade\FlareClient\Stacktrace\Stacktrace;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class ShopAdminController extends Controller
    {
        public function index() {

            $shops = Shop::all();

            return view('admin.shop.shop-list', compact('shops'));

        }

        public function store($shop_id, Request $request) {

            $validator = Validator::make(
                $request->toArray(),
                [
                    'owner_id'      => 'required|int|min:1|max:600',
                    'min_time_work' => 'required|int|min:1|max:600',
                    'min_price'     => 'required|int|min:0|max:6000',
                    'name'          => 'required|string|min:2|max:32',
                    'descr'         => 'required|string|min:5|max:320',
                    'address'       => 'required|string|min:5|max:320',
                    'status'        => 'required|string|min:1|max:320',
                    'image'         => 'image|mimes:png,jpg,jpeg|max:2048',
                ],
                [
                ],
                [
                    'budget' => 'Бюджет',
                    'title'  => 'Название',
                    'descr'  => 'Описание',
                ]
            );

            $data = $validator->validate();

            /** @var Shop $shop */
            $shop = null;
            if ($shop_id > 0) {
                $shop = Shop::find($shop_id);
                if (!$shop) {
                    return redirect()->back()->withErrors(['Магазин не найден'])->withInput();
                }
            }

            if (!$shop) {
                $shop = new Shop();
            }
            $shop->owner_id = $data['owner_id'];
            $shop->min_price = $data['min_price'];
            $shop->min_time_work = $data['min_time_work'];
            $shop->descr = $data['descr'];
            $shop->name = $data['name'];
            $shop->status = $data['status'];
            $shop->address = $data['address'];

            if (isset($data['image'])) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('img/shop'), $imageName);
                $shop->image = $imageName;
            }

            if (!$shop->save()) {
                return redirect()->back()->withErrors(['Не удалось сохранить данные('])->withInput();
            }


            return redirect()->route('admin.shop.create', $shop->id);

        }

        public function edit($shop_id) {

            $shop = null;

            if ($shop_id > 0) {
                $shop = Shop::findOrFail($shop_id);
            }

            return view('admin.shop.shop-create', compact('shop'));

        }

        public function OrderEditStatus(Order $order, Request $request) {

            if (!isset(Order::$ORDER_STATUS[$request['status'] ?? -1])) {
                die("ERR");
            }

            $order->status = $request['status'];
            $order->save();

            return redirect()->back();
        }

        public function OrderEditSave(Order $order, Request $request) {

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

            $order->title = $request['title'];
            $order->descr = $request['descr'];
            $order->budget = $request['budget'];
            $order->save();

            return redirect()->back();
        }

        public function OrderDeteils(Order $order) {
            return view('admin.order-edit', compact('order'));
        }


    }
