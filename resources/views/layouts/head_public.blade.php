        <!-- FAVICON -->
        <link rel="shortcut icon" type="image/x-icon" href="@if(systemGeneralSetting() != null && systemGeneralSetting()->favicon != null) {{asset('storage/image/favicon/'.systemGeneralSetting()->favicon)}} @else {{ URL::asset('assets/images/brand/favicon.ico')}}@endif" />

        <!-- TITLE -->
        <title>@if(systemGeneralSetting() != null && systemGeneralSetting()->website_title != null) {{systemGeneralSetting()->website_title}} @else antaraDesk Powered by rocket.Web @endif</title>


        <!-- BOOTSTRAP CSS -->
        <link href="{{ URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

        <!-- STYLE CSS -->
        <link href="{{ URL::asset('assets/css/style.css')}}" rel="stylesheet"/>
        <link href="{{ URL::asset('assets/css-dark/dark-style.css')}}" rel="stylesheet"/>
        <link href="{{ URL::asset('assets/css/skin-modes.css')}}" rel="stylesheet"/>

        <!--HORIZONTAL CSS-->
        <link href="{{ URL::asset('assets/plugins/horizontal-menu/horizontal-menu.css')}}" rel="stylesheet" />

        <!--C3.JS CHARTS PLUGIN -->
        <link href="{{ URL::asset('assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet"/>

        @yield('css')

        <!-- CUSTOM SCROLL BAR CSS-->
        <link href="{{ URL::asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>

        <!--- FONT-ICONS CSS -->
        <link href="{{ URL::asset('assets/css/icons.css')}}" rel="stylesheet"/>

        <!-- SIDEBAR CSS -->
        <link href="{{ URL::asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">

        <!-- COLOR SKIN CSS -->
        <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ URL::asset('assets/colors/color1.css')}}" />

        <!-- CUSTOM SCRIPTS - HEAD -->
        {!! renderCustomScripts('head') !!}


