@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">Vendor Profile</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('vendor.index')}}">Vendors</a></li>
            <li class="breadcrumb-item active">{{$user->name}}</li>
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
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-check mr-2" aria-hidden="true"></i> {{ session('success') }}
                </div>
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
                                        <img class="" src="{{URL::asset('assets/images/users/10.jpg')}}" alt="img">
                                    </div>
                                    <div class="user-wrap">
                                        <h4>{{$user->name}}</h4>
                                        <h6 class="text-muted mb-1">{{$user->company}}</h6>
                                        <span class="badge badge-{{$user->vendor_type == 'admin' ? 'primary' : 'info'}} mb-3">
                                            {{ucfirst($user->vendor_type)}} Vendor
                                        </span>
                                        <br>
                                        <button class="btn btn-secondary mt-1 mb-1" data-toggle="modal" data-target="#changePassword">
                                            <i class="fa fa-lock"></i> Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="wideget-user-info">
                                    <div class="wideget-user-warap">
                                        <div class="wideget-user-warap-l">
                                            <h6 class="mb-2"><i class="fa fa-envelope"></i> Email</h6>
                                            <p>{{$user->email}}</p>
                                        </div>
                                    </div>
                                    <div class="wideget-user-warap">
                                        <div class="wideget-user-warap-l">
                                            <h6 class="mb-2"><i class="fa fa-phone"></i> Phone</h6>
                                            <p>{{$user->no_hp ?? 'N/A'}}</p>
                                        </div>
                                    </div>
                                    <div class="wideget-user-warap">
                                        <div class="wideget-user-warap-l">
                                            <h6 class="mb-2"><i class="fa fa-circle"></i> Status</h6>
                                            <p>
                                                @if($user->is_active == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </p>
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

    <!-- UPDATE FORM -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Vendor Profile</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('vendor.update', $user->id)}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{$user->name}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{$user->email}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company <span class="text-danger">*</span></label>
                                    <input type="text" name="company" class="form-control" value="{{$user->company}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" class="form-control" value="{{$user->no_hp}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Vendor Type <span class="text-danger">*</span></label>
                                    <select name="vendor_type" class="form-control" required>
                                        <option value="admin" {{$user->vendor_type == 'admin' ? 'selected' : ''}}>Admin</option>
                                        <option value="technical" {{$user->vendor_type == 'technical' ? 'selected' : ''}}>Technical</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="{{route('vendor.index')}}" class="btn btn-secondary">Back to List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CHANGE PASSWORD MODAL -->
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('vendor.password.update', $user->id)}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                            <small class="form-text text-muted">Minimum 8 characters</small>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required minlength="8">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
