@extends('layouts.app')

@section('app-col')

    <div class="container-fluid   ">


        @include('layouts.navbar')

        @yield('content')
    </div>

@endsection
