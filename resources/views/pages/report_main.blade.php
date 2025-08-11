@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/multipleselect/multiple-select.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />

@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('report_main.Report')}}</h1>
{{--								<ol class="breadcrumb">--}}
{{--									<li class="breadcrumb-item"><a href="#"></a></li>--}}
{{--								</ol>--}}
							</div>


@endsection
@section('content')
    <style>
        .apexcharts-menu-item.exportSVG {
            display: none !important;
        }
    </style>

						<!-- ROW-1 OPEN -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="get" action="{{route('report.main')}}">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <label class="form-label">{{__('report_main.Date')}}:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" name="date" class="form-control pull-right" id="reservation">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">&nbsp;</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <button type="submit" class="btn btn-block btn-info">{{__('report_main.Filter')}}</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="{{route('report.main')}}" class="btn btn-block btn-indigo">{{__('report_main.Reset Filter')}}</a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                        <br>
                                        <a class="btn btn-block btn-success text-white" data-toggle="modal" data-target="#addCategory">{{__('report_main.Add Chart')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                                <div class="row h-100">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xl-3">
                                        <div class="card">
                                            <div class="card-body text-center statistics-info h-50">
                                                <div class="counter-icon bg-primary mb-0 box-primary-shadow">
                                                    <i class="fa fa-send-o text-white"></i>
                                                </div>
                                                <h6 class="mt-4 mb-1">{{__('report_main.Open Tickets')}}</h6>
                                                <h2 class="mb-2 number-font">{{ $open_ticket }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xl-3">
                                        <div class="card">
                                            <div class="card-body text-center statistics-info">
                                                <div class="counter-icon bg-success mb-0 box-success-shadow">
                                                    <i class="fa fa-check-circle-o text-white"></i>
                                                </div>
                                                <h6 class="mt-4 mb-1">{{__('report_main.Resolved Ticket')}}</h6>
                                                <h2 class="mb-2  number-font">{{ $resolved_ticket }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xl-3">
                                        <div class="card">
                                            <div class="card-body text-center statistics-info">
                                                <div class="counter-icon bg-danger mb-0 box-info-shadow">
                                                    <i class="fa fa-exclamation-triangle text-white"></i>
                                                </div>
                                                <h6 class="mt-4 mb-1">{{__('report_main.Overdue Tickets')}}</h6>
                                                <h2 class="mb-2  number-font">{{ $over_due_ticket }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xl-3 h-50">
                                        <div class="card">
                                            <div class="card-body text-center statistics-info">
                                                <div class="counter-icon bg-secondary mb-0 box-secondary-shadow">
                                                    <i class="fa fa-ticket text-white"></i>
                                                </div>
                                                <h6 class="mt-4 mb-1">{{__('report_main.Total Tickets')}}</h6>
                                                <h2 class="mb-2 number-font">{{ $total_ticket }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 h-100">--}}
{{--                                <div class="card h-100">--}}
{{--                                    <div class="card-header">--}}
{{--                                        <h3 class="card-title">Tickets @{{yearStart}}</h3>--}}
{{--                                    </div>--}}
{{--                                    <div class="card-body">--}}
{{--                                        <div v-show="chart != null">--}}
{{--                                            <canvas id="myChart" height="200px"></canvas>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div><!-- COL END -->--}}
                            @foreach($charts as $chart)
                                @if($chart->type == 'row' || $chart->type == 'bar')
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 h-100 d-flex align-items-stretch">
                                @else
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 h-100 d-flex align-items-stretch">
                               @endif
                                    <div class="card">
                                        <div class="card-header">
{{--                                            <h3 class="card-title"></h3>--}}
                                            <div class="card-options">
{{--                                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>--}}
{{--                                                <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>--}}
                                                <a href="#" class="card-options-remove" onclick="deleteGraph({{$chart->id}})"><i class="fe fe-x"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            {!! graphContainer($chart,Request::get('date')) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- COL END -->
                        </div>
					</div>
					<!-- CONTAINER CLOSED -->
                        <!-- ADD CHART MODAL -->
                        <div class="modal fade" id="addCategory" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="example-Modal3">{{__('report_main.New Chart')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{route('report.add_chart')}}" id="addCategoryForm">
                                            @csrf
                                            <div class="form-group">
                                                <label for="title" class="form-control-label">{{__('report_main.Title')}}: <small class="text-danger">*</small></label>
                                                <input type="text" class="form-control" id="title" name="title" placeholder="Chart Title" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{__('report_main.Chart Type')}}: <small class="text-danger">*</small></label>
                                                <select name="type" id="select-priority" class="form-control custom-select" required>
                                                    <option value="">{{__('report_main.Select Chart Type')}}</option>
                                                    <option value="pie">{{__('report_main.Pie Chart')}}</option>
                                                    <option value="donut">{{__('report_main.Donut Chart')}}</option>
                                                    <option value="row">{{__('report_main.Row Chart')}}</option>
                                                    <option value="bar">{{__('report_main.Bar Chart')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{__('report_main.Data Field')}}: <small class="text-danger">*</small></label>
                                                <select name="data_field" id="data_field" class="form-control custom-select" required>
                                                    <option value="">{{__('report_main.Select Data Field')}}</option>
                                                    <option value="category" >{{__('report_main.Category')}}</option>
                                                    <option value="custom" >{{__('report_main.Custom Field')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="cat">
                                                <label class="form-label">{{__('report_main.Select Category')}} <small class="text-danger">*</small></label>
                                                <select multiple="multiple" id="cat_select" name="category[]" class="filter-multi">
                                                    @foreach(getCategoryList() as $category)
                                                        <option value="{{$category->id}}">{!! $category->name !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group" id="cus">
                                                <label class="form-label">{{__('report_main.Select Custom Field')}} <small class="text-danger">*</small></label>
                                                <select name="custom" id="cus_select" class="form-control custom-select">
                                                    <option value="">{{__('report_main.Select Custom Field')}}</option>
                                                    @if($custom_fields != null)
                                                        @foreach($custom_fields as $custom_field)
                                                            <option value="{{$custom_field->id}}">{{json_decode($custom_field->name)->English}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('report_main.Close')}}</button>
                                        <button type="submit" form="addCategoryForm" class="btn btn-primary">{{__('report_main.Save Chart')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ADD CHART MODAL CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/multipleselect/multiple-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/multipleselect/multi-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/toggles.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

{{--    <script src="{{ URL::asset('assets/js/index2.js') }}"></script>--}}
    <script src="{{ URL::asset('assets/plugins/chart/Chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/morris/raphael-min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/morris/morris.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js" integrity="sha512-ljeReA8Eplz6P7m1hwWa+XdPmhawNmo9I0/qyZANCCFvZ845anQE+35TuZl9+velym0TKanM2DXVLxSJLLpQWw==" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


{{--    </script>--}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example-getting-started').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#cat').hide();
            $('#cus').hide();
            $('#data_field').on('change', function() {
                if(this.value == 'category')
                {
                    $("#cat_select").prop('required', true);
                    $("#cus_select").prop('required', false);
                    $("#cat").show();
                    $("#cus").hide();
                }else
                {
                    $("#cus_select").prop('required', true);
                    $("#cat_select").prop('required', false);
                    $("#cat").hide();
                    $("#cus").show();

                }
                console.log( this.value );
            });


        });
    </script>
    <script>
        function deleteGraph(id) {
            axios.post('/report/delete_chart', {
                id: id,
            })
                .then(function (response) {
                    // console.log(response);
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    </script>
    <script>
        $(function() {
            $('input[name="date"]').daterangepicker({
                "startDate": "{!! $start_label !!}",
                "endDate": "{!! $end_label !!}",
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>


    @foreach($charts as $chart)
        {!! graphScript($chart, Request::get('date')) !!}
    @endforeach





@endsection
