@extends('layouts.fullscreen')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card  " style="margin-bottom:  56px;">

                    <div class="card-body">

                        <h2 class=" ">
                           Тестовое пополнение баланса
                        </h2>


                        <h5 class=" ">
                            Сейчас ваш баланс: {{ \App\Library\Tarifiner\TarifinerLib::GetCurrentBalance(Auth::user())}} RUB
                        </h5>

                        Вы можете пополнить его на:

                        <BR> <a href="?payplus=50">50 RUB</a>
                        <BR> <a href="?payplus=100">100 RUB</a>
                        <BR> <a href="?payplus=400">400 RUB</a>


                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

