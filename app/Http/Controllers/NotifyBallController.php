<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\PusherMaker;
    use App\Jobs\SendNotifyBell;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Notification;

    class NotifyBallController extends Controller
    {




        public static function SendToUid($uid, $title = "У вас новое уведомление. Похоже стоит его проверить.", $route=null)
        {
            SendNotifyBell::dispatchAfterResponse($uid, $title, $route );

        }

    }
