@extends('layouts.containerscreen')

@section('content')


    <div class="container">
        <div class="row">

            <style>
                .navbar{
                    background: transparent !important;
                    box-shadow: none !important;
                }
            </style>

            <div class="col-xs-12 hidden col-md-5" style="font-size: 1.1em; color: rgba(1,1,1,0.78);">
                <div><BR></div> &nbsp;

                <svg b-shared-svg="" name="logo_main" title="Blanc"
                     height="46" class="logo svg ng-star-inserted"
                     role="img" viewBox="0 0 89 22"><title class="ng-star-inserted">Blanc</title><!---->
                    <path fill="#0E17EB" fill-rule="evenodd"
                          d="M88.046 10.965v-.152h-3.953V11c0 3.913-3.208 7.087-7.162 7.087-3.954 0-7.162-3.174-7.162-7.087s3.208-7.087 7.162-7.087h.118V0h-.118C70.8 0 65.816 4.932 65.816 11s4.983 11 11.115 11c6.132 0 11.115-4.932 11.115-11v-.035zM36.684.398l-7.15 21.204h4.084l.805-2.378c.118-.34.32-.55.758-.55h6.534c.438 0 .65.21.757.55l.805 2.378h4.084L40.211.398h-3.527zm3.729 14.585H36.47c-.414 0-.651-.246-.51-.668l2.072-6.162c.19-.55.651-.55.829 0l2.048 6.162c.154.445-.083.668-.497.668zm19.059-1.816c.343.656.876.516.876-.21V.397h3.941V21.59h-4.77L52.712 8.833c-.343-.656-.876-.516-.876.21v12.559h-3.941V.398h5.007l6.57 12.77zM20.23 17.15V.398h-3.942v21.204h12.666V17.9H21a.727.727 0 01-.77-.75zM14.11 6.244c0 1.792-.782 3.257-2.143 4.24 1.621 1.078 2.592 2.906 2.592 4.956 0 3.561-2.569 6.162-6.002 6.162H0V.398h8.132c3.694 0 5.978 2.402 5.978 5.846zM4.497 3.889c-.343 0-.556.211-.556.55v4.03c0 .329.213.575.556.575H7.41c1.468 0 2.51-1.113 2.51-2.578 0-1.44-1.03-2.577-2.51-2.577H4.498zm.048 14.175h2.923c1.74 0 2.818-1.207 2.83-2.788 0-1.558-1.09-2.741-2.818-2.741H4.546c-.356 0-.604.257-.604.62v4.312c0 .35.26.597.604.597z"
                          clip-rule="evenodd"></path>
                </svg>

<BR>
<BR>
<BR>
                <h2 STYLE="font-size: 40px; font-weight: 600;"> Бланк&nbsp;— банк для бизнеса <br class="sm:d-block d-none"> без санкций  </h2>
                <span style="font-size: 0.8em;">Это  удобный онлайн-сервис для малого и среднего бизнеса. Ведите бухгалтерию своими силами.</span>
            </div>


            <div class="col-xs-12 col-md-7">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class=" ">



                            @yield('content')





                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection
