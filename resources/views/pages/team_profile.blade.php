@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" />

@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">{{__('team_profile.Team Profile')}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{__('team_profile.Team Profile')}}</a></li>
            <li class="breadcrumb-item"><a href="#">{{$user->name}}</a></li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
						<!-- ROW-1 OPEN -->
						<div class="row" id="user-profile">
                            <div class="col-md-12 col-lg-12 mb-2">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i> {{ $error }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<div class="wideget-user">
											<div class="row">
												<div class="col-lg-6 col-md-12">
													<div class="wideget-user-desc d-sm-flex">
														<div class="wideget-user-img">
															<img class="" src="@if($user->profile_picture) {{asset('storage/profile_pic/'.$user->profile_picture)}} @else {{URL::asset('assets/images/users/10.jpg')}} @endif" alt="img">
														</div>
														<div class="user-wrap">
															<h4>{{$user->name}}</h4>
															<h6 class="text-muted mb-3">@if($user->isadmin == 1) {{__('team_profile.Administrator')}} @else {{__('team_profile.Staff')}} @endif</h6>
                                                            <button class="btn btn-secondary mt-1 mb-1" data-toggle="modal" data-target="#changePassword"><i class="fa fa-lock"></i> {{__('team_profile.Change Password')}}</button>
                                                        </div>
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="wideget-user-info">
														<div class="wideget-user-warap">
															<div class="wideget-user-warap-l">
																<h4 class="text-danger">{{$total_ticket}}</h4>
																<p>{{__('team_profile.Total Ticket')}}</p>
															</div>
														</div>
                                                        <div class="wideget-user-warap">
                                                            <div class="wideget-user-warap-l">
                                                                <h4 class="text-danger">{{$total_resolved}}</h4>
                                                                <p>{{__('team_profile.Total Resolved')}}</p>
                                                            </div>
                                                        </div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- COL-END -->
						</div>
						<!-- ROW-1 CLOSED -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card accordion-wizard">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('team_profile.Update Profile')}} {{$user->name}}</h3>
                                    </div>
                                    <div class="card-body">

                                        <form id="form" method="post" action="{{route('team.profile.update')}}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$user->id}}">
                                            <div class="list-group">
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('team_profile.Profile information')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group">
                                                                <label>{{__('team_profile.Name')}}:</label>
                                                                <input type="text" name="name" class="form-control" value="{{$user->name}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{__('team_profile.Email')}}:</label>
                                                                <input type="text" name="email" class="form-control" value="{{$user->email}}">
                                                            </div>
                                                            <div class="form-group mb-5">
                                                                <label>No. KP:</label>
                                                                <input type="text" name="username" class="form-control" value="{{$user->user}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kementerian:</label>
                                                                <select name="kementerian_id" id="kementerian-select" class="form-control custom-select">
                                                                    <option value="">Select Kementerian</option>
                                                                    @foreach($kementerian as $kem)
                                                                        <option value="{{ $kem->id }}" {{ $user->kementerian_id == $kem->id ? 'selected' : '' }}>{{ $kem->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Agensi:</label>
                                                                <select name="agensi_id" id="team-agensi-select" class="form-control custom-select" {{ $user->kementerian_id ? '' : 'disabled' }}>
                                                                    <option value="">Select Agensi</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Sub Agensi:</label>
                                                                <select name="sub_agensi_id" id="team-sub-agensi-select" class="form-control custom-select" {{ $user->agensi_id ? '' : 'disabled' }}>
                                                                    <option value="">Select Sub Agensi</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>No Pejabat:</label>
                                                                <input type="text" name="no_pejabat" class="form-control" value="{{$user->no_pejabat}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>No HP:</label>
                                                                <input type="text" name="no_hp" class="form-control" value="{{$user->no_hp}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>No. Fax:</label>
                                                                <input type="text" name="no_fax" class="form-control" value="{{$user->no_fax}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Alamat Pejabat:</label>
                                                                <textarea name="alamat_pejabat" class="form-control" rows="3">{{$user->alamat_pejabat}}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Poskod:</label>
                                                                <input type="text" name="poskod" class="form-control" value="{{$user->poskod}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Negeri:</label>
                                                                <select name="negeri" class="form-control custom-select">
                                                                    <option value="">Select Negeri</option>
                                                                    <option value="Johor" {{ $user->negeri == 'Johor' ? 'selected' : '' }}>Johor</option>
                                                                    <option value="Kedah" {{ $user->negeri == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                                                    <option value="Kelantan" {{ $user->negeri == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                                                    <option value="Melaka" {{ $user->negeri == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                                                                    <option value="Negeri Sembilan" {{ $user->negeri == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                                                    <option value="Pahang" {{ $user->negeri == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                                                    <option value="Perak" {{ $user->negeri == 'Perak' ? 'selected' : '' }}>Perak</option>
                                                                    <option value="Perlis" {{ $user->negeri == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                                                    <option value="Pulau Pinang" {{ $user->negeri == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                                                                    <option value="Sabah" {{ $user->negeri == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                                                    <option value="Sarawak" {{ $user->negeri == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                                                    <option value="Selangor" {{ $user->negeri == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                                                    <option value="Terengganu" {{ $user->negeri == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                                                    <option value="Wilayah Persekutuan Kuala Lumpur" {{ $user->negeri == 'Wilayah Persekutuan Kuala Lumpur' ? 'selected' : '' }}>Wilayah Persekutuan Kuala Lumpur</option>
                                                                    <option value="Wilayah Persekutuan Labuan" {{ $user->negeri == 'Wilayah Persekutuan Labuan' ? 'selected' : '' }}>Wilayah Persekutuan Labuan</option>
                                                                    <option value="Wilayah Persekutuan Putrajaya" {{ $user->negeri == 'Wilayah Persekutuan Putrajaya' ? 'selected' : '' }}>Wilayah Persekutuan Putrajaya</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="custom-switch">
                                                                    <input type="hidden" name="autoassign" value="0">
                                                                    <input type="checkbox" name="autoassign" class="custom-switch-input" value="1" @if($user->autoassign == 1) checked @endif>
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <span class="custom-switch-description">{{__('team.Auto-assign tickets to this user')}}.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('team_profile.Preferences')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group form-elements">
                                                                <div class="form-label">{{__('team_profile.Account Type')}}</div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="isadmin" value="1" v-on:click="admin" @if($user->isadmin == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.Administrator (access to all features and categories)')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="isadmin" value="0" v-on:click="staff" @if($user->isadmin == 0) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.Staff (you can limit features and categories)')}}</span>
                                                                    </label>

                                                                    <!-- Staff Only -->
                                                                    <?php
                                                                    if ($user->isadmin == 0)
                                                                        {
                                                                            $staff_category = explode(',',$user->categories);
                                                                            $staff_permission = explode(',',$user->heskprivileges);
                                                                        }else{
                                                                        $staff_category = [];
                                                                        $staff_permission = [];
                                                                    }
                                                                    ?>
                                                                    <div class="form-group form-elements mt-5" v-if="showStaff">
                                                                        <div class="form-label">{{__('team_profile.Categories')}}</div>
                                                                        <div class="custom-controls-stacked">
                                                                            <div class="row">
                                                                                @foreach($categories as $category)
                                                                                    <div class="col-4">
                                                                                        <label class="custom-control custom-checkbox">
                                                                                            <input type="checkbox" class="custom-control-input" name="categories[]" value="{{$category->id}}" @if(in_array($category->id, $staff_category)) checked  @endif>
                                                                                            <span class="custom-control-label">{{$category->name}}</span>
                                                                                        </label>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group form-elements mt-5" v-if="showStaff">
                                                                        <div class="form-label">{{__('team_profile.Features')}}</div>
                                                                        <div class="custom-controls-stacked">
                                                                            <div class="row">
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_tickets" @if(in_array('can_view_tickets', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.View tickets')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_reply_tickets" @if(in_array('can_reply_tickets', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Reply to tickets')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_del_tickets" @if(in_array('can_del_tickets', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Delete tickets')}}</span>
                                                                                    </label>
                                                                                </div>
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_edit_tickets" @if(in_array('can_edit_tickets', $staff_permission)) checked @endif>--}}
{{--                                                                                        <span class="custom-control-label">Edit ticket replies</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_merge_tickets" @if(in_array('can_merge_tickets', $staff_permission)) checked @endif>--}}
{{--                                                                                        <span class="custom-control-label">Merge tickets</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_resolve" @if(in_array('can_resolve', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can resolve tickets')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_submit_any_cat" @if(in_array('can_submit_any_cat', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can submit tickets to any category')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_del_notes" @if(in_array('can_del_notes', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Delete any ticket notes')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_change_cat" @if(in_array('can_change_cat', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Change ticket category (to any)')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_change_own_cat" @if(in_array('can_change_own_cat', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Change ticket category (to allowed)')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_kb" @if(in_array('can_man_kb', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Manage knowledgebase')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_cat" @if(in_array('can_man_cat', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Manage categories')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_canned" @if(in_array('can_man_canned', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Manage canned responses')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_ticket_tpl" @if(in_array('can_man_ticket_tpl', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Manage ticket templates')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_man_settings" @if(in_array('can_man_settings', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Manage help desk settings')}}</span>
                                                                                    </label>
                                                                                </div>

{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_add_archive" @if(in_array('can_add_archive', $staff_permission)) checked @endif>--}}
{{--                                                                                        <span class="custom-control-label">Can tag tickets</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_assign_self" @if(in_array('can_assign_self', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can assign tickets to self')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_assign_others" @if(in_array('can_assign_others', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can assign tickets to others')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_unassigned" @if(in_array('can_view_unassigned', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can view unassigned tickets')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_ass_others" @if(in_array('can_view_ass_others', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can view tickets assigned to others')}}</span>
                                                                                    </label>
                                                                                </div>

                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_ass_by" @if(in_array('can_view_ass_by', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can view tickets he/she assigned to others')}}</span>
                                                                                    </label>
                                                                                </div>
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_run_reports" @if(in_array('can_run_reports', $staff_permission)) checked @endif>--}}
{{--                                                                                        <span class="custom-control-label">Can run reports (own)</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_run_reports_full" @if(in_array('can_run_reports_full', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can run reports (all)')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_export" @if(in_array('can_export', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can export tickets')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                {{-- <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_view_online" @if(in_array('can_view_online', $staff_permission)) checked @endif >
                                                                                        <span class="custom-control-label">{{__('team_profile.Can view online staff members')}}</span>
                                                                                    </label>
                                                                                </div> --}}
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_ban_emails" @if(in_array('can_ban_emails', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can ban emails')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_unban_emails" @if(in_array('can_unban_emails', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can unban emails (enables Can ban emails)')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_ban_ips" @if(in_array('can_ban_ips', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can ban ips')}}</span>
                                                                                    </label>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <label class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_unban_ips" @if(in_array('can_unban_ips', $staff_permission)) checked @endif>
                                                                                        <span class="custom-control-label">{{__('team_profile.Can unban ips (enables Can ban ips)')}}</span>
                                                                                    </label>
                                                                                </div>
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_privacy" @if(in_array('can_privacy', $staff_permission)) checked @endif>--}}
{{--                                                                                        <span class="custom-control-label">Can anonymize tickets</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_service_msg" @if(in_array('can_service_msg', $staff_permission)) checked @endif>--}}
{{--                                                                                        <span class="custom-control-label">Edit service messages</span>--}}
{{--                                                                                    </label>--}}
{{--                                                                                </div>--}}
{{--                                                                                <div class="col-4">--}}
{{--                                                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                                                        <input type="checkbox" class="custom-control-input" name="features[]" value="can_email_tpl" @if(in_array('can_email_tpl', $staff_permission)) checked @endif>--}}
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
                                                    <h5 class="mb-0" data-acc-title>{{__('team_profile.Signature')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group">
                                                                <label>{{__('team_profile.Signature (max 1000 chars)')}}</label>
                                                                <textarea class="form-control" name="signature" rows="4">{{$user->signature}}</textarea>
                                                                <label>{{__('team_profile.HTML code is not allowed. Links will be clickable')}}.</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('team_profile.Preferences')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group form-elements">
                                                                <div class="form-label">{{__('team_profile.After replying to a ticket')}}</div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="afterreply" value="0" @if($user->afterreply == 0) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.Show the ticket I just replied to')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="afterreply" value="1" @if($user->afterreply == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.Return to main administration page')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="afterreply" value="2" @if($user->afterreply == 2) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.Open next ticket that needs my reply')}}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group form-elements m-0">
                                                                <div class="form-label">{{__('team_profile.Defaults')}}</div>
                                                                <div class="custom-controls-stacked">
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="autostart" value="1">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="autostart" value="1" @if($user->autostart == 1) checked @endif>--}}
{{--                                                                        <span class="custom-control-label">{{__('team_profile.Automatically start timer when I open a ticket')}}</span>--}}
{{--                                                                    </label>--}}
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_customer_new" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_customer_new" value="1" @if($user->notify_customer_new == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.Select notify customer option in the new ticket form')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_customer_reply" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_customer_reply" value="1" value="1" @if($user->notify_customer_reply == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.Select notify customer option in the ticket reply form')}}</span>
                                                                    </label>
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="show_suggested" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="show_suggested" value="1" @if($user->show_suggested == 1) checked @endif>--}}
{{--                                                                        <span class="custom-control-label">{{__('team_profile.Show what knowledgebase articles were suggested to customers')}}</span>--}}
{{--                                                                    </label>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('team_profile.Notifications')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group form-elements m-0">
                                                                <div class="form-label">{{__('team_profile.The help desk will send an email notification when')}}:</div>
                                                                <div class="custom-controls-stacked mb-4">
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="notify_new_unassigned" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="notify_new_unassigned" value="1" @if($user->notify_new_unassigned == 1) checked @endif>--}}
{{--                                                                        <span class="custom-control-label">{{__('team_profile.A new ticket is submitted with owner: Unassigned')}}</span>--}}
{{--                                                                    </label>--}}
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_new_my" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_new_my" value="1" @if($user->notify_new_my == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.A new ticket is submitted with owner: Assigned to me')}}</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked mb-4">
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="notify_reply_unassigned" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="notify_reply_unassigned" value="1" @if($user->notify_reply_unassigned == 1) checked @endif>--}}
{{--                                                                        <span class="custom-control-label">{{__('team_profile.Client responds to a ticket with owner: Unassigned')}}</span>--}}
{{--                                                                    </label>--}}
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_reply_my" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_reply_my" value="1" @if($user->notify_reply_my == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.Client responds to a ticket with owner: Assigned to me')}}</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked mb-4">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_assigned" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_assigned" value="1" @if($user->notify_assigned == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.A ticket is assigned to me')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_note" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_note" value="1" @if($user->notify_note == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('team_profile.Someone adds a note to a ticket assigned to me')}}</span>
                                                                    </label>
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="notify_pm" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="notify_pm" value="1" @if($user->notify_pm == 1) checked @endif>--}}
{{--                                                                        <span class="custom-control-label">{{__('team_profile.A private message is sent to me')}}</span>--}}
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
                            </div>
                        </div>
					</div>
				</div>
				<!-- CONTAINER CLOSED -->
                <!-- CHANGE PASSWORD MODAL -->
                <div class="modal fade" id="changePassword" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="example-Modal3">{{__('team_profile.Change Password')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{route('team.change_password')}}" id="changePasswordForm">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <div class="form-group">
                                        <label for="new_pass" class="form-control-label">{{__('team_profile.New Password')}} <small class="text-danger">*</small></label>
                                        <input type="password" class="form-control" id="new_pass" name="new_pass" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="con_pass" class="form-control-label">{{__('team_profile.Confirm Password')}} <small class="text-danger">*</small></label>
                                        <input type="password" class="form-control" id="con_pass" name="con_pass" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('team_profile.Close')}}</button>
                                <button type="submit" form="changePasswordForm" class="btn btn-primary">{{__('team_profile.Change Password')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CHANGE PASSWORD MODAL CLOSED -->
			</div>
@endsection
@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                permission : {{$user->isadmin}},
                showStaff : '',
            },
            methods: {
                staff: function () {
                    this.showStaff = !this.showStaff
                },
                admin: function () {
                    this.showStaff = !this.showStaff
                },
            },
            mounted:function(){
                if (this.permission == 0)
                {
                    this.showStaff = true
                }else{
                    this.showStaff = false
                }
            },
        })
    </script>
    <script src="{{ URL::asset('assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/advancedform.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>

    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Load existing data on page load
            var userKementerianId = '{{ $user->kementerian_id }}';
            var userAgensiId = '{{ $user->agensi_id }}';
            var userSubAgensiId = '{{ $user->sub_agensi_id }}';

            // Load existing agensi if kementerian is selected
            if (userKementerianId) {
                loadAgensi(userKementerianId, userAgensiId);
            }

            // Load existing sub agensi if agensi is selected
            if (userAgensiId) {
                loadSubAgensi(userAgensiId, userSubAgensiId);
            }

            // Kementerian change handler
            $('#kementerian-select').on('change', function() {
                var kementerianId = $(this).val();
                var agensiSelect = $('#team-agensi-select');
                var subAgensiSelect = $('#team-sub-agensi-select');

                // Reset dependent dropdowns
                agensiSelect.html('<option value="">Select Agensi</option>');
                agensiSelect.prop('disabled', true);
                subAgensiSelect.html('<option value="">Select Sub Agensi</option>');
                subAgensiSelect.prop('disabled', true);

                if (kementerianId) {
                    loadAgensi(kementerianId);
                }
            });

            // Agensi change handler
            $('#team-agensi-select').on('change', function() {
                var agensiId = $(this).val();
                var subAgensiSelect = $('#team-sub-agensi-select');

                // Reset sub agensi dropdown
                subAgensiSelect.html('<option value="">Select Sub Agensi</option>');
                subAgensiSelect.prop('disabled', true);

                if (agensiId) {
                    loadSubAgensi(agensiId);
                }
            });

            function loadAgensi(kementerianId, selectedAgensiId = null) {
                $.ajax({
                    url: '/get-agensi/' + kementerianId,
                    type: 'GET',
                    success: function(response) {
                        var agensiSelect = $('#team-agensi-select');
                        agensiSelect.html('<option value="">Select Agensi</option>');

                        if (response.length > 0) {
                            $.each(response, function(index, agensi) {
                                var selected = (selectedAgensiId && agensi.id == selectedAgensiId) ? 'selected' : '';
                                agensiSelect.append('<option value="' + agensi.id + '" ' + selected + '>' + agensi.nama + '</option>');
                            });
                            agensiSelect.prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching agensi:', xhr, status, error);
                    }
                });
            }

            function loadSubAgensi(agensiId, selectedSubAgensiId = null) {
                $.ajax({
                    url: '/get-sub-agensi/' + agensiId,
                    type: 'GET',
                    success: function(response) {
                        var subAgensiSelect = $('#team-sub-agensi-select');
                        subAgensiSelect.html('<option value="">Select Sub Agensi</option>');

                        if (response.length > 0) {
                            $.each(response, function(index, subAgensi) {
                                var selected = (selectedSubAgensiId && subAgensi.id == selectedSubAgensiId) ? 'selected' : '';
                                subAgensiSelect.append('<option value="' + subAgensi.id + '" ' + selected + '>' + subAgensi.nama + '</option>');
                            });
                            subAgensiSelect.prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching sub agensi:', xhr, status, error);
                    }
                });
            }
        });
    </script>
@endsection
