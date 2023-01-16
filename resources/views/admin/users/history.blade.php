@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $userShow \app\Models\User */
   /*** @var $character \app\Models\Character */
@endphp


@extends('admin.screen')




@section('content')

    <h1>User {{$userShow->name ?? $userShow->player->name ?? "NA"}} #{{$userShow->id}}</h1>

    <div class="col-5 messageboxWindow">
        <div class="card">

            <div class="card-body " style="font-size: 14px; font-weight: 600; color: #000;">
                {{env("APP_NAME")}}
            </div>

            <div class="card-body mess_scroll">
                @foreach($historys as $history)
                    @include("messagebox.mess", ['user'=>$userShow, 'history'=>$history])
                @endforeach
            </div>


        </div>
    </div>

@endsection

