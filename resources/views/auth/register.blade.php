@extends('layouts.containerscreen')

@section('content')


    <div class="container">
        <div class="row">

            <style>
                .navbar {
                    background: transparent !important;
                    box-shadow: none !important;
                }
            </style>

            <div class="col-xs-12 hidden col-md-5" style="font-size: 1.1em; color: rgba(1,1,1,0.78);">
                <div><BR></div> &nbsp;



                <BR>
                <BR>
                <h2 STYLE="font-size: 40px; font-weight: 600;"> Makret &nbsp;— быстрый маркет<br
                            class="sm:d-block d-none"> для решения проблем </h2>

                +
                <a class="navbar-brand mt-2 mt-lg-0" href="">
                    <img
                            src="/img/Logo.png"
                            height="35"
                            alt="MDB Logo"
                            loading="lazy"
                    />
                </a>

                <span style="font-size: 0.8em;">Настройте бухгалтерию один раз, и решайте проблемы удаленно Настройте дебаг один раз, и решайте проблемы удаленно Настройте дебаг один раз, и решайте проблемы удаленно </span>
            </div>

            <div class="col-xs-12 col-md-7">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class=" ">

                            <BR>
                            <BR>
                            <BR>
                            <h3>Регистрация</h3>

                            <BR>
                            <BR>




                            <form method="POST" action="{{ route('register') }}">
                            @csrf

                                <?php

                                $inpList = [
                                    'email' => [
                                        'type' => 'email',
                                        'label' => 'Почта',
                                    ],
                                    'password' => [
                                        'type' => 'password',
                                        'label' => 'Пароль',
                                    ],
                                    'password_confirmation' => [
                                        'type' => 'password',
                                        'label' => 'Подтверждение пароля',
                                    ],
                                ];
                                ?>

                                @include('inputs.main', $inpList)


                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Регистрация') }}
                                </button>



                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
