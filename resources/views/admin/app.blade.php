<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <link
        href="{{ asset('css/mdb.min.css') }}"
        rel="stylesheet"
    />

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/BaseClass.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="{{ asset('js/easyapi/easyapi.js')."?".microtime()  }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap"
          rel="stylesheet">


    <script src="{{ asset('js/formbuilder/formBuilderHelper.js') }}"></script>
    <script src="{{ asset('js/formbuilder/InputValidatorValues.js') }}"></script>
    <script src="{{ asset('js/formbuilder/InputValidatorValues.js') }}"></script>


    <style>
        .mess_time {

            font-size: 12px;
            color: #000;
            opacity: 0.4;
        }

        .mess_row {
            font-size: 13px;
            color: #000;
        }

        .mess_login {
            color: #2a5885;
            font-size: 12.5px;
        }

        .mess_row_btns .btn {
            background: #e5ebf1;
            color: #346297;
            font-size: 12px;
            text-transform: none !important;
            box-shadow: none;
        }

        .messageboxWindow .card-body {
            border-bottom: 1px solid #ddd;
        }

        .textarea_mess {
            width: 100%;
            border: 1px solid #ddd;
            background: #fff;
            padding: 10px;
            font-size: 13px;
            border-radius: 4px;
        }

        .mess_scroll {
            height: 600px;
            overflow: auto;
            line-height: 1.21;
        }
    </style>

    @livewireStyles
    <style>

        body {
            background: #F7F7FA;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            color: #000;
            letter-spacing: -0.015em;
        }


        .spanTitle {
            font-style: normal;
            color: #000;
            font-style: normal;
            font-weight: 400;
            font-size: 19.7653px;
            line-height: 24px;
        }

        .sidebarFloatind .spanTitle {
            display: block;
            margin-bottom: 10px;
            padding-left: 13px;
        }
        .sidebarFloatind a {
            display: block;
            padding: 6.5px 26px;
            color: #000;
        }
        .sidebarFloatind a:hover {
            background: #c5c5c545;
            transition: 0.081s;
        }

        .divHrefSide a {

            color: #000;
        }

        .divHrefSide {
            line-height: 2.0em;
            font-style: normal;
            font-weight: 400;
            color: #000;
            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 13px;
        }

        h1, h2, h3, h4 {

            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            line-height: 50px;
            color: #000000;
        }

        h1 {
            font-size: 41.4032px;
        }

        h2 {
            font-size: 26px;
        }

        h3 {
            font-style: normal;
            font-weight: 400;
            font-size: 17.7083px;
            line-height: 21px;
            letter-spacing: 0.015em;
        }


        .textDotLimiter {
            display: inline-block;
            width: 180px;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
        }

        .sidebarFloatind {
            margin-bottom: 25px;
            background: #E6E6E6;
        }

        @media (min-width: 1200px) {
            .sidebarFloatind {
                max-width: 270px;
            }
        }

        .btn{
            border-radius: 0px;
            box-shadow: none !important;
            font-size: 13px;
            letter-spacing: -0.01em;
            text-transform: none ;
        }
        .btn-dark{
            background: #EAE9E9;
            color: #000;
        }
        .btn-primary{
            background: #044AFF;
            color: #fff;
        }
        .table-bordered>:not(caption)>*>*{
            border: 1px solid #000;
        }

    </style>
</head>
<body>
<div id="app">
    @yield('app-col')
</div>


@livewireScripts
</body>

@include("formbuilder::approved-modal")


<script src="{{ asset('js/formbuilder/ApprovedModalController.js') }}"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>

@yield('scripts')

<script>

</script>


</html>
