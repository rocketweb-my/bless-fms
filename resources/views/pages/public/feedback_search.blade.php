@extends('layouts.master_public')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main2.css')}}" rel="stylesheet">
@endsection
@section('page-header')

@endsection
@section('content')
						<!-- ROW-1 OPEN -->
                        <div class="row mt-8">
                            <div class="col-md-12">

                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i> {{ $error }}
                                        </div>
                                    @endforeach
                                @endif

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0 card-title">{{__('public/feedback_search.Search for ticket')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('public.reply')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label">{{__('public/feedback_search.Ticket tracking ID')}} <small class="text-danger">*</small></label>
                                                <input type="text" class="form-control" name="trackid" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{__('public/feedback_search.Email')}} <small class="text-danger">*</small></label>
                                                <input type="text" class="form-control" name="email" @if(Session::get('public_remember_email') != null ) value="{{Session::get('public_remember_email')}}" @endif required>
                                            </div>
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="remember_email" value="1">
                                                <span class="custom-control-label">{{__('public/feedback_search.Remember my email address')}}</span>
                                            </label>
                                            <br>
                                            <button type="submit" class="btn btn-primary btn-block">{{__('public/feedback_search.Search')}}</button>
                                        </form>
                                        <div class="row">
                                            <div class="col-md-12 text-center mt-5">
                                                <button v-on:click="show = !show" class="text-primary">{{__('public/feedback_search.Forgot Tracking ID')}}?</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" v-if="show">
                                    <div class="card-body">
                                        <h5>{{__('public/feedback_search.Forgot Tracking ID')}}?</h5>
                                        <form method="post" action="{{route('public.forgot_tracking')}}">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label">{{__('public/feedback_search.No worries! Enter your Email address and we will send you your tracking ID right away')}}: </label>
                                                <input type="email" class="form-control" name="email" placeholder="abc@def.xyz" @if(Session::get('public_remember_email') != null ) value="{{Session::get('public_remember_email')}}" @endif required>
                                                <div class="custom-controls-stacked mt-3">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="open" value="1" checked>
                                                        <span class="custom-control-label">{{__('public/feedback_search.Send me only open tickets')}}</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="open" value="2">
                                                        <span class="custom-control-label">{{__('public/feedback_search.Send me all my tickets')}}</span>
                                                    </label>
                                                </div>
                                                <button class="btn btn-primary mt-3">{{__('public/feedback_search.Send me my tracking ID')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Language Switcher -->
                                {{-- <div class="card">
                                    <div class="card-body text-center">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Language Switcher">
                                            <button onclick="changeLanguage('en')"
                                                    class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-primary' }}">
                                                🇺🇸 EN
                                            </button>
                                            <button onclick="changeLanguage('ms')"
                                                    class="btn btn-sm {{ app()->getLocale() == 'ms' ? 'btn-primary' : 'btn-outline-primary' }}">
                                                🇲🇾 MS
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}

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
            },

        })
    </script>
@endsection
