@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">Create New Ticket</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Choose Category</a></li>
								</ol>
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
                                        <h3 class="card-title">Select Ticket Category & Sub Category</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{route('admin_create_ticket')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label">Category:</label>
                                                <select class="form-control select2-show-search" name="category" id="category_select" required>
                                                    <option value="">Select Category</option>
                                                    @foreach(getCategoryList() as $category)
                                                        <option value="{{$category->id}}">{!! $category->name !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Sub Category:</label>
                                                <select class="form-control select2-show-search" name="sub_category" id="sub_category_select" required disabled>
                                                    <option value="">Select Sub Category</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block" id="submit_btn" disabled>Create New Ticket In This Category</button>
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
<script>
$(document).ready(function() {
    $('#category_select').on('change', function() {
        var categoryId = $(this).val();
        var subCategorySelect = $('#sub_category_select');
        var submitBtn = $('#submit_btn');
        
        // Reset sub category dropdown
        subCategorySelect.html('<option value="">Select Sub Category</option>');
        subCategorySelect.prop('disabled', true);
        submitBtn.prop('disabled', true);
        
        if (categoryId) {
            // Fetch sub categories for selected category
            $.ajax({
                url: '/get-sub-categories/' + categoryId,
                type: 'GET',
                success: function(response) {
                    if (response.length > 0) {
                        $.each(response, function(index, subCategory) {
                            subCategorySelect.append('<option value="' + subCategory.id + '">' + subCategory.name + '</option>');
                        });
                        subCategorySelect.prop('disabled', false);
                    } else {
                        subCategorySelect.html('<option value="">No Sub Categories Available</option>');
                    }
                },
                error: function() {
                    alert('Error fetching sub categories');
                }
            });
        }
    });
    
    $('#sub_category_select').on('change', function() {
        var subCategoryId = $(this).val();
        var submitBtn = $('#submit_btn');
        
        if (subCategoryId) {
            submitBtn.prop('disabled', false);
        } else {
            submitBtn.prop('disabled', true);
        }
    });
});
</script>
@endsection
