@php

    /** @var \App\Models\Bot\History[] $historys */

@endphp

@extends('layouts.containerscreen')

@section('content')

    <script src="{{ asset('js/messagebox/messagebox.js')."?".microtime() }}"></script>



    <div class="row ">

        <div class="col-5 messageboxWindow">
            <div class="card">
                <div class="card-body " style="font-size: 14px; font-weight: 600; color: #000;">
                    {{env("APP_NAME")}}
                </div>
                <div class="card-body mess_scroll">
                    @foreach($historys as $history)
                        @include("messagebox.mess")
                    @endforeach

                </div>

                <div class="card-body">
                    <textarea placeholder="Напишите сообщение..." rows="1" class="textarea_mess"></textarea>
                    <div class="row mess_row_btns p-1">

                        @include("messagebox.keyboard", ['buttons'=>$user->buttons ])

                    </div>
                </div>
            </div>
        </div>


        <div class="col-3 ">
            <a class="btn btn-outline-dark col-12"
               href="{{route('messagebox.action.clearmessage')  }}">Удалить
                историю</a>
            <BR>
            <BR>
            <a class="btn btn-outline-dark col-12"
               href="{{route('messagebox.action.autotest')  }}">Автотест</a>
            <BR>
            <BR>
            <a class="btn btn-outline-dark col-12"
               href="{{route('messagebox.action.resetuser')  }}">Ресет ака</a>

        </div>
    </div>
@endsection
