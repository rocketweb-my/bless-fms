@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/ion.rangeSlider/css/ion.rangeSlider.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/ion.rangeSlider/css/ion.rangeSlider.skinSimple.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('dashboard.Dashboard')}}</h1>
{{--								<ol class="breadcrumb">--}}
{{--									<li class="breadcrumb-item"><a href="#"></a></li>--}}
{{--								</ol>--}}
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')

						<!-- ROW-1 OPEN -->
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="fa fa-exclamation mr-2" aria-hidden="true"></i> {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                                <div class="row h-100">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                                        <div class="card">
                                            <div class="card-body text-center statistics-info">
                                                <div class="counter-icon bg-primary mb-0 box-primary-shadow">
                                                    <i class="fa fa-send-o text-white"></i>
                                                </div>
                                                <h6 class="mt-4 mb-1">{{__('dashboard.New Tickets')}}</h6>
                                                <h2 class="mb-2 number-font">{{$new_ticket}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                                        <div class="card">
                                            <div class="card-body text-center statistics-info">
                                                <div class="counter-icon bg-secondary mb-0 box-secondary-shadow">
                                                    <i class="fa fa-comments-o text-white"></i>
                                                </div>
                                                <h6 class="mt-4 mb-1">{{__('dashboard.Waiting Reply Tickets')}}</h6>
                                                <h2 class="mb-2 number-font">{{$waiting_reply_ticket}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                                        <div class="card">
                                            <div class="card-body text-center statistics-info">
                                                <div class="counter-icon bg-success mb-0 box-success-shadow">
                                                    <i class="fa fa-check-circle-o text-white"></i>
                                                </div>
                                                <h6 class="mt-4 mb-1">{{__('dashboard.Resolved Ticket')}}</h6>
                                                <h2 class="mb-2  number-font">{{$resolved_ticket}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                                        <div class="card">
                                            <div class="card-body text-center statistics-info">
                                                <div class="counter-icon bg-danger mb-0 box-info-shadow">
                                                    <i class="fa fa-exclamation-triangle text-white"></i>
                                                </div>
                                                <h6 class="mt-4 mb-1">{{__('dashboard.Overdue Tickets')}}</h6>
                                                <h2 class="mb-2  number-font">{{$over_due_ticket}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 h-100">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('dashboard.30 Days Tickets')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        {{-- <div id="chart" style="height: 300px;"></div> --}}
                                        {!! $chart->container() !!}
                                    </div>
                                </div>
                            </div><!-- COL END -->
                        </div>
                        @if($over_due_ticket != 0)
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-status card-status-left bg-danger br-bl-7 br-tl-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('dashboard.Overdue Tickets')}}  ({{$over_due_ticket}})</h3>
                                        <div class="card-options">
                                            <a href="{{route('ticket.index')}}" class="btn btn-primary btn-sm">{{__('dashboard.Show All Tickets')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="ticket_table" class="table table-striped table-bordered display"#navbarSupportedContent-4>
                                                <thead>
                                                <tr>
                                                    <th width="25px">No</th>
                                                    <th>{{ __('Tracking Id') }}</th>
                                                    <th class="">{{ __('main.Updated') }}</th>
                                                    <th class="">{{__('main.Name')}}</th>
                                                    <th class="">{{ __('main.Subject') }}</th>
                                                    <th width="70px">{{ __('main.Status') }}</th>
                                                    <th class="">{{ __('main.Last Replier') }}</th>
                                                    <th width="70px">{{ __('main.Priority') }}</th>
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
                        @endif
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script src="{{ URL::asset('assets/js/index2.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/Chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/morris/raphael-min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/morris/morris.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('#ticket_table').DataTable({
                // pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: "/dashboard",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'trackid_edit', name: 'trackid_edit'},
                    {data: { '_': 'lastchange.display', 'sort': 'lastchange' }, name: 'lastchange.timestamp'},
                    {data: 'name', name: 'name'},
                    {data: 'subject_edit', name: 'subject_edit'},
                    {data: 'status_edit', name: 'status_edit'},
                    {data: 'lastreplier_edit', name: 'lastreplier_edit'},
                    {data: 'priority_edit', name: 'priority_edit'},

                ]
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

        });
    </script>

    {{-- <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "/api/chart/dashboard_chart",
            type: 'line',
            hooks: new ChartisanHooks()
                .colors(['#f82649', '#0774f8'])
                .responsive()
                .datasets([{
                    type: 'line',
                    fill: false,
                    ticks: ([{
                        autoSkip: false,
                    }])
                }]),

        });
    </script> --}}
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endsection
