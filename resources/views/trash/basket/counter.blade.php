<div class="col-12 countController">
    @if(isset($productId))

        <a class="btn btn-primary btn-sm _btnMinus" onclick="ProductController.BtnMinus({{$productId}})">-</a>
        <span class="p-2  _monitorCount">{{$item_count??0}}</span>
        <a class="btn btn-primary  btn-sm _btnPlus" onclick="ProductController.BtnPlus({{$productId}})">+</a>


    @else

        <a class="btn btn-primary btn-sm _btnMinus">-</a>
        <span class="p-2  _monitorCount">{{$item_count??0}}</span>
        <a class="btn btn-primary  btn-sm _btnPlus">+</a>
    @endif

</div>
