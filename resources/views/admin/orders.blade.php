@php


    /*** @var $order \app\Models\Trash\Order */
@endphp


@extends('admin.screen')




@section('content')

    <h1>Заказы</h1>

    <table class="table  bg-white">
        <tr>
            <td>ИД</td>
            <td>Название</td>
            <td>Клиент</td>
            <td>Исполнитель</td>
            <td>Статус</td>
        </tr>

        @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>

                <td>
                    <a href="{{route("order.show", $order->id)}}">
                        {{$order->title}}
                    </a>
                </td>
                <td>
                    <a href="{{route("user.show", $order->client->id ?? 0)}}">
                        {{$order->client->name ?? "N/A"}}
                    </a>
                </td>
                <td>
                    <a href="{{route("user.show", $order->performer->id ?? 0)}}">
                        {{$order->client->name ?? "Нет исполнителя"}}
                    </a>
                </td>
                <td>
                     <span class="badge badge-info  "
                           style="font-size: 13px;"> {{\app\Models\Trash\Order::$ORDER_STATUS[$order->status]}} </span>
                </td>

                <td>
                    <a href="{{route("admin.order.edit", $order->id)}}">Изменить</a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection

