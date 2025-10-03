@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">Draft Tickets</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Draft Tickets</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Draft Tickets</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="draft-tickets-table" class="table table-bordered text-nowrap key-buttons">
                            <thead>
                            <tr>
                                <th>Draft ID</th>
                                <th>Subject</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Created Date</th>
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
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#draft-tickets-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin_draft_tickets.data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'subject', name: 'subject' },
                    { data: 'category', name: 'category' },
                    { data: 'priority', name: 'priority' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[4, 'desc']]
            });
        });

        function submitDraft(id) {
            alert('submitDraft called with ID: ' + id);
            if (confirm('Adakah anda pasti untuk hantar draft ini sebagai tiket?')) {
                console.log('Submitting draft ID:', id);
                console.log('Action URL:', '/draft_tickets/' + id + '/submit');

                // Use regular form submission instead of AJAX to follow redirects
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '/draft_tickets/' + id + '/submit'
                });

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                }));

                console.log('Form created:', form);
                $('body').append(form);
                console.log('Form submitted');
                form.submit();
            }
        }

        function deleteDraft(id) {
            if (confirm('Adakah anda pasti untuk padam draft ini?')) {
                $.ajax({
                    url: '/draft_tickets/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#draft-tickets-table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Error deleting draft');
                    }
                });
            }
        }
    </script>
@endsection
