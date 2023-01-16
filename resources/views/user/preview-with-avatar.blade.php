<div class="col-auto"><img src="/img/ava0.jpg" width="76"></div>
<div class="col ">

    @auth
        <a href="{{route("user.show", $user->id ?? 0)}}">
            {{$user->name ?? "Не указано"}}
        </a>
    @endauth

    @guest
        ████████ ██████
    @endguest


    <BR>
    <small style="opacity: 0.8;">
        @if($user)
            @include("user.small-info", ['user'=>$user])
        @else
            Пользователь удален
        @endif
    </small>
</div>
