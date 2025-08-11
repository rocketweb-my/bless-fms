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
                                        <h3 class="mb-0 card-title"><a href="{{route('public.knowledgebase_category')}}">{{__('public/knowledgebase.Knowledgebase')}}</a> | Category : {{$category->name}}</h3>
                                        <div class="card-options">
                                            <a href="{{route('public.knowledgebase_category')}}" class="btn btn-primary">Back</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="knowledgebase_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="w-10">No</th>
                                                    <th class="">{{__('public/knowledgebase.Subject')}}</th>
                                                    <th class="">{{__('public/knowledgebase.Category')}}</th>
                                                    <th class="w-15">{{__('public/knowledgebase.Published Date')}}</th>
                                                    <th class="w-10">{{__('public/knowledgebase.Action')}}</th>
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
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {

            var table = $('#knowledgebase_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/public/knowledgebase/category/{{$id}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'subject', name: 'subject'},
                    {data: 'category', name: 'category'},
                    {data: 'date', name: 'date'},
                    {data: 'action', name: 'action'},
                ]
            });

        });
    </script>

@endsection
