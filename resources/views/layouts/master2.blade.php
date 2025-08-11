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

    <body class="login-img">
        @yield('content')
        @include('layouts.footer-scripts')
    </body>
</html>
