@extends('layouts.master')
@section('css')

    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/multipleselect/multiple-select.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('slider.Slider')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('slider.Slider')}}</a></li>
								</ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')

						<!-- ROW-1 OPEN -->
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
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
                                        <h3 class="card-title">{{__('slider.Upload Slider')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card shadow">
                                                    <div class="card-header">
                                                        <h3 class="mb-0 card-title">{{__('slider.Slider')}} 1</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <form method="post" action="{{route('slider.upload')}}" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="1">
                                                            <input type="file" name="slider" class="dropify" data-default-file="{{asset('storage/image/slider/'.sliderFile(1))}}" data-height="300"  /><br>
                                                            <button type="submit" class="float-right btn btn-info">{{__('slider.Save Slider')}} 1</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card shadow">
                                                    <div class="card-header">
                                                        <h3 class="mb-0 card-title">{{__('slider.Slider')}} 2</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <form method="post" action="{{route('slider.upload')}}" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="2">
                                                            <input type="file" name="slider" class="dropify" data-default-file="{{asset('storage/image/slider/'.sliderFile(2))}}" data-height="300"  /><br>
                                                            <button type="submit" class="float-right btn btn-info">{{__('slider.Save Slider')}} 2</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card shadow">
                                                    <div class="card-header">
                                                        <h3 class="mb-0 card-title">{{__('slider.Slider')}} 3</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <form method="post" action="{{route('slider.upload')}}" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="3">
                                                            <input type="file" name="slider" class="dropify" data-default-file="{{asset('storage/image/slider/'.sliderFile(3))}}" data-height="300"  /><br>
                                                            <button type="submit" class="float-right btn btn-info">{{__('slider.Save Slider')}} 3</button>
                                                        </form>
                                                    </div>
                                                </div>
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
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/multipleselect/multiple-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/multipleselect/multi-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/toggles.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

@endsection
