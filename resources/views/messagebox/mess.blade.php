@php

    /** @var \App\Models\History $history */

@endphp
<div class="row mess_row mb-3">
    <div class="col-auto m-0 mr-0 pr-0" style="    padding-right: 2px;">
        <img
            width="36"
            style="border-radius: 100%;"
            @if($history->isFromBot)
                src="https://sun4-11.userapi.com/s/v1/ig2/MsW3oMvQbmo374czjkKCFo0i_1q8hFHuOmpQy5ueh3c6ObjshmlcF8MtDGMp_NL5Y7nTGWi8c754kvKJNkGdZxHH.jpg?size=50x50&quality=95&crop=46,436,296,296&ava=1"
            @else
                src="/img/ava0.jpg"
            @endif
        >
    </div>
    <div class="col">

        <b class="mess_login">
            @if($history->isFromBot)
                {{env("APP_NAME")}}
            @else
                {{$user->name ?? "Не указано"}}
            @endif

        </b>
        <span class="mess_time"> {{\Carbon\Carbon::parse($history->created_at,"UTC")}}</span>
        <BR>
        {!! nl2br($history->message) !!}

        @if($history->attachment_sound)
            <audio
                controls
                src="/sound/{{$history->attachment_sound}}">
            </audio>
        @endif


    </div>
</div>
