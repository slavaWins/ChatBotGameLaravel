<div>


    <BR>
    <BR>
    <BR>
    <h1 style="text-align: center;">Шаг <b>{{$step}} из {{$stepMax}}</b></h1>

    <div class="progress">
        <div class="progress-bar  "
             style="width: {{$step/$stepMax*100}}%" ;
             role="progressbar"></div>
    </div>

    <style>
        .Step {
            display: none;
            transition: 0.26s;
            xposition: absolute;
            xleft: -100%;
        }

        .Step{{$step}}           {
            display: block;
            xleft: 35%;
            xwidth: 30%;
            xmin-width: 320px;
        }

        .showError {
            transition: 0.12s;
        }

        body {
            background-position-y: {{$step/$stepMax*25}}%;
            transition: 0.35s;
        }
    </style>


    @if($showError)



        <div class="alert showError alert-danger" role="alert" data-mdb-color="danger"

        >
            {{$showError}}
        </div>
    @endif

    <div class="card Step1 Step">
        <div class="card-body">
            <h5 class="card-title">Введите название вашего проекта</h5>
            <p class="card-text">Например Project1</p>


            <?php
            $inpList = [
                'inn' => [
                    'type'  => 'text',
                    'label' => '',
                    'wire'  => 'projectName',
                ],
            ];
            ?>
            @include('inputs.main', $inpList)


            <button type="button" wire:click="makeStep1" class="btn btn-primary">Далее</button>

            <BR>
            <BR>
            <p class="card-text">Название проекта не будет использоваться в коде, только в панели управления.</p>
        </div>
    </div>


    <div class="card Step2 Step">
        <div class="card-body">
            <h5 class="card-title">Выберите под что этот проект</h5>

            @foreach($typeProjectList as $K=>$V)
                <BR>
                <button type="button" style="width: 100%;" class="btn btn-primary mt-1" wire:click="makeStep2yes('{{$K}}')">{{$V}}</button>
            @endforeach
        </div>
    </div>


    <div class="card Step3 Step">
        <div class="card-body">
            <h5 class="card-title">Теперь перейдем к вашему первому проекту!</h5>

            Запишите токен проекта:

            <BR>

            <div class="form-outline mb-4" >
                <textarea readonly class="form-control" style="font-size: 11px; border: 1px solid #ddd;" value=" "/>{{$projectId}}:{{$projectToken}}</textarea>
            </div>

            <BR>
            <button type="button" class="btn btn-primary" wire:click="makeStep3_Finish">НАЧНЕМ!</button>
        </div>
    </div>


    @if($isCanSkip)
        <BR>
        <BR>
        <BR>
        <center>
            <a href="{{route("home")}}">< Отменить создание проекта</a>
        </center>
    @endif

</div>
