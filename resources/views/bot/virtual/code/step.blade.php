@php



    /*** @var $room \App\Models\Bot\VirtualRoom */
    /*** @var $step \App\Models\Bot\VirtualStep */
@endphp

public function Step{{$step->step}}_{{$step->GetStepFunctionName()}}()
{
        $this->response->Reset();

        $this->response->message = "{{$step->start_message}}";


@if($step->render_character)
    //render_character: {{$step->render_character}}
    @if($step->render_character == "var1")
        $this->response->message .="\n" .     $this->{{$room->item_varible_name1}}->Render();
    @endif
    @if($step->render_character == "var2")
        $this->response->message .="\n" .   $this->{{$room->item_varible_name2}}->Render();
    @endif
    @if($step->render_character == "player")
        $this->response->message .="\n" .   $this->user->player->Render();
    @endif
@endif


@if($step->selector_character )

    $example =  new \{{$step->selector_character}}();

    //selector_character_filter {{$step->selector_character_filter}}

        @if($step->selector_character_filter == "all")
            $items = \{{$step->selector_character}}::all();
        @elseif($step->selector_character_filter == "player")
            $items = $this->user->GetAllCharacters(\{{$step->selector_character}}::class);
        @elseif($step->selector_character_filter == "player_parentRoomCharacter1")
            $items = $this->user->GetAllCharacters(\{{$step->selector_character}}::class);
            $items= $items->filter(function($item){
            return $item->parent_id == $this->{{$room->item_varible_name1}}->id;
            });
        @elseif($step->selector_character_filter == "player_parentRoomCharacter2")
            $items = $this->user->GetAllCharacters(\{{$step->selector_character}}::class);
            $items= $items->filter(function($item){
            return $item->parent_id == $this->{{$room->item_varible_name2}}->id;
            });
        @endif

        $selectCharacter = $this->PaginateSelector($items);

        if (count($items) == 1) {
        //$selectCharacter = $this->items->first();
        } elseif (count($items) == 0) {
          $this->response->AddWarning($example->icon." ".$example->baseName.': 0 шт.');
        }

        if ($selectCharacter) {

    @if($step->selector_character_to_varible == "var1")
        $this->scene->SetData('id', $selectCharacter->id);
        $this->scene->save();
    @endif

    @if($step->selector_character_to_varible == "var2")
        $this->scene->SetData('id2', $selectCharacter->id);
        $this->scene->save();
    @endif

        return $this->NextStep();
        }
@endif


@if($step->btn_scene_name)
    if ($this->AddButton("{{$step->btn_scene_name}}")) {
    @if($step->btn_scene_input=="not")
        return $this->SetRoom(\{{$step->btn_scene_class}}::class);
    @endif
    @if($step->btn_scene_input=="var1")
        return $this->SetRoom(\{{$step->btn_scene_class}}::class, ['id'=>$this->{{$room->item_varible_name1}}->id]);
    @endif
    @if($step->btn_scene_input=="var2")
        return $this->SetRoom(\{{$step->btn_scene_class}}::class, ['id'=>$this->{{$room->item_varible_name2}}->id]);
    @endif
    }
@endif

@if($step->btn_shop_name)
    //step->btn_shop_parent = {{$step->btn_shop_parent}}
    if ($this->AddButton("{{$step->btn_shop_name}}")) {
    @if($step->btn_shop_parent=="not")
        $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  \{{$step->btn_shop_class}}::class);
    @endif

    @if($step->btn_shop_parent=="var1")
        $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  \{{$step->btn_shop_class}}::class, $this->{{$room->item_varible_name1}}->id);
    @endif

    @if($step->btn_shop_parent=="var2")
        $room = ShopRoom::CreateShopRoomByCharacterType($this->user,  \{{$step->btn_shop_class}}::class, $this->{{$room->item_varible_name2}}->id);
    @endif
    return $this->SetRoom($room, null, true);

    }
@endif

@if($step->btn_exit)
    if ($this->AddButton("{{$step->btn_exit}}")) {
    $this->DeleteRoom();
    return null;
    }
@endif

@if($step->btn_back and $step->step>0)
    if ($this->AddButton("{{$step->btn_back}}")) {
    return $this->PrevStep();
    }
@endif

@if($step->btn_next)
    if ($this->AddButton("{{$step->btn_next}}")) {
    return $this->NextStep();
    }
@endif

        return $this->response;
}
