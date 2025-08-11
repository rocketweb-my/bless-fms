@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection

@section('page-header')
    <div>
        <h1 class="page-title">{{__('advance_report.Advanced Reports')}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">{{__('advance_report.Dashboard')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('advance_report.Advanced Reports')}}</li>
        </ol>
    </div>
@endsection

@section('content')
    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 card-title">{{__('advance_report.Advanced Reporting System')}}</h3>
                    <div class="card-options">
                        <a href="{{route('advance-report.generate')}}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> {{__('advance_report.Generate New Report')}}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <a href="{{route('advance-report.generate')}}">
                                <div class="card bg-primary img-card box-primary-shadow">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="text-white">
                                                <h3 class="mb-0 number-font">{{__('advance_report.Generate Report')}}</h3>
                                                <p class="text-white mb-0">{{__('advance_report.Generate Report Description')}}</p>
                                            </div>
                                            <div class="ml-auto"> 
                                                <i class="fa fa-file-excel text-white fs-30 mr-2 mt-2"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="card bg-info img-card box-info-shadow">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="text-white">
                                            <h3 class="mb-0 number-font">Report History</h3>
                                            <p class="text-white mb-0">{{__('advance_report.Report History Description')}}</p>
                                        </div>
                                        <div class="ml-auto"> 
                                            <i class="fa fa-history text-white fs-30 mr-2 mt-2"></i> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5><i class="fa fa-info-circle"></i> {{__('advance_report.Features')}}</h5>
                                <ul class="mb-0">
                                    <li><strong>{{__('advance_report.Advanced Filtering')}}:</strong> {{__('advance_report.Advanced Filtering Description')}}</li>
                                    <li><strong>{{__('advance_report.Excel Export')}}:</strong> {{__('advance_report.Excel Export Description')}}</li>
                                    <li><strong>{{__('advance_report.Real-time Preview')}}:</strong> {{__('advance_report.Real-time Preview Description')}}</li>
                                    <li><strong>{{__('advance_report.Required Fields')}}:</strong> {{__('advance_report.Required Fields Description')}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection