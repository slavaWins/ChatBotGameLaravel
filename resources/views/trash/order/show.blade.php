@php

    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $order \app\Models\Trash\Order */
@endphp


@extends('layouts.containerscreen')


@section('scripts')

    <script type="text/javascript">


        function offerFormShow() {
            $("#offer_form_div").show();
            $(".hideIsFormOffer").hide();
        }

        function offerFormHide() {
            $("#offer_form_div").hide();
            $(".hideIsFormOffer").show();
        }
    </script>

@endsection



@section('content')

    <div class="row">
        <div class="col-md-8">


            <small>Заказ</small>
            <h3>  {{$order->title}} </h3>

            <Br>

            <div class=" card   " style=" ">
                <div class="card-body">

                    <b>Описание задачи:</b>
                    <br> {{$order->descr}}

                    <BR>
                    <BR>

                    <div class="row" style="opacity: 0.9">
                        <div class="col">
                            <small> Бюджет: </small> <BR> {{$order->budget}} RUB
                        </div>

                        <div class="col">
                            <small> Заказ создан: </small>
                            <BR> {{$order->created_at}}
                        </div>

                        <div class="col">
                            <small>Номер заказа : </small>
                            <BR>
                            #{{$order->id}}
                        </div>

                        <div class="col">
                            <small>Просмотры : </small>
                            <BR>
                            {{$order->views}}
                        </div>


                    </div>
                </div>
            </div>


            <BR>

            @if($order->status<=2)
                <div class="row mb-4">
                    <div class="col">
                        <button onclick="offerFormShow()" class="btn  btn-outline-dark float-end">Оставить отклик
                        </button>
                    </div>
                </div>



                @guest
                    <div id="offer_form_div" class="mb-6 align-content-center"
                         style="display: none; text-align: center;">
                        @include("user.guest-reg-info")
                    </div>
                @endguest

                @auth
                    @include("offer.form")
                @endauth
            @endif


            @if(!$order->offers()->count())
                <div class="row" id="no_offers">
                    <div class="col text-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/3782/3782548.png"
                             style="width: 220px; opacity: 0.8;">
                        <BR>
                        <BR>
                        У заказа ещё нет откликов.
                        <div class="hideIsFormOffer">
                            Станьте первым кто откликнится! <a onclick="offerFormShow()" href="#">Откликнуться</a>
                        </div>
                    </div>
                </div>
            @endif


            @foreach($order->offers() as $offer)

                @include("offer.element", ['offer' => $offer])
            @endforeach

        </div>


        <div class="col-md-4">

                        <span class="badge badge-info  "
                              style="font-size: 13px;"> {{\app\Models\Trash\Order::$ORDER_STATUS[$order->status]}} </span>


            <Br>
            <Br>

            <div class="row">
                @if($order->client)
                    @include("user.preview-with-avatar", ['user'=>$order->client ])
                @endif
            </div>


            <Br>

            <div class=" card   " style=" ">
                <div class="card-body">


                    Заказ создан: <BR> {{$order->created_at}}

                    <BR> <BR> Откликов: <BR> {{$order->offers()->count()}}

                    <BR> <BR> Бюджет: <BR> {{$order->budget}}
                </div>
            </div>


            @auth
                <BR>
                <small class=" ">
                    <a class="text-danger float-end " data-bs-toggle="modal" data-bs-target="#myModal"
                       href="#">Пожаловаться</a>
                </small>

                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Жалоба</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                @php
                                    FElement::NewInputText()
                                     ->SetLabel("Суть жалобы")
                                     ->SetName("descr")
                                     ->FrontendValidate()->String(4,75)
                                     ->SetValue(old("descr") ?: "")
                                     ->SetDescr("Опишите проблему")
                                     ->RenderHtml(true);
                                @endphp

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn  btn-outline-dark" data-bs-dismiss="modal">Close
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endauth

        </div>
    </div>

@endsection
