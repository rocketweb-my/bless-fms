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
                                                    <th class="">{{__('main.Kumpulan Pengguna')}}</th>
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
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>No. KP:</label>
                                                                        <input type="text" name="username" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
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
                                                            </div>
                                                            <input type="hidden" name="autoassign" value="0">

                                                            <!-- Profile Fields -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Agensi:</label>
                                                                        <select name="agensi_id" id="agensi_id_modal" class="form-control">
                                                                            <option value="">Pilih Agensi</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Sub Agensi:</label>
                                                                        <select name="sub_agensi_id" id="sub_agensi_id_modal" class="form-control">
                                                                            <option value="">Pilih Sub Agensi</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Kumpulan Pengguna:</label>
                                                                        <select name="kumpulan_pengguna_id" id="kumpulan_pengguna_id_modal" class="form-control">
                                                                            <option value="">Pilih Kumpulan Pengguna</option>
                                                                            @foreach($kumpulanPengguna as $kp)
                                                                                <option value="{{$kp->id}}">{{$kp->nama}}</option>
                                                                            @endforeach
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

                                                                    <!-- Staff Only - Categories Hidden -->
                                                                    <div class="form-group form-elements mt-5" v-if="showStaff" style="display: none;">
                                                                        <div class="form-label">{{__('team.Categories')}}</div>
                                                                        <div class="custom-controls-stacked">
                                                                            <div class="row">
                                                                                @foreach($categories as $category)
                                                                                    <div class="col-4">
                                                                                        <label class="custom-control custom-checkbox">
                                                                                            <input type="checkbox" class="custom-control-input" name="categories[]" value="{{$category->id}}">
                                                                                            <span class="custom-control-label">{{$category->name}}</span>
                                                                                        </label>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Features Section - All Hidden with Default Values -->
                                                                    <div style="display: none;" v-if="showStaff">
                                                                        <!-- Default enabled features -->
                                                                        <input type="checkbox" name="features[]" value="can_view_tickets" checked>
                                                                        <input type="checkbox" name="features[]" value="can_reply_tickets" checked>
                                                                        <input type="checkbox" name="features[]" value="can_resolve" checked>
                                                                        <input type="checkbox" name="features[]" value="can_change_cat" checked>

                                                                        <!-- Other features with their default states -->
                                                                        <input type="checkbox" name="features[]" value="can_del_tickets">
                                                                        <input type="checkbox" name="features[]" value="can_submit_any_cat" checked>
                                                                        <input type="checkbox" name="features[]" value="can_del_notes">
                                                                        <input type="checkbox" name="features[]" value="can_change_own_cat">
                                                                        <input type="checkbox" name="features[]" value="can_man_kb">
                                                                        <input type="checkbox" name="features[]" value="can_man_cat">
                                                                        <input type="checkbox" name="features[]" value="can_man_canned">
                                                                        <input type="checkbox" name="features[]" value="can_man_ticket_tpl">
                                                                        <input type="checkbox" name="features[]" value="can_man_settings">
                                                                        <input type="checkbox" name="features[]" value="can_assign_self" checked>
                                                                        <input type="checkbox" name="features[]" value="can_assign_others">
                                                                        <input type="checkbox" name="features[]" value="can_view_unassigned" checked>
                                                                        <input type="checkbox" name="features[]" value="can_view_ass_others">
                                                                        <input type="checkbox" name="features[]" value="can_view_ass_by">
                                                                        <input type="checkbox" name="features[]" value="can_run_reports_full">
                                                                        <input type="checkbox" name="features[]" value="can_export">
                                                                        <input type="checkbox" name="features[]" value="can_ban_emails">
                                                                        <input type="checkbox" name="features[]" value="can_unban_emails">
                                                                        <input type="checkbox" name="features[]" value="can_ban_ips">
                                                                        <input type="checkbox" name="features[]" value="can_unban_ips">
                                                                    </div>

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
                                                    <!-- Hidden default values for Preferences -->
                                                    <input type="hidden" name="afterreply" value="0">
                                                    <input type="hidden" name="autostart" value="1">
                                                    <input type="hidden" name="notify_customer_new" value="1">
                                                    <input type="hidden" name="notify_customer_reply" value="1">
                                                    <input type="hidden" name="show_suggested" value="0">
                                                    
                                                    <!-- Hidden default values for Notifications -->
                                                    <input type="hidden" name="notify_new_unassigned" value="0">
                                                    <input type="hidden" name="notify_new_my" value="1">
                                                    <input type="hidden" name="notify_reply_unassigned" value="0">
                                                    <input type="hidden" name="notify_reply_my" value="1">
                                                    <input type="hidden" name="notify_assigned" value="1">
                                                    <input type="hidden" name="notify_note" value="1">
                                                    <input type="hidden" name="notify_pm" value="0">
                                                    
                                                    <!-- Submit Button -->
                                                    <div class="text-center mt-4">
                                                        <button type="submit" class="btn btn-primary">{{__('team.Register New Team Member')}}</button>
                                                    </div>
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
                    {data: 'kumpulan_pengguna', name: 'kumpulan_pengguna'},
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
