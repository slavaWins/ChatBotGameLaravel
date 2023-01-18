@php

    use \App\Models\EasyAnalitics\EasyAnaliticsSetting;


    /** @var string $ind */
    $info  = EasyAnaliticsSetting::GetAnaliticsData($ind);

@endphp

@if($info)

    <div class="card  mb-4">
        <div class="card-body   p-4 border-dark " style="min-height: 170px;">
            <div class=""
                 style="position: absolute; right: 19px; top: 19px; width: 60%; text-align: right; z-index: 2;  ">
                @if($info->data->count())
                <small>За {{$info->data->last()->date_day}}</small>
                <h1>{{$info->data->last()->amount}}</h1>
                @endif
                <span class="float-end b">{{$info->setting->name}}</span>
            </div>

            @if($info->data->count())
                @foreach($info->data->take(15) as $item)
                    <div class="col mb-1  "
                         style="height: 3px; border-radius: 5px;
                 background: #9ba0da;
                 width: {{ $item->amount/$info->max*50  }}%;">
                    </div>
                @endforeach
            @endif
        </div>
    </div>

@else
    Not found  {{$ind}} analitics!
@endif
