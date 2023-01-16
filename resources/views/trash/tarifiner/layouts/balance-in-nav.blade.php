<?
    use App\Library\Tarifiner\TarifinerLib;

    $endDate = \App\Library\Tarifiner\TarifinerLib::DayCountToBlocked(Auth::user());

    $secEnd = $endDate->diffInSeconds(\Carbon\Carbon::now());
    $difEnd= $endDate->diff(\Carbon\Carbon::now());


?>

<!-- Balance -->
<div class="dropdown" style="margin-right: 10px;">
    <a
            class="dropdown-toggle d-flex align-items-center hidden-arrow"
            href="#"
            id="navbarDropdownMenuAvatar"
            role="button"
            data-mdb-toggle="dropdown"
            aria-expanded="false"
            style="font-size: 12px; color: #333;"
    >
        Баланс {{ TarifinerLib::GetCurrentBalance(Auth::user())}} RUB
    </a>

    <div class=" dropdown-menu  "  style="padding: 10px;" aria-labelledby="navbarDropdownMenuAvatar" >

        @if($secEnd>3600*24)

            Ваш акаунт оплчен до <BR> {{ \App\Library\Tarifiner\TarifinerLib::DayCountToBlocked(Auth::user())}}
            @elseif($secEnd<5)

            Акаунт заблокирован!!! Нужно пополнить баланс!

            @else
           Сегодня последний день. Завтра акаунт будет заблокирован!

            @endif
        <BR>
        <a href="{{route("Tarifiner.PayTest")}}">Пополнить</a>

            <BR><BR><a href="{{route("Tarifiner.Tarifs")}}">Сменить тариф</a>
    </div>
</div>