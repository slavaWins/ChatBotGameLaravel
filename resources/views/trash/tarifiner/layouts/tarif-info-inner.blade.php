
<?php

        /** @var $item \App\Library\Tarifiner\TarifinerStruct */
?>

<h4>{{$item->name}}</h4>
<p class="_descr">{{$item->descr}}</p>


Заказов паралельно: {{$item->limitProject}} шт.
<BR> Откликов: {{$item->limitDebugCount}} шт/день

<hr>

<div class="listTableCompare">
@foreach($item->listTableCompare as $K=>$V)
   <b>{{$K}}</b>: {{$V}} <BR>
    @endforeach
</div>

<BR>
<BR>
Стоимость:
<h4>{{$item->priceDay*30}} ₽ <small>/месяц</small></h4>

