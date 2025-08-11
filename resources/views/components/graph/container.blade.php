<div id="{!! $id !!}"></div>

@foreach($labels as $index => $label)
<!-- Modal -->
<div class="modal fade" id="modal{!!$id!!}{!!$index!!}" tabindex="-1" role="dialog" aria-labelledby="modal{!!$id!!}{!!$index!!}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal{!!$id!!}{!!$index!!}Label">{!! $title !!} - {!! $label !!}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" id="table{!!$id!!}{!!$index!!}">
                    <table class="table table-striped table-bordered text-nowrap w-100">
                        <thead >
                        <tr>
                            <th>No</th>
                            <th>Tracking Id</th>
                            <th>Name</th>
                            <th>Submission Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataSets[$index] as $indexData => $data)
                        <tr>
                            <th scope="row">{{$indexData + 1}}</th>
                            <td><a href="{{route('ticket.reply',$data->trackid)}}">{{$data->trackid}}</a></td>
                            <td>{{$data->name}}</td>
                            <td>{{Carbon\Carbon::parse($data->dt)->format('d/m/Y H:m:s')}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endforeach
