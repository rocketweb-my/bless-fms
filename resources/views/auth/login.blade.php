@extends('layouts.master2')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('content')
		<!-- BACKGROUND-IMAGE -->
		<div class="login-img">

			<!-- GLOABAL LOADER -->
			<div id="global-loader">
				<img src="{{URL::asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
			</div>
			<!-- /GLOABAL LOADER -->

			<!-- PAGE -->
			<div class="page">
				<div class="">
				    <!-- CONTAINER OPEN -->
{{--					<div class="col col-login mx-auto">--}}
{{--						<div class="text-center">--}}
{{--							<img src="{{URL::asset('assets/images/brand/e-Aduan-logo.png')}}" class="header-brand-img" alt="">--}}
{{--						</div>--}}
{{--					</div>--}}
					<div class="container-login100">

						<div class="wrap-login100 p-6">
                            <div class="text-center mb-5">
                                <img src="@if(systemGeneralSetting() != null && systemGeneralSetting()->logo != null) {{asset('storage/image/logo/'.systemGeneralSetting()->logo)}} @else {{URL::asset('assets/images/brand/antaraDesk-logo.png')}} @endif" class="header-brand-img" style="height: auto !important;" alt="">
                            </div>
							<form method="post" action="{{route('login')}}" class="login100-form validate-form">
                                @csrf
{{--								<span class="login100-form-title">--}}
{{--									Login--}}
{{--								</span>--}}
								<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
									<input class="input100" type="email" name="email" placeholder="Email">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<i class="zmdi zmdi-email" aria-hidden="true"></i>
									</span>
								</div>
								<div class="wrap-input100 validate-input" data-validate = "Password is required">
									<input class="input100" type="password" name="password" placeholder="Password">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<i class="zmdi zmdi-lock" aria-hidden="true"></i>
									</span>
								</div>
                                <div class="row">
                                    <div class="col-6 text-left">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="remember_me" value="1">
                                            <span class="custom-control-label">Remember Me</span>
                                        </label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <p class="mb-0"><a href="{{route('forgot_password')}}" class="text-primary ml-1">Forgot Password?</a></p>
                                    </div>
                                </div>
								<div class="container-login100-form-btn">
									<button type="submit" class="login100-form-btn btn-primary">
										Login
									</button>
								</div>
							</form>
						</div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
			<!-- End PAGE -->

		</div>
		<!-- BACKGROUND-IMAGE CLOSED -->
@endsection
@section('js')
@endsection
