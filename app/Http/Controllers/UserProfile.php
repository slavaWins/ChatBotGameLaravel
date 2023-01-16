<?php

    namespace App\Http\Controllers;


    use MoveMoveIo\DaData\Enums\BranchType;
    use MoveMoveIo\DaData\Enums\CompanyType;
    use MoveMoveIo\DaData\Facades\DaDataCompany;
    use MoveMoveIo\DaData\Facades\DaDataAddress;


    use App\Models\Cat;
    use Illuminate\Http\Request;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    class UserProfile extends Controller
    {


        public function RequestUpdate(Request $request) {

            //if(!Auth::user())redirect()->back();
            if (!Auth::user()) die("Error");


            $user = User::find(Auth::user()->id);

            $validate = $request->validate([
                'name' => 'required|min:3|max:322',
            ]);

            //if(!$validate) return redirect()->back();

            $user->name = $request->name;
            $user->save();

            //   dd($dadata['suggestions'][0]);


            return redirect()->back();
        }

        public function index() {
            if (!Auth::user()) exit;

            $user = User::find(Auth::user()->id);

            // dd($user);
            return view("profile")->withUser($user);
        }
    }
