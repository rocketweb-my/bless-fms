@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">Create New Ticket</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">New Ticket</a></li>
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
                                            <h3 class="mb-0 card-title">Create New Ticket for <u>{{categoryName($selected_category)->name}}</u> - <u>{{\App\Models\SubCategory::find($selected_sub_category)->name ?? 'Unknown Sub Category'}}</u></h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{route('admin_create_ticket.store')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Name <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="name">
                                                        </div>

                                                        {{--                                                    <div class="form-group">--}}
                                                        {{--                                                        <label class="form-label">Category<small class="text-danger">*</small></label>--}}
                                                        {{--                                                        <select name="category" id="select-category" class="form-control custom-select">--}}
                                                        {{--                                                            @foreach(getCategoryList() as $category)--}}
                                                        {{--                                                                <option value="{{$category->id}}">{{$category->name}}</option>--}}
                                                        {{--                                                            @endforeach--}}
                                                        {{--                                                        </select>--}}
                                                        {{--                                                    </div>--}}
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Email <small class="text-danger">*</small></label>
                                                            <input type="email" class="form-control" name="email">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Phone Number</label>
                                                            <input type="text" class="form-control" name="phone_number" placeholder="Enter phone number">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">{{__('aduan_pertanyaan.Label')}} <small class="text-danger">*</small></label>
                                                            <select name="aduan_pertanyaan" id="select-aduan-pertanyaan" class="form-control custom-select" required>
                                                                <option value="">{{__('aduan_pertanyaan.Select Type')}}</option>
                                                                <option value="aduan">{{__('aduan_pertanyaan.Aduan')}}</option>
                                                                <option value="pertanyaan">{{__('aduan_pertanyaan.Pertanyaan')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Priority<small class="text-danger">*</small></label>
                                                            <select name="priority" id="select-priority" class="form-control custom-select">
                                                                @foreach($activePriorities as $priority)
                                                                    <option value="{{ $priority->priority_value }}" {{ $priority->priority_value == 3 ? 'selected' : '' }}>
                                                                        {{ $priority->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">{{__('lookup_kaedah_melapor.Kaedah Melapor')}} <small class="text-danger">*</small></label>
                                                            <select name="kaedah_melapor_id" id="select-kaedah-melapor" class="form-control custom-select" required>
                                                                <option value="">{{__('lookup_kaedah_melapor.Select Kaedah Melapor')}}</option>
                                                                @foreach($kaedah_melapor as $kaedah)
                                                                    <option value="{{ $kaedah->id }}">{{ $kaedah->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">{{__('lookup_agensi.Agensi')}}</label>
                                                            <select name="agensi_id" id="agensi-select" class="form-control custom-select">
                                                                <option value="">{{__('lookup_agensi.Select Agensi')}}</option>
                                                                @foreach($agensi as $ag)
                                                                    <option value="{{ $ag->id }}">{{ $ag->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">{{__('main.Lesen')}}</label>
                                                            <select name="lesen_id" id="admin-lesen-select" class="form-control custom-select" disabled>
                                                                <option value="">Pilih Lesen</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">BL No</label>
                                                            <input type="text" class="form-control" id="bl_no" name="bl_no" placeholder="Enter BL Number">
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
                                                            <label class="form-label">Select a ticket template</label>
                                                            <select name="template" id="select-template" class="form-control custom-select">
                                                                <option value="" hidden>Select Template</option>
                                                            @foreach($ticket_templates as $ticket_template)
                                                                    <option value="{{$ticket_template->message}}" >{{$ticket_template->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">Subject <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" id="subject" name="subject" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Message <small class="text-danger">*</small></label>
                                                            <textarea class="form-control" name="message" id="message" rows="6" required></textarea>
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
                                                    <label class="form-label">Attachment</label>
                                                    <div id="attachment-container">
                                                        <div class="attachment-row mb-2">
                                                            <input type="file" name="file[1]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2">
                                                            <input type="file" name="file[2]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2" style="display: none;">
                                                            <input type="file" name="file[3]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2" style="display: none;">
                                                            <input type="file" name="file[4]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2" style="display: none;">
                                                            <input type="file" name="file[5]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2" style="display: none;">
                                                            <input type="file" name="file[6]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                    </div>
                                                    <button type="button" id="add-attachment-btn" class="btn btn-sm btn-secondary" onclick="showNextAttachment()">Add Another Attachment</button>
                                                    <small class="d-block mt-2">Max file size: 20MB | File format: .gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf</small>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label">Options</label>
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-checkbox">
                                                            @if(User()->notify_customer_new == 1)
                                                                <input type="checkbox" class="custom-control-input" id="create_notify1" name="notify" value="1" checked="">
                                                            @else
                                                                <input type="checkbox" class="custom-control-input" id="create_notify1" name="notify" value="1">
                                                            @endif
                                                            <span class="custom-control-label">Send email notification to the customer</span>
                                                        </label>
{{--                                                        <label class="custom-control custom-checkbox">--}}
{{--                                                            <input type="checkbox" class="custom-control-input" id="create_show1" name="show" value="1" checked="">--}}
{{--                                                            <span class="custom-control-label">Show the ticket after submission</span>--}}
{{--                                                        </label>--}}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Select Kumpulan Pengguna for Assignment</label>
                                                    <select name="assignment_kumpulan_pengguna_id" id="assignment-kumpulan-pengguna-select" class="form-control custom-select">
                                                        <option value="">Pilih Kumpulan Pengguna</option>
                                                        @foreach(\App\Models\LookupKumpulanPengguna::where('is_active', 1)->orderBy('nama', 'ASC')->get() as $kp)
                                                            <option value="{{$kp->id}}">{{$kp->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Assign this ticket to</label>
                                                    <select name="owner" id="select-owner" class="form-control custom-select">
                                                        <option value="-1" selected>> Unassigned <</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="openby" value="{{Illuminate\Support\Facades\Session::get('user_id')}}">
                                                <hr>
                                                <input type="hidden" name="category" value="{{$selected_category}}">
                                                <input type="hidden" name="sub_category" value="{{$selected_sub_category}}">
                                                <input type="hidden" name="dt" value="{{\Carbon\Carbon::now()}}">
                                                <input type="hidden" name="lastchange" value="{{\Carbon\Carbon::now()}}">
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
        var _validFileExtensions = [".gif", ".jpg", ".jpeg", ".png", ".zip", ".rar", ".csv", ".doc", ".docx", ".xls", ".xlsx", ".txt", ".pdf"];
        var maxFileSize = 20 * 1024 * 1024; // 20MB in bytes

        function ValidateSingleInput(oInput) {
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length > 0) {
                    // Check file extension
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }

                    if (!blnValid) {
                        alert("Sorry, invalid attachment file format");
                        oInput.value = "";
                        return false;
                    }

                    // Check file size
                    if (oInput.files && oInput.files[0]) {
                        var fileSize = oInput.files[0].size;
                        if (fileSize > maxFileSize) {
                            alert("File size exceeds 20MB limit. Please choose a smaller file.");
                            oInput.value = "";
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        function showNextAttachment() {
            var attachmentRows = document.querySelectorAll('.attachment-row');
            var addButton = document.getElementById('add-attachment-btn');

            for (var i = 0; i < attachmentRows.length; i++) {
                if (attachmentRows[i].style.display === 'none') {
                    attachmentRows[i].style.display = 'block';

                    // Hide button if all 6 attachments are visible
                    if (i === attachmentRows.length - 1) {
                        addButton.style.display = 'none';
                    }
                    break;
                }
            }
        }
        $('#select-template').on('change', function (e) {
            var message = this.value;
            var name = $("#select-template  option:selected").text();

            $("#message").val(message);
            $("#subject").val(name);
        });

        // Agensi dependent dropdown functionality for Lesen
        $('#agensi-select').on('change', function() {
            var agensiId = $(this).val();
            var lesenSelect = $('#admin-lesen-select');

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

        // Kumpulan Pengguna dependent dropdown functionality for ticket assignment
        $('#assignment-kumpulan-pengguna-select').on('change', function() {
            var kumpulanPenggunaId = $(this).val();
            var ownerSelect = $('#select-owner');

            // Reset owner dropdown to default options
            ownerSelect.html('<option value="-1" selected>> Unassigned <</option>');

            if (kumpulanPenggunaId) {
                // Fetch team members for selected kumpulan pengguna
                $.ajax({
                    url: '/get-team/' + kumpulanPenggunaId,
                    type: 'GET',
                    success: function(response) {
                        if (response.length > 0) {
                            $.each(response, function(index, teamMember) {
                                ownerSelect.append('<option value="' + teamMember.id + '">' + teamMember.name + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching team members:', xhr, status, error);
                        alert('Error fetching team members: ' + error);
                    }
                });
            }
        });
    </script>
@endsection
