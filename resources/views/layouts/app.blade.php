<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/basket.css') }}" rel="stylesheet">
    <link href="{{ asset('css/product.css') }}" rel="stylesheet">
    <link href="{{ asset('css/shop.css') }}" rel="stylesheet">

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
    <script src="{{ asset('js/mdb.min.js') }}" defer></script>
    <script src="{{ asset('js/MApi.js') }}" defer></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


    <script src="{{ asset('js/easyapi/easyapi.js')."?".microtime()  }}"></script>
    <script src="{{ asset('js/editor/block-controller.js')."?".microtime() }}"></script>
    <script src="{{ asset('js/editor/baserow-controller.js')."?".microtime() }}"></script>
    <script src="{{ asset('js/editor/window-editor-controller.js')."?".microtime() }}"></script>
    <script src="{{ asset('js/editor/textarea.js')."?".microtime() }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap"
          rel="stylesheet">




    <script src="{{ asset('js/formbuilder/formBuilderHelper.js') }}"></script>
    <script src="{{ asset('js/formbuilder/InputValidatorValues.js') }}"></script>
    <script src="{{ asset('js/formbuilder/InputValidatorValues.js') }}"></script>
    <script src="{{ asset('js/ProductController.js') }}?={{time()}}x{{rand(122,999)}}"></script>


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

        h1, h2, h3 {
            font-weight: 900;
            opacity: 1;
            color: #000;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .main-card-container {
            xmin-height: 2550px;
            padding-top: 30px;
        }

        .navbar-light .navbar-brand, .navbar-light .navbar-brand:focus, .navbar-light .navbar-brand:hover,
        .navbar-light .navbar-nav .nav-link {
            color: #000;
        }

        .bg-white {

        }

        .form-outline .form-control.disabled, .form-outline .form-control:disabled, .form-outline .form-control[readonly] {
            background-color: transparent !important;
        }

        .navbarMain {
            height: 80px;
            font-size: 15px;
            padding: 22px 0px;
            box-shadow: none !important;
            background: transparent !important;
            border: none !important;
            opacity: 1;
            z-index: 1;
            font-weight: 400;
            font-style: normal;
            color: #000;
        }

        body {
            background: #F7F7FA;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            color: #000;

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


</html>
