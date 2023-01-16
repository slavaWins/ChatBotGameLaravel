<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileStartPage extends Controller
{

    public function index() {



        return view('startPage');
    }

}
