<div>
    <!-- Notifications -->

    <style>
        .notifyNewItem {
            background: #f1fff0;
        }

        .notifyItem {
            padding: 20px 7px;
            min-width: 360px;

        }
        .bellCards{
            height: 400px;
            overflow: auto;
        }
    </style>
    <div class="dropdown dropdownBellDiv">
        <a
                class="text-reset me-3 dropdown-toggle hidden-arrow"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-mdb-toggle="dropdown"
                aria-expanded="false"
        >
            <i class="fas fa-bell iconBell" style="font-size: 21px;"></i>

            @if($countNew>0)
                <span class="badge rounded-pill badge-notification bg-danger badeNotify">{{$countNew}}</span>
            @endif

        </a>
        <ul
                class="dropdown-menu dropdown-menu-end bellCards"
                aria-labelledby="navbarDropdownMenuLink"
        >


            @foreach($list as $item)
                <li>
                    <div class="  notifyItem card
@if(!$item->isOpen)
                            notifyNewItem
@endif
                            ">
                        {{$item->title}}

                        <small>    {{\App\Helpers\TimeHelper::time_back(strtotime($item->created_at))}}</small>

                        @if(!empty($item->route))
                        <a class="btn btn-primary" href="{{$item->route}}" role="button">Перейти  </a>
                        @endif
                    </div>
                </li>
            @endforeach

        </ul>
    </div>


</div>

<script>

    $('.notifyNewItem').on("mouseenter", function () {
        $(this).removeClass("notifyNewItem");
    });

    $('.dropdownBellDiv').on('show.bs.dropdown', function () {
        $('.badeNotify').hide();
    });

    $('.dropdownBellDiv').on('hide.bs.dropdown', function () {
        window.livewire.emit('OpenAllNotify');
    });

    pusherChannel.bind('notify_{{$userId}}', function (data) {
        window.livewire.emit('UpdData');
        $('.iconBell').effect("bounce", 32, 33)
    });
</script>
