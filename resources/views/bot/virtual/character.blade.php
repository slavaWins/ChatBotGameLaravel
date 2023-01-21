@php


    /*** @var $userShow \app\Models\User */
    /*** @var $character \App\Models\Bot\Character */
@endphp


@extends('adminwinda::screen')




@section('content')

    <h1>roo </h1>

    <div class="col-5 ">
        <div class="card">

            <div class="card-body " style="font-size: 14px; font-weight: 600; color: #000;">
                {{env("APP_NAME")}}
            </div>

            <div class="card-body mess_scroll">

            </div>


        </div>
    </div>

@endsection

