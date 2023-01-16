@php
    use SlavaWins\Formbuilder\Library\FElement;

   /*** @var $shop \app\Models\Trash\Shop */
@endphp


@extends('layouts.containerscreen')




@section('content')

    <h1>Создание проекта</h1>
    <form method="POST" action="{{ route('project.create.store') }}"
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
                             ->SetPlaceholder("Например Сайт Авто")
                             ->SetDescr("Краткое")
                             ->SetValue(old("name")  )
                             ->RenderHtml(true);
                        @endphp



                                <!-- Submit button -->
                        <button type="submit" class="btn btn-outline-dark float-end">Создать</button>


                    </div>
                </div>
            </div>


        </div>

    </form>
@endsection

