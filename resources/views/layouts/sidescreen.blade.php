@extends('layouts.app')

@section('app-col')

    <div class="container-fluid px-4">

        @include('layouts.navbar')

        <div class="row justify-content-left  ">


            @include('layouts.sidebar')

            <div class="col-md-8">

                @yield('content')

            </div>
        </div>
    </div>

@endsection
