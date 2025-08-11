@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('setting_general.Settings')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('setting_general.Settings')}}</a></li>
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
                                        <h3 class="card-title">{{__('setting_general.General Settings')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('setting.general.store')}}" enctype="multipart/form-data" id="setting_form">
                                            @csrf
                                            <input  type="hidden" name="id" value="@if($general_setting != null){{$general_setting->id}}@endif">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_general.Website Title')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="website_title" value="@if($general_setting != null){{$general_setting->website_title}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_general.Website Description')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="website_description" value="@if($general_setting != null){{$general_setting->website_description}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_general.Help Desk Title')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="help_desk_title" value="@if($general_setting != null){{$general_setting->help_desk_title}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_general.Webmaster Email')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="email" class="form-control" name="webmaster_email" value="@if($general_setting != null){{$general_setting->webmaster_email}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_general.From Email')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="email" class="form-control" name="from_email" value="@if($general_setting != null){{$general_setting->from_email}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_general.From Name')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="from_name" value="@if($general_setting != null){{$general_setting->from_name}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_general.Language')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <select name="language" class="form-control custom-select">
                                                                <option value="en" @if($general_setting != null && $general_setting->language == 'en') selected @endif>English</option>
                                                                <option value="ms" @if($general_setting != null && $general_setting->language == 'ms') selected @endif>Bahasa Melayu</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_general.Logo Dashboard')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="file" name="logo" size="50">
                                                                <label class="form-label"><small>Logo Dimensions : 290 x 75 pixels</small></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">{{__('setting_general.Logo Public')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="file" name="logo_public" size="50">
                                                                <label class="form-label"><small>Logo Dimensions : 290 x 75 pixels</small></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label text-right">Favicon</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <input type="file" name="favicon" size="50">
                                                                <label class="form-label"><small>Favicon Dimensions : 32 x 32 pixels</small></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <button class="btn btn-info float-right" type="submit">{{__('setting_general.Save')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                    {{-- <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">{{__('setting_general.Helpdesk Settings')}}</h3>
                                        </div>
                                        <div class="card-body">
                                                <input  type="hidden" name="id" value="@if($general_setting != null){{$general_setting->id}}@endif">
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label text-right">{{__('setting_general.Overdue days')}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <input type="number" class="form-control" name="overdue" value="@if($general_setting != null){{$general_setting->overdue}}@endif" form="setting_form">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <button class="btn btn-info float-right" type="submit" form="setting_form">{{__('setting_general.Save')}}</button>
                                                    </div>
                                                </div>

                                        </div>
                                    </div> --}}
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Priority Overdue Days Settings</h3>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{route('setting.priority.store')}}" id="priority_form">
                                                @csrf
                                                <div class="row">
                                                    @foreach($priorities as $priority)
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label text-right">
                                                                        {{__('setting_general.Overdue days')}} - {{ $priority->name }} Priority
                                                                        <small class="text-muted">({{ $priority->name_en }} / {{ $priority->name_ms }})</small>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="priorities[{{$loop->index}}][priority_value]" value="{{ $priority->priority_value }}">
                                                                    <input type="number" class="form-control" name="priorities[{{$loop->index}}][duration_days]" value="{{ $priority->duration_days }}" min="1" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <button class="btn btn-success float-right" type="submit">{{__('setting_general.Save')}} Priority Settings</button>
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
