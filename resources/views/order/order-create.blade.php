@php

    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $shop \app\Models\Trash\Shop */
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
        .big_shop_prview {
            border-radius: 9px;
        }
    </style>

    <form method="POST" action="{{route('order.create.post')}}">
        @csrf

        <div class="row  p-0  ">
            <div class="col-12  mb-4  ">
                @include('shop.big-preview')
            </div>

            <div class="col-12     col-lg-8  ">
                <div class=" card    ">
                    <div class="card-body " s>
                        <h3>Условия доставки</h3>


                        @php
                            FElement::NewInputText()
                             ->SetLabel("Комментарий к заказу")
                             ->SetName("message")
                             ->FrontendValidate()->String(0,90)
                             ->SetDescr("Можно написать пожеланию к заказу, или уточнение по доставке.")
                             ->SetValue(old("message" ) )
                             ->RenderHtml(true);
                        @endphp


                        @php
                            FElement::New()->SetView()->InputSelect()
                             ->SetLabel("Время доставки")
                             ->SetName("convenient_delivery_time")
                             ->SetDescr("Желаемое время доставки")
                             ->AddOptionFromArray($convenient_delivery_timeOptions)
                             ->SetValue(old("convenient_delivery_time") )
                             ->RenderHtml(true);
                        @endphp


                    </div>
                </div>

                <div class=" card mt-2    ">
                    <div class="card-body ">
                        <h3>Ваш заказ</h3>
                        <div class="col" style="max-width: 340px;">
                            @foreach($basketItems as $item)
                                @include('basket.elemnt-basket', ['basketitem'=>$item])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12   col-md-6 col-lg-4">
                <div class=" card    ">
                    <div class="card-body " s>


                        <h3>Детали заказа</h3>

                        <BR>

                        @include('basket.smeta')

                        <BR> <BR>
                        <button type="submit" class="btn  btn-primary btn-lg   " style="width: 100%">К оплате</button>

                    </div>
                </div>
            </div>


        </div>

    </form>

    @include('basket.clear-basket')
@endsection
