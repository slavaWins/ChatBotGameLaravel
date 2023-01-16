<h3 class="">Корзина</h3>


@guest
    <div id="offer_form_div" class="mb-6  mt-2 mb-3">
        @include("user.guest-reg-info")
    </div>
@endguest

@auth

@if(isset($basketItems))

    @foreach($basketItems as $item)
        @include('basket.elemnt-basket', ['basketitem'=>$item])
    @endforeach
@endif




<div class="col-12 p-3 " style="position: absolute; bottom: 0px; left: 0px; ">


    @include('basket.smeta')


    <BR>

    <a href="{{route('order.create')}}" class="btn  btn-primary btn-lg   " style="width: 100%">К оплате</a>

</div>

@endauth
