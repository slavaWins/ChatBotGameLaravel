<span class="spanTitle">Пользователи  </span>

<a href="{{route("admin.users.list")}}">Все
    <span class="badge bg-primary "> {{count(\App\Models\User::all())}}</span>
</a>

<BR>
<BR>

<span class="spanTitle">МАГАЗИН ИТЕМОВ  </span>
<a href="{{route("admin.itemshop.cat")}}">Все категории</a>
@foreach(\App\Services\Bot\ParserBotService::GetShopItmesClasses() as $V)

    <a href="{{route("admin.itemshop.showCategory", basename(get_class($V)))}}">{{$V->baseName}} <BR> <small>{{basename(get_class($V))}}</small></a>

@endforeach



<BR>
<BR>

<span class="spanTitle">ОСНОВНОЕ  </span>
<a href="{{route("admin")}}">Главная</a>
<BR> <a href="">Статистика</a>
