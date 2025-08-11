@extends('layouts.master_public')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main2.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
{{--						<!-- PAGE-HEADER -->--}}
{{--						<div class="page-header">--}}
{{--							<div>--}}
{{--								<h1 class="page-title">Empty</h1>--}}
{{--								<ol class="breadcrumb">--}}
{{--									<li class="breadcrumb-item"><a href="#">Pages</a></li>--}}
{{--									<li class="breadcrumb-item active" aria-current="page">Empty</li>--}}
{{--								</ol>--}}
{{--							</div>--}}
{{--							<div class="ml-auto pageheader-btn">--}}
{{--								<a href="#" class="btn btn-success btn-icon text-white mr-2">--}}
{{--									<span>--}}
{{--										<i class="fe fe-plus"></i>--}}
{{--									</span> Add Account--}}
{{--								</a>--}}
{{--								<a href="#" class="btn btn-danger btn-icon text-white">--}}
{{--									<span>--}}
{{--										<i class="fe fe-log-in"></i>--}}
{{--									</span> Export--}}
{{--								</a>--}}
{{--							</div>--}}
{{--						</div>--}}
						<!-- PAGE-HEADER END -->
@endsection
@section('content')
						<!-- ROW-1 OPEN -->
						<div class="row mt-8">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0 card-title">{{__('public/feedback_after_submission.Ticket Submitted')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            {{__('public/feedback_after_submission.Your ticket has been successfully submitted! Ticket ID')}}: <span class="font-weight-bold">{{$trackId}}</span>
                                            <br><br>
                                            <span style="color:red"><b>{{__('public/feedback_after_submission.No confirmation email')}}?</b><br>{{__('public/feedback_after_submission.We sent a confirmation message to your email address. If you do not receive it within a few minutes, please check your Junk, Bulk or Spam folders. Mark the message as Not SPAM to avoid problems receiving our correspondence in the future')}}.</span><br><br>
                                            @if($thank_you != null)
                                                {!! $thank_you->message !!}
                                            @endif
                                            <a class="btn btn-primary mr-2" href="{{route('public.search')}}">{{__('public/feedback_after_submission.Search Ticket')}}</a>
                                            <a class="btn btn-info" href="{{route('public.submission')}}">{{__('public/feedback_after_submission.Submit Another Ticket')}}</a>
                                        </p>
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
