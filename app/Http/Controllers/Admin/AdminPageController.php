<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\ResponseApi;
    use app\Models\Trash\Order;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class AdminPageController extends Controller
    {
        public function OrderList() {

            $orders = Order::all();

            return view('admin.orders', compact('orders'));

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

        public function index() {


            return view('admin.index');

        }
    }
