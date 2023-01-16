@php
    use SlavaWins\Formbuilder\Library\FElement;

@endphp

@extends('layouts.containerscreen')



@section('content')

    <h1>Создание заказа </h1>


    <BR>
    <BR>

    <div class=" card   " style=" ">
        <div class="card-body">

            <form method="POST" action="{{ route('order.store') }}">
                @csrf


                @php
                    FElement::NewInputTextRow()
                     ->SetLabel("Название заказаа")
                     ->SetName("title")
                     ->FrontendValidate()->String(15,120)
                     ->SetPlaceholder("Например: Нужно отправить декларацию в налоговую и понять что с перелатами")
                     ->SetDescr("Кратко опишите суть заказа")
                     ->SetValue(old("title") ?: "")
                     ->RenderHtml(true);
                @endphp


                @php
                    FElement::NewInputTextRow()
                     ->SetLabel("Бюджет")
                     ->SetName("budget")
                     ->FrontendValidate()->Money()
                     ->SetValue(old("budget") ?: "1200.00")
                     ->SetDescr("В какую суммы вы готовы уложится.")
                     ->RenderHtml(true);
                @endphp


                <label for="id_descr" class="col-md-3 col-lg-2 col-form-label">Описание</label>

                <textarea type="text"
                          class="form-control noclass  "
                          id="id_descr" name="descr"
                          value="{{old("descr") ?: ""}}"
                          placeholder="Например: Нужно отправить декларацию в налоговую и понять что с перелатами"
                          inputvalidatorvalues="String"
                          inputvalidatorvalues-maxlen="320"
                          inputvalidatorvalues-minlen="5">Типа надо чета сделать</textarea>

                <BR>
                <BR>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-blockX">Создать заказ</button>

            </form>
        </div>
    </div>
    <BR>

@endsection
