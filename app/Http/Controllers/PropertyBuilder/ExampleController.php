<?php

namespace App\Http\Controllers\PropertyBuilder;


use App\Actions\AuthSms\SendSms;
use App\Actions\OpenHomePage;
use App\Characters\PlayerCharacter;
use App\Http\Controllers\Controller;
use App\Library\Tarifiner\TarifinerLib;
use App\Mail\ActivationMailable;
use App\Models\Bot\History;
use App\Models\Bot\VirtualStep;
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
use Illuminate\Support\Facades\Validator;


class ExampleController extends Controller
{

    public function index()
    {


        $model = VirtualStep::all()->first();

        return view('property-builder.index', compact('model'));

    }

    public function story(Request $request)
    {

        $rules = History::GetValidateRules();
        $validator = Validator::make($request->toArray(), $rules);
        $validator->validate();

        if ($validator->fails()) {
            dd("X");
            //   return ResponseApi::Error($validator->errors()->first());
        }
        $shops = [];

        $model = History::all()->first();

        return redirect()->back();

    }


}
