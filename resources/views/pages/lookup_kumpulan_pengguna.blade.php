@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('lookup_kumpulan_pengguna.Kumpulan Pengguna')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('lookup_kumpulan_pengguna.Lookup')}}</a></li>
									<li class="breadcrumb-item"><a href="#">{{__('lookup_kumpulan_pengguna.Kumpulan Pengguna')}}</a></li>
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
                                        <h3 class="card-title">{{__('lookup_kumpulan_pengguna.Senarai Kumpulan Pengguna')}}</h3>
                                        <div class="card-options">
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addModal">{{__('lookup_kumpulan_pengguna.Tambah Kumpulan Pengguna')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="lookup_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="">No</th>
                                                    <th class="">{{__('lookup_kumpulan_pengguna.Nama')}}</th>
                                                    <th class="">{{__('lookup_kumpulan_pengguna.Deskripsi')}}</th>
                                                    <th class="">{{__('lookup_kumpulan_pengguna.Status')}}</th>
                                                    <th class="">{{__('lookup_kumpulan_pengguna.Tarikh Dicipta')}}</th>
                                                    <th class="">{{__('lookup_kumpulan_pengguna.Tindakan')}}</th>
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
                    
                    <!-- ADD MODAL -->
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('lookup_kumpulan_pengguna.Tambah Kumpulan Pengguna')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('lookup.kumpulan-pengguna.store')}}" id="addForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nama" class="form-control-label">{{__('lookup_kumpulan_pengguna.Nama')}}: <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi" class="form-control-label">{{__('lookup_kumpulan_pengguna.Deskripsi')}}:</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lookup_kumpulan_pengguna.Tutup')}}</button>
                                    <button type="submit" form="addForm" class="btn btn-primary">{{__('lookup_kumpulan_pengguna.Simpan')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ADD MODAL CLOSED -->
                    
                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('lookup_kumpulan_pengguna.Kemaskini Kumpulan Pengguna')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="editForm">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="edit_id" name="id">
                                        <div class="form-group">
                                            <label for="edit_nama" class="form-control-label">{{__('lookup_kumpulan_pengguna.Nama')}}: <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_deskripsi" class="form-control-label">{{__('lookup_kumpulan_pengguna.Deskripsi')}}:</label>
                                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lookup_kumpulan_pengguna.Tutup')}}</button>
                                    <button type="submit" form="editForm" class="btn btn-primary">{{__('lookup_kumpulan_pengguna.Kemaskini')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- EDIT MODAL CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('#lookup_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/lookup/kumpulan-pengguna',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    {data: 'deskripsi', name: 'deskripsi'},
                    {data: 'status', name: 'status'},
                    {data: 'created_date', name: 'created_date'},
                    {data: 'action', name: 'action'},
                ]
            });

            // Edit button click
            $('#lookup_table tbody').on('click', 'td button#edit', function (){
                var id = $(this).data('id');
                
                axios.get('/lookup/kumpulan-pengguna/' + id + '/edit')
                    .then(function (response) {
                        $('#edit_id').val(response.data.id);
                        $('#edit_nama').val(response.data.nama);
                        $('#edit_deskripsi').val(response.data.deskripsi);
                        $('#editForm').attr('action', '/lookup/kumpulan-pengguna/' + response.data.id);
                        $('#editModal').modal('show');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

            // Enable/Disable button click
            $('#lookup_table tbody').on('click', 'td button#enable, td button#disable', function (){
                var id = $(this).data('id');
                var action = $(this).attr('id') === 'enable' ? '{{__("lookup_kumpulan_pengguna.mengaktifkan")}}' : '{{__("lookup_kumpulan_pengguna.menyahaktifkan")}}';
                
                Swal.fire({
                    title: "{{__('lookup_kumpulan_pengguna.Pengesahan')}}",
                    text: "{{__('lookup_kumpulan_pengguna.Adakah anda pasti untuk')}}" + " " + action + " " + "{{__('lookup_kumpulan_pengguna.item ini?')}}",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: '{{__("lookup_kumpulan_pengguna.Ya")}}',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: '{{__("lookup_kumpulan_pengguna.Tidak")}}'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/lookup/kumpulan-pengguna/toggle-status', {
                            id: id,
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