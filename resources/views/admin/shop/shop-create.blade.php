@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $shop \app\Models\Trash\Shop */
@endphp


@extends('admin.screen')




@section('content')

    <small>Редактор магазина</small>

    <h1>{{$shop->name ?? "Новый магазин*"}}</h1>
    <form method="POST" action="{{ route('admin.shop.create.post', ['shop' => $shop->id ?? 0] ) }}"
          enctype="multipart/form-data">
        @csrf

        <div class="row">

            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>Общие данные</h3>


                        @php
                            FElement::NewInputTextRow()
                             ->SetLabel("Название ")
                             ->SetName("name")
                             ->FrontendValidate()->String(2,32)
                             ->SetPlaceholder("Например: Нужно отправить декларацию в налоговую и понять что с перелатами")
                             ->SetDescr("Кратко опишите суть заказа")
                             ->SetValue(old("name") ?? $shop->name ?? "" )
                             ->RenderHtml(true);
                        @endphp


                        @php
                            FElement::NewInputTextRow()
                             ->SetLabel("Адресс ")
                             ->SetName("address")
                             ->FrontendValidate()->String(7,232)
                             ->SetPlaceholder("Полный адрес")
                             ->SetDescr("Кратко опишите суть заказа")
                             ->SetValue(old("address", $shop->address ?? "") )
                             ->RenderHtml(true);
                        @endphp


                        @php
                            FElement::NewInputTextRow()
                             ->SetLabel("Срок готовки ")
                             ->SetName("min_time_work")
                             ->FrontendValidate()->Digital(1,3)
                             ->SetPlaceholder("")
                             ->SetDescr("Сколько времени нужно на подготовку заказа до его отправки. Минимальное время.")
                             ->SetValue(old("min_time_work", $shop->min_time_work ?? 10) )
                             ->RenderHtml(true);
                        @endphp

                        @php
                            FElement::NewInputTextRow()
                             ->SetLabel("Минимальная сумма заказа")
                             ->SetName("min_price")
                             ->FrontendValidate()->Money()
                             ->SetValue(old("min_price", $shop->min_price ?? ""))
                             ->SetDescr("Мин заказ.")
                             ->RenderHtml(true);
                        @endphp

                        @php
                            FElement::NewInputTextRow()
                             ->SetLabel("ИД пользователя")
                             ->SetName("owner_id")
                             ->FrontendValidate()->Digital()
                             ->SetValue(old("owner_id", $shop->owner_id ?? ""))
                             ->SetDescr("Ид владельца магазина")
                             ->RenderHtml(true);
                        @endphp

                        <label for="id_descr" class="col-md-3 col-lg-2 col-form-label">Описание</label>

                        <textarea type="text"
                                  class="form-control noclass  "
                                  id="id_descr" name="descr"
                                  value="{{old("descr", $shop->descr ?? "") }}"
                                  placeholder="Например: Нужно отправить декларацию в налоговую и понять что с перелатами"
                                  inputvalidatorvalues="String"
                                  inputvalidatorvalues-maxlen="320"
                                  inputvalidatorvalues-minlen="5">Типа пару слов туда сюда</textarea>

                        <BR>
                        <BR>

                        @php
                            FElement::New()->SetView()->InputSelect()
                             ->SetLabel("Статус магазина")
                             ->SetName("status")
                             ->SetDescr("Статус типа")
                             ->AddOptionFromArray(\app\Models\Trash\Shop::$STATUS)
                             ->SetValue(old("status", $shop->status ?? "") )
                             ->RenderHtml(true);
                        @endphp



                                <!-- Submit button -->
                        <button type="submit" class="btn btn-outline-dark float-end">Сохранить</button>


                    </div>
                </div>
            </div>

            @if($shop)
                <div class="col-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3>Картинка</h3>
                            @if(!empty($shop->image))
                                <img src="/img/shop/{{$shop->image}}" class="bg-image col-12 mb-2">
                            @endif
                            <input type="file" class="form-control" name="image"/>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </form>
@endsection

