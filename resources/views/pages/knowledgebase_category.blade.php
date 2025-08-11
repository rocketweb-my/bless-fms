@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('knowledgebase.Manage Knowledgebase Category')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('knowledgebase.Manage Knowledgebase Category')}}</a></li>
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
                                        @if(user()->isadmin == 1 || userPermissionChecker('can_man_kb') == true)
                                        <div class="card-options">
                                            <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#addCategory">{{__('knowledgebase.Add New Category')}}</a>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="knowledgebase_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="w-10">No</th>
                                                    <th class="">{{__('knowledgebase.Name')}}</th>
                                                    <th class="">{{__('knowledgebase.Type')}}</th>
                                                    <th class="">{{__('knowledgebase.Total Article')}}</th>
                                                    <th class="w-15">{{__('knowledgebase.Action')}}</th>
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
                                    <h5 class="modal-title" id="example-Modal3">{{__('knowledgebase.New Knowledgebase Category')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('knowledgebase.category.store')}}" id="addCategoryForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">{{__('knowledgebase.Category Title')}}: <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="title">
                                        </div>
                                        <div class="form-group form-elements">
                                            <div class="form-label">{{__('knowledgebase.Type')}} <small class="text-danger">*</small></div>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio mb-2">
                                                    <input type="radio" class="custom-control-input" name="type" value="0" checked form="addCategoryForm">
                                                    <span class="custom-control-label"><b>{{__('knowledgebase.Published')}}</b></span><br>
                                                    <span class="custom-control-label">{{__('knowledgebase.The category is viewable to everyone in the knowledgebase')}}.</span>
                                                </label>
                                                <label class="custom-control custom-radio mb-2">
                                                    <input type="radio" class="custom-control-input" name="type" value="1" form="addCategoryForm">
                                                    <span class="custom-control-label"><b>{{__('knowledgebase.Private')}}</b></span><br>
                                                    <span class="custom-control-label">{{__('knowledgebase.The category can only be read by staff')}}.</span>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('knowledgebase.Close')}}</button>
                                    <button type="submit" form="addCategoryForm" class="btn btn-primary">{{__('knowledgebase.Save Category')}}</button>
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
                                    <h5 class="modal-title" id="example-Modal3">{{__('knowledgebase.Edit Knowledgebase Category')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('knowledgebase.category.edit')}}" id="editCategoryForm">
                                        @csrf
                                        <input type="hidden"  name="id" id="id-edit">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">{{__('knowledgebase.Category Title')}}: <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="title" id="title_edit">
                                        </div>
                                        <div class="form-group form-elements">
                                            <div class="form-label">{{__('knowledgebase.Type')}} <small class="text-danger">*</small></div>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio mb-2">
                                                    <input type="radio" class="custom-control-input" name="type" id="published" value="0" checked form="editCategoryForm">
                                                    <span class="custom-control-label"><b>{{__('knowledgebase.Published')}}</b></span><br>
                                                    <span class="custom-control-label">{{__('knowledgebase.The category is viewable to everyone in the knowledgebase')}}.</span>
                                                </label>
                                                <label class="custom-control custom-radio mb-2">
                                                    <input type="radio" class="custom-control-input" name="type" id="private" value="1" form="editCategoryForm">
                                                    <span class="custom-control-label"><b>{{__('knowledgebase.Private')}}</b></span><br>
                                                    <span class="custom-control-label">{{__('knowledgebase.The category can only be read by staff')}}.</span>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('knowledgebase.Close')}}</button>
                                    <button type="submit" form="editCategoryForm" class="btn btn-primary">{{__('knowledgebase.Save Category')}}</button>
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

            var table = $('#knowledgebase_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/knowledgebase/category",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'type_edit', name: 'type_edit'},
                    {data: 'articles', name: 'articles'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#knowledgebase_table tbody').on('click', 'td button#delete', function (){
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
                        axios.post('/knowledgebase/delete_category', {
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
        $('#editCategory').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var name = button.data('name')
            var id = button.data('id')
            var type = button.data('type')

            $('#title_edit').val(name);
            $('#id-edit').val(id);

            if (type == 0)
            {
                $("#published").prop("checked", true);
            }else{
                $("#private").prop("checked", true);
            }
        })
    </script>
@endsection
