@extends('layouts.master_public')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main2.css')}}" rel="stylesheet">
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
                                        <h3 class="mb-0 card-title">{{__('public/feedback_submission.Submit a Support Request for')}} <u>{{categoryName($selected_category)->name}}</u> - <u>{{\App\Models\SubCategory::find($selected_sub_category)->name ?? 'Unknown Sub Category'}}</u></h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('public.submission_form')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('public/feedback_submission.Name')}} <small class="text-danger">*</small></label>
                                                        <input type="text" class="form-control" name="name" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('public/feedback_submission.Email')}} <small class="text-danger">*</small></label>
                                                        <input type="email" class="form-control" name="email" @if (env('OTP_SERVICE') == 'enabled') value="{{ Session::get('email_otp') }}" disabled @endif required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('public/feedback_submission.Phone Number')}}</label>
                                                        <input type="text" class="form-control" name="phone_number">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('aduan_pertanyaan.Label')}} <small class="text-danger">*</small></label>
                                                        <select name="aduan_pertanyaan" id="select-aduan-pertanyaan" class="form-control custom-select" required>
                                                            <option value="">{{__('aduan_pertanyaan.Select Type')}}</option>
                                                            <option value="aduan">{{__('aduan_pertanyaan.Aduan')}}</option>
                                                            <option value="pertanyaan">{{__('aduan_pertanyaan.Pertanyaan')}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('public/feedback_submission.Priority')}}<small class="text-danger">*</small></label>
                                                        <select name="priority" id="select-priority" class="form-control custom-select">
                                                            @foreach($activePriorities as $priority)
                                                                <option value="{{ $priority->priority_value }}" {{ $priority->priority_value == 3 ? 'selected' : '' }}>
                                                                    {{ $priority->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('lookup_agensi.Agensi')}}</label>
                                                        <select name="agensi_id" id="public-agensi-select" class="form-control custom-select">
                                                            <option value="">{{__('lookup_agensi.Select Agensi')}}</option>
                                                            @foreach($agensi as $ag)
                                                                <option value="{{ $ag->id }}">{{ $ag->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('main.Lesen')}}</label>
                                                        <select name="lesen_id" id="public-lesen-select" class="form-control custom-select" disabled>
                                                            <option value="">Pilih Lesen</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">BL No</label>
                                                        <input type="text" class="form-control" name="bl_no" placeholder="Enter BL Number">
                                                    </div>
                                                </div>
                                            </div>
                                            @if($before_messages->count() != 0)
                                                <hr>
                                                <div class="row">
                                                    @foreach( $before_messages as $before_message)
                                                        <div class="col-md-12">
                                                            {!! customFieldProcessor($before_message) !!}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('public/feedback_submission.Subject')}} <small class="text-danger">*</small></label>
                                                        <input type="text" class="form-control" name="subject" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('public/feedback_submission.Message')}} <small class="text-danger">*</small></label>
                                                        <textarea class="form-control" name="message" rows="6" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($after_messages->count() != 0)
                                                <hr>
                                                <div class="row">
                                                    @foreach( $after_messages as $after_message)
                                                        <div class="col-md-12">
                                                            {!! customFieldProcessor($after_message) !!}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <hr>
                                            <div class="form-group">
                                                <label class="form-label">{{__('public/feedback_submission.Attachment')}}</label>
                                                <input type="file" name="file[1]" size="50" onchange="ValidateSingleInput(this);">
                                                <br>
                                                <input type="file" name="file[2]" size="50" onchange="ValidateSingleInput(this);">
                                                <br>
                                                <small>{{__('public/feedback_submission.Max file size')}}: 10MB | {{__('public/feedback_submission.Choose file')}}: .gif,.jpg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf</small>
                                            </div>
                                            <hr>
                                            <input type="hidden" name="category" value="{{$selected_category}}">
                                            <input type="hidden" name="sub_category" value="{{$selected_sub_category}}">
                                            <input type="hidden" name="dt" value="{{\Carbon\Carbon::now()}}">
                                            <input type="hidden" name="lastchange" value="{{\Carbon\Carbon::now()}}">
                                            <button type="submit" class="btn btn-primary btn-block">{{__('public/feedback_submission.Submit')}}</button>
                                        </form>
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
        var _validFileExtensions = [".gif", ".jpg", ".png", ".zip", ".rar", ".csv", ".doc", ".docx", ".xls", ".xlsx", ".txt", ".pdf"];
        function ValidateSingleInput(oInput) {
        if (oInput.type == "file") {
        var sFileName = oInput.value;
        if (sFileName.length > 0) {
        var blnValid = false;
        for (var j = 0; j < _validFileExtensions.length; j++) {
        var sCurExtension = _validFileExtensions[j];
        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
        blnValid = true;
        break;
        }
        }

        if (!blnValid) {
        alert("{{__('public/feedback_submission.Invalid file format')}}");
        oInput.value = "";
        return false;
        }
        }
        }
        return true;
        }
    </script>
    <script>
        $('form').submit(function() {
            // $(this).find("button[type='submit']").prop('disabled',true);
            $(this).find("button[type='submit']").attr("disabled","disabled");
            $(this).find("button[type='submit']").text('{{__('public/feedback_submission.Sending ticket please wait')}}');
        });

        // Agensi dependent dropdown functionality for Lesen
        $('#public-agensi-select').on('change', function() {
            var agensiId = $(this).val();
            var lesenSelect = $('#public-lesen-select');

            // Reset lesen dropdown
            lesenSelect.html('<option value="">Pilih Lesen</option>');
            lesenSelect.prop('disabled', true);

            if (agensiId) {
                // Fetch lesen for selected agensi
                $.ajax({
                    url: '/get-lesen/' + agensiId,
                    type: 'GET',
                    success: function(response) {
                        if (response.length > 0) {
                            $.each(response, function(index, lesen) {
                                lesenSelect.append('<option value="' + lesen.id + '">' + lesen.nama + '</option>');
                            });
                            lesenSelect.prop('disabled', false);
                        } else {
                            lesenSelect.html('<option value="">Tiada Lesen Tersedia</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching lesen:', xhr, status, error);
                        alert('Error fetching lesen: ' + error);
                    }
                });
            }
        });
    </script>
@endsection
