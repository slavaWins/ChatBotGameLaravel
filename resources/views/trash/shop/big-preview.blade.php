@php
    /*** @var $shop \app\Models\Trash\Shop */
@endphp


<div class="col-12 big_shop_prview ">
    <div
            class="_img   "
            style="background: url('/img/shop/{{$shop->image}}'); background-size: cover;   height: 310px;"
    >

        <div class="col-12 p-5"
             style="background: linear-gradient( rgba(0,0,0,0.68),  rgba(0,0,0,0.18)); color: #fff;  height: 310px;">
            <BR>
            <BR>
            <h1 style="color: #fff;">  {{$shop->name}} </h1>
            Фермерский магазин

            <BR>
            <BR>

            <span class="badge  p-2 badge-secondary  ">От 20 до 30 мин</span>
            <span class="badge  p-2 badge-secondary  ">От 20 до 30 мин</span>
        </div>

    </div>
</div>
