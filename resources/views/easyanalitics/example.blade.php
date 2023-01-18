@php

    use SlavaWins\EasyAnalitics\Models\EasyAnaliticsSetting;

@endphp

<div class="row">
    <div class="col">
        @include('easyanalitics::list',['ind' =>'btn_back'])
    </div>
    <div class="col">
        @include('easyanalitics::last',['ind' =>'analitics_1674048076_example'])
    </div>
</div>


<div class="row">
    @foreach(EasyAnaliticsSetting::all() as $item)
        <div class="col-3">
            @include('easyanalitics::list',['ind' =>$item->ind])
        </div>
    @endforeach
</div>
