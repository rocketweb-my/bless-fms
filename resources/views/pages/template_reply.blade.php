@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('template.Canned Response')}}</h1>
{{--								<ol class="breadcrumb">--}}
{{--									<li class="breadcrumb-item"><a href="#"></a></li>--}}
{{--								</ol>--}}
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
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addCanned" v-on:click="clearData">{{__('template.New Canned Response')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="template_reply_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="w-10">No</th>
                                                    <th class="">{{__('template.Title')}}</th>
                                                    <th class="w-15">{{__('template.Action')}}</th>
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
                    <!-- ADD CANNED MODAL -->
                    <div class="modal fade" id="addCanned" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="example-Modal3">{{__('template.New Canned Response')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('template.canned.store')}}" id="addCannedTemplateForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="title" class="form-control-label">{{__('template.Title')}}:</label>
                                            <input type="text" class="form-control" id="title" name="title" v-model="title">
                                        </div>
                                        <div class="form-group">
                                            <label for="message" class="form-control-label">{{__('template.Message')}}:</label>
                                            <textarea class="form-control" id="message" name="message" rows="6" v-model="message"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-info mb-2" v-on:click="addValue('HESK_ID')">{{ __('template.Ticket number') }}</button>
                                                <button type="button" class="btn btn-info mb-2" v-on:click="addValue('HESK_TRACK_ID')">{{ __('template.Tracking ID') }}</button>
                                                <button type="button" class="btn btn-info mb-2" v-on:click="addValue('HESK_NAME')">{{ __('template.Name') }}</button>
                                                <button type="button" class="btn btn-info mb-2" v-on:click="addValue('HESK_EMAIL')">{{ __('template.Email') }}</button>
                                                <button type="button" class="btn btn-info mb-2" v-on:click="addValue('HESK_OWNER')">{{ __('template.Owner') }}</button>
                                                @foreach($custom_fields as $custom_field)
                                                <button type="button" class="btn btn-info mb-2" v-on:click="addValue('HESK_custom{{$custom_field->id}}')">{{json_decode($custom_field->name)->English}}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('template.Close')}}</button>
                                    <button type="submit" form="addCannedTemplateForm" class="btn btn-primary">{{__('template.Save Template')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ADD CANNED MODAL CLOSED -->
                    <!-- ADD CANNED MODAL -->
                    <div class="modal fade" id="editCanned" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="example-Modal3">{{__('template.Edit Canned Response')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('template.canned.edit')}}" id="editCannedTemplateForm">
                                        @csrf
                                        <input type="hidden" id="id-edit" name="id">
                                        <div class="form-group">
                                            <label for="title" class="form-control-label">{{__('template.Title')}}:</label>
                                            <input type="text" class="form-control" id="title-edit" name="title">
                                        </div>
                                        <div class="form-group">
                                            <label for="message" class="form-control-label">{{__('template.Message')}}:</label>
                                            <textarea class="form-control" name="message" id="message-edit" rows="6" v-model="messageEdit"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-info mb-2" onclick="addValueEdit('HESK_ID')">{{ __('template.Ticket number') }}</button>
                                                <button type="button" class="btn btn-info mb-2" onclick="addValueEdit('HESK_TRACK_ID')">{{ __('template.Tracking ID') }}</button>
                                                <button type="button" class="btn btn-info mb-2" onclick="addValueEdit('HESK_NAME')">{{ __('template.Name') }}</button>
                                                <button type="button" class="btn btn-info mb-2" onclick="addValueEdit('HESK_EMAIL')">{{ __('template.Email') }}</button>
                                                <button type="button" class="btn btn-info mb-2" onclick="addValueEdit('HESK_OWNER')">{{ __('template.Owner') }}</button>
                                                @foreach($custom_fields as $custom_field)
                                                    <button type="button" class="btn btn-info mb-2" v-on:click="addValue('HESK_custom{{$custom_field->id}}')">{{json_decode($custom_field->name)->English}}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('template.Close')}}</button>
                                    <button type="submit" form="editCannedTemplateForm" class="btn btn-primary">{{__('template.Save Template')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ADD CANNED MODAL CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('#template_reply_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('template.canned') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#template_reply_table tbody').on('click', 'td button#delete', function (){
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
                        axios.post('{{route('template.canned.delete')}}', {
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
                title : '',
                message : '',
                messageEdit : '',
            },
            methods: {
                addValue: function (item) {
                this.message = this.message+'%%'+item+'%%';
                },
                clearData: function ()
                {
                    this.message = '';
                    this.title = '';
                },
            },

        })
    </script>
    <script>
        $('#editCanned').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget)
            console.log(button.data('message'))

            $('#title-edit').val(button.data('title'));
            $('#id-edit').val(button.data('id'));
            $('textarea#message-edit').html(button.data('message'));
        })

        function addValueEdit(item)
        {
            $current = $('textarea#message-edit').val();
            $new = $current+'%%'+item+'%%';
            $('textarea#message-edit').val($new);
            console.log($current);
            console.log($new);
        }
    </script>
@endsection
