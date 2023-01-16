@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $order \app\Models\Trash\Order */
   /*** @var $basketitem \app\Models\Trash\BasketItem */
@endphp


@extends('layouts.containerscreen')


@section('scripts')

    <script type="text/javascript">

        $(document).ready(function () {

        });

    </script>

@endsection


@section('content')

    <style>
        .orderItemRound {
            background: #e8e8e8;
            margin-right: 6px;
            border-radius: 15px;
            height: 36px;
            width: 36px;
            background-size: cover !important;
            float: left;
            text-align: center;
            font-size: 13px;
            font-weight: 900;
            color: #575757;
            padding: 7px 0px;
        }
    </style>
    <div class="row  p-0 mt-5 justify-content-center ">


        <div class="col-12     col-lg-4">
            <h2>История заказов</h2>

            @foreach($orders as $order)

                <div class=" card  mb-3  ">
                    <div class="card-body ">
                        <small> {{\app\Models\Trash\Order::$STATUS[$order->status]??"Закрыт"}}</small>
                        <div class="row  mb-0" style="font-size: 16px;">
                            <div class="col-auto  ">
                                <b>{{$order->shop->name}}</b>
                                <BR>
                                <small class="opacity-40">{{$order->shop->created_at}}</small>
                            </div>
                            <div class="col" style="text-align: right;">
                                {{number_format($order->amount_all, 2)}} ₽
                            </div>
                        </div>


                        <div class="col-12 mt-2">
                            @foreach($order->basketitems()->take(4) as $basketitem)
                                @if($basketitem->product)
                                    <div class="orderItemRound"
                                         style="background: url('/img/product/{{$basketitem->product->img}}') center; ">

                                    </div>
                                @endif
                            @endforeach
                            @if(count($order->basketitems())>4)
                                <div class="orderItemRound">
                                    +{{count($order->basketitems())-4}}
                                </div>
                            @endif
                        </div>

                        <a class="btn btn-sm btn-outline-dark mt-1 float-end" href="{{route("order.show", $order)}}">Подробнее</a>
                    </div>
                </div>
            @endforeach


        </div>


        <div class="col-12   col-md-8 col-lg-8">
            <div class=" card    ">
                <div class="card-body " s>


                    <h3>Детали заказа</h3>


                </div>
            </div>
        </div>


    </div>


    @include('basket.clear-basket')
@endsection
