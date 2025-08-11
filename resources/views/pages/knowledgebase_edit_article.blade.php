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
								<h1 class="page-title">Edit  Article</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{route('knowledgebase')}}">Knowledgebase</a></li>
									<li class="breadcrumb-item"><a href="#">Edit Article</a></li>
								</ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Edit Article</div>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{route('knowledgebase.article.edit.save')}}" id="addArticle" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$article->id}}">
                                                <div class="form-group">
                                                    <label class="form-control-label">Subject <small class="text-danger">*</small></label>
                                                    <input type="text" name="subject" value="{{$article->subject}}" class="form-control">
                                                </div>
                                                <textarea class="form-control" name="article" id="summernote">{!! $article->content !!}</textarea>
                                                <div class="form-group">
                                                    <label class="form-label">Attachment</label>
                                                    <input type="file" name="file[1]" size="50">
                                                    <br>
                                                    <input type="file" name="file[2]" size="50">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Keywords <small class="text-gray">(optional - separate by space, comma or new line)</small></label>
                                                    <input type="text" name="keywords" value="{!! $article->keywords !!}" class="form-control">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Article Details</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="m5">
                                                    <div class="form-group">
                                                        <div class="form-label"></div>
                                                        <label class="custom-switch">
                                                            <input type="hidden" name="sticky" value="0" form="addArticle">
                                                            <input type="checkbox" name="sticky" class="custom-switch-input" value="1" @if($article->sticky == 1) checked @endif form="addArticle">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description">Make this article "Sticky"</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group form-elements">
                                                        <div class="form-label">Type <small class="text-danger">*</small></div>
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-radio mb-2">
                                                                <input type="radio" class="custom-control-input type" name="type" value="0" @if($article->type == 0) checked @endif form="addArticle">
                                                                <span class="custom-control-label"><b>Published</b></span><br>
                                                                <span class="custom-control-label">The article is viewable to everyone in the knowledgebase.</span>
                                                            </label>
                                                            <label class="custom-control custom-radio mb-2">
                                                                <input type="radio" class="custom-control-input type" name="type" value="1" @if($article->type == 1)checked @endif form="addArticle">
                                                                <span class="custom-control-label"><b>Private</b></span><br>
                                                                <span class="custom-control-label">Private articles can only be read by staff.</span>
                                                            </label>
                                                            <label class="custom-control custom-radio mb-2">
                                                                <input type="radio" class="custom-control-input type" name="type" value="2" @if($article->type == 2)checked @endif form="addArticle">
                                                                <span class="custom-control-label"><b>Draft</b></span><br>
                                                                <span class="custom-control-label">The article is saved but not yet published. It can only be read by staff who has permission to manage knowledgebase articles.</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Category <small class="text-danger">*</small></label>
                                                        <select name="category" id="select-priority" class="form-control custom-select" form="addArticle">
                                                        </select>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <button type="submit" class="btn btn-block btn-info" form="addArticle">Save Article</button>
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
    <script>
        var kb_cat_private = '{!! $kb_categories_private !!}';
        var kb_cat_public = '{!! $kb_categories_public !!}';
        var kb_cat_all = '{!! $kb_categories_all !!}';

        $( document ).ready(function() {
            @if($article->type == 0)
            $('#select-priority').html(kb_cat_public);
            @elseif($article->type == 1)
            $('#select-priority').html(kb_cat_private);
            @else
            $('#select-priority').html(kb_cat_all);
            @endif
        });

        $('.type').change(function() {

            if (this.value == '0')
            {
                $('#select-priority').html(kb_cat_public);
            }
            else if(this.value == '1')
            {
                $('#select-priority').html(kb_cat_private);
            }
            else
            {
                $('#select-priority').html(kb_cat_all);
            }
        });
    </script>
@endsection
