@extends('layouts.master_public')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main2.css')}}" rel="stylesheet">
@endsection
@section('page-header')

@endsection
@section('content')
						<!-- ROW-1 OPEN -->
                        <div class="row mt-8">
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
                                        <div class="card-title">{{__('public/knowledgebase_view.Article Details')}}</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/knowledgebase_view.Category')}}</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">@if($article->category != null){{$article->category->name}}@endif</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/knowledgebase_view.Date Added')}}</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{\Carbon\Carbon::parse($article->dt)->format('d-m-Y H:m:s')}}</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/knowledgebase_view.Views')}}</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{$article->views}}</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @if($article->attachments)
                                @php($attachments = explode(",",trim($article->attachments,',')))
                                @for($x = 0; $x < count($attachments); $x++)
                                @php($attachment_detail = explode('#',$attachments[$x]))
                                <div class="card">
                                    <div class="card-body">
                                        <a href="{{route('public.knowledgebase_download',Crypt::encryptString($attachment_detail[0]))}}"  class="btn btn-block btn-success text-white">{{__('public/knowledgebase_view.Attachment')}} #{{$x+1}}</a>
                                    </div>
                                </div>
                                @endfor
                                @endif
                                <div class="card">
                                    <div class="card-body">
                                        <a class="btn btn-block btn-info text-white" href="{{route('public.knowledgeabase',$article->catid)}}">{{__('public/knowledgebase_view.Back To Knowledgebase')}}</a>
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
