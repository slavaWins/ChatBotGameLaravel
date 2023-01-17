@extends('admin.app')

@section("sidebar")
    <span class="spanTitle" style="">Параметры</span>

    <BR><BR>
    <BR><BR>

    @include("admin-extend.sidebar")


    <BR><BR>
@endsection

@section('app-col')

    <div class="container-fluid px-3">


        <div class="row justify-content-left  ">


            @include('admin.sidebar')

            <div class="col-md-8 mt-4">
                @yield('content')
            </div>

        </div>
    </div>

@endsection
