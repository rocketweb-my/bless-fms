@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">Vendor Management</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Vendors</a></li>
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
                    <h3 class="card-title">Vendor List</h3>
                    <div class="card-options">
                        <a href="#vendorRegistrationForm" class="btn btn-outline-primary">Register New Vendor</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="vendor_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>
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

    <!-- VENDOR REGISTRATION FORM -->
    <div class="row" id="vendorRegistrationForm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Register New Vendor</h3>
                </div>
                <div class="card-body">
                    <form id="form" method="post" action="{{route('vendor.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                    <small class="form-text text-muted">Email will be used as username for login</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company <span class="text-danger">*</span></label>
                                    <input type="text" name="company" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Vendor Type <span class="text-danger">*</span></label>
                                    <select name="vendor_type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="admin">Admin</option>
                                        <option value="technical">Technical</option>
                                    </select>
                                    <small class="form-text text-muted">Admin vendors have broader access, Technical vendors focus on ticket resolution</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> A random password will be generated and sent to the vendor's email address.
                        </div>

                        <button type="submit" class="btn btn-primary">Register Vendor</button>
                        <a href="{{route('vendor.index')}}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <!-- INTERNAL Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/datatable.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // DataTable
            var table = $('#vendor_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('vendor.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'company', name: 'company'},
                    {data: 'no_hp', name: 'no_hp'},
                    {data: 'vendor_type_badge', name: 'vendor_type'},
                    {data: 'is_active', name: 'is_active'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Status toggle
            $('body').on('click', '#status', function() {
                var vendor_id = $(this).data("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to change this vendor's status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('{{ route('vendor.updateStatus') }}', {
                            id: vendor_id
                        })
                        .then(function (response) {
                            Swal.fire(
                                'Updated!',
                                'Vendor status has been updated.',
                                'success'
                            );
                            table.draw();
                        })
                        .catch(function (error) {
                            Swal.fire(
                                'Error!',
                                'Failed to update status.',
                                'error'
                            );
                            console.log(error);
                        });
                    }
                });
            });

            // Delete vendor
            $('body').on('click', '#delete', function() {
                var vendor_id = $(this).data("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('{{ route('vendor.delete') }}', {
                            id: vendor_id
                        })
                        .then(function (response) {
                            Swal.fire(
                                'Deleted!',
                                'Vendor has been deleted.',
                                'success'
                            );
                            table.draw();
                        })
                        .catch(function (error) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete vendor.',
                                'error'
                            );
                            console.log(error);
                        });
                    }
                });
            });
        });
    </script>
@endsection
