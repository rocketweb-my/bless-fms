@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" />

@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">Profile</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{__('profile.Profile')}}</a></li>
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
															<img style="width: 15rem; height: 15rem" class="" src="@if($user->profile_picture) {{asset('storage/profile_pic/'.$user->profile_picture)}} @else {{URL::asset('assets/images/users/10.jpg')}} @endif" alt="img">
														</div>
														<div class="user-wrap">
															<h4>{{$user->name}}</h4>
															<h6 class="text-muted mb-3">@if($user->isadmin == 1) Administrator @else Staff @endif</h6>
                                                            <button class="btn btn-info mt-1 mb-1" data-toggle="modal" data-target="#changePicture"><i class="fa fa-camera"></i> {{__('profile.Change Picture')}}</button>
                                                            <button class="btn btn-secondary mt-1 mb-1" data-toggle="modal" data-target="#changePassword"><i class="fa fa-lock"></i> {{__('profile.Change Password')}}</button>
                                                        </div>
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="wideget-user-info">
														<div class="wideget-user-warap">
															<div class="wideget-user-warap-l">
																<h4 class="text-danger">{{$total_ticket}}</h4>
																<p>{{__('profile.Total Ticket')}}</p>
															</div>
														</div>
                                                        <div class="wideget-user-warap">
                                                            <div class="wideget-user-warap-l">
                                                                <h4 class="text-danger">{{$total_resolved}}</h4>
                                                                <p>{{__('profile.Total Resolved')}}</p>
                                                            </div>
                                                        </div>
{{--														<div class="wideget-user-rating">--}}
{{--															<a href="#"><i class="fa fa-star text-warning"></i></a>--}}
{{--															<a href="#"><i class="fa fa-star text-warning"></i></a>--}}
{{--															<a href="#"><i class="fa fa-star text-warning"></i></a>--}}
{{--															<a href="#"><i class="fa fa-star text-warning"></i></a>--}}
{{--															<a href="#"><i class="fa fa-star-o text-warning mr-1"></i></a> <span>5 (3876 Reviews)</span>--}}
{{--														</div>--}}
{{--														<div class="wideget-user-icons">--}}
{{--															<a href="#" class="bg-facebook text-white mt-0"><i class="fa fa-facebook"></i></a>--}}
{{--															<a href="#" class="bg-info text-white"><i class="fa fa-twitter"></i></a>--}}
{{--															<a href="#" class="bg-google text-white"><i class="fa fa-google"></i></a>--}}
{{--															<a href="#" class="bg-dribbble text-white"><i class="fa fa-dribbble"></i></a>--}}
{{--														</div>--}}
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
                                        <h3 class="card-title">{{__('profile.Update Profile')}}</h3>
                                    </div>
                                    <div class="card-body">

                                        <form id="form" method="post" action="{{route('profile.update')}}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$user->id}}">
                                            <div class="list-group">
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>Profile information</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group">
                                                                <label>{{__('profile.Name')}}:</label>
                                                                <input type="text" name="name" class="form-control" value="{{$user->name}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{__('profile.Email')}}:</label>
                                                                <input type="text" name="email" class="form-control" value="{{$user->email}}">
                                                            </div>
                                                            <div class="form-group mb-5">
                                                                <label>{{__('profile.Username')}}:</label>
                                                                <input type="text" name="username" class="form-control" value="{{$user->user}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('profile.Signature')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group">
                                                                <label>{{__('profile.Signature (max 1000 chars)')}}</label>
                                                                <textarea class="form-control" name="signature" rows="4">{{$user->signature}}</textarea>
                                                                <label>{{__('profile.HTML code is not allowed. Links will be clickable')}}.</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item py-4" data-acc-step>
                                                    <h5 class="mb-0" data-acc-title>{{__('profile.Preferences')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group form-elements">
                                                                <div class="form-label">{{__('profile.After replying to a ticket')}}</div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="afterreply" value="0" @if($user->afterreply == 0) checked @endif>
                                                                        <span class="custom-control-label">{{__('profile.Show the ticket I just replied to')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="afterreply" value="1" @if($user->afterreply == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('profile.Return to main administration page')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="afterreply" value="2" @if($user->afterreply == 2) checked @endif>
                                                                        <span class="custom-control-label">{{__('profile.Open next ticket that needs my reply')}}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group form-elements m-0">
                                                                <div class="form-label">{{__('profile.Defaults')}}</div>
                                                                <div class="custom-controls-stacked">
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="autostart" value="1">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="autostart" value="1" @if($user->autostart == 1) checked @endif>--}}
{{--                                                                        <span class="custom-control-label">{{__('team_profile.Automatically start timer when I open a ticket')}}</span>--}}
{{--                                                                    </label>--}}
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_customer_new" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_customer_new" value="1" @if($user->notify_customer_new == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('profile.Select notify customer option in the new ticket form')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_customer_reply" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_customer_reply" value="1" value="1" @if($user->notify_customer_reply == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('profile.Select notify customer option in the ticket reply form')}}</span>
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
                                                    <h5 class="mb-0" data-acc-title>{{__('profile.Notifications')}}</h5>
                                                    <div data-acc-content>
                                                        <div class="my-3">
                                                            <div class="form-group form-elements m-0">
                                                                <div class="form-label">{{__('profile.The help desk will send an email notification when')}}:</div>
{{--                                                                <div class="custom-controls-stacked mb-4">--}}
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="notify_new_unassigned" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="notify_new_unassigned" value="1" @if($user->notify_new_unassigned == 1) checked @endif>--}}
{{--                                                                        <span class="custom-control-label">{{__('profile.A new ticket is submitted with owner: Unassigned')}}</span>--}}
{{--                                                                    </label>--}}
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_new_my" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_new_my" value="1" @if($user->notify_new_my == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('profile.A new ticket is submitted with owner: Assigned to me')}}</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked mb-4">
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="notify_reply_unassigned" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="notify_reply_unassigned" value="1" @if($user->notify_reply_unassigned == 1) checked @endif>--}}
{{--                                                                        <span class="custom-control-label">{{__('profile.Client responds to a ticket with owner: Unassigned')}}</span>--}}
{{--                                                                    </label>--}}
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_reply_my" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_reply_my" value="1" @if($user->notify_reply_my == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('profile.Client responds to a ticket with owner: Assigned to me')}}</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked mb-4">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_assigned" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_assigned" value="1" @if($user->notify_assigned == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('profile.A ticket is assigned to me')}}</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="notify_note" value="0">
                                                                        <input type="checkbox" class="custom-control-input" name="notify_note" value="1" @if($user->notify_note == 1) checked @endif>
                                                                        <span class="custom-control-label">{{__('profile.Someone adds a note to a ticket assigned to me')}}</span>
                                                                    </label>
{{--                                                                    <label class="custom-control custom-checkbox">--}}
                                                                        <input type="hidden" name="notify_pm" value="0">
{{--                                                                        <input type="checkbox" class="custom-control-input" name="notify_pm" value="1" @if($user->notify_pm == 1) checked @endif>--}}
{{--                                                                        <span class="custom-control-label">{{__('profile.A private message is sent to me')}}</span>--}}
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
                                <h5 class="modal-title" id="example-Modal3">{{__('profile.Change Password')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{route('profile.change_password')}}" id="changePasswordForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="new_pass" class="form-control-label">{{__('profile.New Password')}} <small class="text-danger">*</small></label>
                                        <input type="password" class="form-control" id="new_pass" name="new_pass" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="con_pass" class="form-control-label">{{__('profile.Confirm Password')}} <small class="text-danger">*</small></label>
                                        <input type="password" class="form-control" id="con_pass" name="con_pass" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="old_pass" class="form-control-label">{{__('profile.Old Password')}} <small class="text-danger">*</small></label>
                                        <input type="password" class="form-control" id="old_pass" name="old_pass" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('profile.Close')}}</button>
                                <button type="submit" form="changePasswordForm" class="btn btn-primary">{{__('profile.Change Password')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CHANGE PASSWORD MODAL CLOSED -->
                <!-- CHANGE PROFILE PICTURE MODAL -->
                <div class="modal fade" id="changePicture" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="example-Modal3">{{__('profile.Change Profile Picture')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{route('profile.picture')}}" id="changePictureForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" class="dropify" name="image" data-max-file-size="1M" />
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('profile.Close')}}</button>
                                <button type="submit" form="changePictureForm" class="btn btn-primary">{{__('profile.Change Profile Picture')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CHANGE PROFILE PICTURE CLOSED -->
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/advancedform.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>

    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
