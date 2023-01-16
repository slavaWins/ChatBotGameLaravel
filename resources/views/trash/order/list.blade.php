@extends('layouts.containerscreen')

@section('content')

    <h1>Заказы</h1>

    Здесь вы можете посмотреть все открытые заказы

    <BR>
    <BR>



    @foreach($orders as $order)
        @include('trash.order.element-for-performer', ['order'=>$order])
    @endforeach


    <BR>
    <BR>

@endsection
