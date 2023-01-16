@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $categorys \App\Models\Bot\ItemCharacterShop[] */
   /*** @var $item \App\Models\Bot\ItemCharacterShop */
   /*** @var $example \App\Models\Bot\ItemCharacterShop */
   /*** @var $parameter \App\Library\Structure\StatStructure */
@endphp


@extends('admin.screen')




@section('content')

    <h1>{{$example->baseName}}: База товаров </h1>

    <table class="table  bg-white">
        <tr>
            <td>ИД</td>
            <td>Класс</td>
            <td>Название</td>
            <td>Цена</td>


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
                    <td class="small">{{basename($item->className)}}</td>
                    <td>
                        @php
                            FElement::NewInputText()
                             ->SetName("name")
                             ->FrontendValidate()->String(2,75)
                             ->SetValue(old("name", $item->name)  )
                             ->RenderHtml(true);
                        @endphp
                    </td>
                    <td>

                        @php
                            FElement::NewInputText()
                             ->SetName("price")
                             ->SetValue(old("price", $item->price)  )
                             ->RenderHtml(true);
                        @endphp
                    </td>

                    @foreach((array)$example->characterData as $K=>$parameter)

                        <td>
                            @php
                                FElement::NewInputText()
                                 ->SetName($K)
                                 ->SetValue(old($K, $item->characterData->$K)  )
                                 ->RenderHtml(true);
                            @endphp
                        </td>
                    @endforeach

                    <td>

                        <button type="submit" class="btn btn-outline-dark btn-sm">Сохранить</button>
                    </td>
                </form>
            </tr>
        @endforeach
    </table>

    <a href="{{route("admin.itemshop.showCategory.create", $catClassNameOriginal)}}" class="btn btn-outline-dark">Создать {{$example->baseName}}</a>

    <style>
        .formMini .btn {
            margin-top: -4px;
        }

        .formMini input {
            font-size: 12px;
            padding: 3px 1px;
            width: 100%;
        }

        .formMini .form-group {
            padding: 0px;
            margin: 0px;
            margin-top: -4px;
        }
    </style>

@endsection

