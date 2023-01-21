@php


    /*** @var $userShow \app\Models\User */
    /*** @var $character \App\Models\Bot\Character */
    /*** @var $room \App\Models\Bot\VirtualRoom */
@endphp


namespace App\Scene\Virtual;

use App\Scene\Core\BaseRoomPlus;
use App\Scene\Core\ShopRoom;

class {{$className}} extends BaseRoomPlus
{

@if($room->item_varible_name1)
    public ?\{{$room->item_varible_class1}} ${{$room->item_varible_name1}};
@endif

@if($room->item_varible_name2)
    public ?\{{$room->item_varible_class2}} ${{$room->item_varible_name2}};
@endif


@foreach($steps as $step)
     @include('bot.virtual.code.step')
@endforeach

@if($room->item_varible_name1 || $room->item_varible_name2)
    function Boot()
    {

        @if($room->item_varible_name1)
                    if ($this->scene->sceneData['id'] ?? false) {

                        $this->{{$room->item_varible_name1}} = \{{$room->item_varible_class1}}::LoadCharacterById($this->scene->sceneData['id']);

                    }
                    @endif

        @if($room->item_varible_name2)
                    if ($this->scene->sceneData['id2'] ?? false) {

                        $this->{{$room->item_varible_name2}} = \{{$room->item_varible_class2}}::LoadCharacterById($this->scene->sceneData['id2']);

                    }
        @endif

}
@endif

}
