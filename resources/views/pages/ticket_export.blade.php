@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">

@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('ticket.Export Tickets')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item active" aria-current="page">{{__('ticket.Export Tickets')}}</li>
                                </ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')

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
                                    <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('ticket.Export Tickets')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('ticket.export_ticket_excel')}}" id="export-ticket-form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title" class="form-label">{{__('ticket.Date From')}} : <small class="text-danger">*</small></label>
                                                        <input type="date" class="form-control" id="date_from" name="date_from" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title" class="form-label">{{__('ticket.Date To')}} : <small class="text-danger">*</small></label>
                                                        <input type="date" class="form-control" id="date_to" name="date_to" required>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($categories != null)
                                            <div class="form-group form-elements mt-5">
                                                <div class="form-label">{{__('team_profile.Categories')}} : <small class="text-danger">*</small>
                                                    <button type="button" class="btn btn-primary btn-sm ml-2" onclick="selectAllCategories()">{{__('ticket.Select All')}}</button>
                                                    <button type="button" class="btn btn-danger btn-sm ml-2" onclick="deselectAllCategories()">{{__('ticket.Deselect All')}}</button>
                                                </div>
                                                <div class="custom-controls-stacked">
                                                    <div class="row">
                                                        @foreach($categories as $category)
                                                            <div class="col-4">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="categories[]" value="{{$category->id}}">
                                                                    <span class="custom-control-label">{{$category->name}}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group form-elements mt-5">
                                                <div class="form-label">{{__('ticket.Status')}} : <small class="text-danger">*</small>
                                                    <button type="button" class="btn btn-primary btn-sm ml-2" onclick="selectAllStatus()">{{__('ticket.Select All')}}</button>
                                                    <button type="button" class="btn btn-danger btn-sm ml-2" onclick="deselectAllStatus()">{{__('ticket.Deselect All')}}</button>
                                                </div>
                                                <div class="custom-controls-stacked">
                                                    <div class="row">
                                                        @php($statusLookups = \App\Models\LookupStatusLog::where('is_active', true)->orderBy('order', 'ASC')->get())
                                                        @foreach($statusLookups as $statusLookup)
                                                        <div class="col-4">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="status[]" value="{{$statusLookup->id}}">
                                                                <span class="custom-control-label">
                                                                    <span class="badge" style="background-color: {{$statusLookup->color}}; color: white; margin-right: 8px;">{{$statusLookup->nama}}</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-elements mt-5">
                                                <div class="form-label">{{__('ticket.Priority')}} : <small class="text-danger">*</small>
                                                    <button type="button" class="btn btn-primary btn-sm ml-2" onclick="selectAllPriority()">{{__('ticket.Select All')}}</button>
                                                    <button type="button" class="btn btn-danger btn-sm ml-2" onclick="deselectAllPriority()">{{__('ticket.Deselect All')}}</button>
                                                </div>
                                                <div class="custom-controls-stacked">
                                                    <div class="row">
                                                        @foreach($activePriorities as $priority)
                                                            <div class="col-4">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="priority[]" value="{{ $priority->priority_value }}">
                                                                    <span class="custom-control-label">{{ $priority->name }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">{{__('ticket.Export Tickets')}}</button>
                                            </div>


                                        </form>

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">

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
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script>
        function selectAllCategories() {
            $('input[name="categories[]"]').prop('checked', true);
        }
        function selectAllStatus() {
            $('input[name="status[]"]').prop('checked', true);
        }
        function selectAllPriority() {
            $('input[name="priority[]"]').prop('checked', true);
        }

        function deselectAllCategories() {
            $('input[name="categories[]"]').prop('checked', false);
        }
        function deselectAllStatus() {
            $('input[name="status[]"]').prop('checked', false);
        }
        function deselectAllPriority() {
            $('input[name="priority[]"]').prop('checked', false);
        }
    </script>

@endsection
