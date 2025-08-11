<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="@if(systemGeneralSetting() != null && systemGeneralSetting()->website_description != null) {{systemGeneralSetting()->website_description}} @else antaraDesk Powered by rocket.Web @endif">
        @include('layouts.head_public')
    </head>

    <body>
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
            @include('layouts.header_public')
{{--            @include('layouts.horizontal-main')--}}
            @include('layouts.mobile-header_public')
        <div class="container app-content">
        <div class="">
            @yield('page-header')
            @yield('content')
            @include('layouts.sidebar')
            @include('layouts.footer')
        </div>
        </div>
            @include('layouts.footer-scripts')
            {{-- <script> !function() { var t; if (t = window.webbot = window.webbot = window.webbot || [], !t.init) return t.invoked ? void (window.console && console.error && console.error("Snippet included twice.")) : ( t.load =function(e){ var o,n; o=document.createElement("script"); e.type="text/javscript"; o.async=!0; o.crossorigin="anonymous"; o.src="https://app.antara.chat/web-bot/script/frame/"+e+"/webbot.js"; n=document.getElementsByTagName("script")[0]; n.parentNode.insertBefore(o,n); }); }(); webbot.load('0WFaGFWwMbRYKgF5K6UqoCoVkIKRUibfYZspzkgU'); </script> --}}

            <!-- CUSTOM SCRIPTS - BODY -->
            {!! renderCustomScripts('body') !!}

    </body>
</html>
