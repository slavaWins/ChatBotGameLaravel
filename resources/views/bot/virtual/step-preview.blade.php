@php


    /*** @var $user \App\Models\User */
    /*** @var $steps \App\Models\Bot\VirtualStep[] */
    /*** @var $step \App\Models\Bot\VirtualStep */
    /*** @var $room \App\Models\Bot\VirtualRoom */

$btns = [];
@endphp


<div class="col-5 messageboxWindow">
    <div class="card">

        <div class="card-body " style="font-size: 14px; font-weight: 600; color: #000;">
            Step{{$step->id}}_{{$step->GetStepFunctionName()}}()
        </div>

        <div class="card-body mess_scroll">


            <div class="row mess_row mb-3">
                <div class="col-auto m-0 mr-0 pr-0" style="    padding-right: 2px;">
                    <img
                        width="36"
                        style="border-radius: 100%;"

                        src="https://sun4-11.userapi.com/s/v1/ig2/MsW3oMvQbmo374czjkKCFo0i_1q8hFHuOmpQy5ueh3c6ObjshmlcF8MtDGMp_NL5Y7nTGWi8c754kvKJNkGdZxHH.jpg?size=50x50&quality=95&crop=46,436,296,296&ava=1"

                    >
                </div>
                <div class="col">

                    <b class="mess_login">
                        {{env("APP_NAME")}}

                    </b>
                    <span class="mess_time"> 00:50</span>
                    <BR>

                    {{$user->player->GetHeader()}}
                    <BR>
                    <BR>
                    <textarea name="start_message" class="textarea-visual">{{$step->start_message}}</textarea>

                    @if($step->render_character == "player")
                        @php
                            /** @var \App\Models\Bot\Character $char */
                            $char =   \App\Characters\PlayerCharacter::first();
                            echo nl2br( $char->Render(true));
                            echo "<BR>";
                        @endphp
                    @endif

                    @if($step->render_character == "var1")
                        @php
                            /** @var \App\Models\Bot\Character $char */
                            $cl = $room->item_varible_class1;
                            $char =   $cl::first();
                            echo nl2br( $char->Render(true));
                            echo "<BR>";
                        @endphp
                    @endif

                    @if($step->render_character == "var2")
                        @php
                            /** @var \App\Models\Bot\Character $char */
                            $cl = $room->item_varible_class2;
                            $char =   $cl::first();
                            echo nl2br( $char->Render(true));
                            echo "<BR>";
                        @endphp
                    @endif

                    @if($step->selector_character)
                        @php
                            /** @var \App\Models\Bot\Character $char */
                            $cl = $step->selector_character;
                            $char =   $cl::first();
                            for($i=41;$i<44;$i++){
                                echo "<BR><BR>".$i."] ".nl2br( $char->Render(true));
                                $btns[$i.'']=0;
                            }
                               $btns['<']=0;
                               $btns['>']=0;
                        @endphp
                    @endif


                </div>
            </div>
        </div>


        <div class="card-body">
            <textarea placeholder="Напишите сообщение..." rows="1" class="textarea_mess"></textarea>
            <div class="row mess_row_btns p-1">

                <?

                $btns = $step->GetBtns($btns);
                ?>

                @include("messagebox.keyboard", ['buttons'=>$btns ])

            </div>
        </div>

    </div>
</div>
