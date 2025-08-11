@extends('layouts.master_public')
@section('css')
    <link href="{{ URL::asset('assets/plugins/single-page/css/main2.css')}}" rel="stylesheet">
@endsection
@section('page-header')

@endsection
@section('content')
    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-md-12">
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="fa fa-exclamation mr-2" aria-hidden="true"></i> {{ $error }}
                    </div>
                @endforeach
            @endif
            @if($sliders != null)
            <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach($sliders as $slider)
                    <li data-target="#carouselIndicators" data-slide-to="{{$slider->id}}" class="active"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach($sliders as $index => $slider)
                    <div class="carousel-item @if($index == 0) active @endif">
                        <img class="d-block w-100" src="{{asset('storage/image/slider/'.$slider->file_name)}}">
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{__('public/main.Previous')}}</span>
                </a>
                <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{__('public/main.Next')}}</span>
                </a>
            </div>
            @endif

            <div class="card mt-3">
{{--                <div class="card-header">--}}
{{--                    <h3 class="mb-0 card-title text-center">Hello, how can we help?</h3>--}}
{{--                </div>--}}
                <div class="card-body">
                    <div class="row">
                        @if($kb_article == null)
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <a @if (env('OTP_SERVICE') == 'enabled') href="#" v-on:click="otp" @else href="{{route('public.submission')}}" @endif>
                                <div class="card bg-primary img-card box-primary-shadow">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="text-white">
                                                <h3 class="mb-0 number-font">{{__('public/main.Submit a ticket')}}</h3>
                                                <p class="text-white mb-0">{{__('public/main.Submit a new issue to a department')}}</p>
                                            </div>
                                            <div class="ml-auto"> <i class="fa fa-send-o text-white fs-30 mr-2 mt-2"></i> </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div><!-- COL END -->
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <a href="{{route('public.search')}}">
                                <div class="card bg-info img-card box-info-shadow">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="text-white">
                                            <h3 class="mb-0 number-font">{{__('public/main.View existing tickets')}}</h3>
                                            <p class="text-white mb-0">{{__('public/main.View tickets you submitted in the past')}}</p>
                                        </div>
                                        <div class="ml-auto"> <i class="fa fa-search text-white fs-30 mr-2 mt-2"></i> </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div><!-- COL END -->
                        @else

                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <a @if (env('OTP_SERVICE') == 'enabled') href="#" v-on:click="otp" @else href="{{route('public.submission')}}" @endif>
                                    <div class="card bg-primary img-card box-primary-shadow">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="text-white">
                                                    <h3 class="mb-0 number-font">{{__('public/main.Submit a ticket')}}</h3>
                                                    <p class="text-white mb-0">{{__('public/main.Submit a new issue to a department')}}</p>
                                                </div>
                                                <div class="ml-auto"> <i class="fa fa-send-o text-white fs-30 mr-2 mt-2"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div><!-- COL END -->
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <a href="{{route('public.search')}}">
                                    <div class="card bg-info img-card box-info-shadow">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="text-white">
                                                    <h3 class="mb-0 number-font">{{__('public/main.View existing tickets')}}</h3>
                                                    <p class="text-white mb-0">{{__('public/main.View tickets you submitted in the past')}}</p>
                                                </div>
                                                <div class="ml-auto"> <i class="fa fa-search text-white fs-30 mr-2 mt-2"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div><!-- COL END -->
                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <a href="{{route('public.knowledgebase_category')}}">
                                    <div class="card bg-success img-card box-info-shadow">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="text-white">
                                                    <h3 class="mb-0 number-font">{{__('public/main.Knowledgebase')}}</h3>
                                                    <p class="text-white mb-0">{{__('public/main.View list of article in knowledgebase')}}</p>
                                                </div>
                                                <div class="ml-auto"> <i class="fa fa-book text-white fs-30 mr-2 mt-2"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div><!-- COL END -->
                        @endif
                    </div>
                    <!-- Language Switcher -->
                    @if(env('ENABLE_LANGUAGE_SWITCHER', false))
                    <div class="row">
                        <div class="col-md-12 text-center mt-4">
                            <div class="btn-group" role="group" aria-label="Language Switcher">
                                <button onclick="changeLanguage('en')"
                                        class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    🇺🇸 English
                                </button>
                                <button onclick="changeLanguage('ms')"
                                        class="btn btn-sm {{ app()->getLocale() == 'ms' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    🇲🇾 Bahasa Malaysia
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12 text-center mt-3">
                            <a href="{{route('dashboard.index')}}" class="text-primary"><b>{{__('public/main.Go to Administration Panel')}}</b></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <!-- CONTAINER CLOSED -->
    </div>
    </div>
