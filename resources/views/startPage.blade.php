@extends('layouts.fullscreen')

@section('content')



    <style>
        nav {
            display: none !important;
        }
    </style>

    <div class="container" style="max-width: 500px">
        <div class="row justify-content-center">

            <h6 class="mt-3 " style="font-weight: 300; text-align: center;">
                Стартовые настройки для вашего профиля
            </h6>
            <livewire:profile-start/>


        </div>
    </div>
@endsection

