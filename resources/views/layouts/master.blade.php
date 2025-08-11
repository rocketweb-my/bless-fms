<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>

        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="@if(systemGeneralSetting() != null && systemGeneralSetting()->website_description != null) {{systemGeneralSetting()->website_description}} @else antaraDesk Powered by rocket.Web @endif">
        @include('layouts.head')
    </head>

    <body class="app sidebar-mini">
    <style>
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>

            <!-- GLOBAL-LOADER -->
            <div id="global-loader">
                <img src="{{URL::asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
            </div>
            <!-- /GLOBAL-LOADER -->
            <!-- PAGE -->
             <div class="page" id="app">
             <div class="page-main">
                @include('layouts.app-sidebar')
                @include('layouts.mobile-header')
            <div class="app-content">
            <div class="side-app">
            <div class="page-header">
                @yield('page-header')
                @include('layouts.notification')
            </div>
                @yield('content')
                @include('layouts.sidebar')
                @include('layouts.footer')
            </div>
            </div>
                @include('components.create_ticket_popup')
                @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@10"])
                @include('layouts.footer-scripts')

                <!-- CUSTOM SCRIPTS - BODY -->
                {!! renderCustomScripts('body') !!}

    </body>
</html>
