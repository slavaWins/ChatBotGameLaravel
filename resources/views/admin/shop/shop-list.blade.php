@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $shop \app\Models\Trash\Shop */
@endphp


@extends('admin.screen')




@section('content')

    <h1>Магазины</h1>

    <table class="table  bg-white">
        <tr>
            <td>ИД</td>
            <td>Название</td>
            <td>Владелец</td>
            <td>Статус</td>
            <td>Управление</td>
        </tr>

        @foreach($shops as $shop)
            <tr>
                <td>{{$shop->id}}</td>

                <td>
                    <a href="{{route("order.show", $shop->id)}}">
                        {{$shop->name}}
                    </a>
                </td>
                <td>
                    <a href="{{route("user.show", $shop->owner->id ?? 0)}}">
                        {{$shop->owner->name ?? "N/A"}}
                    </a>
                </td>

                <td>
                     <span class="badge badge-info  "
                           style="font-size: 13px;"> {{\app\Models\Trash\Shop::$STATUS[$shop->status]}} </span></td>

                <td>
                    <a href="{{route("admin.shop.create", $shop->id)}}">Изменить</a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection

