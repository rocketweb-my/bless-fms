@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">

@endsection
@section('page-header')
<!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">{{__('main.Tickets')}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">{{__('main.Tickets')}}</li>
        </ol>
    </div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')

                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('ticket.Filter Tickets')}}</h3>
                                        <div class="card-options">
                                            {{-- <a href={{ route('ticket.index') }} class="btn btn-success btn-md ml-2">{{__('ticket.Reset Filter')}}</a> --}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form method="GET" id="search_form">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('ticket.Client Name')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="client_name" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('ticket.Client Email')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="email" class="form-control" name="client_email" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('ticket.Tracking Id')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="tracking_id" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-md-12 col-sm-12">
                                                    <button class="btn btn-info float-right" type="submit">{{__('ticket.Search')}}</button>
                                                    <a href={{ route('ticket.index') }} class="btn btn-success float-right mr-2">{{__('ticket.Reset Filter')}}</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                                    <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('ticket.Open Tickets')}} ({{$total_ticket}})</h3>
                                        <div class="card-options">
                                            <a href={{ route('ticket.export') }} class="btn btn-success btn-md ml-2">{{__('ticket.Export Tickets')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="ticket_table" class="table table-striped table-bordered display">
                                                <thead>
                                                <tr>
                                                    <th width="2px"></th>
                                                    <th width="25px">{{__('ticket.No')}}</th>
                                                    <th>{{__('ticket.Tracking Id')}}</th>
                                                    <th class="">{{__('ticket.Updated')}}</th>
                                                    <th class="">{{__('ticket.Name')}}</th>
                                                    <th class="">{{__('ticket.Subject')}}</th>
                                                    <th width="70px">{{__('ticket.Status')}}</th>
                                                    <th class="">{{__('ticket.Owner')}}</th>
                                                    <th class="">{{__('ticket.Last Replier')}}</th>
                                                    <th width="70px">{{__('ticket.Priority')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">{{__('ticket.Change priority')}}</label>
                                                    <div class="input-group">
                                                        <select name="priority" id="priority" class="form-control custom-select">
                                                            <option value="">{{__('ticket.--Select--')}}</option>
                                                            @foreach($activePriorities as $priority)
                                                                <option value="{{ $priority->priority_value }}">Set priority to: {{ $priority->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-append">
													        <a class="btn btn-azure text-white" style="border-color: rgb(36, 196, 180)" type="button" onclick="priority()">{{__('ticket.Execute')}}</a>
												        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(user()->isadmin == 1 || userPermissionChecker('can_assign_others') == true || userPermissionChecker('can_assign_self') == true)
                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">{{__('ticket.Assign To')}}</label>
                                                    <div class="input-group">
                                                        <select name="assign" id="assign" class="form-control custom-select">
                                                            <option value="">{{__('ticket.--Select--')}}</option>
                                                            @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-append">
													        <a class="btn btn-azure text-white" style="border-color: rgb(36, 196, 180)" type="button" onclick="assign()">{{__('ticket.Assign')}}</a>
												        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h3 class="card-title text-white">{{__('ticket.Filter Tickets')}}</h3>
                                        <div class="card-options">
                                            <button v-on:click="buttonClick" class="btn btn-secondary btn-sm ml-2">@{{ button }} {{__('ticket.Filter')}}</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group form-elements">
                                                        <div class="row">
                                                            <div class="col-1 form-label">{{__('ticket.Status')}}</div>
                                                            <div class="col-3">
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="status[]" value="0" checked="" v-model="status">
                                                                        <span class="custom-control-label text-red">{{ __('ticket.New') }}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="status[]" value="3" checked="" v-model="status">
                                                                        <span class="custom-control-label text-green">{{ __('ticket.Resolved') }}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="status[]" value="1" checked="" v-model="status">
                                                                        <span class="custom-control-label text-orange">{{ __('ticket.Waiting Reply') }}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="status[]" value="4" checked="" v-model="status">
                                                                        <span class="custom-control-label">{{ __('ticket.In Progress') }}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="status[]" value="2" checked="" v-model="status">
                                                                        <span class="custom-control-label text-blue">{{ __('ticket.Replied') }}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="status[]" value="5"  v-model="status">
                                                                        <span class="custom-control-label">{{ __('ticket.On Hold') }}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-2"></div>
                                                        </div>
                                                        <!--Hide-->
                                                        <div v-if="showMoreFilter">
                                                            <hr class="separator">
                                                            <div class="row mt-6">
                                                                <div class="col-1 form-label">{{__('ticket.Priority')}}</div>
                                                                <div class="col-11">
                                                                    <div class="custom-controls-stacked">
                                                                        @foreach($activePriorities as $priority)
                                                                            <label class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" name="priority[]" value="{{ $priority->priority_value }}" v-model="priority">
                                                                                <span class="custom-control-label {{ $priority->priority_value == 1 ? 'text-red' : '' }}">{{ $priority->name }}</span>
                                                                            </label>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr class="separator">
                                                            @if(user()->isadmin == 1)
                                                            <div class="row mt-6">
                                                                <div class="col-1 form-label">{{__('ticket.Show')}}</div>
                                                                <div class="col-11">
                                                                    <div class="custom-controls-stacked">
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" name="showMyTicket" value="true" v-model="showMyTicket">
                                                                            <span class="custom-control-label">{{__('ticket.Assigned to me')}}</span>
                                                                        </label>

                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" name="showNoOwnerTicket" value="true" v-model="showNoOwnerTicket">
                                                                            <span class="custom-control-label">{{__('ticket.Unassigned tickets')}}</span>
                                                                        </label>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" name="showOtherTicket" value="true" v-model="showOtherTicket">
                                                                            <span class="custom-control-label">{{__('ticket.Assigned to others')}}</span>
                                                                        </label>
                                                                        {{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        {{--                                                                        <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">--}}
                                                                        {{--                                                                        <span class="custom-control-label">Only tagged tickets</span>--}}
                                                                        {{--                                                                    </label>--}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            
                                                        </div>
                                                        <!--Hide End-->
                                                    </div>
                                                    <button v-on:click="submit" type="button" class="btn btn-info float-right">{{__('ticket.Save')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                showMoreFilter : false,
                button : '{!! __('ticket.Show More') !!}',
                status : {!! json_encode($current_status_filtered) !!},
                priority : {!! json_encode($current_priority_filtered) !!},
                showTicket : [1],
                showOtherTicket : {{ session('showOtherTicket')  }},
                showNoOwnerTicket : {!! session('showNoOwnerTicket') !!},
                showMyTicket : {!! session('showMyTicket') !!},
            },
            methods: {
                buttonClick: function () {
                    this.showMoreFilter = !this.showMoreFilter
                    if(this.showMoreFilter == true)
                    {
                        this.button = '{!! __('ticket.Hide') !!}';
                    }else{
                        this.button = '{!! __('ticket.Show More') !!}';
                    }
                },
                submit: function () {
                    let formData = new FormData();
                    formData.append('status', this.status);
                    formData.append('priority', this.priority);
                    formData.append('showOtherTicket', this.showOtherTicket);
                    formData.append('showNoOwnerTicket', this.showNoOwnerTicket);
                    formData.append('showMyTicket', this.showMyTicket);

                    axios.post('/store_filter', formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then(function (response) {

                            if (!response.data) {
                                alert('File not uploaded.');
                            } else {
                                // alert('File uploaded.');
                                location.reload();
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
            },

        })
    </script>

        <script type="text/javascript">
        $(function () {

            var table = $('#ticket_table').DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/ticket",
                    data: function (d) {
                        d.client_name = $('input[name=client_name]').val();
                        d.client_email = $('input[name=client_email]').val();
                        d.tracking_id = $('input[name=tracking_id]').val();
                    }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'trackid_edit', name: 'trackid_edit'},
                    {data: { '_': 'lastchange.display', 'sort': 'lastchange' }, name: 'lastchange.timestamp'},
                    {data: 'name', name: 'name'},
                    {data: 'subject_edit', name: 'subject_edit', orderable: false,},
                    {data: 'status_edit', name: 'status_edit'},
                    {data: 'owner_edit', name: 'owner_edit', orderable: false,},
                    {data: 'lastreplier_edit', name: 'lastreplier_edit'},
                    {data: 'priority_edit', name: 'priority_edit'},

                ]
            });

            // Enable AJAX reload for search form
            $('#search_form').on('submit', function(e) {
                e.preventDefault();
                $('#ticket_table').DataTable().ajax.reload();
            });

        });

        if (window.innerWidth < 1250)
        {
            $('#ticket_table').addClass("nowrap");
        }else{
            $('#ticket_table').addClass("wrap");
        }
        window.addEventListener("resize", function () {
            if (window.innerWidth < 1250)
            {
                $('#ticket_table').addClass("nowrap");
            }else{
                $('#ticket_table').addClass("wrap");
            }

        });
    </script>
    <script>
        function assign() {
            let checked = $('input[name=ticket_checkbox]:checked').map(function(_, el) {
            return $(el).val();
        }).get();

            let selected = $( "#assign" ).val();

            console.log(checked.length);
            console.log(selected);
            if (checked.length == 0)
            {
                Swal.fire({
                    title: "Error",
                    text: "Please tick at least one ticket.",
                    icon: "error",
                    showConfirmButton:true,
                    showCloseButton:false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                })
            }else if(selected == '')
            {
                Swal.fire({
                    title: "Error",
                    text: "Please choose a person for selected ticket.",
                    icon: "error",
                    showConfirmButton:true,
                    showCloseButton:false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                })
            } else {
                Swal.fire({
                    title: "Confirm",
                    text: "Are you sure you want to continue?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Stay on the page'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '/bulk_assign',
                            data:{
                                "_token": "{{ csrf_token() }}",
                                id:checked,
                                selected:selected,
                            },
                            success: function(data){
                                location.reload();
                            }
                        });
                    }
                });
            }

        }

        function priority() {
            let checked = $('input[name=ticket_checkbox]:checked').map(function (_, el) {
                return $(el).val();
            }).get();

            let selected = $("#priority").val();

            if (checked.length == 0) {
                Swal.fire({
                    title: "Error",
                    text: "Please tick at least one ticket.",
                    icon: "error",
                    showConfirmButton: true,
                    showCloseButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                })
            } else if (selected == '') {
                Swal.fire({
                    title: "Error",
                    text: "Please choose priority for selected ticket.",
                    icon: "error",
                    showConfirmButton: true,
                    showCloseButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                })
            } else {

                Swal.fire({
                    title: "Confirm",
                    text: "Are you sure you want to continue?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Stay on the page'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '/bulk_priority_update',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: checked,
                                selected: selected,
                            },
                            success: function (data) {
                                location.reload();
                            }
                        });
                    }
                });
            }
        }

        function test()
        {
            Swal.fire({
                title: 'Are you sure?',
                text: "",
                icon:"question",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Withdraw',
            })
        }
    </script>
@endsection
