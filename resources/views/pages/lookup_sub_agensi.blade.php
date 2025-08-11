@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('lookup_sub_agensi.Sub Agensi')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('lookup_sub_agensi.Lookup')}}</a></li>
									<li class="breadcrumb-item"><a href="#">{{__('lookup_sub_agensi.Sub Agensi')}}</a></li>
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
                                        <h3 class="card-title">{{__('lookup_sub_agensi.Senarai Sub Agensi')}}</h3>
                                        <div class="card-options">
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addModal">{{__('lookup_sub_agensi.Tambah Sub Agensi')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="lookup_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="">No</th>
                                                    <th class="">{{__('lookup_sub_agensi.Nama')}}</th>
                                                    <th class="">{{__('lookup_sub_agensi.Agensi')}}</th>
                                                    <th class="">{{__('lookup_sub_agensi.Kementerian')}}</th>
                                                    <th class="">{{__('lookup_sub_agensi.Deskripsi')}}</th>
                                                    <th class="">{{__('lookup_sub_agensi.Status')}}</th>
                                                    <th class="">{{__('lookup_sub_agensi.Tarikh Dicipta')}}</th>
                                                    <th class="">{{__('lookup_sub_agensi.Tindakan')}}</th>
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
                                    <h5 class="modal-title">{{__('lookup_sub_agensi.Tambah Sub Agensi')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('lookup.sub-agensi.store')}}" id="addForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nama" class="form-control-label">{{__('lookup_sub_agensi.Nama')}}: <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="agensi_id" class="form-control-label">{{__('lookup_sub_agensi.Agensi')}}: <small class="text-danger">*</small></label>
                                            <select class="form-control" id="agensi_id" name="agensi_id" required>
                                                <option value="">{{__('lookup_sub_agensi.Pilih Agensi')}}</option>
                                                @foreach($agensis as $agensi)
                                                    <option value="{{$agensi->id}}">{{$agensi->nama}} ({{$agensi->kementerian ? $agensi->kementerian->nama : '-'}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi" class="form-control-label">{{__('lookup_sub_agensi.Deskripsi')}}:</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lookup_sub_agensi.Tutup')}}</button>
                                    <button type="submit" form="addForm" class="btn btn-primary">{{__('lookup_sub_agensi.Simpan')}}</button>
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
                                    <h5 class="modal-title">{{__('lookup_sub_agensi.Kemaskini Sub Agensi')}}</h5>
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
                                            <label for="edit_nama" class="form-control-label">{{__('lookup_sub_agensi.Nama')}}: <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_agensi_id" class="form-control-label">{{__('lookup_sub_agensi.Agensi')}}: <small class="text-danger">*</small></label>
                                            <select class="form-control" id="edit_agensi_id" name="agensi_id" required>
                                                <option value="">{{__('lookup_sub_agensi.Pilih Agensi')}}</option>
                                                @foreach($agensis as $agensi)
                                                    <option value="{{$agensi->id}}">{{$agensi->nama}} ({{$agensi->kementerian ? $agensi->kementerian->nama : '-'}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_deskripsi" class="form-control-label">{{__('lookup_sub_agensi.Deskripsi')}}:</label>
                                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('lookup_sub_agensi.Tutup')}}</button>
                                    <button type="submit" form="editForm" class="btn btn-primary">{{__('lookup_sub_agensi.Kemaskini')}}</button>
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
                ajax: '/lookup/sub-agensi',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    {data: 'agensi_nama', name: 'agensi_nama'},
                    {data: 'kementerian_nama', name: 'kementerian_nama'},
                    {data: 'deskripsi', name: 'deskripsi'},
                    {data: 'status', name: 'status'},
                    {data: 'created_date', name: 'created_date'},
                    {data: 'action', name: 'action'},
                ]
            });

            // Edit button click
            $('#lookup_table tbody').on('click', 'td button#edit', function (){
                var id = $(this).data('id');
                
                axios.get('/lookup/sub-agensi/' + id + '/edit')
                    .then(function (response) {
                        $('#edit_id').val(response.data.id);
                        $('#edit_nama').val(response.data.nama);
                        $('#edit_agensi_id').val(response.data.agensi_id);
                        $('#edit_deskripsi').val(response.data.deskripsi);
                        $('#editForm').attr('action', '/lookup/sub-agensi/' + response.data.id);
                        $('#editModal').modal('show');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

            // Enable/Disable button click
            $('#lookup_table tbody').on('click', 'td button#enable, td button#disable', function (){
                var id = $(this).data('id');
                var action = $(this).attr('id') === 'enable' ? '{{__("lookup_sub_agensi.mengaktifkan")}}' : '{{__("lookup_sub_agensi.menyahaktifkan")}}';
                
                Swal.fire({
                    title: "{{__('lookup_sub_agensi.Pengesahan')}}",
                    text: "{{__('lookup_sub_agensi.Adakah anda pasti untuk')}}" + " " + action + " " + "{{__('lookup_sub_agensi.item ini?')}}",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: '{{__("lookup_sub_agensi.Ya")}}',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: '{{__("lookup_sub_agensi.Tidak")}}'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/lookup/sub-agensi/toggle-status', {
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