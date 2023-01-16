@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $order \app\Models\Trash\Order */
@endphp


@extends('admin.screen')




@section('content')

    <small>Управление заказом #{{$order->id}}</small>
    <h1>{{$order->title}}</h1>


    <div class="card mb-4">
        <div class="card-body">
            <h3>Общие данные</h3>

            <form method="POST" action="{{ route('admin.order.edit.status', $order) }}">
                @csrf

                @php
                    FElement::New()->SetView()->InputSelect()
                     ->SetLabel("Статус заказаа")
                     ->SetName("status")
                     ->SetDescr("Статус типа")
                     ->AddOptionFromArray(\app\Models\Trash\Order::$ORDER_STATUS)
                     ->SetValue(old("status", $order->status) )
                     ->RenderHtml(true);
                @endphp



                        <!-- Submit button -->
                <button type="submit" class="btn btn-outline-dark float-end">Сохранить</button>


            </form>
        </div>
    </div>

    <div class="card ">
        <div class="card-body">
            <h3>Поля заказа</h3>

            <BR>

            <form method="POST" action="{{ route('admin.order.edit.save', $order) }}">
                @csrf

                @php
                    FElement::NewInputTextRow()
                     ->SetLabel("Название заказаа")
                     ->SetName("title")
                     ->FrontendValidate()->String(15,120)
                     ->SetPlaceholder("Например: Нужно отправить декларацию в налоговую и понять что с перелатами")
                     ->SetDescr("Кратко опишите суть заказа")
                     ->SetValue(old("title", $order->title) )
                     ->RenderHtml(true);
                @endphp


                @php
                    FElement::NewInputTextRow()
                     ->SetLabel("Бюджет")
                     ->SetName("budget")
                     ->FrontendValidate()->Money()
                     ->SetValue(old("budget", $order->budget))
                     ->SetDescr("В какую суммы вы готовы уложится.")
                     ->RenderHtml(true);
                @endphp

                <label for="id_descr" class="col-md-3 col-lg-2 col-form-label">Описание</label>

                <textarea type="text"
                          class="form-control noclass  "
                          id="id_descr" name="descr"
                          value="{{old("descr", $order->descr) }}"
                          placeholder="Например: Нужно отправить декларацию в налоговую и понять что с перелатами"
                          inputvalidatorvalues="String"
                          inputvalidatorvalues-maxlen="320"
                          inputvalidatorvalues-minlen="5">Типа надо чета сделать</textarea>

                <BR>
                <BR>

                <!-- Submit button -->
                <button type="submit" class="btn btn-outline-dark float-end">Сохранить изменения</button>


            </form>
        </div>
    </div>

@endsection

