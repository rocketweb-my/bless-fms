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

								<div class="card shadow-none">
									<div class="card-body p-6">
                                        <div class="text-center mb-5">
                                            <img src="@if(systemGeneralSetting() != null && systemGeneralSetting()->logo != null) {{asset('storage/image/logo/'.systemGeneralSetting()->logo)}} @else {{URL::asset('assets/images/brand/antaraDesk-logo.png')}} @endif" class="header-brand-img" style="height: auto !important;" alt="">
                                        </div>
										<h3 class="text-center card-title">Your new password has been sent to your email address.</h3>

											<div class="form-footer">
												<a href="{{route('login')}}" class="btn btn-primary btn-block">Login</a>
											</div>
											<div class="text-center text-muted mt-3 ">
										</div>
									</div>
                                </div>
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
