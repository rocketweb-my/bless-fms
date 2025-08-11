<!--APP-SIDEBAR-->
                <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
                <aside class="app-sidebar">
                    <div class="side-header">
                        <a class="header-brand1" href="{{route('ticket.index')}}">
{{--                            <img src="{{URL::asset('assets/images/brand/e-Aduan-logo.png')}}" class="header-brand-img desktop-logo" alt="logo">--}}
{{--                            <img src="{{URL::asset('assets/images/brand/e-Aduan-logo.png')}}"  class="header-brand-img toggle-logo" alt="logo">--}}
{{--                            <img src="{{URL::asset('assets/images/brand/e-Aduan-logo.png')}}" class="header-brand-img light-logo" alt="logo">--}}
                            <img src="@if(systemGeneralSetting() != null && systemGeneralSetting()->logo != null) {{asset('storage/image/logo/'.systemGeneralSetting()->logo)}} @else {{URL::asset('assets/images/brand/antaraDesk-logo.png')}} @endif" class="header-brand-img light-logo1" style="height: auto !important;" alt="logo">
                        </a><!-- LOGO -->
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
                    </div>
                    <ul class="side-menu">
                        <li><h3>{{__('main.Main')}}</h3></li>
                        <li>
                            <a class="side-menu__item" href="{{route('dashboard.index')}}"><i class="side-menu__icon fa fa-ticket"></i><span class="side-menu__label">Dashboard</span></a>
                        </li>
                        <li>
                            <a class="side-menu__item" href="{{route('ticket.index')}}"><i class="side-menu__icon fa fa-ticket"></i><span class="side-menu__label">{{__('main.Tickets')}}</span></a>
                        </li>
                        @if(user()->isadmin == 1 || userPermissionChecker('can_man_canned') == true || userPermissionChecker('can_man_ticket_tpl') == true)
                        <li class="slide">
                            <a class="side-menu__item"  data-toggle="slide" href="#" style="width: 100%!important;"><i class="side-menu__icon fa fa-newspaper-o"></i><span class="side-menu__label" style="text-align: left !important;">{{__('main.Templates')}}</span><i class="angle fa fa-angle-right"></i></a>
                            <ul class="slide-menu">
                                @if(user()->isadmin == 1 || userPermissionChecker('can_man_canned') == true)
                                <li><a class="slide-item" href="{{route('template.canned')}}"><span>{{__('main.Responses')}}</span></a></li>
                                @endif
                                @if(user()->isadmin == 1 || userPermissionChecker('can_man_ticket_tpl') == true)
                                <li><a class="slide-item" href="{{route('template.ticket')}}"><span>{{__('main.Tickets')}}</span></a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        <li>
                            <a class="side-menu__item" href="{{route('knowledgebase')}}"><i class="side-menu__icon fa fa-university"></i><span class="side-menu__label">{{__('main.Knowledgebase')}}</span></a>
                        </li>
                        @if(user()->isadmin == 1 || userPermissionChecker('can_man_cat') == true)
                        <li>
                            <a class="side-menu__item" href="{{route('category.index')}}"><i class="side-menu__icon fa fa-briefcase"></i><span class="side-menu__label">{{__('main.Categories')}}</span></a>
                        </li>
                        <li>
                            <a class="side-menu__item" href="{{route('sub-category.index')}}"><i class="side-menu__icon fa fa-briefcase"></i><span class="side-menu__label">{{__('main.Sub Categories')}}</span></a>
                        </li>
                        @endif
                        @if(user()->isadmin == 1)
                        <li><h3>{{__('main.Management')}}</h3></li>
                        <li>
                            <a class="side-menu__item" href="{{route('team.index')}}"><i class="side-menu__icon fa fa-users"></i><span class="side-menu__label">{{__('main.Teams')}}</span></a>
                        </li>
{{--                        <li class="slide">--}}
{{--                            <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-bar-chart-o"></i><span class="side-menu__label">{{__('main.Reports')}}</span><i class="angle fa fa-angle-right"></i></a>--}}
{{--                            <ul class="slide-menu">--}}
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index') }}"><span>{{__('main.Run Reports')}}</span></a></li>--}}
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index2') }}"><span>{{__('main.Export Tickets')}}</span></a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                        @endif
                        @if(user()->isadmin == 1 || userPermissionChecker('can_run_reports_full') == true)
                        <li>
                            <a class="side-menu__item" href="{{route('report.main')}}"><i class="side-menu__icon fa fa-bar-chart-o"></i><span class="side-menu__label">{{__('main.Reports')}}</span></a>
                        </li>
                        <li>
                            <a class="side-menu__item" href="{{route('advance-report.generate')}}"><i class="side-menu__icon fa fa-file-excel-o"></i><span class="side-menu__label">{{__('main.Advanced Reports')}}</span></a>
                        </li>
                        @endif
                        @if(user()->isadmin == 1 || userPermissionChecker('can_man_settings') == true)
                        <li><h3>{{__('main.Configuration')}}</h3></li>
                        <li class="slide">
                            <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-wrench"></i><span class="side-menu__label">{{__('main.Tools')}}</span><i class="angle fa fa-angle-right"></i></a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{route('ban.email')}}"><span>{{__('main.Ban Emails')}}</span></a></li>
                                <li><a class="slide-item" href="{{route('ban.ip')}}"><span>{{__('main.Ban IPs')}}</span></a></li>
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index2') }}"><span>{{__('main.Service Messages')}}</span></a></li>--}}
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index2') }}"><span>{{__('main.Email Templates')}}</span></a></li>--}}
                                <li><a class="slide-item" href="{{route('custom_field.index')}}"><span>{{__('main.Custom Fields')}}</span></a></li>
                            <li><a class="slide-item" href="{{route('custom_script.index')}}"><span>{{__('main.Custom Scripts')}}</span></a></li>
                                <li><a class="slide-item" href="{{route('slider.index')}}"><span>{{__('main.Slider')}}</span></a></li>
                                <li><a class="slide-item" href="{{route('thank.index')}}"><span>{{__('main.Thank You Message')}}</span></a></li>
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index2') }}"><span>{{__('main.Statuses')}}</span></a></li>--}}
                            </ul>
                        </li>
                        <li class="slide">
                            <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-gears"></i><span class="side-menu__label">{{__('main.Settings')}}</span><i class="angle fa fa-angle-right"></i></a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{route('setting.general')}}"><span>{{__('main.General')}}</span></a></li>
                                <!--Imap Setting -->
                                <li><a class="slide-item" href="{{ route('setting.email') }}"><span>{{__('main.Email')}}</span></a></li>
                                <!--Imap Setting End-->
                            </ul>
                        </li>
                        <li class="slide">
                            <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-binoculars"></i><span class="side-menu__label">{{__('main.Lookup')}}</span><i class="angle fa fa-angle-right"></i></a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{route('lookup.kumpulan-pengguna.index')}}"><span>{{__('main.Kumpulan Pengguna')}}</span></a></li>
                                <li><a class="slide-item" href="{{route('lookup.kementerian.index')}}"><span>{{__('main.Kementerian')}}</span></a></li>
                                <li><a class="slide-item" href="{{route('lookup.agensi.index')}}"><span>{{__('main.Agensi')}}</span></a></li>
                                <li><a class="slide-item" href="{{route('lookup.sub-agensi.index')}}"><span>{{__('main.Sub Agensi')}}</span></a></li>
                                <li><a class="slide-item" href="{{route('lookup.kaedah-melapor.index')}}"><span>{{__('main.Kaedah Melapor')}}</span></a></li>
                                <li><a class="slide-item" href="{{route('lookup.status-log.index')}}"><span>{{__('main.Status Log')}}</span></a></li>
                                <li><a class="slide-item" href="{{route('setting.general')}}"><span>{{__('main.Konsultan')}}</span></a></li>
                            </ul>
                        </li>

{{--                        <li class="slide">--}}
{{--                            <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-gears"></i><span class="side-menu__label">{{__('main.Settings')}}</span><i class="angle fa fa-angle-right"></i></a>--}}
{{--                            <ul class="slide-menu">--}}
{{--                                <li><a class="slide-item" href="{{route('setting.general')}}"><span>{{__('main.General')}}</span></a></li>--}}
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index2') }}"><span>{{__('main.Help Desk')}}</span></a></li>--}}
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index2') }}"><span>{{__('main.Knowledgebase')}}</span></a></li>--}}
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index2') }}"><span>{{__('main.Email')}}</span></a></li>--}}
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index2') }}"><span>{{__('main.Ticket List')}}</span></a></li>--}}
{{--                                <li><a class="slide-item" href="{{ url('/' . $page='index2') }}"><span>{{__('main.Misc')}}</span></a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                        @endif
                    </ul>
                </aside>
<!--/APP-SIDEBAR-->
