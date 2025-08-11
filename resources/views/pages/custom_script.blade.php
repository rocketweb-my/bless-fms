@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('custom_script.Custom Scripts')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('custom_script.Custom Scripts')}}</a></li>
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
                                        <h3 class="card-title"></h3>
                                        <div class="card-options">
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addCustomScriptModal">{{__('custom_script.New Custom Script')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="custom_script_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="">No</th>
                                                    <th class="">{{__('custom_script.Name')}}</th>
                                                    <th class="">{{__('custom_script.Description')}}</th>
                                                    <th class="">{{__('custom_script.Location')}}</th>
                                                    <th class="">{{__('custom_script.Page')}}</th>
                                                    <th class="">{{__('custom_script.Status')}}</th>
                                                    <th class="">{{__('custom_script.Action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<!-- CONTAINER CLOSED -->

    <!-- ADD CUSTOM SCRIPT MODAL -->
    <div class="modal fade" id="addCustomScriptModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('custom_script.New Custom Script')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('custom_script.store')}}" id="addCustomScript">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-control-label">{{__('custom_script.Name')}}:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">{{__('custom_script.Description')}}:</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">{{__('custom_script.Location')}}:</label>
                            <select name="location" class="form-control custom-select" required>
                                <option value="head">{{__('custom_script.Head')}}</option>
                                <option value="body">{{__('custom_script.Body')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">{{__('custom_script.Page')}}:</label>
                            <select name="page" class="form-control custom-select" required>
                                <option value="all_pages">{{__('custom_script.All Pages')}}</option>
                                <option value="feedback_form">{{__('custom_script.Feedback Submission Form')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="script_content" class="form-control-label">{{__('custom_script.Script Content')}}:</label>
                            <textarea class="form-control" id="script_content" name="script_content" rows="10" placeholder="<script>&#10;// Your custom JavaScript code here&#10;</script>" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">{{__('custom_script.Status')}}:</label>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="status" value="1" checked>
                                    <span class="custom-control-label">{{__('custom_script.Active')}}</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="status" value="0">
                                    <span class="custom-control-label">{{__('custom_script.Inactive')}}</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('custom_script.Close')}}</button>
                    <button type="submit" form="addCustomScript" class="btn btn-primary">{{__('custom_script.Save Custom Script')}}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT CUSTOM SCRIPT MODAL -->
    <div class="modal fade" id="editCustomScriptModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('custom_script.Edit Custom Script')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('custom_script.update')}}" id="editCustomScript">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label for="edit_name" class="form-control-label">{{__('custom_script.Name')}}:</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description" class="form-control-label">{{__('custom_script.Description')}}:</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">{{__('custom_script.Location')}}:</label>
                            <select name="location" id="edit_location" class="form-control custom-select" required>
                                <option value="head">{{__('custom_script.Head')}}</option>
                                <option value="body">{{__('custom_script.Body')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">{{__('custom_script.Page')}}:</label>
                            <select name="page" id="edit_page" class="form-control custom-select" required>
                                <option value="all_pages">{{__('custom_script.All Pages')}}</option>
                                <option value="feedback_form">{{__('custom_script.Feedback Submission Form')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_script_content" class="form-control-label">{{__('custom_script.Script Content')}}:</label>
                            <textarea class="form-control" id="edit_script_content" name="script_content" rows="10" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">{{__('custom_script.Status')}}:</label>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="status" value="1" id="edit_status_active">
                                    <span class="custom-control-label">{{__('custom_script.Active')}}</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="status" value="0" id="edit_status_inactive">
                                    <span class="custom-control-label">{{__('custom_script.Inactive')}}</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('custom_script.Close')}}</button>
                    <button type="submit" form="editCustomScript" class="btn btn-primary">{{__('custom_script.Update Custom Script')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('#custom_script_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/custom_scripts',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'location', name: 'location'},
                    {data: 'page', name: 'page'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#custom_script_table tbody').on('click', 'td button#delete', function (){
                Swal.fire({
                    title: "Confirm",
                    text: "Are you sure you want to delete?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/custom_scripts/delete', {
                            id: $(this).data('id'),
                        })
                            .then(function (response) {
                                location.reload();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                    }
                });
            });

            // Edit button click
            $('#custom_script_table tbody').on('click', 'td button#edit', function () {
                var id = $(this).data('id');
                axios.post('/custom_scripts/get_data', {
                    id: id,
                }).then(function(response) {
                    var data = response.data;
                    $('#edit_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_description').val(data.description);
                    $('#edit_location').val(data.location);
                    $('#edit_page').val(data.page);
                    $('#edit_script_content').val(data.script_content);
                    if (data.status == 1) {
                        $('#edit_status_active').prop('checked', true);
                    } else {
                        $('#edit_status_inactive').prop('checked', true);
                    }
                    $('#editCustomScriptModal').modal('show');
                }).catch(function (error) {
                    console.log(error);
                });
            });

        });

    </script>
@endsection

