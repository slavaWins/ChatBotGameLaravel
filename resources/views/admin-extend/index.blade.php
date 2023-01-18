@extends('adminwinda::screen')




@section('content')

    <h1>Панель управления</h1>
    <h2>Управление и разработка</h2>
    <p>
        Панель управления - это простой и понятный инструмент для выполнения повседневных задач контент-менеджера. От
        простого редактирования информации до управления разделами проекта.</p>

@include("easyanalitics::example.example")
@include("easyanalitics::voronka", ['inds'=>['user_new','user_tracking_frist','user_tracking_hist','reg_buy_garage','reg_buy_car'],'name'=>"Воронка регистраций"])

@endsection

