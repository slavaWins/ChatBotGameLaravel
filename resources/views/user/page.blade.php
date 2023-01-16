@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $user \App\Models\User */
@endphp


@extends('layouts.containerscreen')


@section('scripts')

    <script>


    </script>

@endsection



@section('content')

    <div class="row mb-4">
        @include("user.preview-with-avatar", ['user'=>$user ])
    </div>

    <div class="row">
        <div class="col-md-8">


            <small>Бухгалтер</small>
            <h3>  {{$user->name}} </h3>

            <Br>

            <div class=" card   " style=" ">
                <div class="card-body">

                    <b>О себе:</b>
                    <br>

                    <BR>
                    <BR>

                    <div class="row" style="opacity: 0.9">
                        <div class="col">
                            <small> Стаж: </small> <BR> ЛЕТ
                        </div>

                        <div class="col">
                            <small>ИД : </small>
                            <BR>
                            #{{$user->id}}
                        </div>

                        <div class="col">
                            <small>Просмотры : </small>
                            <BR>
                            {{$user->views}}
                        </div>


                    </div>
                </div>
            </div>


            <BR>
            <div class="row mb-4">
                <div class="col">
                    <button onclick="offerFormShow()" class="btn  btn-outline-dark float-end">Оставить отзыв
                    </button>
                </div>
            </div>


            @include("user.guest-reg-info")


        </div>


        <div class="col-md-4">


            <Br>
            <Br>

            <div class="row">

            </div>


            <Br>

            <div class=" card   " style=" ">
                <div class="card-body">


                    Заказ создан: <BR> 12

                    <BR> <BR> Откликов: <BR> 35

                    <BR> <BR> Бюджет: <BR> 35
                </div>
            </div>


        </div>
    </div>

@endsection
