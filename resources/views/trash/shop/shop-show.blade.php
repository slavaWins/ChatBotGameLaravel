@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $shop \app\Models\Trash\Shop */
@endphp


@extends('layouts.contatiner-fluid')


@section('scripts')

    <script type="text/javascript">

        $(document).ready(function () {
            var heightwindow = $(window).height();
            heightwindow -= $('.basket_Height').position().top;
            heightwindow -= 300;
            heightwindow = 700;
            $('.basket_Height').css('height', heightwindow + 'px');
        });

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

    <div class="row  p-0 p-lg-5">
        <div class="col-12     col-lg-2  ">


            <BR> {{$shop->name}}
            <small>
                <BR> {{$shop->descr}}
            </small>

            <BR> <BR>

            <BR> Минимальная сумма заказа:
            <small>
                <BR> {{number_format($shop->min_price,2)}} ₽
            </small>

            <BR>
            @include('complain.complain')
            <h5>Каталог</h5>
            <div class="col-12 mt-3 mb-3" style="position: sticky; top:12px;">
                @include('trash.shop.category')
            </div>


        </div>


        <div class="col-12   col-md-8 col-lg-8">

            @include('trash.shop.big-preview')


            @guest
                <div id="offer_form_div" class="mb-6  mt-2 mb-3"
                     style="text-align: center;">
                    @include("user.guest-reg-info")
                </div>
            @endguest

            <BR>

            @if(count($productsTop)>0)
                <h1>Популярные товары</h1>
                <div class="row  p-1  ">
                    @foreach($productsTop   as $product)
                        @include("product.product", ['product' => $product, 'basketItemShortData'=>$basketItemShortData])
                    @endforeach
                </div>
            @endif

            @foreach($shop->GetCategoryMap() as $catName=>$cat)

                <h1 id="ykm_{{md5($catName)}}"> {{$catName}}</h1>

                @if(!empty($cat['inner']))
                    <div class="row  p-1  ">
                        @foreach($cat['inner'] as $product)
                            @include("product.product", ['product' => $product, 'basketItemShortData'=>$basketItemShortData])
                        @endforeach
                    </div>
                @endif

                @if(count($cat['subcats'])>1 && $cat['count']>3)
                    @foreach($cat['subcats'] as $subcatName=>$subcatProducts)
                        <a class="badge badge-dark" href="#yk_{{md5($subcatName)}}">{{$subcatName}}</a>
                    @endforeach
                    <BR>
                    <BR>
                @endif

                @foreach($cat['subcats'] as $subcatName=>$subcatProducts)
                    <h3 id="yk_{{md5($subcatName)}}">  {{$subcatName}}</h3>
                    @if(!empty($subcatProducts))
                        <div class="row  p-1  ">
                            @foreach($subcatProducts as $product)
                                @include("product.product", ['product' => $product, 'basketItemShortData'=>$basketItemShortData])
                            @endforeach
                        </div>
                    @endif
                @endforeach

            @endforeach


        </div>


        <div class="col-12 col-md-4 col-lg-2 p-1 " style="padding-top: 0px;">
            <div class=" card  basket_Height  " style="position: sticky; top:12px; ">

                <div class="card-body basketLoading" style="height: 100%; display: none;">
                    <h3>Загрузка корзины...</h3>
                    <h5 class="card-title placeholder-glow">
                        <span class="placeholder col-6"></span>
                    </h5>
                    <p class="card-text placeholder-glow">
                        <span class="placeholder col-7"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-6"></span>
                        <span class="placeholder col-8"></span>
                    </p>
                    <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-12"></a>
                </div>

                <div class="card-body basketContainer" style="height: 100%;">
                    @include('basket.basket', $basketData)
                </div>
            </div>
        </div>
    </div>


    @include('basket.clear-basket')
@endsection
