@php
    /*** @var $shop \app\Models\Trash\Shop */
@endphp


<a class="col-3 shopItem mb-4" href="{{route("shop.show", $shop->id)}}">

    @if($shop->image)
        <div class="col-12 imgdiv"
             style="height: 200px;     position: relative;     border-radius: 12px; overflow: hidden;">
            <div
                    class="_img   "
                    style="background: url('/img/shop/{{$shop->image}}') #fff;    height: 200px;"
            >

            </div>
            <div class="col-12   " style="position: absolute; bottom: 0px;">
                <span class="badge  p-2 badge-secondary  ">От 20 до 30 мин</span>
            </div>
        </div>
    @endif
    <span class="_name">{{$shop->name}}</span>
    <BR>
    <small>
        От {{number_format($shop->min_price)}} ₽
    </small>


</a>
