@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">Lesen</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Lookup</a></li>
									<li class="breadcrumb-item"><a href="#">Lesen</a></li>
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
                                        <h3 class="card-title">Senarai Lesen</h3>
                                        <div class="card-options">
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addModal">Tambah Lesen</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="lookup_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="">No</th>
                                                    <th class="">Nama</th>
                                                    <th class="">Agensi</th>
                                                    <th class="">Penerangan</th>
                                                    <th class="">Status</th>
                                                    <th class="">Tarikh Dicipta</th>
                                                    <th class="">Tindakan</th>
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
                        <!-- ROW-1 CLOSED -->
					</div>
				</div>
				<!-- CONTAINER CLOSED -->

                <!-- ADD MODAL -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Lesen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="{{ route('lookup.lesen.store') }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="agensi_id" class="form-control-label">Agensi <small class="text-danger">*</small></label>
                                        <select class="form-control" id="agensi_id" name="agensi_id" required>
                                            <option value="">Pilih Agensi</option>
                                            @foreach($agensi as $a)
                                                <option value="{{ $a->id }}">{{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama" class="form-control-label">Nama <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" id="nama" name="nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="penerangan" class="form-control-label">Penerangan</label>
                                        <textarea class="form-control" id="penerangan" name="penerangan" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- EDIT MODAL -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Kemaskini Lesen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="" id="editForm">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="edit_agensi_id" class="form-control-label">Agensi <small class="text-danger">*</small></label>
                                        <select class="form-control" id="edit_agensi_id" name="agensi_id" required>
                                            <option value="">Pilih Agensi</option>
                                            @foreach($agensi as $a)
                                                <option value="{{ $a->id }}">{{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_nama" class="form-control-label">Nama <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_penerangan" class="form-control-label">Penerangan</label>
                                        <textarea class="form-control" id="edit_penerangan" name="penerangan" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Kemaskini</button>
                                </div>
                            </form>
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
            var table = $('#lookup_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/lookup/lesen',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    {data: 'agensi_nama', name: 'agensi_nama'},
                    {data: 'penerangan', name: 'penerangan'},
                    {data: 'status', name: 'status'},
                    {data: 'created_date', name: 'created_date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Edit functionality
            $('#lookup_table tbody').on('click', 'button#edit', function(){
                var id = $(this).data('id');
                $.get('/lookup/lesen/' + id + '/edit', function(data) {
                    $('#editForm').attr('action', '/lookup/lesen/' + id);
                    $('#edit_nama').val(data.nama);
                    $('#edit_penerangan').val(data.penerangan);
                    $('#edit_agensi_id').val(data.agensi_id);
                    $('#editModal').modal('show');
                });
            });

            // Enable/Disable functionality
            $('#lookup_table tbody').on('click', 'button#enable, button#disable', function(){
                var id = $(this).data('id');
                var action = $(this).attr('id');
                var message = action === 'enable' ? 'aktifkan' : 'nyahaktifkan';
                
                Swal.fire({
                    title: "Pengesahan",
                    text: "Adakah anda pasti ingin " + message + " lesen ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.post('/lookup/lesen/toggle-status', {
                            _token: '{{ csrf_token() }}',
                            id: id
                        }).done(function(response) {
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>
@endsection