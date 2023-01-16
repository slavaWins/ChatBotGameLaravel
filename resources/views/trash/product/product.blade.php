@php
    /*** @var $product \app\Models\Trash\Product */
@endphp


<div class="col-6 col-md-3 proItem p-1  mb-3 productControllerElement product_{{$product->id}}"
     productId="{{$product->id}}"
     productStock={{$product->stock}}
     shopId={{$product->shop_id}}
     @if(isset($basketItemShortData))
     productOrder={{$basketItemShortData[$product->id] ?? 0}}
@else
    productOrder=0
        @endif
>

    <div class="card  " style="border-radius: 19px;">
        <div class="card-body  " style="padding: 10px; border-radius: 19px;">

            @if($product->img)

                <div class="_img col-12  mb-2"
                     style="background: url('/img/product/{{$product->img}}') center;   border-radius: 19px;   height: 190px;">

                </div>
            @endif

            <b style="font-size: 17px; font-weight: 600;">
                {{number_format($product->price, 2)}} ₽
            </b>

            <BR>


            <span class="_name">{{$product->name}}</span>

            <div class="col-12 mt-2 mb-1" style="opacity: 0.6;">
                {{number_format($product->mass, 0)}} г
            </div>

            @auth
                <a class="btn btn_backet   btn-primary col-12 p-3">
                    Добавить
                </a>
            @endauth

            @include('basket.counter')

            <div class="warning col-12  " style="  text-align: center; font-size: 12px;"></div>
            <div class="error col-12  " style="color: red; text-align: center; font-size: 12px;"></div>


        </div>
    </div>

</div>
