<BR>
<BR>

<span class="spanTitle">МАГАЗИН ИТЕМОВ  </span>
<a href="{{route("admin.itemshop.cat")}}">Все категории</a>
@foreach(\App\Services\Bot\ParserBotService::GetShopItmesClasses() as $V)

    <a href="{{route("admin.itemshop.showCategory", basename(get_class($V)))}}">{{$V->baseName}} <BR>
        <small>{{basename(get_class($V))}}</small></a>

@endforeach

