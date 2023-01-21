<?php

    namespace App\Http\Controllers;


    use App\Actions\AuthSms\SendSms;
    use App\Actions\OpenHomePage;
    use App\Characters\PlayerCharacter;
    use App\Library\Tarifiner\TarifinerLib;
    use App\Mail\ActivationMailable;
    use app\Models\Trash\Order;
    use app\Models\Trash\Shop;
    use App\Models\User;
    use App\Repositories\OperationsRepository;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Http\Request;
    use App\Models\ResponseApi;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use App\Mail\GandonMailable;
    use Illuminate\Support\Facades\Mail;


    class HomeController extends Controller
    {

/*
        public function __construct() {
            $this->middleware('auth');
        }
*/

        public function index() {

dd(decline_number(1,['a','b','c']));
            /** @var PlayerCharacter $test */
            /*
            $test = PlayerCharacter::find(231);
            $test->characterData->money+=1;
            echo $test->Render();
*/
          //  Auth::user()->GetBasketShortData();
            /*
                        if (Auth::user()->IsFirstStepRegistration()) {
                            return redirect()->route("projCreate");
                        }

            */
            $shops = [];

            return view('welcome', compact('shops'));

        }


    }
