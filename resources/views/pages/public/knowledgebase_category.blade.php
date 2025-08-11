@extends('layouts.master_public')
@section('css')
<link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/single-page/css/main2.css')}}" rel="stylesheet">
@endsection
@section('page-header')

@endsection
@section('content')
						<!-- ROW-1 OPEN -->
                        <div class="row mt-8">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0 card-title">{{__('public/knowledgebase_category.Knowledgebase Categories')}}</h3>
                                        <div class="card-options">
                                            <a href="{{route('public.index')}}" class="btn btn-primary">{{__('public/knowledgebase_category.Back to Main')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($categories as $category)
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <a href="{{route('public.knowledgeabase',$category->id)}}">
                                                    <div class="card bg-success img-card box-primary-shadow">
                                                        <div class="card-body">
                                                            <div class="d-flex">
                                                                <div class="text-white">
                                                                    <h4 class="mb-0 number-font">{{$category->name}}</h4>
{{--                                                                    <p class="text-white mb-0">Submit a new issue to a department</p>--}}
                                                                </div>
{{--                                                                <div class="ml-auto"><i class="fa fa-send-o text-white fs-30 mr-2 mt-2"></i>--}}
{{--                                                                </div>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
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

@endsection
