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
			<!-- End GLOABAL LOADER -->

			<!-- PAGE -->
			<div class="page">
				<div class="">

				    <!-- CONTAINER OPEN -->
					<div class="container-login100">
						<div class="row">
							<div class="col col-login mx-auto">

								<form class="card shadow-none" action="{{route('reset_password')}}" method="post">
                                    @csrf
									<div class="card-body p-6">
                                        <div class="text-center mb-5">
                                            <img src="@if(systemGeneralSetting() != null && systemGeneralSetting()->logo != null) {{asset('storage/image/logo/'.systemGeneralSetting()->logo)}} @else {{URL::asset('assets/images/brand/antaraDesk-logo.png')}} @endif" class="header-brand-img" style="height: auto !important;" alt="">
                                        </div>
										<h3 class="text-center card-title">Forgot password</h3>
											<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
												<input class="input100" type="email" name="email" placeholder="Email">
												<span class="focus-input100"></span>
												<span class="symbol-input100">
													<i class="zmdi zmdi-email" aria-hidden="true"></i>
												</span>
											</div>
											<div class="form-footer">
												<button type="submit" class="btn btn-primary btn-block">Send</button>
											</div>
											<div class="text-center text-muted mt-3 ">
											Forget it, <a href="{{route('login')}}">send me back</a> to the sign in screen.
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
			<!--END PAGE -->

		</div>
		<!-- BACKGROUND-IMAGE CLOSED -->

@endsection
@section('js')
@endsection
