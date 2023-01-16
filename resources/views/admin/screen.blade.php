@extends('layouts.app')

@section("sidebar")
    <small>АДМИН ПАНЕЛЬ</small>

    <BR><BR>

    <div class="col">
        <span class="spanTitle">Пользователи  </span>

        <div class="px-3 my-2 divHrefSide">
            <a href="{{route("admin.user.list")}}">Все <span class="badge bg-primary "> {{count(\App\Models\User::all())}}</span> </a>
        </div>
    </div>

    <BR>

    <div class="col">
        <span class="spanTitle">МАГАЗИН ИТЕМОВ  </span>

        <div class="px-3 my-2 divHrefSide">
            <a href="{{route("admin.itemshop.cat")}}">Категории</a>
        </div>
    </div>

    <BR>

    <div class="col">
        <span class="spanTitle">ОСНОВНОЕ  </span>

        <div class="px-3 my-2 divHrefSide">
            <a href="{{route("admin")}}">Главная</a>
            <BR> <a href="">Статистика</a>
        </div>
    </div>



    <BR><BR>
@endsection

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
