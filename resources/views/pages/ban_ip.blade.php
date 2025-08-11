@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('ban_Ip.Ban IPs')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('ban_Ip.Ban IPs')}}</a></li>
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
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addCategory">{{__('ban_Ip.Ban New IP')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="ban_ip_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="">No</th>
                                                    <th class="">IP</th>
                                                    <th class="">{{__('ban_Ip.IP Range')}}</th>
                                                    <th class="">{{__('ban_Ip.Banned By')}}</th>
                                                    <th class="">{{__('ban_Ip.Date')}}</th>
                                                    <th class="">{{__('ban_Ip.Action')}}</th>
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
                                    <h5 class="modal-title" id="example-Modal3">{{__('ban_Ip.Ban New IP')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('ban.ip.store')}}" id="addCategoryForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">{{__('ban_Ip.IP Address')}}: <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="ip">
                                        </div>
                                    </form>
                                    <label class="form-control-label">{{__('ban_Ip.Example')}}:</label>
                                    <ul style="margin-left: 10px">
                                        <li>123.0.0.0</li>
                                        <li>123.0.0.1 - 123.0.0.53</li>
                                        <li>123.0.0.0/24</li>
                                        <li>123.0.*.*</li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('ban_Ip.Close')}}</button>
                                    <button type="submit" form="addCategoryForm" class="btn btn-primary">{{__('ban_Ip.Save')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- ADD CATEGORY MODAL CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('#ban_ip_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/banned/ips',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'ip_display', name: 'ip_display'},
                    {data: 'ip_range', name: 'ip_range'},
                    {data: 'ban_by', name: 'ban_by'},
                    {data: 'date', name: 'date'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#ban_ip_table tbody').on('click', 'td button#delete', function (){
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
                        axios.post('{{route('ban.ip.delete')}}', {
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
@endsection
