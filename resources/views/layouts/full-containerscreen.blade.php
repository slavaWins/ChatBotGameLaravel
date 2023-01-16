@extends('layouts.app')

@section('app-col')

    <div class="container-fluid  ">


        @include('layouts.navbar')
    </div>
        <div class="container  ">
        @yield('content')
    </div>

@endsection
