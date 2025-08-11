@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/formwizard/smart_wizard.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/formwizard/smart_wizard_theme_arrows.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/formwizard/smart_wizard_theme_circles.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/formwizard/smart_wizard_theme_dots.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/wysiwyag/richtext.css')}}" rel="stylesheet">

@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">View Article</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{route('knowledgebase')}}">Knowledgebase</a></li>
									<li class="breadcrumb-item"><a href="#">View Article</a></li>
								</ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">{{$article->subject}}</div>
                                        </div>
                                        <div class="card-body">
                                            {!! $article->content !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Article Details</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5 mb-2">
                                                    <label>Article ID</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{$article->id}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>Category</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">@if($article->category != null){{$article->category->name}}@endif</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>Date Added</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{\Carbon\Carbon::parse($article->dt)->format('d-m-Y H:m:s')}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>Views</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{$article->views}}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ROW-1 OPEN -->
                            <div class="row"></div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/chart/Chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/wysiwyag/wysiwyag.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ URL::asset('assets/js/summernote.js') }}"></script>
    <script src="{{ URL::asset('assets/js/formeditor.js') }}"></script>
@endsection
