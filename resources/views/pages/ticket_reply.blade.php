@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
<style>
.placeholder{
    position: absolute;
    top: 32px;
    left: 35px;
    font-family: "Lato",Arial,sans-serif;
    font-size: 14px;
    font-weight: 400;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.57;
    z-index: 0;
    letter-spacing: .1px;
    color: #959eb0;
}
</style>
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('ticket_reply.Reply Ticket')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{route('ticket.index')}}">{{__('ticket_reply.Ticket')}}</a></li>
									<li class="breadcrumb-item active" aria-current="page">{{$ticket->trackid}}</li>
								</ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">{{__('ticket_reply.Customer Details')}} & {{__('ticket_reply.Custom Fields')}}</h3>
                                            <div class="card-options">
                                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Customer Name -->
                                                <div class="col-2 mb-2">
                                                    <label>{{__('ticket_reply.Name')}}</label>
                                                </div>
                                                <div class="col-10">
                                                    <span class="font-weight-bold mr-2">{{ $ticket->name }}</span>
                                                </div>

                                                <!-- Customer Email -->
                                                <div class="col-2 mb-2">
                                                    <label>{{__('ticket_reply.Email')}}</label>
                                                </div>
                                                <div class="col-10">
                                                    <span class="font-weight-bold mr-2">{{ $ticket->email }}</span>
                                                </div>

                                                <!-- Phone Number -->
                                                @if($ticket->phone_number)
                                                <div class="col-2 mb-2">
                                                    <label>{{__('ticket_reply.Phone Number')}}</label>
                                                </div>
                                                <div class="col-10">
                                                    <span class="font-weight-bold mr-2">{{ $ticket->phone_number }}</span>
                                                </div>
                                                @endif

                                                <!-- Custom Fields -->
                                                @for ($i = 1; $i <= 20; $i++)
                                                    @if ($ticket->{'custom' . $i})
                                                        <div class="col-2 mb-2">
                                                            <label>{{ json_decode(\App\Models\CustomField::find($i)?->name)?->English }}</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <span class="font-weight-bold mr-2">{{ $ticket->{'custom' . $i} }}</span>
                                                        </div>
                                                    @endif
                                                @endfor

                                            </div>
                                        </div>
                                    </div>

                                    {{-- PBM Information Card --}}
                                    @if($ticket->user_type || $ticket->pic_id || $ticket->kementerian_id || $ticket->agensi_id || $ticket->ticket_type_id || $ticket->kategori_aduan || $ticket->nombor_serahan || $ticket->jenis_permohonan || $ticket->lesen_id || $ticket->bl_no)
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Ticket Information</h3>
                                            <div class="card-options">
                                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @if($ticket->pic_id)
                                                <div class="col-2 mb-2">
                                                    <label>Created By (PIC)</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->pic->name ?? 'N/A' }}</span>
                                                    @if($ticket->pic)
                                                        <br><small class="text-muted">{{ $ticket->pic->email }}</small>
                                                        @if($ticket->pic->phone_number)
                                                            <br><small class="text-muted">{{ $ticket->pic->phone_number }}</small>
                                                        @endif
                                                    @endif
                                                </div>
                                                @endif

                                                @if($ticket->user_type)
                                                <div class="col-2 mb-2">
                                                    <label>Jenis Pengadu</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">
                                                        @if($ticket->user_type == 'self')
                                                            Diri Sendiri
                                                        @elseif($ticket->user_type == 'other')
                                                            Anggota/Pegawai Lain
                                                        @elseif($ticket->user_type == 'public')
                                                            Syarikat/Orang Awam
                                                        @else
                                                            {{ ucfirst($ticket->user_type) }}
                                                        @endif
                                                    </span>
                                                </div>
                                                @endif

                                                @if($ticket->kementerian_id)
                                                <div class="col-2 mb-2">
                                                    <label>Kementerian</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->kementerian->nama ?? 'N/A' }}</span>
                                                </div>
                                                @endif

                                                @if($ticket->agensi_id)
                                                <div class="col-2 mb-2">
                                                    <label>Bahagian/Agensi/Seksyen</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->agensi->nama ?? 'N/A' }}</span>
                                                </div>
                                                @endif

                                                @if($ticket->ticket_type_id)
                                                <div class="col-2 mb-2">
                                                    <label>Jenis Aduan/Pertanyaan</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->ticketType->name ?? 'N/A' }}</span>
                                                </div>
                                                @endif

                                                @if($ticket->kategori_aduan)
                                                <div class="col-2 mb-2">
                                                    <label>Kategori Aduan</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->kategori_aduan }}</span>
                                                </div>
                                                @endif

                                                @if($ticket->nombor_serahan)
                                                <div class="col-2 mb-2">
                                                    <label>Nombor Serahan</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->nombor_serahan }}</span>
                                                </div>
                                                @endif

                                                @if($ticket->lesen_id)
                                                <div class="col-2 mb-2">
                                                    <label>Lesen</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->lesen->nama ?? 'N/A' }}</span>
                                                </div>
                                                @endif

                                                @if($ticket->jenis_permohonan)
                                                <div class="col-2 mb-2">
                                                    <label>Jenis Permohonan</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->jenis_permohonan }}</span>
                                                </div>
                                                @endif

                                                @if($ticket->bl_no)
                                                <div class="col-2 mb-2">
                                                    <label>BL No</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->bl_no }}</span>
                                                </div>
                                                @endif

                                                @php
                                                    $category = \App\Models\Category::find($ticket->category);
                                                    $isPertanyaanUmum = $category && $category->name == 'Pertanyaan Umum';
                                                @endphp

                                                @if(!$isPertanyaanUmum && $ticket->vendor_id)
                                                <div class="col-12 mb-2 mt-3">
                                                    <hr>
                                                    <h5 class="text-primary">Vendor Information</h5>
                                                </div>

                                                <div class="col-2 mb-2">
                                                    <label>Assigned Vendor</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    <span class="font-weight-bold">{{ $ticket->vendor->name ?? 'N/A' }}</span>
                                                    @if($ticket->vendor)
                                                        <br><small class="text-muted">{{ $ticket->vendor->company }}</small>
                                                        <br><small class="text-muted">{{ $ticket->vendor->email }}</small>
                                                        @if($ticket->vendor->no_hp)
                                                            <br><small class="text-muted">{{ $ticket->vendor->no_hp }}</small>
                                                        @endif
                                                    @endif
                                                </div>

                                                <div class="col-2 mb-2">
                                                    <label>Vendor Type</label>
                                                </div>
                                                <div class="col-10 mb-2">
                                                    @if($ticket->vendor)
                                                        @if($ticket->vendor->vendor_type == 'admin')
                                                            <span class="badge badge-primary">Admin</span>
                                                        @elseif($ticket->vendor->vendor_type == 'technical')
                                                            <span class="badge badge-info">Technical</span>
                                                        @endif
                                                    @else
                                                        <span class="font-weight-bold">N/A</span>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">{{$ticket->subject}}</h3>
                                            <div class="card-options">
                                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                                <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <span class="text-gray">{{__('ticket_reply.Contact')}} :</span>
                                                <div class="btn-group mt-2 mb-2">
                                                    <button type="button" class="dropdown-toggle text-primary font-weight-bolder" data-toggle="dropdown" style="text-transform: capitalize">
                                                        {{$ticket->name}} <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li class="dropdown-plus-title">
                                                            {{__('ticket_reply.Email')}} : {{$ticket->email}}
                                                        </li>
                                                        <li class="dropdown-plus-title">
                                                            IP : {{$ticket->ip}}
                                                        </li>
                                                        @if(user()->isadmin == 1 || userPermissionChecker('can_ban_emails') == true)
                                                        <li><a v-on:click="banEmail()"><i class="fa fa-eye-slash"></i>&nbsp;{{__('ticket_reply.Ban this email')}}</a></li>
                                                        @endif
                                                        @if(user()->isadmin == 1 || userPermissionChecker('can_ban_ips') == true)
                                                        <li><a v-on:click="banIp()"><i class="fa fa-eye-slash"></i>&nbsp;{{__('ticket_reply.Ban this IP')}}</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                &nbsp;<span class="text-gray">{{\Carbon\Carbon::parse($ticket->dt)->format('d/m/Y H:m:s')}}</span>
                                            </div>
                                            <p>{!! $ticket->message !!}</p>
                                            @if($ticket->attachments)
                                            @php($attachments = explode(",",trim($ticket->attachments,',')))
                                            @for($x = 0; $x < count($attachments); $x++)
                                                @php($attachment_detail = explode('#',$attachments[$x]))
                                                @if(count($attachment_detail) > 1)
                                                    {{-- New format: att_id#filename --}}
                                                    @php($attachment_file = \App\Models\Attachment::where('att_id',$attachment_detail[0])->first())
                                                    @if($attachment_file)
                                                        <a href="{{ asset('storage/attachment/'.$attachment_file->saved_name) }}" class="btn btn-success mr-2 mb-2" target="_blank"><i class="fa fa-download"></i> Attachment #{{$x+1}}</a>
                                                    @endif
                                                @else
                                                    {{-- Old format: just filename --}}
                                                    <a href="{{ asset('storage/attachment/ticket/'.rawurlencode($attachments[$x])) }}" class="btn btn-success mr-2 mb-2" target="_blank"><i class="fa fa-download"></i> Attachment #{{$x+1}}</a>
                                                @endif
                                            @endfor
                                            @endif
                                            @foreach($notes as $note)
                                            <div class="card bg-yellow-lightest">
                                                <div class="card-body">
                                                    <div>
                                                        <span class="text-gray">{{__('ticket_reply.Noted By')}} :</span>
                                                        <div class="btn-group mt-2 mb-2">
                                                            <span class="font-weight-bold mr-2">{{$note->noteby->name}}</span>
                                                        </div>
                                                        &nbsp;<span class="text-gray">{{\Carbon\Carbon::parse($note->dt)->format('d/m/Y H:m:s')}}</span>
                                                        @if($note->who == user()->id || user()->isadmin == 1 || userPermissionChecker('can_del_notes') == true)
                                                        <button class="btn btn-outline-danger float-right ml-2" v-on:click="deleteNote({{$note->id}})"><i class="fa fa-trash-o"></i></button>
                                                        @endif
                                                        @if($note->who == user()->id)
                                                        <button class="btn btn-outline-success float-right" data-toggle="modal" data-target="#exampleModalCenter" v-on:click="editNote({{$note}})"><i class="fa fa-edit"></i></button>
                                                        @endif
                                                    </div>
                                                    <p>{!! $note->message !!}</p>
                                                    @if($note->attachments != null && $note->attachments != "")
                                                        <a href="{{ asset('storage/attachment/' . $note->attachments) }}" class="btn btn-success mr-2 mb-2" target="_blank"><i class="fa fa-download"></i> Attachment</a>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="row" v-if="showNoteForm">
                                                <div class="col-md-12 ">
                                                    <form method="post" action="{{route('ticket.note')}}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group mb-0">
                                                            <label class="form-label">{{__('ticket_reply.Noted')}} <span class="text-danger">*</span></label>
                                                            <input type="hidden" name="tracking_id" value="{{$ticket->trackid}}">
                                                            <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                                            <textarea class="form-control" name="message" rows="4" required></textarea>
                                                        </div>
                                                        <br>
                                                        <div class="form-group">
                                                            <label class="form-label">{{__('ticket_reply.Attachment')}}</label>
                                                            <input type="file" name="file" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                            <br>
                                                            <small>Max file size: 20MB | File format: .gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf</small>
                                                        </div>
                                                        <button type="submit" class="btn btn-info"><i class="fe fe-file"></i>{{__('ticket_reply.Submit')}}</button>
                                                        <p class="mt-2">{{__('ticket_reply.Notes are hidden from customers!')}}</p>
                                                    </form>
                                                </div>
                                            </div>
                                            <br>
                                            <button type="button" class="btn btn-outline-info"  v-on:click="showNote"><i class="fe fe-file"></i>{{__('ticket_reply.Add Note')}}</button>
                                        </div>
                                    </div>
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default active">
                                            <div class="panel-heading " role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    @if($replies->count() > 1)
                                                        <button role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="btn btn-info mb-3 collapsed">
                                                            {{__('ticket_reply.Show previous replies')}} {{$replies->count() - 1}}
                                                        </button>
                                                    @endif
                                                </h4>
                                            </div>
                                            @if($replies->count() > 1)
                                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" style="">
                                            @else
                                                    <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
                                            @endif
                                                        <div class="panel-body">
                                                            @for($x = 0; $x < $replies->count()-1; $x++)
                                                                <div class="card">
                                                                    <div class="card-status  card-status-left @if($replies[$x]->staffid == 0) bg-info @else bg-success @endif br-bl-7 br-tl-7"></div>
                                                                    <div class="card-body">
                                                                        <div>
                                                                            <span class="text-gray">{{__('ticket_reply.Contact')}} :</span>
                                                                            <div class="btn-group mt-2 mb-2">
                                                                                <span class="font-weight-bold mr-2" style="text-transform: capitalize">{{$replies[$x]->name}}</span>
                                                                                <ul class="dropdown-menu" role="menu">
                                                                                    <li class="dropdown-plus-title">
                                                                                        {{__('ticket_reply.Email')}} : {{$replies[$x]->email}}
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
                                                                                <a href={{ asset('storage/attachment/'.$attachment_file->saved_name) }} class="btn btn-success mr-2 mb-2" target="_blank"><i class="fa fa-download"></i> Attachment #{{$y+1}}</a>
                                                                            @endfor
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    @if($replies->count() != 0)
                                                    <div class="panel-body">
                                                        <div class="card">
                                                            @php($total_num = $replies->count()-1)
                                                            <div class="card-status  card-status-left @if($replies[$total_num]->staffid == 0) bg-info @else bg-success @endif br-bl-7 br-tl-7"></div>
                                                            <div class="card-body">
                                                                <div>
                                                                    <span class="text-gray">{{__('ticket_reply.Contact')}} :</span>
                                                                    <div class="btn-group mt-2 mb-2">
                                                                        <span class="font-weight-bold mr-2" style="text-transform: capitalize">{{$replies[$total_num]->name}}</span>
                                                                        <ul class="dropdown-menu" role="menu">
                                                                            <li class="dropdown-plus-title">
                                                                                {{__('ticket_reply.Email')}} : {{$replies[$total_num]->email}}
                                                                            </li>
                                                                            <li class="dropdown-plus-title">
                                                                                IP : {{$replies[$total_num]->ip}}
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    &nbsp;<span class="text-gray">{{\Carbon\Carbon::parse($replies[$total_num]->dt)->format('d/m/Y H:m:s')}}</span>
                                                                </div>
                                                                <p>{!! $replies[$total_num]->message !!}</p>
                                                                @if($replies[$total_num]->attachments)
                                                                    @php($attachments = explode(",",trim($replies[$total_num]->attachments,',')))
                                                                    @for($y = 0; $y < count($attachments); $y++)
                                                                        @php($attachment_detail = explode('#',$attachments[$y]))
                                                                        @php($attachment_file = \App\Models\Attachment::where('att_id',$attachment_detail[0])->first())
                                                                        <a href={{ asset('storage/attachment/'.$attachment_file->saved_name) }} class="btn btn-success mr-2 mb-2" target="_blank"><i class="fa fa-download"></i> Attachment #{{$y+1}}</a>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                        </div>
                                    </div>
                                    @if(user()->isadmin == 1 || ( User()->id == $ticket->owner && userPermissionChecker('can_reply_tickets') == true) || (User()->user_type == 'vendor' && User()->vendor_type == 'admin') || (User()->user_type == 'vendor' && User()->vendor_type == 'technical' && $ticket->vendor_id == User()->id))
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="container">
                                                        <div class="row align-items-center flex-row-reverse">
                                                            <div class="col-md-12 col-sm-12 text-center">
                                                                <span>{{__('ticket_reply.Time Worked')}} : </span>
{{--                                                                <span id="timer-countup"></span>--}}
{{--                                                                <input type="text" class="short" name="time_worked" id="time_worked" size="10" value="00:00:00" />--}}
                                                                <div id="time_worked">00:00:00</div>
                                                                <input type="hidden" name="time_worked" id="time_worked_input" form="reply_form">
                                                                {{--<input type="text" name="time_worked" value="00:00:00" style="max-width: 70px !important;">--}}
                                                                <span id="buttonPausePlay"><button id="pauseButton"><i class="fe fe-pause-circle"></i></button></span>

                                                                <button id="resetButton"><i class="fe fe-refresh-cw"></i></button>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="card">
                                        <div class="card-body">
                                            <form method="post" action="{{route('ticket.reply.store')}}" id="reply_form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group mb-0">
                                                    <input type="hidden" name="tracking_id" v-model="replyTrackId">
                                                    <input type="hidden" name="ticket_id" v-model="replyTicketId">
                                                    <textarea class="form-control" name="message"  rows="4" v-model="replyMessage" required ref="messageInput"></textarea>
                                                    <div class="placeholder" v-if="!replyMessage" style="">{{ __('ticket_reply.Type your message or') }} <a href="javascript:" data-toggle="modal" data-target="#template">{{ __('ticket_reply.reply from template') }}</a>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">{{__('ticket_reply.Attachment')}}</label>
                                                    <div id="reply-attachment-container">
                                                        <div class="attachment-row mb-2">
                                                            <input type="file" name="file[1]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2">
                                                            <input type="file" name="file[2]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2" style="display: none;">
                                                            <input type="file" name="file[3]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2" style="display: none;">
                                                            <input type="file" name="file[4]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2" style="display: none;">
                                                            <input type="file" name="file[5]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                        <div class="attachment-row mb-2" style="display: none;">
                                                            <input type="file" name="file[6]" size="50" onchange="ValidateSingleInput(this);" class="form-control-file" accept=".gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf">
                                                        </div>
                                                    </div>
                                                    <button type="button" id="add-reply-attachment-btn" class="btn btn-sm btn-secondary" onclick="showNextReplyAttachment()">Add Another Attachment</button>
                                                    <br>
                                                    <small>Max file size: 20MB | {{ __('ticket_reply.File format') }}: .gif,.jpg,.jpeg,.png,.zip,.rar,.csv,.doc,.docx,.xls,.xlsx,.txt,.pdf</small>
                                                </div>
                                                <div class="form-group form-elements mb-3" style="display: none;">
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="signature" value="1" checked="">
                                                            <span class="custom-control-label">{{__('ticket_reply.Attach signature')}}</span>
                                                        </label>
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="no_notify" value="1">
                                                            <span class="custom-control-label">{{__('ticket_reply.Don\'t send email notification of this reply to the customer')}}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-info"><i class="fe fe-navigation"></i>&nbsp;{{__('ticket_reply.Submit reply')}}</button>
                                                <button type="button" class="btn btn-outline-info" v-on:click="saveToDraft"><i class="fe fe-folder-plus"></i>&nbsp;{{__('ticket_reply.Save and continue later')}}</button>

                                            </form>
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="row user-social-detail">
                                                @if(user()->isadmin == 1 || userPermissionChecker('can_export') == true)
                                                <div class="col-lg-6 col-sm-6 col-md-6 col-6">
                                                    <form method="post" action="{{route('ticket.reply.export_pdf')}}" target="_blank">
                                                        @csrf
                                                        <input type="hidden" value="{{$ticket->id}}" name="id">
                                                        <button type="submit" class="btn btn-success btn-block">{{__('ticket_reply.Print Ticket')}}</button>
                                                    </form>
                                                </div>
                                                @endif
                                                @if(user()->isadmin == 1 || userPermissionChecker('can_export') == true)
                                                <div class="col-lg-6 col-sm-6 col-md-6 col-6">
                                                    <form method="post" action="{{route('ticket.reply.export_with_notes_pdf')}}" target="_blank">
                                                        @csrf
                                                        <input type="hidden" value="{{$ticket->id}}" name="id">
                                                        <button type="submit" class="btn btn-success btn-block">{{__('ticket_reply.Print Ticket & Notes')}}</button>
                                                    </form>
                                                </div>
                                                @endif
                                                @if($ticket->status == 3)
                                                    <div class="col-lg-12 col-sm-12 col-md-12 col-12 mt-2">
                                                        <button type="button" class="btn btn-info btn-block" v-on:click="changeStatus(1)">{{__('ticket_reply.Open Ticket')}}</button>
                                                    </div>
                                                @else
                                                    @if(user()->isadmin == 1 || userPermissionChecker('can_resolve') == true)
                                                        <div class="col-lg-12 col-sm-12 col-md-12 col-12 mt-2">
                                                            <button type="button" class="btn btn-danger btn-block" v-on:click="changeStatus(3)">{{__('ticket_reply.Close Ticket')}}</button>
                                                        </div>
                                                    @endif
                                                @endif

{{--                                                <div class="col-lg-3 col-sm-3 col-3">--}}
{{--                                                    <button type="button" class="btn btn-success"><i class="fe fe-edit mr-2"></i>Edit</button>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-3 col-sm-3 col-3">--}}
{{--                                                    <button type="button" class="btn btn-primary"><i class="fe fe-printer mr-2"></i>Print</button>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-lg-6 col-sm-6 col-6">--}}
{{--                                                    <div class="dropdown">--}}
{{--                                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">--}}
{{--                                                            More Action--}}
{{--                                                        </button>--}}
{{--                                                        <div class="dropdown-menu">--}}
{{--                                                            <a class="dropdown-item" href="javascript:void(0)">Dropdown</a>--}}
{{--                                                            <a class="dropdown-item" href="javascript:void(0)">Dropdown link</a>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">{{ __('ticket_reply.Action') }}</h3>
                                        </div>
                                        <div class="row m-2">

                                            <div class="col-5 mb-2">
                                                <label>{{__('ticket_reply.Change status to')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <div class="dropdown">
                                                    <button type="button" class="dropdown-toggle font-weight-bold" data-toggle="dropdown">{{statusName($ticket->status)}}</button>
                                                    <div class="dropdown-menu">
                                                        @php($statusLookups = \App\Models\LookupStatusLog::where('is_active', true)->orderBy('order', 'ASC')->get())
                                                        @foreach($statusLookups as $statusLookup)
                                                            @if($statusLookup->id == 3 && !(user()->isadmin == 1 || userPermissionChecker('can_resolve') == true))
                                                                @continue
                                                            @endif
                                                            <button class="dropdown-item" v-on:click="changeStatus({{$statusLookup->id}})" @if($ticket->status == $statusLookup->id) style="display: none" @endif>
                                                                <span class="badge" style="background-color: {{$statusLookup->color}}; color: white; margin-right: 8px;">{{$statusLookup->nama}}</span>
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @if(user()->isadmin == 1 || userPermissionChecker('can_change_cat') == true || userPermissionChecker('can_change_own_cat') == true)
                                            <div class="col-5 mb-2">
                                                <label>{{__('ticket_reply.Move ticket to')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <div class="dropdown">
                                                    <button type="button" class="dropdown-toggle font-weight-bold" data-toggle="dropdown">{{categoryName($ticket->category)->name}}</button>
                                                    <div class="dropdown-menu">
                                                        @foreach($categories as $category)
                                                            <button class="dropdown-item" @if($category->id == $ticket->category) style="display: none" @endif v-on:click="changeCategory({{$category->id}})">{{$category->name}}</button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="col-5 mb-2">
                                                <label>{{__('ticket_reply.Change priority to')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <div class="dropdown">
                                                    <button type="button" class="dropdown-toggle font-weight-bold" data-toggle="dropdown">{{priorityName($ticket->priority)}}</button>
                                                    <div class="dropdown-menu">
                                                        @foreach($activePriorities as $priority)
                                                            <button class="dropdown-item" v-on:click="changePriority({{ $priority->priority_value }})" @if($ticket->priority == $priority->priority_value) style="display: none" @endif>{{ $priority->name }}</button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @if(user()->isadmin == 1 || userPermissionChecker('can_assign_others') == true || userPermissionChecker('can_assign_self') == true)
                                            <div class="col-5 mb-2">
                                                <label>{{__('ticket_reply.Assign to')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <div class="dropdown">
                                                    <button type="button" class="dropdown-toggle font-weight-bold" data-toggle="dropdown">@if(findUser($ticket->owner)){{findUser($ticket->owner)->name}} @endif</button>
                                                    <div class="dropdown-menu">
                                                        @foreach($users as $user)
                                                            <button class="dropdown-item" v-on:click="changeOwner({{$user->id}})" @if($ticket->owner == $user->id) style="display: none" @endif>{{$user->name}}</button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @if(user()->isadmin == 1 || userPermissionChecker('can_del_tickets') == true)
                                            <div class="col-5 mb-2">
                                                <label>{{__('ticket_reply.Action')}}:</label>
                                            </div>
                                            <div class="col-7">
                                                <div class="dropdown">
                                                    <button type="button" class="dropdown-toggle font-weight-bold" data-toggle="dropdown">{{ __('ticket_reply.Select Action') }}</button>
                                                    <div class="dropdown-menu">
                                                        <button class="dropdown-item" v-on:click="deleteTicket()" >{{__('ticket_reply.Delete ticket')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">{{ __('ticket_reply.Cc Email') }}</h3>
                                        </div>
                                        <div class="form-group m-3">
                                            <form id="cc-email-form" method="post" action="{{ route('ticket.reply.add_cc_email') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $ticket->id }}">
                                                <div id="cc-email-container">
                                                    {{-- Display Existing CC Emails --}}
                                                    @if (!empty($ticket->cc_email))
                                                        @foreach (json_decode($ticket->cc_email) as $cc_email)
                                                            <div class="input-group mb-2 cc-email-row">
                                                                <input type="email" class="form-control" name="cc_emails[]" placeholder="abc@def.xyz" value="{{ $cc_email }}" readonly>
                                                                <span class="input-group-append">
                                                                    <button type="button" class="btn btn-danger remove-cc-email">Remove</button>
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <button type="button" id="add-cc-email" class="btn btn-secondary">{{ __('ticket_reply.Add Email') }}</button>
                                                    <button type="submit" class="btn btn-primary">{{ __('ticket_reply.Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @if(User()->user_type == 'vendor' && User()->vendor_type == 'admin')
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">{{__('ticket_reply.Assign Ticket')}}</h3>
                                            <div class="card-options">
                                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- Vendor Admin Assignment Form -->
                                            <form id="vendor-assignment-form" method="post" action="{{ route('ticket.reply.assign.vendor') }}">
                                                @csrf
                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                                <div class="form-group">
                                                    <label class="form-label">Jenis Vendor</label>
                                                    <select name="vendor_type" id="vendor-type-select" class="form-control custom-select" required>
                                                        <option value="">Pilih Jenis Vendor</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="technical">Technical</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label">Assign to Vendor</label>
                                                    <select name="vendor_id" id="vendor-select" class="form-control custom-select" required>
                                                        <option value="">Select Vendor</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block">Assign to Vendor</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">{{__('ticket_reply.Ticket Details')}}</h3>
                                            <div class="card-options">
                                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Tracking ID')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{$ticket->trackid}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Ticket number')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{$ticket->id}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Created on')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{\Carbon\Carbon::parse($ticket->dt)->format('d-m-Y H:m:s')}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Ticket status')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{statusName($ticket->status)}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Updated')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{\Carbon\Carbon::parse($ticket->lastchange)->format('d-m-Y H:m:s')}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Category')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{categoryName($ticket->category)->name}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Sub Category')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{\App\Models\SubCategory::find($ticket->sub_category)->name ?? 'Unknown Sub Category'}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('aduan_pertanyaan.Label')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{ ucfirst($ticket->aduan_pertanyaan) }}</span>
                                                </div>

                                                @if($ticket->kaedah_melapor_id)
                                                <div class="col-5 mb-2">
                                                    <label>{{__('lookup_kaedah_melapor.Kaedah Melapor')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{\App\Models\LookupKaedahMelapor::find($ticket->kaedah_melapor_id)->nama ?? 'Unknown Kaedah Melapor'}}</span>
                                                </div>
                                                @endif

                                                @if($ticket->agensi_id)
                                                <div class="col-5 mb-2">
                                                    <label>{{__('lookup_agensi.Agensi')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{\App\Models\LookupAgensi::find($ticket->agensi_id)->nama ?? 'Unknown Agensi'}}</span>
                                                </div>
                                                @endif

                                                @if($ticket->lesen_id)
                                                <div class="col-5 mb-2">
                                                    <label>{{__('main.Lesen')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{$ticket->lesen->nama ?? 'Unknown Lesen'}}</span>
                                                </div>
                                                @endif

                                                @if($ticket->bl_no)
                                                <div class="col-5 mb-2">
                                                    <label>BL No:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{$ticket->bl_no}}</span>
                                                </div>
                                                @endif

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Replies')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{$ticket->replies}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Priority')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{priorityName($ticket->priority)}}</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Last replier')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    @if($ticket->lastreplier == 0)
                                                        <span class="font-weight-bold mr-2" style="text-transform: capitalize">{{$ticket->name}}</span>
                                                    @else
                                                    <span class="font-weight-bold mr-2" style="text-transform: capitalize">{{findUser($ticket->lastreplier)->name}}</span>
                                                    @endif
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Owner')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2" style="text-transform: capitalize">@if(findUser($ticket->owner)){{findUser($ticket->owner)->name}}@endif</span>
                                                </div>

                                                <div class="col-5 mb-2">
                                                    <label>{{__('ticket_reply.Time worked')}}:</label>
                                                </div>
                                                <div class="col-7">
                                                    <span class="font-weight-bold mr-2">{{$ticket->time_worked}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">{{__('ticket_reply.Ticket History')}}</h3>
                                            <div class="card-options">
                                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <?php
                                                if ($ticket->history != null || $ticket->history != '')
                                                    {
                                                $history = array_filter(explode('</li>', $ticket->history));
                                                foreach ($history as $history_edit) {
                                                    $history_piece = str_replace('<li class="smaller"">', '', $history_edit);
                                                    if ($history_piece != '')
                                                        {
                                                            $date_and_contents = explode(' | ', $history_piece);
                                                        }
                                                ?>
                                                    <div class="col-5 mb-2">
                                                        <ul>
                                                            <li>{!! $date_and_contents[0] !!}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-7 mb-2">
                                                        <span class="font-weight-bold mr-2" style="text-transform: capitalize">{!! $date_and_contents[1] !!}</span>
                                                    </div>
                                                    <hr>
                                                <?php }} ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- EDIT NOTE MODAL -->
                            <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('ticket_reply.Edit Note') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="closeButton">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('ticket.note.edit')}}" id="edit_note">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="note_id" v-model="noteId">
                                                <div class="form-group">
                                                    <label for="message-text" class="form-control-label">{{ __('ticket_reply.Message') }}:</label>
                                                    <textarea class="form-control" id="message-text" name="message" v-model="note"></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-round btn-default" data-dismiss="modal" v-on:click="closeButton">{{ __('ticket_reply.Close') }}</button>
                                            <button type="submit" class="btn btn-round btn-primary" form="edit_note">{{ __('ticket_reply.Save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- EDIT NOTE CLOSED -->

                            <!-- CHOOSE REPLY TEMPLATE MODAL -->
                            <div class="modal fade bd-example-modal-lg" id="template" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="templateTitle">{{ __('ticket_reply.Canned Responses') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="closeButton">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="form-label">{{ __('ticket_reply.Select a canned response') }}</label>
                                                <select name="template" id="mySelect" class="form-control custom-select" onchange="setMessage(this)">
                                                    <option value="" data-message="">Select</option>
                                                    @foreach($template_reply as $template)
                                                    <option value="{{$template->id}}" data-message="{{$template->message}}">{{$template->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-round btn-default" data-dismiss="modal" v-on:click="closeButton">{{ __('ticket_reply.Close') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CHOOSE REPLY TEMPLATE CLOSED -->
                            <!-- ROW-1 OPEN -->
                            <div class="row"></div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/js/easytimer.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("textarea").focus(function(){
                $(".placeholder").css("display", "none");
            });


            $('#add-cc-email').click(function () {
            $('#cc-email-container').append(`
                <div class="input-group mb-2 cc-email-row">
                    <input type="email" class="form-control" name="cc_emails[]" placeholder="abc@def.xyz">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-danger remove-cc-email">Remove</button>
                    </span>
                </div>
            `);
        });

        // Remove a CC email input row
        $(document).on('click', '.remove-cc-email', function () {
            $(this).closest('.cc-email-row').remove();
        });
        });

        // Remove a CC email row
        $(document).on('click', '.remove-cc-email', function () {
            $(this).closest('.cc-email-row').remove();
        });

        // Assignment Kumpulan Pengguna dependent dropdown functionality for ticket assignment
        $(document).ready(function() {
            $('#assignment-kumpulan-pengguna-select-reply').on('change', function() {
                var kumpulanPenggunaId = $(this).val();
                var ownerSelect = $('#assignment-user-select-reply');

                // Reset owner dropdown to default options
                ownerSelect.html('<option value="">Select Team Member</option>');

                if (kumpulanPenggunaId) {
                    // Fetch team members for selected kumpulan pengguna
                    $.ajax({
                        url: '/get-team/' + kumpulanPenggunaId,
                        type: 'GET',
                        success: function(response) {
                            if (response.length > 0) {
                                $.each(response, function(index, teamMember) {
                                    ownerSelect.append('<option value="' + teamMember.id + '">' + teamMember.name + '</option>');
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching team members:', xhr, status, error);
                            alert('Error fetching team members: ' + error);
                        }
                    });
                }
            });

            // Vendor Type dependent dropdown functionality for vendor assignment
            $('#vendor-type-select').on('change', function() {
                var vendorType = $(this).val();
                var vendorSelect = $('#vendor-select');

                // Reset vendor dropdown to default options
                vendorSelect.html('<option value="">Select Vendor</option>');

                if (vendorType) {
                    // Fetch vendors for selected vendor type
                    $.ajax({
                        url: '/get-vendors/' + vendorType,
                        type: 'GET',
                        success: function(response) {
                            if (response.length > 0) {
                                $.each(response, function(index, vendor) {
                                    vendorSelect.append('<option value="' + vendor.id + '">' + vendor.name + ' (' + vendor.company + ')</option>');
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching vendors:', xhr, status, error);
                            alert('Error fetching vendors: ' + error);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function(){

            $("textarea").blur(function(){
                var message = $.trim($("textarea").val());
                if (message === '')
                {
                    $(".placeholder").css("display", "initial");
                }
            });

        });
    </script>
    <script>
            var timer = new easytimer.Timer();
            timer.start();

            timer.addEventListener('secondsUpdated', function (e) {
                $('#time_worked').html(timer.getTimeValues().toString());
                $timer_now = $('#time_worked').text();
                $('#time_worked_input').val($timer_now);
            });
            $(document).ready(function(){

                $("#pauseButton").click(function(){
                    console.log('pause');
                    var div = ( document.all ) ? document.all['buttonPausePlay'] : document.getElementById('buttonPausePlay');
                    div.innerHTML = '<button id="playButton"><i class="fe fe-play-circle"></i></button>';
                    timer.pause();
                });

                $("#resetButton").click(function(){
                    console.log('reset');
                    timer.reset();
                });

                $("#playButton").click(function(){
                    console.log('resume');
                    var div = ( document.all ) ? document.all['buttonPausePlay'] : document.getElementById('buttonPausePlay');
                    div.innerHTML = '<button id="pauseButton"><i class="fe fe-pause-circle"></i></button>';
                    timer.start();
                });
            });

    </script>
    </script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                noteId : '',
                note : '',
                showNoteForm : false,
                replyTrackId : '{!!$ticket->trackid!!}',
                replyTicketId : '{!!$ticket->id!!}',
                replyMessage : '{!! $draft->message !!}',
            },
            methods: {
                showNote: function () {
                    this.showNoteForm = !this.showNoteForm
                },
                editNote: function (note) {
                    console.log(note.id);
                    console.log(note.message);
                    this.noteId = note.id;
                    this.note = note.message;
                },
                deleteNote: function (note_id)
                {

                    Swal.fire({
                        title: "Confirm",
                        text: "Are you sure you want to delete?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes delete',
                        cancelButtonText: 'Stay on the page'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: '/ticket/note/delete',
                                data:{
                                    "_token": "{{ csrf_token() }}",
                                    "note_id":note_id,
                                },
                                success: function(data){
                                    location.reload();
                                }
                            });
                        }
                    });
                },
                deleteTicket: function ()
                {
                    Swal.fire({
                        title: "Confirm",
                        text: "Are you sure you want to delete this ticket?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes delete',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: '/ticket/reply/delete',
                                data:{
                                    "_token": "{{ csrf_token() }}",
                                    id      : "{{$ticket->id}}",
                                },
                                success: function(data){
                                    location.href = "{{route('ticket.index')}}";
                                }
                            });
                        }
                    });
                },
                closeButton: function () {

                    this.noteId = '';
                    this.note = '';
                },
                saveToDraft: function ()
                {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/ticket/reply/save_to_draft',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            ticket_id : this.replyTicketId,
                            message: this.replyMessage,
                        },
                        success: function(data){
                            location.reload();
                        }
                    });
                },
                changeCategory: function ($data)
                {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/ticket/reply/change_category',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id      : "{{$ticket->id}}",
                            category: $data,
                        },
                        success: function(data){
                            location.reload();
                        }
                    });
                },
                changeStatus: function ($data)
                {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/ticket/reply/change_status',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id      : "{{$ticket->id}}",
                            status: $data,
                        },
                        success: function(data){
                            location.reload();
                        }
                    });
                },
                changePriority: function ($data)
                {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/ticket/reply/change_priority',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id      : "{{$ticket->id}}",
                            priority: $data,
                        },
                        success: function(data){
                            location.reload();
                        }
                    });
                },
                changeOwner: function ($data)
                {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/ticket/reply/change_owner',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id      : "{{$ticket->id}}",
                            user_id : $data,
                        },
                        success: function(data){
                            location.reload();
                        }
                    });
                },
                banEmail: function ()
                {
                    Swal.fire({
                        title: "Confirm",
                        text: "Are you sure you want to ban this email?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes I am Sure',
                        cancelButtonText: 'Stay on the page'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: '/banned/emails/store_reply_page',
                                data:{
                                    "_token": "{{ csrf_token() }}",
                                    "email":'{!! $ticket->email !!}',
                                },
                                success: function(data){
                                    location.reload();
                                }
                            });
                        }
                    });

                },
                banIp: function ()
                {
                    Swal.fire({
                        title: "Confirm",
                        text: "Are you sure you want to ban this ip?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes I am Sure',
                        cancelButtonText: 'Stay on the page'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: '/banned/ips/store_reply_page',
                                data:{
                                    "_token": "{{ csrf_token() }}",
                                    "ip":'{!! $ticket->ip !!}',
                                },
                                success: function(data){
                                    location.reload();
                                }
                            });
                        }
                    });
                },

            },
        })
    </script>
    <script>
        function setMessage(sel)
        {
            var opt = sel.options[sel.selectedIndex];
            var myMsg = opt.dataset.message;
            if(myMsg === '')
            {
                $(".placeholder").css("display", "initial");
            }else{
                $(".placeholder").css("display", "none");

                myMsg = myMsg.replace(/%%HESK_ID%%/g, '{!! $ticket->id !!}');
                myMsg = myMsg.replace(/%%HESK_TRACKID%%/g, '{!! $ticket->trackid !!}');
                myMsg = myMsg.replace(/%%HESK_TRACK_ID%%/g, '{!! $ticket->trackid !!}');
                myMsg = myMsg.replace(/%%HESK_NAME%%/g, '{!! $ticket->name !!}');
                myMsg = myMsg.replace(/%%HESK_EMAIL%%/g, '{!! $ticket->email !!}');
                myMsg = myMsg.replace(/%%HESK_OWNER%%/g, '@if(findUser($ticket->owner)){!!findUser($ticket->owner)->name!!} @endif');

                <?php
                for ($i=1; $i<=50; $i++)
                {
                    echo 'myMsg = myMsg.replace(/%%HESK_custom'.$i.'%%/g, \''.$ticket['custom'.$i].'\');';
                }
                ?>

                $("textarea").val(myMsg);
            }
        }
    </script>
    <script>
        var _validFileExtensions = [".gif", ".jpg", ".jpeg", ".png", ".zip", ".rar", ".csv", ".doc", ".docx", ".xls", ".xlsx", ".txt", ".pdf"];
        var maxFileSize = 20 * 1024 * 1024; // 20MB in bytes
        
        function ValidateSingleInput(oInput) {
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length > 0) {
                    // Check file extension
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }

                    if (!blnValid) {
                        alert("Sorry, invalid attachment file format");
                        oInput.value = "";
                        return false;
                    }

                    // Check file size
                    if (oInput.files && oInput.files[0]) {
                        var fileSize = oInput.files[0].size;
                        if (fileSize > maxFileSize) {
                            alert("File size exceeds 20MB limit. Please choose a smaller file.");
                            oInput.value = "";
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        function showNextReplyAttachment() {
            var attachmentRows = document.querySelectorAll('#reply-attachment-container .attachment-row');
            var addButton = document.getElementById('add-reply-attachment-btn');
            
            for (var i = 0; i < attachmentRows.length; i++) {
                if (attachmentRows[i].style.display === 'none') {
                    attachmentRows[i].style.display = 'block';
                    
                    // Hide button if all 6 attachments are visible
                    if (i === attachmentRows.length - 1) {
                        addButton.style.display = 'none';
                    }
                    break;
                }
            }
        }
    </script>
@endsection