@endsection
@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                show : false,
            },methods: {
        otp: function () {
            Swal.fire({
                    title: "Email Verification",
                    text: "Please enter your email for verification",
                    input: 'email',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Send Verification Code',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel',

                }).then((result) => {

                    @if (env('OTP_EMAIL_RESTRICTION') == 'enabled')
                    if (result.value) {
                        if( /@tekun.gov.my/.test(result.value))
                        {
                        axios.get('{{route('opt_request')}}', {
                            params: {
                                email: result.value,
                                type: 'ticket-submission-verification',
                            }
                        })
                            .then(function (response) {
                                console.log(response.data.uniqueId)
                                sessionStorage.setItem('otp_uid',response.data.uniqueId);
                                Swal.fire({
                                    title: "Email Verification Sent",
                                    text: "Please check your email and enter OTP code for verification",
                                    input: 'text',
                                    icon: "info",
                                    showCancelButton: true,
                                    confirmButtonText: 'Verify OTP Code',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                                    if (result.value) {
                                        axios.get('{{route('opt_verify')}}', {
                                            params: {
                                                otp: result.value,
                                                otp_uid: sessionStorage.getItem('otp_uid'),
                                            }
                                        })
                                        .then(function (response) {
                                            sessionStorage.setItem('email_verified',1);
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Email Verified',
                                                text: 'You will be redirect to submit ticket page now',
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(()=>{
                                                window.location.assign('{{ route('public.submission') }}');
                                            })

                                        })
                                    }
                                })
                            })
                            .catch(function (error) {
                                Swal.fire('Error', '', 'error')
                            });
                        }else{
                            Swal.fire('Error', 'Please use tekun official email', 'error')
                        }
                    }
                    @else

                    axios.get('{{route('opt_request')}}', {
                            params: {
                                email: result.value,
                                type: 'ticket-submission-verification',
                            }
                        })
                            .then(function (response) {
                                console.log(response.data.uniqueId)
                                sessionStorage.setItem('otp_uid',response.data.uniqueId);
                                Swal.fire({
                                    title: "Email Verification Sent",
                                    text: "Please check your email and enter OTP code for verification",
                                    input: 'text',
                                    icon: "info",
                                    showCancelButton: true,
                                    confirmButtonText: 'Verify OTP Code',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                                    if (result.value) {
                                        axios.get('{{route('opt_verify')}}', {
                                            params: {
                                                otp: result.value,
                                                otp_uid: sessionStorage.getItem('otp_uid'),
                                            }
                                        })
                                        .then(function (response) {
                                            sessionStorage.setItem('email_verified',1);
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Email Verified',
                                                text: 'You will be redirect to submit ticket page now',
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(()=>{
                                                window.location.assign('{{ route('public.submission') }}');
                                            })

                                        })
                                    }
                                })
                            })
                            .catch(function (error) {
                                Swal.fire('Error', '', 'error')
                            });

                    @endif
                });
        }
    }

        })
    </script>
    @if(env('APP_BOT') == true)
    <script>
        var botmanWidget = {
            aboutText: 'Power By RocketWeb',
            introMessage: "I am ADAM, your virtual assistant. Would you like to continue this interaction?"
        };
    </script>

    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    @endif
@endsection
