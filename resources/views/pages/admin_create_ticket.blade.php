@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">Create New Ticket</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create New Ticket</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fa fa-exclamation mr-2" aria-hidden="true"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 card-title">Create New Ticket</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin_create_ticket.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <!-- Section 1: Maklumat Aduan -->
                        <h5 class="font-weight-bold mb-3">1. Maklumat Aduan</h5>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Kaedah Aduan <small class="text-danger">*</small></label>
                                    <select name="kaedah_melapor_id" id="kaedah-aduan" class="form-control custom-select @error('kaedah_melapor_id') is-invalid @enderror" required>
                                        <option value="">Sila Pilih</option>
                                        @foreach($kaedah_melapor as $kaedah)
                                            <option value="{{ $kaedah->id }}" {{ old('kaedah_melapor_id', isset($draft) ? $draft->kaedah_melapor_id : '') == $kaedah->id ? 'selected' : '' }}>{{ $kaedah->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kaedah_melapor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Tarikh Aduan <small class="text-danger">*</small></label>
                                    <input type="date" name="tarikh_aduan" id="tarikh-aduan" class="form-control @error('tarikh_aduan') is-invalid @enderror" value="{{ old('tarikh_aduan', isset($draft) ? $draft->tarikh_aduan : date('Y-m-d')) }}" required>
                                    @error('tarikh_aduan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Masa Aduan <small class="text-danger">*</small></label>
                                    <input type="time" name="masa_aduan" id="masa-aduan" class="form-control @error('masa_aduan') is-invalid @enderror" value="{{ old('masa_aduan', isset($draft) ? $draft->masa_aduan : date('H:i')) }}" required>
                                    @error('masa_aduan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Section 2: Maklumat Pengadu -->
                        <h5 class="font-weight-bold mb-3">2. Maklumat Pengadu</h5>

                        <div class="form-group">
                            <label class="form-label">Nama <small class="text-danger">*</small></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($draft) ? $draft->name : '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" id="alamat-emel-label">Alamat E-mel <small class="text-danger">*</small></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', isset($draft) ? $draft->email : '') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nombor Telefon <small class="text-danger">*</small></label>
                                    <input type="tel" name="phone_number" id="no-telefon" maxlength="13" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', isset($draft) ? $draft->phone_number : '') }}" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Login ID Sistem (Pilihan)</label>
                                    <input type="text" name="login_id" class="form-control @error('login_id') is-invalid @enderror" value="{{ old('login_id', isset($draft) ? $draft->login_id : '') }}">
                                    @error('login_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jantina <small class="text-danger">*</small></label>
                                    <select name="jantina" class="form-control custom-select @error('jantina') is-invalid @enderror" required>
                                        <option value="">Sila Pilih</option>
                                        <option value="Lelaki" {{ old('jantina', isset($draft) ? $draft->jantina : '') == 'Lelaki' ? 'selected' : '' }}>Lelaki</option>
                                        <option value="Perempuan" {{ old('jantina', isset($draft) ? $draft->jantina : '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jantina')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Section 3: Maklumat Pertanyaan -->
                        <h5 class="font-weight-bold mb-3">3. Maklumat Pertanyaan</h5>

                        <!-- Radio buttons for complaint type -->
                        <div class="form-group">
                            <label class="form-label">Jenis <small class="text-danger">*</small></label>
                            <div class="d-flex align-items-center">
                                <label class="custom-control custom-radio mr-4">
                                    <input type="radio" class="custom-control-input" name="complaint_type" value="general" {{ old('complaint_type', isset($draft) ? $draft->complaint_type : 'general') == 'general' ? 'checked' : '' }}>
                                    <span class="custom-control-label">Pertanyaan Umum</span>
                                </label>
                                <label class="custom-control custom-radio mr-4">
                                    <input type="radio" class="custom-control-input" name="complaint_type" value="technical" {{ old('complaint_type', isset($draft) ? $draft->complaint_type : '') == 'technical' ? 'checked' : '' }}>
                                    <span class="custom-control-label">Aduan Aplikasi</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="complaint_type" value="server" {{ old('complaint_type', isset($draft) ? $draft->complaint_type : '') == 'server' ? 'checked' : '' }}>
                                    <span class="custom-control-label">Aduan Server</span>
                                </label>
                            </div>
                        </div>

                        <!-- Pertanyaan Umum Fields -->
                        <div id="pertanyaan-container" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Agensi</label>
                                <select name="agensi_id_umum" id="agensi-select-umum" class="form-control custom-select @error('agensi_id_umum') is-invalid @enderror">
                                    <option value="">Sila Pilih Agensi</option>
                                    @foreach($agensi as $ag)
                                        <option value="{{ $ag->id }}" {{ old('agensi_id_umum', isset($draft) ? $draft->agensi_id_umum : '') == $ag->id ? 'selected' : '' }}>{{ $ag->nama }}</option>
                                    @endforeach
                                </select>
                                @error('agensi_id_umum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Pertanyaan berkaitan :-</label>
                                <select name="pertanyaan" id="pertanyaan" class="form-control custom-select @error('pertanyaan') is-invalid @enderror">
                                    <option value="">Sila Pilih</option>
                                    <option value="Lesen" {{ old('pertanyaan', isset($draft) ? $draft->pertanyaan : '') == 'Lesen' ? 'selected' : '' }}>Lesen</option>
                                    <option value="Borang Permohonan" {{ old('pertanyaan', isset($draft) ? $draft->pertanyaan : '') == 'Borang Permohonan' ? 'selected' : '' }}>Borang Permohonan</option>
                                    <option value="Proses" {{ old('pertanyaan', isset($draft) ? $draft->pertanyaan : '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="Profil" {{ old('pertanyaan', isset($draft) ? $draft->pertanyaan : '') == 'Profil' ? 'selected' : '' }}>Profil</option>
                                    <option value="Status Permohonan" {{ old('pertanyaan', isset($draft) ? $draft->pertanyaan : '') == 'Status Permohonan' ? 'selected' : '' }}>Status Permohonan</option>
                                    <option value="Lain-lain" {{ old('pertanyaan', isset($draft) ? $draft->pertanyaan : '') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                </select>
                                @error('pertanyaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Conditional Lesen Fields for Pertanyaan Umum -->
                            <div id="kategori-umum-lesen" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Lesen</label>
                                    <select name="lesen_id_umum" id="lesen-select-umum" class="form-control custom-select @error('lesen_id_umum') is-invalid @enderror">
                                        <option value="">Sila Pilih</option>
                                    </select>
                                    @error('lesen_id_umum')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Jenis Permohonan</label>
                                    <select name="jenis_permohonan_umum" class="form-control custom-select @error('jenis_permohonan_umum') is-invalid @enderror">
                                        <option value="">Sila Pilih</option>
                                        <option value="New" {{ old('jenis_permohonan_umum', isset($draft) ? $draft->jenis_permohonan_umum : '') == 'New' ? 'selected' : '' }}>New</option>
                                        <option value="Renewal" {{ old('jenis_permohonan_umum', isset($draft) ? $draft->jenis_permohonan_umum : '') == 'Renewal' ? 'selected' : '' }}>Renewal</option>
                                        <option value="Update" {{ old('jenis_permohonan_umum', isset($draft) ? $draft->jenis_permohonan_umum : '') == 'Update' ? 'selected' : '' }}>Update</option>
                                        <option value="Revoke/Cancel" {{ old('jenis_permohonan_umum', isset($draft) ? $draft->jenis_permohonan_umum : '') == 'Revoke/Cancel' ? 'selected' : '' }}>Revoke/Cancel</option>
                                    </select>
                                    @error('jenis_permohonan_umum')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Nombor Serahan</label>
                                    <input type="text" name="nombor_serahan_umum" class="form-control @error('nombor_serahan_umum') is-invalid @enderror" value="{{ old('nombor_serahan_umum', isset($draft) ? $draft->nombor_serahan_umum : '') }}" placeholder="cth: BL20250001">
                                    @error('nombor_serahan_umum')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Aduan Aplikasi Fields -->
                        <div id="technical-fields-container" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Agensi</label>
                                <select name="agensi_id_teknikal" id="agensi-select-teknikal" class="form-control custom-select @error('agensi_id_teknikal') is-invalid @enderror">
                                    <option value="">Sila Pilih Agensi</option>
                                    @foreach($agensi as $ag)
                                        <option value="{{ $ag->id }}" {{ old('agensi_id_teknikal', isset($draft) ? $draft->agensi_id_teknikal : '') == $ag->id ? 'selected' : '' }}>{{ $ag->nama }}</option>
                                    @endforeach
                                </select>
                                @error('agensi_id_teknikal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Kategori <small class="text-danger">*</small></label>
                                <select name="kategori_aplikasi" id="kategori-aplikasi" class="form-control custom-select @error('kategori_aplikasi') is-invalid @enderror">
                                    <option value="">Sila Pilih</option>
                                    @foreach($aduanAplikasiSubCategories as $subCat)
                                        <option value="{{ $subCat->id }}" {{ old('kategori_aplikasi', isset($draft) ? $draft->kategori_aplikasi : '') == $subCat->id ? 'selected' : '' }}>{{ $subCat->name }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_aplikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Conditional Lesen Fields for Aduan Aplikasi -->
                            <div id="kategori-aplikasi-lesen" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Lesen</label>
                                    <select name="lesen_id_teknikal" id="lesen-select-teknikal" class="form-control custom-select @error('lesen_id_teknikal') is-invalid @enderror">
                                        <option value="">Sila Pilih</option>
                                    </select>
                                    @error('lesen_id_teknikal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Jenis Permohonan</label>
                                    <select name="jenis_permohonan_teknikal" class="form-control custom-select @error('jenis_permohonan_teknikal') is-invalid @enderror">
                                        <option value="">Sila Pilih</option>
                                        <option value="New" {{ old('jenis_permohonan_teknikal', isset($draft) ? $draft->jenis_permohonan_teknikal : '') == 'New' ? 'selected' : '' }}>New</option>
                                        <option value="Renewal" {{ old('jenis_permohonan_teknikal', isset($draft) ? $draft->jenis_permohonan_teknikal : '') == 'Renewal' ? 'selected' : '' }}>Renewal</option>
                                        <option value="Update" {{ old('jenis_permohonan_teknikal', isset($draft) ? $draft->jenis_permohonan_teknikal : '') == 'Update' ? 'selected' : '' }}>Update</option>
                                        <option value="Revoke/Cancel" {{ old('jenis_permohonan_teknikal', isset($draft) ? $draft->jenis_permohonan_teknikal : '') == 'Revoke/Cancel' ? 'selected' : '' }}>Revoke/Cancel</option>
                                    </select>
                                    @error('jenis_permohonan_teknikal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Nombor Serahan</label>
                                    <input type="text" name="nombor_serahan_teknikal" class="form-control @error('nombor_serahan_teknikal') is-invalid @enderror" value="{{ old('nombor_serahan_teknikal', isset($draft) ? $draft->nombor_serahan_teknikal : '') }}" placeholder="cth: BL20250001">
                                    @error('nombor_serahan_teknikal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Aduan Server Fields -->
                        <div id="server-fields-container" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Kategori <small class="text-danger">*</small></label>
                                <select name="kategori_server" class="form-control custom-select @error('kategori_server') is-invalid @enderror">
                                    <option value="">Sila Pilih</option>
                                    @foreach($aduanServerSubCategories as $subCat)
                                        <option value="{{ $subCat->id }}" {{ old('kategori_server', isset($draft) ? $draft->kategori_server : '') == $subCat->id ? 'selected' : '' }}>{{ $subCat->name }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_server')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Common Fields: Subject and Message -->
                        <div class="form-group">
                            <label class="form-label">Subjek <small class="text-danger">*</small></label>
                            <input type="text" name="subject" id="tajuk-aduan" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject', isset($draft) ? $draft->subject : '') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Keterangan <small class="text-danger">*</small></label>
                            <textarea name="message" id="keterangan-aduan" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message', isset($draft) ? $draft->message : '') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Attachment fields -->
                        <div class="form-group">
                            <label class="form-label">Lampiran (Pilihan)</label>
                            <small class="d-block text-muted mb-2">Format fail: .gif, .jpg, .png, .zip, .rar, .csv, .doc, .docx, .xls, .xlsx, .txt, .pdf | Max: 20MB</small>
                            <div id="attachment-container">
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
                            <button type="button" id="add-attachment-btn" class="btn btn-sm btn-secondary" onclick="showNextAttachment()">Tambah Lampiran Lain</button>
                        </div>

                        <hr class="my-4">

                        <!-- Priority -->
                        <div class="form-group">
                            <label class="form-label">Priority <small class="text-danger">*</small></label>
                            <select name="priority" class="form-control custom-select @error('priority') is-invalid @enderror" required>
                                @foreach($activePriorities as $priority)
                                    <option value="{{ $priority->priority_value }}" {{ old('priority', isset($draft) ? $draft->priority : 3) == $priority->priority_value ? 'selected' : '' }}>
                                        {{ $priority->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Assignment Options -->
                        <div class="form-group">
                            <label class="form-label">Select Kumpulan Pengguna for Assignment</label>
                            <select name="assignment_kumpulan_pengguna_id" id="assignment-kumpulan-pengguna-select" class="form-control custom-select">
                                <option value="">Pilih Kumpulan Pengguna</option>
                                @foreach(\App\Models\LookupKumpulanPengguna::where('is_active', 1)->orderBy('nama', 'ASC')->get() as $kp)
                                    <option value="{{$kp->id}}" {{ old('assignment_kumpulan_pengguna_id', isset($draft) ? $draft->assignment_kumpulan_pengguna_id : '') == $kp->id ? 'selected' : '' }}>{{$kp->nama}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Assign this ticket to</label>
                            <select name="owner" id="select-owner" class="form-control custom-select">
                                <option value="-1" {{ old('owner', isset($draft) ? $draft->owner : '-1') == '-1' ? 'selected' : '' }}>> Unassigned <</option>
                            </select>
                        </div>

                        <!-- Notification Option -->
                        <div class="form-group">
                            <label class="form-label">Options</label>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-checkbox">
                                    @if(User()->notify_customer_new == 1)
                                        <input type="checkbox" class="custom-control-input" name="notify" value="1" checked="">
                                    @else
                                        <input type="checkbox" class="custom-control-input" name="notify" value="1">
                                    @endif
                                    <span class="custom-control-label">Send email notification to the customer</span>
                                </label>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="openby" value="{{Illuminate\Support\Facades\Session::get('user_id')}}">
                        <input type="hidden" name="dt" value="{{\Carbon\Carbon::now()}}">
                        <input type="hidden" name="lastchange" value="{{\Carbon\Carbon::now()}}">
                        <input type="hidden" name="action" id="form-action" value="submit">
                        @if(isset($draft))
                        <input type="hidden" name="draft_id" value="{{ $draft->id }}">
                        @endif

                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-secondary btn-block" onclick="saveDraft()">
                                    <i class="fe fe-save mr-2"></i>{{ isset($draft) ? 'Simpan' : 'Simpan Sebagai Draft' }}
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-danger btn-block" onclick="saveTutup()">
                                    <i class="fe fe-check-circle mr-2"></i>Tutup
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-send mr-2"></i>Hantar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-1 CLOSED -->
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        // Initialize Select2
        $(document).ready(function() {
            $('.select2').select2();

            // Initialize form on page load
            updateConditionalFields();

            // Restore pertanyaan Lesen fields if old value exists or draft exists
            @if(old('pertanyaan', isset($draft) ? $draft->pertanyaan : '') == 'Lesen')
                $('#kategori-umum-lesen').show();
            @endif

            // Restore kategori aplikasi Lesen fields if old value exists or draft exists
            @if(old('kategori_aplikasi', isset($draft) ? $draft->kategori_aplikasi : ''))
                var selectedKategoriText = $('#kategori-aplikasi option:selected').text();
                if(selectedKategoriText == 'Lesen') {
                    $('#kategori-aplikasi-lesen').show();
                }
            @endif

            // Restore lesen dropdown for Pertanyaan Umum if draft exists
            @if(isset($draft) && $draft->agensi_id_umum)
                var agensiIdUmum = '{{ $draft->agensi_id_umum }}';
                var lesenIdUmum = '{{ old('lesen_id_umum', $draft->lesen_id_umum ?? '') }}';

                if (agensiIdUmum) {
                    $.ajax({
                        url: '/get-lesen/' + agensiIdUmum,
                        type: 'GET',
                        success: function(response) {
                            var lesenSelect = $('#lesen-select-umum');
                            lesenSelect.html('<option value="">Sila Pilih</option>');

                            if (response.length > 0) {
                                $.each(response, function(index, lesen) {
                                    var selected = (lesen.id == lesenIdUmum) ? 'selected' : '';
                                    lesenSelect.append('<option value="' + lesen.id + '" ' + selected + '>' + lesen.nama + '</option>');
                                });
                            }
                        }
                    });
                }
            @endif

            // Restore lesen dropdown for Aduan Aplikasi if draft exists
            @if(isset($draft) && $draft->agensi_id_teknikal)
                var agensiIdTeknikal = '{{ $draft->agensi_id_teknikal }}';
                var lesenIdTeknikal = '{{ old('lesen_id_teknikal', $draft->lesen_id_teknikal ?? '') }}';

                if (agensiIdTeknikal) {
                    $.ajax({
                        url: '/get-lesen/' + agensiIdTeknikal,
                        type: 'GET',
                        success: function(response) {
                            var lesenSelect = $('#lesen-select-teknikal');
                            lesenSelect.html('<option value="">Sila Pilih</option>');

                            if (response.length > 0) {
                                $.each(response, function(index, lesen) {
                                    var selected = (lesen.id == lesenIdTeknikal) ? 'selected' : '';
                                    lesenSelect.append('<option value="' + lesen.id + '" ' + selected + '>' + lesen.nama + '</option>');
                                });
                            }
                        }
                    });
                }
            @endif

            // Restore owner dropdown if draft exists
            @if(isset($draft) && $draft->assignment_kumpulan_pengguna_id)
                var kumpulanPenggunaId = '{{ $draft->assignment_kumpulan_pengguna_id }}';
                var ownerId = '{{ old('owner', $draft->owner ?? '-1') }}';

                if (kumpulanPenggunaId) {
                    $.ajax({
                        url: '/get-team/' + kumpulanPenggunaId,
                        type: 'GET',
                        success: function(response) {
                            var ownerSelect = $('#select-owner');
                            ownerSelect.html('<option value="-1">> Unassigned <</option>');

                            if (response.length > 0) {
                                $.each(response, function(index, teamMember) {
                                    var selected = (teamMember.id == ownerId) ? 'selected' : '';
                                    ownerSelect.append('<option value="' + teamMember.id + '" ' + selected + '>' + teamMember.name + '</option>');
                                });
                            }
                        }
                    });
                }
            @endif
        });

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
                        alert("Format fail tidak sah");
                        oInput.value = "";
                        return false;
                    }

                    // Check file size
                    if (oInput.files && oInput.files[0]) {
                        var fileSize = oInput.files[0].size;
                        if (fileSize > maxFileSize) {
                            alert("Saiz fail melebihi had 20MB. Sila pilih fail yang lebih kecil.");
                            oInput.value = "";
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        function showNextAttachment() {
            var attachmentRows = document.querySelectorAll('#attachment-container .attachment-row');
            var addButton = document.getElementById('add-attachment-btn');

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

        // Function to handle the visibility of conditional fields
        function updateConditionalFields() {
            const selectedType = document.querySelector('input[name="complaint_type"]:checked').value;

            // Hide all conditional containers first
            document.getElementById('pertanyaan-container').style.display = 'none';
            document.getElementById('technical-fields-container').style.display = 'none';
            document.getElementById('server-fields-container').style.display = 'none';

            // Show the relevant container
            if (selectedType === 'general') {
                document.getElementById('pertanyaan-container').style.display = 'block';
            } else if (selectedType === 'technical') {
                document.getElementById('technical-fields-container').style.display = 'block';
            } else if (selectedType === 'server') {
                document.getElementById('server-fields-container').style.display = 'block';
            }
        }

        // Add event listeners to the radio buttons
        document.getElementsByName('complaint_type').forEach(radio => {
            radio.addEventListener('change', updateConditionalFields);
        });

        // Phone number formatting
        document.getElementById('no-telefon').addEventListener('input', function (e) {
            const input = e.target;
            let value = input.value.replace(/\D/g, ''); // Remove all non-digit characters

            // Limit to 11 digits
            if (value.length > 11) {
                value = value.slice(0, 11);
            }

            // Add dashes and spaces to match the desired format
            if (value.length > 7) {
                value = value.substring(0, 3) + '-' + value.substring(3, 7) + ' ' + value.substring(7);
            } else if (value.length > 3) {
                value = value.substring(0, 3) + '-' + value.substring(3);
            }

            input.value = value;
        });

        // Handle Pertanyaan dropdown change
        $('#pertanyaan').on('change', function() {
            var pertanyaan = $(this).val();

            if(pertanyaan == 'Lesen') {
                $('#kategori-umum-lesen').show();
            } else {
                $('#kategori-umum-lesen').hide();
            }
        });

        // Handle Kategori Aplikasi dropdown change
        $('#kategori-aplikasi').on('change', function() {
            var selectedText = $(this).find('option:selected').text();

            if(selectedText == 'Lesen') {
                $('#kategori-aplikasi-lesen').show();
            } else {
                $('#kategori-aplikasi-lesen').hide();
            }
        });

        // Handle Agensi change for Pertanyaan Umum - update Lesen dropdown
        $('#agensi-select-umum').on('change', function() {
            var agensiId = $(this).val();

            if (agensiId) {
                // Fetch lesen for selected agensi
                $.ajax({
                    url: '/get-lesen/' + agensiId,
                    type: 'GET',
                    success: function(response) {
                        var lesenSelect = $('#lesen-select-umum');
                        lesenSelect.html('<option value="">Sila Pilih</option>');

                        if (response.length > 0) {
                            $.each(response, function(index, lesen) {
                                lesenSelect.append('<option value="' + lesen.id + '">' + lesen.nama + '</option>');
                            });
                        }
                    }
                });
            } else {
                $('#lesen-select-umum').html('<option value="">Sila Pilih</option>');
            }
        });

        // Handle Agensi change for Aduan Aplikasi - update Lesen dropdown
        $('#agensi-select-teknikal').on('change', function() {
            var agensiId = $(this).val();

            if (agensiId) {
                // Fetch lesen for selected agensi
                $.ajax({
                    url: '/get-lesen/' + agensiId,
                    type: 'GET',
                    success: function(response) {
                        var lesenSelect = $('#lesen-select-teknikal');
                        lesenSelect.html('<option value="">Sila Pilih</option>');

                        if (response.length > 0) {
                            $.each(response, function(index, lesen) {
                                lesenSelect.append('<option value="' + lesen.id + '">' + lesen.nama + '</option>');
                            });
                        }
                    }
                });
            } else {
                $('#lesen-select-teknikal').html('<option value="">Sila Pilih</option>');
            }
        });

        // Kumpulan Pengguna dependent dropdown functionality for ticket assignment
        $('#assignment-kumpulan-pengguna-select').on('change', function() {
            var kumpulanPenggunaId = $(this).val();
            var ownerSelect = $('#select-owner');

            // Reset owner dropdown to default options
            ownerSelect.html('<option value="-1" selected>> Unassigned <</option>');

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
                    }
                });
            }
        });

        // Form submission functions
        function saveDraft() {
            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Validate subject and message manually
            var subject = $('#tajuk-aduan').val().trim();
            var message = $('#keterangan-aduan').val().trim();
            var hasError = false;

            if (!subject) {
                $('#tajuk-aduan').addClass('is-invalid');
                $('#tajuk-aduan').after('<div class="invalid-feedback" style="display:block;">The subject field is required.</div>');
                hasError = true;
            }

            if (!message) {
                $('#keterangan-aduan').addClass('is-invalid');
                $('#keterangan-aduan').after('<div class="invalid-feedback" style="display:block;">The message field is required.</div>');
                hasError = true;
            }

            if (hasError) {
                return false;
            }

            // Set action to draft
            $('#form-action').val('draft');

            // Remove required from all fields except subject and message
            $('form [required]').not('#tajuk-aduan').not('#keterangan-aduan').each(function() {
                $(this).removeAttr('required');
            });

            // Disable button
            $('form button[type="button"]:first').attr("disabled","disabled").html('<i class="fe fe-save mr-2"></i>Menyimpan draft...');

            // Submit form
            $('form')[0].submit();
        }

        function saveTutup() {
            if (confirm('Adakah anda pasti untuk tutup tiket ini? Tiket akan disimpan dan diselesaikan secara automatik.')) {
                $('#form-action').val('tutup');
                $('form button[type="button"]:eq(1)').attr("disabled","disabled").html('<i class="fe fe-check-circle mr-2"></i>Menutup tiket...');
                $('form')[0].submit();
            }
        }

        // Handle form submission
        $('form').on('submit', function(e) {
            var action = $('#form-action').val();

            if (action === 'submit') {
                // Normal submit - disable submit button
                $(this).find("button[type='submit']").attr("disabled","disabled");
                $(this).find("button[type='submit']").html('<i class="fe fe-send mr-2"></i>Menghantar tiket sila tunggu...');
            }
        });
    </script>
@endsection
