<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\History;
use app\Models\Trash\Order;
use app\Models\Trash\Shop;
use App\Models\User;
use Facade\FlareClient\Stacktrace\Stacktrace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersAdminController extends Controller
{
    public function index()
    {


        $users = User::all();
        return view('admin.users.list', compact('users'));

    }

    public function show(User $userShow)
    {

        return view('admin.users.show', compact('userShow'));

    }

    public function history(User $userShow)
    {
        $historys = History::where('user_id', $userShow->id)->orderBy('id')->get();
        return view('admin.users.history', compact('userShow', 'historys'));

    }


}
