@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('main.Categories')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('main.Categories')}}</a></li>
								</ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')

						<!-- ROW-1 OPEN -->
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"></h3>
                                        <div class="card-options">
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addCategory">{{__('category.New Category')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="category_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="">No</th>
                                                    <th class="">{{__('category.Name')}}</th>
                                                    <th class="">{{__('category.Priority')}}</th>
                                                    <th class="">{{__('category.Tickets')}}</th>
                                                    <th class="">{{__('category.Type')}}</th>
                                                    <th class="">{{__('category.Auto-Assign')}}n</th>
                                                    <th class="">{{__('category.Action')}}</th>
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
                    <!-- ADD CATEGORY MODAL -->
                    <div class="modal fade" id="addCategory" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="example-Modal3">{{__('category.New Category')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('category.store')}}" id="addCategoryForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">{{__('category.Name')}} ({{__('category.Max 40 chars')}}):</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('category.Priority Category')}}:</label>
                                            <select name="priority" id="select-priority" class="form-control custom-select">
                                                @foreach($activePriorities as $priority)
                                                    <option value="{{ $priority->priority_value }}" {{ $priority->priority_value == 3 ? 'selected' : '' }}>
                                                        {{ $priority->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('category.Type')}}:</label>
                                            <select name="type" id="select-type" class="form-control custom-select">
                                                <option value="0" selected>Public</option>
                                                <option value="1">Private</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-switch">
                                                <input type="checkbox" name="autoassign" class="custom-switch-input" value="1" checked>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{__('category.Auto-assign tickets in this category')}}</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('category.Close')}}</button>
                                    <button type="submit" form="addCategoryForm" class="btn btn-primary">{{__('category.Save Category')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ADD CATEGORY MODAL CLOSED -->
                    <!-- EDIT CATEGORY MODAL -->
                    <div class="modal fade" id="editCategory" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="example-Modal3">{{__('category.Edit Category')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('category.edit')}}" id="editCategoryForm">
                                        @csrf
                                        <input type="hidden" id="id-edit" name="id">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">{{__('category.Name')}} ({{__('category.Max 40 chars')}}):</label>
                                            <input type="text" class="form-control" id="name_edit" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('category.Priority Category')}}:</label>
                                            <select name="priority" id="select-priority-edit" class="form-control custom-select">
                                                @foreach($activePriorities as $priority)
                                                    <option value="{{ $priority->priority_value }}">{{ $priority->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('category.Type')}}:</label>
                                            <select name="type" id="select-type-edit" class="form-control custom-select">
                                                <option value="0" selected>Public</option>
                                                <option value="1">Private</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-switch">
                                                <input type="hidden" name="autoassign" value="0">
                                                <input type="checkbox" name="autoassign" id="autoassign-edit" class="custom-switch-input" value="1">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{__('category.Auto-assign tickets in this category')}}</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('category.Close')}}</button>
                                    <button type="submit" form="editCategoryForm" class="btn btn-primary">{{__('category.Save Category')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- EDIT CATEGORY MODAL CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('#category_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/categories',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'priority_edit', name: 'priority'},
                    {data: 'total_ticket', name: 'total_ticket'},
                    {data: 'type_edit', name: 'type_edit'},
                    {data: 'autoassign_edit', name: 'autoassign_edit'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#category_table tbody').on('click', 'td button#delete', function (){
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
                        axios.post('/categories/delete', {
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

        });
    </script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                type : 'text',
            },
            methods: {
                test: function (id) {
                },
            }

        })
    </script>

    <script>
        $('#editCategory').on('show.bs.modal', function (event) {
            $('#autoassign-edit').prop("checked", false);

            var button = $(event.relatedTarget);

            var id = button.data('id');
            var name = button.data('name');
            var priority = button.data('priority');
            var type = button.data('type');
            var autoassign = button.data('autoassign');

            $('#name_edit').val(name);
            $('#select-priority-edit').val(priority);
            $('#select-type-edit').val(type);
            if (autoassign == '1') {
                $('#autoassign-edit').prop("checked", true);
            }
            $('#id-edit').val(id);

        });

    </script>
@endsection
