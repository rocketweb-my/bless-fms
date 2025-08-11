@extends('layouts.master_public')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main2.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
{{--						<!-- PAGE-HEADER -->--}}
{{--						<div class="page-header">--}}
{{--							<div>--}}
{{--								<h1 class="page-title">Empty</h1>--}}
{{--								<ol class="breadcrumb">--}}
{{--									<li class="breadcrumb-item"><a href="#">Pages</a></li>--}}
{{--									<li class="breadcrumb-item active" aria-current="page">Empty</li>--}}
{{--								</ol>--}}
{{--							</div>--}}
{{--							<div class="ml-auto pageheader-btn">--}}
{{--								<a href="#" class="btn btn-success btn-icon text-white mr-2">--}}
{{--									<span>--}}
{{--										<i class="fe fe-plus"></i>--}}
{{--									</span> Add Account--}}
{{--								</a>--}}
{{--								<a href="#" class="btn btn-danger btn-icon text-white">--}}
{{--									<span>--}}
{{--										<i class="fe fe-log-in"></i>--}}
{{--									</span> Export--}}
{{--								</a>--}}
{{--							</div>--}}
{{--						</div>--}}
						<!-- PAGE-HEADER END -->
@endsection
@section('content')
						<!-- ROW-1 OPEN -->
						<div class="row mt-8">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0 card-title">{{__('public/feedback_category.Submit a Support Request')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('public.submission')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label">{{__('public/feedback_category.Select Feedback Category')}}</label>
                                                <select class="form-control select2-show-search" name="category" id="category_select" required>
                                                    <option value="">Select Category</option>
                                                    @foreach($public_categories as $category)
                                                        <option value="{{$category->id}}">{!! $category->name !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Sub Category</label>
                                                <select class="form-control select2-show-search" name="sub_category" id="sub_category_select" required disabled>
                                                    <option value="">Select Sub Category</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block" id="submit_btn" disabled>{{__('public/feedback_category.Choose This Category')}}</button>
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
    <script>
    $(document).ready(function() {
        console.log('Public feedback category script loaded');
        
        $('#category_select').on('change', function() {
            var categoryId = $(this).val();
            var subCategorySelect = $('#sub_category_select');
            var submitBtn = $('#submit_btn');
            
            console.log('Category selected: ' + categoryId);
            
            // Reset sub category dropdown
            subCategorySelect.html('<option value="">Select Sub Category</option>');
            subCategorySelect.prop('disabled', true);
            submitBtn.prop('disabled', true);
            
            if (categoryId) {
                console.log('Fetching sub categories for category: ' + categoryId);
                // Fetch sub categories for selected category
                $.ajax({
                    url: '/get-sub-categories/' + categoryId,
                    type: 'GET',
                    success: function(response) {
                        console.log('Sub categories response:', response);
                        if (response.length > 0) {
                            $.each(response, function(index, subCategory) {
                                subCategorySelect.append('<option value="' + subCategory.id + '">' + subCategory.name + '</option>');
                            });
                            subCategorySelect.prop('disabled', false);
                        } else {
                            subCategorySelect.html('<option value="">No Sub Categories Available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching sub categories:', xhr, status, error);
                        alert('Error fetching sub categories: ' + error);
                    }
                });
            }
        });
        
        $('#sub_category_select').on('change', function() {
            var subCategoryId = $(this).val();
            var submitBtn = $('#submit_btn');
            
            console.log('Sub category selected: ' + subCategoryId);
            
            if (subCategoryId) {
                submitBtn.prop('disabled', false);
            } else {
                submitBtn.prop('disabled', true);
            }
        });
    });
    </script>
@endsection
