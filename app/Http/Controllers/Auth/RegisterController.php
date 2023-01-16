<?php

    namespace App\Http\Controllers\Auth;

    use App\Actions\Factory\CreateTestContentUser;
    use App\Http\Controllers\Controller;
    use App\Providers\RouteServiceProvider;
    use App\Models\Cat;
    use App\Models\User;
    use Illuminate\Foundation\Auth\RegistersUsers;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use PhpParser\Error;
    use App\Models\Operation;


    class RegisterController extends Controller
    {
        /*
        |--------------------------------------------------------------------------
        | Register Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles the registration of new users as well as their
        | validation and creation. By default this controller uses a trait to
        | provide this functionality without requiring any additional code.
        |
        */

        use RegistersUsers;

        /**
         * Where to redirect users after registration.
         *
         * @var string
         */
        protected $redirectTo = RouteServiceProvider::HOME;

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct() {
            $this->middleware('guest');
        }

        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array $data
         * @return \Illuminate\Contracts\Validation\Validator
         */
        protected function validator(array $data) {
            $v = Validator::make($data, [

                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users',],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

           // return back()->withErrors(['msg' => "suka gavno"])->withInput();

            return $v;
        }

        /**
         * Create a new user instance after a valid registration.
         *
         * @param  array $data
         * @return \App\Models\User
         */
        protected function create(array $data) {

            dd("X");

            $user = User::create([
                'name'     => "Новый пользователь",
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);



            $createTestContentUser = new CreateTestContentUser();
            $createTestContentUser->create($user->id);


            return $user;
        }
    }
