<?php

    namespace App\Http\Controllers;



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



            return redirect()->back();
        }

        public function index() {
            if (!Auth::user()) exit;

            $user = User::find(Auth::user()->id);

            // dd($user);
            return view("profile")->withUser($user);
        }
    }
