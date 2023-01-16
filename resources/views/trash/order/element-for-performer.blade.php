@php
    /*** @var $order \app\Models\Trash\Order */
@endphp

<div class="card mb-3   " style=" ">
    <div class="card-body">


        <h3>{{$order->title}}</h3>
        <BR>

        <div class="row">
            @include("user.preview-with-avatar", ['user'=>$order->client ?? null])
        </div>

        <BR>

        <B>Бюджет:</B>
        <BR> {{number_format($order->budget)}} RUB


        @if($order->created_at<>$order->updated_at)
            <BR>
            <small class="opacity-70  ">
                Обновлено {{$order->updated_at}}
            </small>
        @endif


        <a

                href="{{route("order.show", $order->id)}}"
                class="btn   btn-outline-dark float-end">Подробнее </a>

    </div>
</div>
