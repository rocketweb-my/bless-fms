@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('setting_email.Settings')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('setting_email.Email Settings')}}</a></li>
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
                                        <h3 class="card-title">{{__('setting_email.SMTP Settings')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('setting.email.store')}}" id="setting_email_form">
                                            @csrf
                                            <div class="row">
                                                {{-- <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_email.Send emails using')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <select name="mail_method" class="form-control custom-select">
                                                                    <option value="mail" @if($setting_imap != null && $setting_imap->mail_method == 'mail') selected @endif>Mail</option>
                                                                    <option value="smtp" @if($setting_imap != null && $setting_imap->mail_method == 'smtp') selected @endif>SMTP</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_email.SMTP Host')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="smtp_host" value="@if($setting_imap != null){{$setting_imap->smtp_host}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_email.SMTP Port')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="smtp_port" value="@if($setting_imap != null){{$setting_imap->smtp_port}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_email.SMTP Username')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="smtp_username" value="@if($setting_imap != null){{$setting_imap->smtp_username}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_email.SMTP Password')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="password" class="form-control" name="smtp_password" value="@if($setting_imap != null){{$setting_imap->smtp_password}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_email.SMTP From Email')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="smtp_from_email" value="@if($setting_imap != null){{$setting_imap->smtp_from_email}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_email.SMTP From Name')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="smtp_from_name" value="@if($setting_imap != null){{$setting_imap->smtp_from_name}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_email.SSL Protocol')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <select name="ssl_protocol" class="form-control custom-select">
                                                                    <option value="on" @if($setting_imap != null && $setting_imap->ssl_protocol == 'on') selected @endif>On</option>
                                                                    <option value="off" @if($setting_imap != null && $setting_imap->ssl_protocol == 'off') selected @endif>Off</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_email.TLS Protocol')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <select name="tls_protocol" class="form-control custom-select">
                                                                    <option value="on" @if($setting_imap != null && $setting_imap->tls_protocol == 'on') selected @endif>On</option>
                                                                    <option value="off" @if($setting_imap != null && $setting_imap->tls_protocol == 'off') selected @endif>Off</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <button class="btn btn-info float-right" type="submit">{{__('setting_general.Save')}}</button>
                                                    {{-- <a href="{{route('setting.email.test')}}" class="btn btn-secondary float-right">Test Email</a> --}}
                                                </div>
                                            </div>
                                        </form>
                                        <br>
                                        <form method="post" action="{{route('setting.email.test')}}" id="setting_email_form">
                                            @csrf
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label text-right">Testing Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="smtp_host" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                {{-- <button class="btn btn-info float-right" type="submit">{{__('setting_general.Save')}}</button> --}}
                                                <button type=submit class="btn btn-secondary float-right">Test Email</button>
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


@endsection
