@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('main.Sub Categories')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('main.Sub Categories')}}</a></li>
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
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addSubCategory">{{__('sub_category.New Sub Category')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="sub_category_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="">No</th>
                                                    <th class="">{{__('sub_category.Name')}}</th>
                                                    <th class="">{{__('sub_category.Category')}}</th>
                                                    <th class="">{{__('sub_category.Priority')}}</th>
                                                    <th class="">{{__('sub_category.Tickets')}}</th>
                                                    <th class="">{{__('sub_category.Type')}}</th>
                                                    <th class="">{{__('sub_category.Auto-Assign')}}</th>
                                                    <th class="">{{__('sub_category.Action')}}</th>
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
                    <!-- ADD SUB CATEGORY MODAL -->
                    <div class="modal fade" id="addSubCategory" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="example-Modal3">{{__('sub_category.New Sub Category')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('sub-category.store')}}" id="addSubCategoryForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">{{__('sub_category.Name')}} ({{__('sub_category.Max 40 chars')}}):</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('sub_category.Category')}}:</label>
                                            <select name="category_id" id="select-category" class="form-control custom-select">
                                                <option value="">{{__('sub_category.Select Category')}}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('sub_category.Priority Sub Category')}}:</label>
                                            <select name="priority" id="select-priority" class="form-control custom-select">
                                                @foreach($activePriorities as $priority)
                                                    <option value="{{ $priority->priority_value }}" {{ $priority->priority_value == 3 ? 'selected' : '' }}>
                                                        {{ $priority->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('sub_category.Type')}}:</label>
                                            <select name="type" id="select-type" class="form-control custom-select">
                                                <option value="0" selected>Public</option>
                                                <option value="1">Private</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-switch">
                                                <input type="checkbox" name="autoassign" class="custom-switch-input" value="1" checked>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{__('sub_category.Auto-assign tickets in this sub category')}}</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('sub_category.Close')}}</button>
                                    <button type="submit" form="addSubCategoryForm" class="btn btn-primary">{{__('sub_category.Save Sub Category')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ADD SUB CATEGORY MODAL CLOSED -->
                    <!-- EDIT SUB CATEGORY MODAL -->
                    <div class="modal fade" id="editSubCategory" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="example-Modal3">{{__('sub_category.Edit Sub Category')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('sub-category.edit')}}" id="editSubCategoryForm">
                                        @csrf
                                        <input type="hidden" id="id-edit" name="id">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">{{__('sub_category.Name')}} ({{__('sub_category.Max 40 chars')}}):</label>
                                            <input type="text" class="form-control" id="name_edit" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('sub_category.Category')}}:</label>
                                            <select name="category_id" id="select-category-edit" class="form-control custom-select">
                                                <option value="">{{__('sub_category.Select Category')}}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('sub_category.Priority Sub Category')}}:</label>
                                            <select name="priority" id="select-priority-edit" class="form-control custom-select">
                                                @foreach($activePriorities as $priority)
                                                    <option value="{{ $priority->priority_value }}">{{ $priority->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{__('sub_category.Type')}}:</label>
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
                                                <span class="custom-switch-description">{{__('sub_category.Auto-assign tickets in this sub category')}}</span>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('sub_category.Close')}}</button>
                                    <button type="submit" form="editSubCategoryForm" class="btn btn-primary">{{__('sub_category.Save Sub Category')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- EDIT SUB CATEGORY MODAL CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('#sub_category_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/sub-categories',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'priority_edit', name: 'priority'},
                    {data: 'total_ticket', name: 'total_ticket'},
                    {data: 'type_edit', name: 'type_edit'},
                    {data: 'autoassign_edit', name: 'autoassign_edit'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#sub_category_table tbody').on('click', 'td button#delete', function (){
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
                        axios.post('/sub-categories/delete', {
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
        $('#editSubCategory').on('show.bs.modal', function (event) {
            $('#autoassign-edit').prop("checked", false);

            var button = $(event.relatedTarget);

            var id = button.data('id');
            var name = button.data('name');
            var category_id = button.data('category_id');
            var priority = button.data('priority');
            var type = button.data('type');
            var autoassign = button.data('autoassign');

            $('#name_edit').val(name);
            $('#select-category-edit').val(category_id);
            $('#select-priority-edit').val(priority);
            $('#select-type-edit').val(type);
            if (autoassign == '1') {
                $('#autoassign-edit').prop("checked", true);
            }
            $('#id-edit').val(id);

        });

    </script>
@endsection