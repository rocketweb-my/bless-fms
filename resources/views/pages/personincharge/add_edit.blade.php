@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet">
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #000000 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6c757d !important;
    }
</style>
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{ isset($personInCharge) ? __('personincharge.Edit Person In Charge') : __('personincharge.Add Person In Charge') }}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{route('personincharge.index')}}">{{__('personincharge.Person In Charge')}}</a></li>
									<li class="breadcrumb-item"><a href="#">{{ isset($personInCharge) ? __('personincharge.Edit Person In Charge') : __('personincharge.Add Person In Charge') }}</a></li>
								</ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">{{ isset($personInCharge) ? __('personincharge.Edit Person In Charge') : __('personincharge.Add New Person In Charge') }}</div>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ isset($personInCharge) ? route('personincharge.update') : route('personincharge.store') }}" id="addPersonInCharge">
                                                @csrf
                                                @if(isset($personInCharge))
                                                    <input type="hidden" name="id" value="{{ $personInCharge->id }}">
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{__('personincharge.Name')}} <small class="text-danger">{{__('personincharge.required')}}</small></label>
                                                            <input type="text" name="name" class="form-control" value="{{ $personInCharge->name ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{__('personincharge.Email')}} <small class="text-danger">{{__('personincharge.required')}}</small></label>
                                                            <input type="email" name="email" class="form-control" value="{{ $personInCharge->email ?? '' }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{__('personincharge.Phone Number')}} <small class="text-danger">{{__('personincharge.required')}}</small></label>
                                                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $personInCharge->phone_number ?? '' }}" pattern="[0-9]{10,15}" title="Phone number must be 10-15 digits" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{__('personincharge.Kementerian')}} <small class="text-danger">{{__('personincharge.required')}}</small></label>
                                                            <select name="kementerian_id" id="kementerian" class="form-control select2" required>
                                                                <option value="">{{__('personincharge.Select Kementerian')}}</option>
                                                                @foreach(\App\Models\LookupKementerian::where('is_active', 1)->get() as $kementerian)
                                                                    <option value="{{ $kementerian->id }}" {{ (isset($personInCharge) && $personInCharge->kementerian_id == $kementerian->id) ? 'selected' : '' }}>{{ $kementerian->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{__('personincharge.Agensi')}} <small class="text-danger">{{__('personincharge.required')}}</small></label>
                                                            <select name="agensi_id" id="agensi" class="form-control select2" required>
                                                                <option value="">{{__('personincharge.Select Agensi')}}</option>
                                                                @if(isset($personInCharge) && $personInCharge->kementerian_id)
                                                                    @foreach(\App\Models\LookupAgensi::where('is_active', 1)->where('kementerian_id', $personInCharge->kementerian_id)->get() as $agensi)
                                                                        <option value="{{ $agensi->id }}" {{ (isset($personInCharge) && $personInCharge->agensi_id == $agensi->id) ? 'selected' : '' }}>{{ $agensi->nama }}</option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach(\App\Models\LookupAgensi::where('is_active', 1)->get() as $agensi)
                                                                        <option value="{{ $agensi->id }}" {{ (isset($personInCharge) && $personInCharge->agensi_id == $agensi->id) ? 'selected' : '' }}>{{ $agensi->nama }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary" form="addPersonInCharge">{{ isset($personInCharge) ? __('personincharge.Update Person In Charge') : __('personincharge.Save Person In Charge') }}</button>
                                            <a href="{{route('personincharge.index')}}" class="btn btn-secondary">{{__('personincharge.Cancel')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ROW-1 OPEN -->
                            <div class="row"></div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Phone number validation - only allow numbers
            $('#phone_number').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Optional: Dynamic Agensi filtering based on Kementerian
            $('#kementerian').change(function() {
                var kementerianId = $(this).val();
                if(kementerianId) {
                    $.ajax({
                        url: '/get-agensi/' + kementerianId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#agensi').empty();
                            $('#agensi').append('<option value="">{{__('personincharge.Select Agensi')}}</option>');
                            $.each(data, function(key, value) {
                                $('#agensi').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
                            });
                        }
                    });
                } else {
                    $('#agensi').empty();
                    $('#agensi').append('<option value="">{{__('personincharge.Select Agensi')}}</option>');
                }
            });
        });
    </script>
@endsection
