@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $categorys \App\Models\Bot\ItemCharacterShop[] */
   /*** @var $item \App\Models\Bot\ItemCharacterShop */
   /*** @var $example \App\Models\Bot\ItemCharacterShop */
   /*** @var $parameter \App\Library\Structure\StatStructure */
@endphp


@extends('adminwinda::screen')




@section('content')

    <style>
        .sidebarFloatind {
            display: none;
        }

        .mainContent {
            width: 100%;
        }
    </style>

   <a href="./"> <h2>< Назад</h2></a>

    <h4 class="mb-0"> База товаров </h4>
    <h1> {{$example->baseName}}</h1>

    <p>
        Когда вы создаете новый класс пространственных объектов магазины или таблицу в базе магазина с помощью
        инструментов редактора - можно управлять их значениями.
        Можно использовать специальные кнопки панели инструментов: Дублировать, Удалить, Сохранить. Эти операции можно
        осуществить с любыми элементами.
    </p>

    <table class="table  bg-white table-bordered">
        <tr class="small">
            <td>ИД</td>
            <td>Покупок</td>
            <td>Название</td>
            @if(!$issetPriceVarible)
                <td>Цена</td>
            @endif
            <td>Торговец</td>


            @foreach((array)$example->characterData as $K=>$parameter)

                <td>
                    {{$parameter->icon}} {{$parameter->name}}
                    <BR>
                    <small>
                        {{$K}} | Макс: {{$parameter->max ?? "безлимит"}}
                    </small>
                </td>
            @endforeach
        </tr>

        @foreach($items as $item)
            <tr class="formMini">
                <form method="POST"
                      action="{{route('admin.itemshop.edit', ['catClassName'=>$catClassNameOriginal, 'id'=> $item->id])}}">
                    @csrf
                    <td>{{$item->id}}</td>
                    <td>{{$item->buy_count}}</td>
                    <td>
                        @php
                            FElement::NewInputText()
                             ->SetName("name")
                             ->FrontendValidate()->String(2,75)
                             ->SetValue(old("name", $item->name)  )
                             ->RenderHtml(true);
                        @endphp
                    </td>
                    @if(!$issetPriceVarible)
                        <td>
                            @php
                                FElement::NewInputText()
                                 ->SetName("price")
                                 ->SetValue(old("price", $item->price)  )
                                 ->RenderHtml(true);
                            @endphp
                        </td>
                    @endif

                    <td>
                        @php
                            FElement::New()->SetView()->InputSelect()
                             ->SetName("merchant_id")
                              ->AddOptionFromArray($merchantList)
                             ->SetValue(old("merchant_id", $item->merchant_id ?? 0)  )
                              ->RenderHtml(true);
                        @endphp
                    </td>

                    @foreach((array)$example->characterData as $K=>$parameter)

                        <td>
                            @if($parameter->options ?? false)
                                @php
                                    $options = [];
                                    foreach ($parameter->options as $variant)$options[$variant]=$variant;

                                        FElement::New()->SetView()->InputSelect()
                                         ->SetName($K)
                                          ->AddOptionFromArray($options)
                                         ->SetValue(old($K, $item->characterData->$K ?? 0)  )
                                          ->RenderHtml(true);
                                @endphp
                            @else
                                @php
                                    FElement::NewInputText()
                                     ->SetName($K)
                                     ->SetValue(old($K, $item->characterData->$K ?? 0)  )
                                     ->RenderHtml(true);
                                @endphp
                            @endif

                        </td>
                    @endforeach

                    <td>
                        <button type="submit" class="btn btn-outline-dark btn-sm btn-cont">Сохранить</button>
                    </td>

                    <td>
                        <button type="submit" class="btn btn-outline-dark btn-sm btn-cont" name="doubleMake" value="1">
                            Дубль
                        </button>
                    </td>
                </form>
            </tr>
        @endforeach
    </table>

    <a href="{{route("admin.itemshop.showCategory.create", $catClassNameOriginal)}}"
       class="btn btn-primary">Создать {{$example->baseName}}</a>

    <style>
        td {
            padding: 0px !important;

        }

        .formMini .btn {
            margin-top: -4px;
        }

        .btn-cont {
            font-size: 10px;
            border-width: 1px;
            padding: 4px !important;
            margin: 0px !important;
        }

        .formMini input, .formMini select {
            font-size: 12px;
            padding: 4px 2px;
            width: 100%;
            border: none;
            border-radius: 0px;
        }

        .formMini label {
            display: none;
        }

        .formMini select {
            font-size: 12px;
            padding: 4px 2px;
            width: 100%;
            border: none;
            border-radius: 0px;
        }

        .formMini .form-group {
            padding: 0px;
            margin: 0px;
            margin-top: 0px;
        }
    </style>

@endsection

