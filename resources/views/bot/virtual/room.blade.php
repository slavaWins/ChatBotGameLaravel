@php


    use SlavaWins\Formbuilder\Library\FElement;
    /*** @var $user \App\Models\User */
    /*** @var $steps \App\Models\Bot\VirtualStep[] */
    /*** @var $room \App\Models\Bot\VirtualRoom */
@endphp


@extends('adminwinda::screen')




@section('content')

    <h1>{{$className}} </h1>

    <script>
        $(document).ready(function () {
            $("[hideClassIfValue]").each(function (e) {
                e = $(this);
                var div = $(e.attr("hideClassIfValue"));
                var input = $(e.attr("isInputEmpty"));

                function redner() {
                    if (e.is(':checked')) {
                        div.show();

                    } else {
                        div.hide();
                        input.val("");
                    }
                }

                e.on("input", redner);


                // input.on("input", myset);
                if (input.val() != "" && input.val() != "not") e.prop('checked', true);
                redner();
            });
            ;
        });
    </script>
    <style>
        .rowInTwoColum label {
            width: 100% !important;
        }

        .rowInTwoColum > * {
            display: block;
            width: 50%;
        }

        .rowInTreeColum > * {
            display: block;
            width: 33%;
        }

        .textarea-visual {
            border: none;
            width: 100%;
        }
    </style>

    <div class="col-12 p-3">
        <div class="row">
            <a href="{{ route('bot.virtual.room.new.step', $className) }}" class="btn btn-outline-dark col-auto m-2  ">Создать
                шаг</a>

            <a href="{{ route('bot.virtual.room.play', $className) }}" target="_blank"
               class="btn btn-outline-dark col-auto m-2  ">Play </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{ route('bot.virtual.room.save.room', $room) }}">
                @csrf
                <h2 class="mt-4">Настройки комнаты</h2>

                <h3 class="mt-4">Сохранение переменной</h3>
                <small>Кастомная кнопка перехода</small>
                <div class="row rowInTwoColum">

                    @php
                        FElement::NewInputTextRow()
                         ->SetLabel("Подгружаемый чарактер 1")
                         ->SetPlaceholder("Название переменной")
                         ->SetName("item_varible_name1")
                         ->SetDescr("Название переменной, желательно что бы отражало суть")
                         ->FrontendValidate()->String(0,75)
                         ->SetValue(old("item_varible_name1", $room->item_varible_name1 ?? ""))
                         ->RenderHtml(true);
                    @endphp
                    @php
                        $_list =[];
                           $_list["not"]="not";
                        foreach (\App\Services\Bot\ParserBotService::GetCharacterClasses() as $V){
                            $_list[$V]=$V;
                        }
                            FElement::New()->SetView()->InputSelect()
                            ->SetLabel("Тип переменной")
                            ->SetDescr("Какого типа переменная")
                             ->SetName("item_varible_class1")
                              ->AddOptionFromArray($_list)
                             ->SetValue(old("item_varible_class1", $room->item_varible_class1)  )
                              ->RenderHtml(true);
                    @endphp
                </div>


                <div class="row rowInTwoColum mt-4">

                    @php
                        FElement::NewInputTextRow()
                         ->SetLabel("Подгружаемый чарактер 2")
                         ->SetPlaceholder("Название переменной")
                         ->SetName("item_varible_name2")
                         ->SetDescr("Название переменной, желательно что бы отражало суть")
                         ->FrontendValidate()->String(0,75)
                         ->SetValue(old("item_varible_name2", $room->item_varible_name2 ?? ""))
                         ->RenderHtml(true);
                    @endphp
                    @php
                        FElement::New()->SetView()->InputSelect()
                        ->SetLabel("Тип переменной")
                        ->SetDescr("Какого типа переменная")
                         ->SetName("item_varible_class2")
                          ->AddOptionFromArray($_list)
                         ->SetValue(old("item_varible_class2", $room->item_varible_class2)  )
                          ->RenderHtml(true);
                    @endphp
                </div>


                <button type="submit" class="btn btn-outline-dark mt-4 float-end">Сохранить</button>
            </form>
        </div>
    </div>
    @foreach($steps as $step)

        <form method="POST" action="{{ route('bot.virtual.room.save', $step) }}">
            @csrf
            <div id="step_id{{$step->id}}" class="row  p-2" style="background: transparent; border: 1px solid #ddd;">

                @include('bot.virtual.step-preview')

                <div class="col card p-4">


                    <h3>Функции</h3>

                    <label>
                        <input type="checkbox" class="form-check-input"
                               hideClassIfValue=".divSelector{{$step->id}}"
                               isInputEmpty=".divSelector{{$step->id}} #id_selector_character"
                        > Селектор чарактера
                        <small class="form-text text-muted">
                            Вывести все чары определенного типа, и сохр в переменные комнаты
                        </small>
                    </label>

                    <div class="row rowInTreeColum divSelector{{$step->id}}">
                        @php
                            $_list =[];
                               $_list["not"]="Нет селектора";
                            foreach (\App\Services\Bot\ParserBotService::GetCharacterClasses() as $V){
                                $_list[$V]=basename($V);
                            }

                                FElement::New()->SetView()->InputSelect()
                                ->SetLabel("Селектор чаров")
                                ->SetDescr("Выводим чаректер селектор на этом шаге, и сейвет результат в id")
                                 ->SetName("selector_character")
                                  ->AddOptionFromArray($_list)
                                 ->SetValue(old("selector_character", $step->selector_character)  )
                                  ->RenderHtml(true);

                                FElement::New()->SetView()->InputSelect()
                                ->SetLabel("Фильтр чаров")
                                ->SetDescr("Фильтр для выбора чара")
                                 ->SetName("selector_character_filter")
                                  ->AddOptionFromArray(\App\Http\Controllers\Bot\Virtual\RoomVirtualController::FilterSelectorCharacter($room))
                                 ->SetValue(old("selector_character_filter", $step->selector_character_filter)  )
                                  ->RenderHtml(true);



                                FElement::New()->SetView()->InputSelect()
                                ->SetLabel("Сохр в")
                                ->SetDescr("После выбора чара куда сохранить выбранное?")
                                 ->SetName("selector_character_to_varible")
                                  ->AddOptionFromArray(\App\Http\Controllers\Bot\Virtual\RoomVirtualController::RoomVaribles($room))
                                 ->SetValue(old("selector_character_to_varible", $step->selector_character_to_varible)  )
                                  ->RenderHtml(true);
                        @endphp
                    </div>


                    <label>
                        <input type="checkbox" class="form-check-input"
                               hideClassIfValue=".divRender{{$step->id}}"
                               isInputEmpty=".divRender{{$step->id}} #id_render_character"
                        > Рендерить переменную
                        <small class="form-text text-muted">
                            Отрендерить чарактера сохраненного в комнате
                        </small>
                    </label>

                    <div class="row rowInTreeColum divRender{{$step->id}}">
                        @php
                            $_list = \App\Http\Controllers\Bot\Virtual\RoomVirtualController::RoomVaribles($room);
                            $_list['not']="Не рендерить";
                            $_list['player']="Статки игрока";

                                    FElement::New()->SetView()->InputSelect()
                                    ->SetDescr("Этот чарактер будет отрендерен")
                                      ->SetLabel("Какой чар?  ")
                                     ->SetName("render_character")
                                      ->AddOptionFromArray($_list )
                                     ->SetValue(old("render_character", $step->render_character)  )
                                      ->RenderHtml(true);


                        @endphp
                    </div>


                    <h3 class="mt-4">Кнопки</h3>

                    <label>
                        <input type="checkbox" class="form-check-input"
                               hideClassIfValue=".rowShop{{$step->id}}"
                               isInputEmpty=".rowShop{{$step->id}} #id_btn_shop_name"
                        > Открыть магазин
                        <small class="form-text text-muted">
                            Кнопка перехода в магазин
                        </small>
                    </label>


                    <div class="row rowInTreeColum rowShop{{$step->id}}">
                        @php
                            FElement::NewInputText()
                             ->SetLabel("Надпись")
                             ->SetPlaceholder("Название кнопки")
                             ->SetName("btn_shop_name")
                             ->SetDescr("Название кнопки для перехода в др сцену")
                             ->FrontendValidate()->String(0,75)
                             ->SetValue(old("btn_shop_name", $step->btn_shop_name))
                             ->RenderHtml(true);
                        @endphp
                        @php
                            $_list =[];
                               $_list["not"]="not";

                            foreach (\App\Services\Bot\ParserBotService::GetShopItmesClasses() as $V){
                                 $_list[get_class($V)]=$V->icon .' '. get_class($V);
                            }
                                FElement::New()->SetView()->InputSelect()
                                ->SetDescr("Куда будет переход")
                                  ->SetLabel("Что будет покупаться  ")
                                 ->SetName("btn_shop_class")
                                  ->AddOptionFromArray($_list)
                                 ->SetValue(old("btn_shop_class", $step->btn_shop_class)  )
                                  ->RenderHtml(true);
                        @endphp
                        @php
                            FElement::New()->SetView()->InputSelect()
                            ->SetDescr("После покупки, предмет станет дочерним этому объекту")
                              ->SetLabel("Родитель")
                             ->SetName("btn_shop_parent")
                              ->AddOptionFromArray(\App\Http\Controllers\Bot\Virtual\RoomVirtualController::RoomVaribles($room))
                             ->SetValue(old("btn_shop_parent", $step->btn_shop_parent)  )
                              ->RenderHtml(true);
                        @endphp
                    </div>

                    <BR>

                    @for($i=1;$i<=2;$i++)
                        <label>
                            <input type="checkbox" class="form-check-input"
                                   hideClassIfValue=".btn_sceneRow{{$step->id}}_{{$i}}"
                                   isInputEmpty=".btn_sceneRow{{$step->id}}_{{$i}} #id_btn_scene_name{{$i}}"
                            > Кнопка перехода в сцену {{$i}}
                            <small class="form-text text-muted">
                                Перенести игрока на другую сцену
                            </small>
                        </label>


                        <div class="row rowInTreeColum btn_sceneRow{{$step->id}}_{{$i}}">
                            @php
                                FElement::NewInputText()
                                 ->SetLabel("Переход  ")
                                 ->SetPlaceholder("Не открывать")
                                 ->SetName("btn_scene_name".$i)
                                 ->SetDescr("Название кнопки для перехода в др сцену")
                                 ->FrontendValidate()->String(0,75)
                                 ->SetValue(old("btn_scene_name", $step['btn_scene_name'.$i]))
                                 ->RenderHtml(true);
                            @endphp
                            @php
                                $_list =[];
                                   $_list["not"]="not";
                                foreach (\App\Services\Bot\ParserBotService::GetRoomClasses() as $V){
                                    $_list[$V]=$V;
                                }
                                    FElement::New()->SetView()->InputSelect()
                                    ->SetDescr("Куда будет переход")
                                     ->SetLabel("Что открыть?")
                                     ->SetName("btn_scene_class".$i)
                                      ->AddOptionFromArray($_list)
                                     ->SetValue(old("btn_scene_class".$i, $step['btn_scene_class'.$i])  )
                                      ->RenderHtml(true);
                            @endphp

                            @php
                                $_list =\App\Http\Controllers\Bot\Virtual\RoomVirtualController::RoomVaribles($room);
                                   $_list["not"]="Ничего";
                                    FElement::New()->SetView()->InputSelect()
                                    ->SetDescr("Что передать в параметр id сцены?")
                                     ->SetLabel("Передать")
                                     ->SetName("btn_scene_input".$i)
                                      ->AddOptionFromArray($_list)
                                     ->SetValue(old("btn_scene_input".$i, $step['btn_scene_input'.$i])  )
                                      ->RenderHtml(true);
                            @endphp

                        </div>

                        <br>
                    @endfor

                    @php
                        FElement::NewInputTextRow()
                         ->SetLabel("btn_next")
                         ->SetName("btn_next")
                             ->SetPlaceholder("Название кнопки, или оставить пустой")
                         ->FrontendValidate()->String(0,75)
                         ->SetValue(old("btn_next", $step->btn_next))
                         ->RenderHtml(true);
                    @endphp


                    @php
                        FElement::NewInputTextRow()
                         ->SetLabel("btn_exit")
                             ->SetPlaceholder("Название кнопки, или оставить пустой")
                         ->SetName("btn_exit")
                         ->FrontendValidate()->String(0,75)
                         ->SetValue(old("btn_exit", $step->btn_exit))
                         ->RenderHtml(true);
                    @endphp
                    @php
                        FElement::NewInputTextRow()
                         ->SetLabel("btn_back")
                         ->SetName("btn_back")
                             ->SetPlaceholder("Название кнопки, или оставить пустой")
                         ->FrontendValidate()->String(0,75)
                         ->SetValue(old("btn_back", $step->btn_back))
                         ->RenderHtml(true);
                    @endphp

                    <BR>
                    <BR>
                    <h3 class="mt-4">Шаг</h3>

                    @php
                        FElement::NewInputTextRow()
                         ->SetLabel("step")
                         ->SetName("step")
                         ->FrontendValidate()->Digital(0,10)
                         ->SetValue(old("step", $step->step))
                         ->RenderHtml(true);
                    @endphp


                    <BR>
                    <BR>
                    <button type="submit" class="btn btn-outline-dark">Сохранить</button>
                </div>
            </div>
        </form>
    @endforeach
@endsection

