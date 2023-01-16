@php
    /*** @var $basketitem \app\Models\Trash\BasketItem */
@endphp


<div class="row   p-0">
    <div class="col-3  " style="    background: url('/img/product/{{$basketitem->product->img}}') #fff center; background-size: cover;
    border-radius: 8px;
    height: 64px;">

    </div>
    <div class="col" style="font-size: 14px;">
        {{$basketitem->product->name}}
        <BR>
        <small>
            {{$basketitem->product->price*$basketitem->item_count}} ₽
            / {{$basketitem->product->mass*$basketitem->item_count}} г
        </small>

        <div class="col-12">
            @include('basket.counter', ['item_count'=>$basketitem->item_count, 'productId'=>$basketitem->product_id])
        </div>

    </div>
</div>
