@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/formwizard/smart_wizard.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/formwizard/smart_wizard_theme_arrows.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/formwizard/smart_wizard_theme_circles.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/formwizard/smart_wizard_theme_dots.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/forn-wizard/css/demo.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('team.Teams')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('team.Teams')}}</a></li>
								</ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')

						<!-- ROW-1 OPEN -->
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Team Members</h3>
                                        <div class="card-options">
                                            <a href="#teamRegistrationForm" class="btn btn-outline-primary">Register New Team Member</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="team_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="">No</th>
                                                    <th class="">{{__('team.Name')}}</th>
                                                    <th class="">{{__('team.Email')}}</th>
                                                    <th class="">{{__('team.Username')}}</th>
                                                    <th class="">{{__('team.Role')}}</th>
                                                    <th class="">{{__('team.Auto-Assign')}}</th>
                                                    <th class="">{{__('team.Status')}}</th>
                                                    <th class="">{{__('team.Action')}}</th>
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
                        <div class="row" id="teamRegistrationForm">
                            <div class="col-lg-12">
                                <div class="card accordion-wizard">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('team.Register New Team Member')}}</h3>
                                    </div>
                                    <div class="card-body">

                                        <form id="form" method="post" action="{{route('team.store')}}">
                                            @csrf
                                            <div class="list-group">
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('team.Profile information')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>{{__('team.Name')}}:</label>
                                                                        <input type="text" name="name" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>{{__('team.Email')}}:</label>
                                                                        <input type="text" name="email" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-5">
                                                                        <label>No. KP:</label>
                                                                        <input type="text" name="username" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="custom-switch">
                                                                            <input type="hidden" name="autoassign" value="0">
                                                                            <input type="checkbox" name="autoassign" class="custom-switch-input" value="1" checked>
                                                                            <span class="custom-switch-indicator"></span>
                                                                            <span class="custom-switch-description">{{__('team.Auto-assign tickets to this user')}}.</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Profile Fields -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Kementerian:</label>
                                                                        <select name="kementerian_id" id="kementerian_id_modal" class="form-control">
                                                                            <option value="">Pilih Kementerian</option>
                                                                            @foreach($kementerian as $k)
                                                                                <option value="{{$k->id}}">{{$k->nama}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Agensi:</label>
                                                                        <select name="agensi_id" id="agensi_id_modal" class="form-control">
                                                                            <option value="">Pilih Agensi</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Sub Agensi:</label>
                                                                        <select name="sub_agensi_id" id="sub_agensi_id_modal" class="form-control">
                                                                            <option value="">Pilih Sub Agensi</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Contact Information -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>No Pejabat:</label>
                                                                        <input type="text" name="no_pejabat" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>No HP:</label>
                                                                        <input type="text" name="no_hp" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>No. Fax:</label>
                                                                        <input type="text" name="no_fax" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Address Information -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Alamat Pejabat:</label>
                                                                        <textarea name="alamat_pejabat" class="form-control" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Poskod:</label>
                                                                        <input type="text" name="poskod" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Negeri:</label>
                                                                        <select name="negeri" class="form-control">
                                                                            <option value="">Pilih Negeri</option>
                                                                            <option value="Johor">Johor</option>
                                                                            <option value="Kedah">Kedah</option>
                                                                            <option value="Kelantan">Kelantan</option>
                                                                            <option value="Kuala Lumpur">Kuala Lumpur</option>
                                                                            <option value="Labuan">Labuan</option>
                                                                            <option value="Melaka">Melaka</option>
                                                                            <option value="Negeri Sembilan">Negeri Sembilan</option>
                                                                            <option value="Pahang">Pahang</option>
                                                                            <option value="Penang">Penang</option>
                                                                            <option value="Perak">Perak</option>
                                                                            <option value="Perlis">Perlis</option>
                                                                            <option value="Putrajaya">Putrajaya</option>
                                                                            <option value="Sabah">Sabah</option>
                                                                            <option value="Sarawak">Sarawak</option>
                                                                            <option value="Selangor">Selangor</option>
                                                                            <option value="Terengganu">Terengganu</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('team.Permission')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group form-elements">
                                                                <div class="form-label">{{__('team.Account Type')}}</div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="isadmin" value="1" v-on:click="admin" checked>
                                                                        <span class="custom-control-label">{{__('team.Administrator (access to all features and categories)')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="isadmin" value="0" v-on:click="staff">
                                                                        <span class="custom-control-label">{{__('team.Staff (you can limit features and categories)')}}</span>
                                                                    </label>

                                                                    <!-- Staff Only -->
                                                                    <div class="form-group form-elements mt-5" v-if="showStaff">
                                                                        <div class="form-label">{{__('team.Categories')}}</div>
                                                                        <div class="custom-controls-stacked">
                                                                            <div class="row">
                                                                                @foreach($categories as $category)
                                                                                    <div class="col-4">
                                                                                        <label class="custom-control custom-checkbox">
                                                                                            <input type="checkbox" class="custom-control-input" name="categories[]" value="{{$category->id}}" >
                                                                                            <span class="custom-control-label">{{$category->name}}</span>
                                                                                        </label>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group form-elements mt-5" v-if="showStaff">
                                                                        <div class="form-label">{{__('team.Features')}}</div>
                                                                        <div class="custom-controls-stacked">
                                                                            <div class="row">
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_tickets" checked>
                                                                                        <span class="custom-control-label">{{__('team.View tickets')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_reply_tickets" checked>
                                                                                        <span class="custom-control-label">{{__('team.Reply to tickets')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_del_tickets" >
                                                                                        <span class="custom-control-label">{{__('team.Delete tickets')}}</span>
                                                                                    </label>
                                                                                </div>
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_edit_tickets" >--}}
{{--                                                                                        <span class="custom-control-label">Edit ticket replies</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_merge_tickets" >--}}
{{--                                                                                        <span class="custom-control-label">Merge tickets</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_resolve" checked>
                                                                                        <span class="custom-control-label">{{__('team.Can resolve tickets')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_submit_any_cat" checked>
                                                                                        <span class="custom-control-label">{{__('team.Can submit tickets to any category')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_del_notes" >
                                                                                        <span class="custom-control-label">{{__('team.Delete any ticket notes')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_change_cat" checked>
                                                                                        <span class="custom-control-label">{{__('team.Change ticket category (to any)')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_change_own_cat" >
                                                                                        <span class="custom-control-label">{{__('team.Change ticket category (to allowed)')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_kb" >
                                                                                        <span class="custom-control-label">{{__('team.Manage knowledgebase')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_cat" >
                                                                                        <span class="custom-control-label">{{__('team.Manage categories')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_canned" >
                                                                                        <span class="custom-control-label">{{__('team.Manage canned responses')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_ticket_tpl" >
                                                                                        <span class="custom-control-label">{{__('team.Manage ticket templates')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_settings" >
                                                                                        <span class="custom-control-label">{{__('team.Manage help desk settings')}}</span>
                                                                                    </label>
                                                                                </div>

{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_add_archive" >--}}
{{--                                                                                        <span class="custom-control-label">Can tag tickets</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_assign_self" checked>
                                                                                        <span class="custom-control-label">{{__('team.Can assign tickets to self')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_assign_others" >
                                                                                        <span class="custom-control-label">{{__('team.Can assign tickets to others')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_unassigned" checked>
                                                                                        <span class="custom-control-label">{{__('team.Can view unassigned tickets')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_ass_others" >
                                                                                        <span class="custom-control-label">{{__('team.Can assign tickets to others')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_ass_by" >
                                                                                        <span class="custom-control-label">{{__('team.Can view tickets he/she assigned to others')}}</span>
                                                                                    </label>
                                                                                </div>
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_run_reports" >--}}
{{--                                                                                        <span class="custom-control-label">Can run reports (own)</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_run_reports_full" >
                                                                                        <span class="custom-control-label">{{__('team.Can run reports (all)')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_export" >
                                                                                        <span class="custom-control-label">{{__('team.Can export tickets')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                {{-- <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_online" checked>
                                                                                        <span class="custom-control-label">{{__('team.Can view online staff members')}}</span>
                                                                                    </label>
                                                                                </div> --}}
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_ban_emails" >
                                                                                        <span class="custom-control-label">{{__('team.Can ban emails')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_unban_emails" >
                                                                                        <span class="custom-control-label">{{__('team.Can unban emails (enables Can ban emails)')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_ban_ips" >
                                                                                        <span class="custom-control-label">{{__('team.Can ban ips')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_unban_ips" >
                                                                                        <span class="custom-control-label">{{__('team.Can unban ips (enables Can ban ips)')}}</span>
                                                                                    </label>
                                                                                </div>
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_privacy" >--}}
{{--                                                                                        <span class="custom-control-label">Can anonymize tickets</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_service_msg" >--}}
{{--                                                                                        <span class="custom-control-label">Edit service messages</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_email_tpl" >--}}
{{--                                                                                        <span class="custom-control-label">Edit email templates</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Staff Only End -->

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('team.Signature')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group">
                                                                <label>{{__('team.Signature (max 1000 chars)')}}</label>
                                                                <textarea class="form-control" name="signature" rows="4"></textarea>
                                                                <label>{{__('team.HTML code is not allowed. Links will be clickable')}}.</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('team.Preferences')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group form-elements">
                                                                <div class="form-label">{{__('team.After replying to a ticket')}}</div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="afterreply" value="0" checked>
                                                                        <span class="custom-control-label">{{__('team.Show the ticket I just replied to')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="afterreply" value="1">
                                                                        <span class="custom-control-label">{{__('team.Return to main administration page')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="afterreply" value="2">
                                                                        <span class="custom-control-label">{{__('team.Open next ticket that needs my reply')}}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group form-elements m-0">
                                                                <div class="form-label">{{__('team.Defaults')}}</div>
                                                                <div class="custom-controls-stacked">
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="autostart" value="1">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="autostart" value="1" checked>--}}
{{--                                                                        <span class="custom-control-label">{{__('team.Automatically start timer when I open a ticket')}}</span>--}}
{{--                                                                    </label>--}}
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_customer_new" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_customer_new" value="1" checked>
                                                                        <span class="custom-control-label">{{__('team.Select notify customer option in the new ticket form')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_customer_reply" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_customer_reply" value="1" checked>
                                                                        <span class="custom-control-label">{{__('team.Select notify customer option in the ticket reply form')}}</span>
                                                                    </label>
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="show_suggested" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="show_suggested" value="1" checked>--}}
{{--                                                                        <span class="custom-control-label">{{__('team.Show what knowledgebase articles were suggested to customers')}}</span>--}}
{{--                                                                    </label>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('team.Notifications')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group form-elements m-0">
                                                                <div class="form-label">{{__('team.The help desk will send an email notification when')}}:</div>
                                                                <div class="custom-controls-stacked mb-4">
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="notify_new_unassigned" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="notify_new_unassigned" value="1" checked>--}}
{{--                                                                        <span class="custom-control-label">{{__('team.A new ticket is submitted with owner: Unassigned')}}</span>--}}
{{--                                                                    </label>--}}
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_new_my" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_new_my" value="1" checked>
                                                                        <span class="custom-control-label">{{__('team.A new ticket is submitted with owner: Assigned to me')}}</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked mb-4">
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="notify_reply_unassigned" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="notify_reply_unassigned" value="1" checked>--}}
{{--                                                                        <span class="custom-control-label">{{__('team.Client responds to a ticket with owner: Unassigned')}}</span>--}}
{{--                                                                    </label>--}}
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_reply_my" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_reply_my" value="1" checked>
                                                                        <span class="custom-control-label">{{__('team.Client responds to a ticket with owner: Assigned to me')}}</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked mb-4">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_assigned" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_assigned" value="1" checked>
                                                                        <span class="custom-control-label">{{__('team.A ticket is assigned to me')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_note" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_note" value="1" checked>
                                                                        <span class="custom-control-label">{{__('team.Someone adds a note to a ticket assigned to me')}}</span>
                                                                    </label>
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="notify_pm" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="notify_pm" value="1" checked>--}}
{{--                                                                        <span class="custom-control-label">{{__('team.A private message is sent to me')}}</span>--}}
{{--                                                                    </label>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                            </div>
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
        var app = new Vue({
            el: '#app',
            data: {
                showStaff : false,
            },
            methods: {
                staff: function () {
                    this.showStaff = !this.showStaff
                },
                admin: function () {
                    this.showStaff = !this.showStaff
                },
            },
        })
    </script>

    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('#team_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/teams',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'user', name: 'user'},
                    {data: 'isadmin_edit', name: 'isadmin_edit'},
                    {data: 'autoassign_edit', name: 'autoassign_edit'},
                    {data: 'is_active', name: 'is_active'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#team_table tbody').on('click', 'td button#delete', function (){
                Swal.fire({
                    title: "Confirm",
                    text: "Are you sure you want to delete?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/teams/remove', {
                            id: $(this).data('id'),
                        })
                            .then(function (response) {
                                location.reload();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                    }
                });
            });

            $('#team_table tbody').on('click', 'button#status', function (){
                Swal.fire({
                    title: "Confirm",
                    text: "Are you sure you want to change status for this user?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/teams/status', {
                            id: $(this).data('id'),
                        })
                            .then(function (response) {
                                location.reload();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                    }
                });
            });
            
            // Dependent dropdowns for team registration form
            $('#kementerian_id_modal').change(function() {
                var kementerianId = $(this).val();
                loadAgensiModal(kementerianId);
                $('#sub_agensi_id_modal').html('<option value="">Pilih Sub Agensi</option>');
            });

            $('#agensi_id_modal').change(function() {
                var agensiId = $(this).val();
                loadSubAgensiModal(agensiId);
            });

            function loadAgensiModal(kementerianId, selectedAgensiId = null) {
                if (kementerianId) {
                    $.ajax({
                        url: '/get-agensi/' + kementerianId,
                        type: 'GET',
                        success: function(response) {
                            var options = '<option value="">Pilih Agensi</option>';
                            response.forEach(function(agensi) {
                                var selected = selectedAgensiId == agensi.id ? 'selected' : '';
                                options += '<option value="' + agensi.id + '" ' + selected + '>' + agensi.nama + '</option>';
                            });
                            $('#agensi_id_modal').html(options);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading agensi:', error);
                            $('#agensi_id_modal').html('<option value="">Error loading data</option>');
                        }
                    });
                } else {
                    $('#agensi_id_modal').html('<option value="">Pilih Agensi</option>');
                }
            }

            function loadSubAgensiModal(agensiId, selectedSubAgensiId = null) {
                if (agensiId) {
                    $.ajax({
                        url: '/get-sub-agensi/' + agensiId,
                        type: 'GET',
                        success: function(response) {
                            var options = '<option value="">Pilih Sub Agensi</option>';
                            response.forEach(function(subAgensi) {
                                var selected = selectedSubAgensiId == subAgensi.id ? 'selected' : '';
                                options += '<option value="' + subAgensi.id + '" ' + selected + '>' + subAgensi.nama + '</option>';
                            });
                            $('#sub_agensi_id_modal').html(options);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading sub agensi:', error);
                            $('#sub_agensi_id_modal').html('<option value="">Error loading data</option>');
                        }
                    });
                } else {
                    $('#sub_agensi_id_modal').html('<option value="">Pilih Sub Agensi</option>');
                }
            }

        });
    </script>
    <script src="{{ URL::asset('assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js') }}"></script>
{{--    <script src="{{ URL::asset('assets/plugins/chart/Chart.bundle.js') }}"></script>--}}
{{--    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>--}}
{{--    <script src="{{ URL::asset('assets/plugins/formwizard/jquery.smartWizard.js') }}"></script>--}}
{{--    <script src="{{ URL::asset('assets/plugins/formwizard/fromwizard.js') }}"></script>--}}
    <script src="{{ URL::asset('assets/js/advancedform.js') }}"></script>

@endsection
