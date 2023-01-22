<?php

    namespace App\Http\Controllers\PackageMaker;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class PackageMakerController extends Controller
    {


        public function index() {


            return view('packagemaker.example');

        }
    }
