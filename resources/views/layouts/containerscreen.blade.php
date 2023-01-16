@extends('layouts.app')

@section('app-col')

    <div class="container  ">


        @include('layouts.navbar')

        @yield('content')
    </div>

@endsection
