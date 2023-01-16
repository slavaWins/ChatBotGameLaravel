@php
    /*** @var $offer \App\Models\Offer */
    /*** @var $order \app\Models\Trash\Order */
@endphp

<div class="card mb-3   " style=" ">
    <div class="card-body">


        @if( $order->offer_select  == $offer->id)

            <h4 class="text-success float-end font-weight-light">ИСПОЛНИТЕЛЬ</h4>

        @endif


        <div class="row">
            @include("user.preview-with-avatar", ['user'=>$offer->performer])
        </div>

        <BR>
        {{$offer->descr}}

        <BR>
        <BR>

        <B>Предлгаемый бюджет:</B>
        <BR> {{number_format($offer->price)}} RUB


        @if($offer->created_at<>$offer->updated_at)
            <BR>
            <small class="opacity-70  ">
                Изменено {{$offer->updated_at}}
            </small>
        @endif



        @if($order->status<=2)
            <BR>
            @if($offer->client_id == Auth::user()->id )
                <a
                        approvedModal="Вы хотите выбрать этого исполнителя?"
                        href="{{route("offer.select", $offer->id)}}"
                        class="btn  btn-outline-dark float-end">Выбрать исполнителя </a>
            @endif
        @endif

    </div>
</div>
