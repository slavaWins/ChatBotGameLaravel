<BR>
<BR>


<span class="spanTitle">ВИРТУАЛИЗАЦИЯ </span>
@foreach(\App\Models\Bot\VirtualRoom::all() as $V)

    <a href="{{route("bot.virtual.room", ['className'=> basename($V->className)])}}">{{basename($V->className)}}</a>

    @foreach(\App\Models\Bot\VirtualStep::where("className",basename($V->className) )->get() as $step)
        <a class="small"> - Step{{$step->step}}_{{$step->GetStepFunctionName()}} </a>
    @endforeach

@endforeach
<form method="POST" action="{{ route('bot.virtual.room.new.room') }}">
    @csrf
    <a>
    <input name="className" placeholder="Создать" style="background: transparent; border: 1px solid; border-radius: 2px;">
    </a>
</form>


<BR><BR>
<span class="spanTitle">CHARACTER  </span>

@foreach(\App\Services\Bot\ParserBotService::GetCharacterClasses() as $V)

    <a href="{{route("bot.virtual.character", basename($V))}}">{{basename($V)}} </a>
@endforeach

<BR><BR>
<span class="spanTitle">МАГАЗИН ИТЕМОВ  </span>
<a href="{{route("admin.itemshop.cat")}}">Все категории</a>
@foreach(\App\Services\Bot\ParserBotService::GetShopItmesClasses() as $V)

    <a href="{{route("admin.itemshop.showCategory", basename(get_class($V)))}}">{{$V->baseName}} <BR>
        <small>{{basename(get_class($V))}}</small></a>

@endforeach

