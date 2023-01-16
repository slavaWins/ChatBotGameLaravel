<?php

    namespace App\Http\Controllers;


    use App\Actions\OpenHomePage;
    use App\Models\Offer;
    use app\Models\Trash\Order;
    use App\Models\User;
    use App\Repositories\OperationsRepository;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Http\Request;
    use App\Models\ResponseApi;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Validator;


    class UserController extends Controller
    {


        public function list() {


            $orders = Order::all();

            return view('order.list', compact('orders'));

        }


        public function show(User $user) {

            $user->views++;
            $user->save();



            return view('user.page', compact('user'));
        }

    }
