@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $order \app\Models\Trash\Order */
@endphp


<div class=" card  mb-4 mt-2 " style="display: none; " id="offer_form_div">
    <div class="card-body">

        <h3>Оставить отклик</h3>
        <BR>
        <form method="POST" action="{{ route('offer.create', $order) }}">
            @csrf



            @php
                FElement::NewInputTextRow()
                 ->SetLabel("Бюджет")
                 ->SetName("budget")
                 ->FrontendValidate()->Money()
                 ->SetValue(old("budget") ?: "1200.00")
                 ->SetDescr("В какую суммы вы готовы уложится.")
                 ->RenderHtml(true);
            @endphp


            <label for="id_descr" class=" ">Ваше экспертное мнение</label>

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

            <button type="submit" class="btn  btn-outline-dark float-end">Оставить отклик</button>
            <a onclick="offerFormHide()" class="btn   float-end" style="border: none; box-shadow: none;">Отмена</a>
        </form>
    </div>
</div>
