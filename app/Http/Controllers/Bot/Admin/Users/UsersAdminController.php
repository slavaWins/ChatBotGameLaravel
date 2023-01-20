<?php

namespace App\Http\Controllers\Bot\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Bot\History;
use app\Models\Trash\Order;
use app\Models\Trash\Shop;
use App\Models\User;

class UsersAdminController extends Controller
{

    public function history(User $userShow)
    {
        $historys = History::where('user_id', $userShow->id)->orderBy('id')->get();
        return view('admin-extend.users.history', compact('userShow', 'historys'));

    }


}
