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
                                        <h3 class="card-title">{{__('public/feedback_reply.Subject')}} : {{$ticket->subject}} @if($ticket->status == 3) - [Resolved]@endif</h3>
                                        <div class="card-options">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="content vscroll">
                                            <span class="text-gray">{{__('public/feedback_reply.Name')}} :</span>
                                            <div class="btn-group mt-1 mb-2">
                                                <span class="font-weight-bold mr-2">{{$ticket->name}}</span>
                                            </div>
                                            <span class="text-gray">{{__('public/feedback_reply.Email')}} :</span>
                                            <div class="btn-group mt-1 mb-2">
                                                <span class="font-weight-bold mr-2">{{$ticket->email}}</span>
                                            </div>
                                            <div class="btn-group mt-1 mb-2">
                                                <span class="mr-2">{{\Carbon\Carbon::parse($ticket->dt)->format('d/m/Y H:m:s')}}</span>
                                            </div>
                                            <p class="mt-3 mb-3">{!! $ticket->message !!}</p>
                                            @if($ticket->attachments)
                                            @php($attachments = explode(",",trim($ticket->attachments,',')))
                                            @for($x = 0; $x < count($attachments); $x++)
                                                @php($attachment_detail = explode('#',$attachments[$x]))
                                                @php($attachment_file = \App\Models\Attachment::where('att_id',$attachment_detail[0])->first())
                                                    <a href={{ asset('storage/attachment/'.$attachment_file->saved_name) }} class="btn btn-success mr-2 mb-2" target="_blank"><i class="fa fa-download"></i> {{__('public/feedback_reply.Attachment')}} #{{$x+1}}</a>
                                            @endfor
                                            @endif
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default active">
                                                    <div class="panel-heading " role="tab" id="headingOne">
                                                        <h4 class="panel-title" style="background-color: white !important;">
                                                            @if($replies->count() > 1)
                                                                <button role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="btn btn-info mb-3 collapsed">
                                                                    {{__('public/feedback_reply.Show previous replies')}} {{$replies->count() - 1}}
                                                                </button>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                    @if($replies->count() > 1)
                                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" style="">
                                                            @else
                                                                <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
                                                                    @endif
                                                                    @if($replies->count() > 1)
                                                                        <div class="panel-body" style="border: unset !important;">
                                                                            @for($x = 0; $x < $replies->count()-1; $x++)
                                                                                <div class="card">
                                                                                    <div class="card-status  card-status-left @if($replies[$x]->staffid == 0) bg-info @else bg-success @endif br-bl-7 br-tl-7"></div>
                                                                                    <div class="card-body">
                                                                                        <div>
                                                                                            <span class="text-gray">{{__('public/feedback_reply.Contact')}} :</span>
                                                                                            <div class="btn-group mt-2 mb-2">
                                                                                                <span class="font-weight-bold mr-2">{{$replies[$x]->name}}</span>
                                                                                                <ul class="dropdown-menu" role="menu">
                                                                                                    <li class="dropdown-plus-title">
                                                                                                        {{__('public/feedback_reply.Email')}} : {{$replies[$x]->email}}
                                                                                                    </li>
                                                                                                    <li class="dropdown-plus-title">
                                                                                                        IP : {{$replies[$x]->ip}}
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            &nbsp;<span class="text-gray">{{\Carbon\Carbon::parse($replies[$x]->dt)->format('d/m/Y H:m:s')}}</span>
                                                                                        </div>
                                                                                        <p>{!! $replies[$x]->message !!}</p>
                                                                                        @if($replies[$x]->attachments)
                                                                                            @php($attachments = explode(",",trim($replies[$x]->attachments,',')))
                                                                                            @for($y = 0; $y < count($attachments); $y++)
                                                                                                @php($attachment_detail = explode('#',$attachments[$y]))
                                                                                                @php($attachment_file = \App\Models\Attachment::where('att_id',$attachment_detail[0])->first())
                                                                                                <a href={{ asset('storage/attachment/'.$attachment_file->saved_name) }} class="btn btn-success mr-2 mb-2" target="_blank"><i class="fa fa-download"></i> {{__('public/feedback_reply.Attachment')}} #{{$y+1}}</a>
                                                                                            @endfor
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            @endfor
                                                                        </div>
                                                                    @endif

                                                                </div>

                                                                @if($replies->count() != 0)
                                                                    <div class="panel-body">
                                                                        <div class="card">
                                                                            @php($total_num = $replies->count()-1)
                                                                            <div class="card-status  card-status-left @if($replies[$total_num]->staffid == 0) bg-info @else bg-success @endif br-bl-7 br-tl-7"></div>
                                                                            <div class="card-body">
                                                                                <div>
                                                                                    <span class="text-gray">{{__('public/feedback_reply.Contact')}} :</span>
                                                                                    <div class="btn-group mt-2 mb-2">
                                                                                        <span class="font-weight-bold mr-2">{{$replies[$total_num]->name}}</span>
                                                                                        <ul class="dropdown-menu" role="menu">
                                                                                            <li class="dropdown-plus-title">
                                                                                                {{__('public/feedback_reply.Email')}} : {{$replies[$total_num]->email}}
                                                                                            </li>
                                                                                            <li class="dropdown-plus-title">
                                                                                                IP : {{$replies[$total_num]->ip}}
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    &nbsp;<span class="text-gray">{{\Carbon\Carbon::parse($ticket->dt)->format('d/m/Y H:m:s')}}</span>
                                                                                </div>
                                                                                <p>{!! $replies[$total_num]->message !!}</p>
                                                                                @if($replies[$total_num]->attachments)
                                                                                    @php($attachments = explode(",",trim($replies[$total_num]->attachments,',')))
                                                                                    @for($y = 0; $y < count($attachments); $y++)
                                                                                        @php($attachment_detail = explode('#',$attachments[$y]))
                                                                                        @php($attachment_file = \App\Models\Attachment::where('att_id',$attachment_detail[0])->first())
                                                                                        <a href={{ asset('storage/attachment/'.$attachment_file->saved_name) }} class="btn btn-success mr-2 mb-2" target="_blank"><i class="fa fa-download"></i> {{__('public/feedback_reply.Attachment')}} #{{$y+1}}</a>
                                                                                    @endfor
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @if($ticket->status != 3)
                                                                <div class="panel-body">
                                                                    <h6 class="font-weight-bold">{{__('public/feedback_reply.Add reply')}}</h6>
                                                                    <form method="post" action="{{route('public.reply_form')}}">
                                                                        @csrf
                                                                        <div class="form-group mb-0">
                                                                            <input type="hidden" name="tracking_id" value="{{$ticket->trackid}}" v-model="trackingId">
                                                                            <input type="hidden" name="ticket_id" value="{{$ticket->id}}" v-model="ticketId">
                                                                            <input type="hidden" name="name" value="{{$ticket->name}}" v-model="name">
                                                                            <input type="hidden" name="dt" value="{{\Carbon\Carbon::now()}}" v-model="dt">
                                                                            <textarea class="form-control" name="message" placeholder="Type your message" rows="4" v-model="message" required></textarea>

                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label">{{__('public/feedback_reply.Attachment')}}</label>
                                                                            <input ref="file" type="file" name="file[1]" size="50" v-on:change="handleFile1Upload($event)" onchange="ValidateSingleInput(this);">
                                                                            <br>
                                                                            <input ref="file" type="file" name="file[2]" size="50" v-on:change="handleFile2Upload($event)" onchange="ValidateSingleInput(this);">
                                                                            <br>
                                                                            <small>File format: .gif,.jpg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf</small>
                                                                        </div>
                                                                        <button type="button" v-on:click="submit" class="btn btn-primary btn-block" :disabled="message.length == 0"><i class="fe fe-navigation"></i>&nbsp;{{__('public/feedback_reply.Submit reply')}}</button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('public/feedback_reply.Ticket Details')}}</h3>
                                        <div class="card-options">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-5 mb-2">
                                                <label>{{__('public/feedback_reply.Tracking ID')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{$ticket->trackid}}</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/feedback_reply.Ticket number')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{$ticket->id}}</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/feedback_reply.Created on')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{\Carbon\Carbon::parse($ticket->dt)->format('d-m-Y H:m:s')}}</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/feedback_reply.Ticket status')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{statusName($ticket->status)}}</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/feedback_reply.Updated')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{\Carbon\Carbon::parse($ticket->lastchange)->format('d-m-Y H:m:s')}}</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/feedback_reply.Category')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{categoryName($ticket->category)->name}}</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/feedback_reply.Replies')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{$ticket->replies}}</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/feedback_reply.Prioriy')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <span class="font-weight-bold mr-2">{{priorityName($ticket->priority)}}</span>
                                            </div>

                                            <div class="col-5 mb-2">
                                                <label>{{__('public/feedback_reply.Last replier')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                @if($ticket->lastreplier == 0)
                                                    <span class="font-weight-bold mr-2">{{$ticket->name}}</span>
                                                @else
                                                    <span class="font-weight-bold mr-2">{{findUser($ticket->lastreplier)->name}}</span>
                                                @endif
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                @if($ticket->status != 3)
                                <div class="card">
                                    <div class="card-body">
                                        <button class="btn btn-block btn-danger font-weight-bold" v-on:click="close('{{$ticket->trackid}}')" >{{__('public/feedback_reply.Close Ticket')}}</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                trackingId : '{{$ticket->trackid}}',
                ticketId : '{{$ticket->id}}',
                dt : '{!!\Carbon\Carbon::now()!!}',
                name : '{{$ticket->name}}',
                message : '',
                file_name : '',
                // file_data : '',
                form_data : '',
                fileOne: 'undefined',
                fileTwo: 'undefined',


            },
            methods: {
                handleFile1Upload: function(event){
                    this.fileOne = event.target.files[0];
                    console.log(this.fileOne);
                },
                handleFile2Upload: function(event){
                    this.fileTwo = event.target.files[0];
                    console.log(this.fileTwo);
                },
                submit: function () {
                    // console.log(this.$refs.file);
                    // this.fileOne = this.$refs.file.files[0];
                    // this.fileTwo = this.$refs.file2.files[0];

                    console.log(this.fileOne);
                    console.log(this.fileTwo);
                    let formData = new FormData();
                    formData.append('dt', this.dt);
                    formData.append('name', this.name);
                    formData.append('tracking_id', this.trackingId);
                    formData.append('ticket_id', this.ticketId);
                    formData.append('message', this.message);
                    formData.append('file[1]', this.fileOne);
                    formData.append('file[2]', this.fileTwo);

                        axios.post('{{route('public.reply_form')}}', formData,
                            {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then(function (response) {

                                if (!response.data) {
                                    alert('File not uploaded.');
                                } else {
                                    // alert('File uploaded.');
                                    location.reload();
                                }

                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    },

                close: function (trackid){
                    Swal.fire({
                        title: "Confirm",
                        text: "Are you sure you want to close this ticket?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.value) {
                            axios.post('{{route('public.close_ticket')}}', {
                                trackid: trackid,
                            })
                                .then(function (response) {
                                    // console.log(response);
                                    location.reload();
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });

                        }
                    });
                }

                }

        })
    </script>
    <script>
        var _validFileExtensions = [".gif", ".jpg", ".png", ".zip", ".rar", ".csv", ".doc", ".docx", ".xls", ".xlsx", ".txt", ".pdf"];
        function ValidateSingleInput(oInput) {
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length > 0) {
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }

                    if (!blnValid) {
                        alert("Sorry, invalid, attachment file format");
                        oInput.value = "";
                        return false;
                    }
                }
            }
            return true;
        }
    </script>
@endsection
