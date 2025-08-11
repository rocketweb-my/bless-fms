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
                                            <h3 class="mb-0 card-title">Create New Ticket for <u>{{categoryName($selected_category)->name}}</u></h3>
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
                                                    <input type="file" name="file[1]" size="50" onchange="ValidateSingleInput(this);">
                                                    <br>
                                                    <input type="file" name="file[2]" size="50" onchange="ValidateSingleInput(this);">
                                                    <br>
                                                    <small>File format: .gif,.jpg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf</small>
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
                                                    <label class="form-label">Assign this ticket to</label>
                                                    <select name="owner" id="select-owner" class="form-control custom-select">
                                                        <option value="-1" selected>> Unassigned <</option>
                                                        <option value="-2">> Auto-assign <</option>
                                                        @foreach( allUser() as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" name="openby" value="{{Illuminate\Support\Facades\Session::get('user_id')}}">
                                                <hr>
                                                <input type="hidden" name="category" value="{{$selected_category}}">
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
                        alert("Sorry, invalid, attachment file format");
                        oInput.value = "";
                        return false;
                    }
                }
            }
            return true;
        }
        $('#select-template').on('change', function (e) {
            var message = this.value;
            var name = $("#select-template  option:selected").text();

            $("#message").val(message);
            $("#subject").val(name);
        });
    </script>
@endsection
