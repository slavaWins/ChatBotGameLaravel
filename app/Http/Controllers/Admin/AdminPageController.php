<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\ResponseApi;
    use app\Models\Trash\Order;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class AdminPageController extends Controller
    {


        public function index() {


            return view('admin-extend.index');

        }
    }
