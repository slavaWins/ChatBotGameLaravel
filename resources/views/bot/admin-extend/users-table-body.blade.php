@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $user \app\Models\User */
   /*** @var $character \App\Models\Bot\Character */
@endphp


<td>
    <a href="{{route("admin.character.show", $user->player ?? 0)}}">
        {{$user->player->name ?? $user->player->baseName ?? "N/A"}} #{{$user->player->id ?? "N/A"}}
    </a>
</td>

<td>
    <a href="{{route("admin.user.history", $user->id)}}">
        История сообщений
    </a>
</td>

<td>
    <a href="https://vk.com/id{{$user->vk_id ?? 0}}">
        vk.com/id{{$user->vk_id ?? 0}}
    </a>
</td>


<td>
    {{$user->tg_id ?? "NA"}}
</td>

<td>
    @if($user->player)
        {{$user->player->characterData->money }}
    @endif
</td>
<td>
    {{ number_format( \App\Services\MoneyAnalizService::GetUserMoneyState($user) )}} RUB
</td>
