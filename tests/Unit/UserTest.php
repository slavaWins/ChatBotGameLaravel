<?php

    namespace Tests\Unit;

    use App\Actions\TaxActions;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;
    use Tests\TestCase;
    use Illuminate\Support\Facades\Cache;

    class UserTest extends TestCase
    {

        /**
         * A basic unit test example.
         *
         * @return void
         */
        public function test_registration_user() {

            $email = "unit_test".time()."@mail.com";
            $response = $this->post('/register', [
                'email'                 => $email,
                'password'              => $email.$email,
                'password_confirmation' => $email.$email,
            ]);
            $response->assertRedirect('/home');


            $response = $this->get('/home');
            $response->assertRedirect('/start');

            $user = DB::table("users")->where("email", $email)->limit(1)->get()->get(0);

            Cache::put("unit_user",$user);

        }

        public function test_readTackTax() {

            $user = Cache::get("unit_user");
          //  dd($user );

            $taxRequestSuccessfulAction = new TaxActions();
            $myTask = $taxRequestSuccessfulAction->GetAllTaxForUser($user ->id);

            $this->assertTrue(count($myTask) > 0);
        }




        public function test_delete_user() {

            $user = Cache::get("unit_user");

            $this->assertTrue(true);
            DB::table("users")->where("email", $user ->email)->delete();
        }
    }


