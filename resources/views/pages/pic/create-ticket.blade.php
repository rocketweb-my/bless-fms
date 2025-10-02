@extends('layouts.master_public')
@section('css')
<link href="{{ URL::asset('assets/plugins/single-page/css/main2.css')}}" rel="stylesheet">
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
@endsection
@section('content')
                        <!-- ROW-1 OPEN -->
                        <div class="row mt-8">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0 card-title">Borang Aduan PBM Sistem BLESS</h3>
                                    </div>
                                    <div class="card-body">
                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <strong>Ralat!</strong> Sila betulkan ralat berikut:
                                                <ul class="mb-0 mt-2">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form action="{{route('pic.store.ticket')}}" method="post" enctype="multipart/form-data" id="pic-ticket-form">
                                            @csrf

                                            <h5 class="font-weight-bold mb-3">1. Maklumat Pengadu</h5>

                                            <!-- Radio buttons for user type -->
                                            <div class="form-group">
                                                <div class="d-flex">
                                                    <div class="custom-control custom-radio mr-4">
                                                        <input type="radio" id="user-type-self" name="user_type" value="self" class="custom-control-input" {{ old('user_type', 'self') == 'self' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="user-type-self">Diri Sendiri</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mr-4">
                                                        <input type="radio" id="user-type-other" name="user_type" value="other" class="custom-control-input" {{ old('user_type') == 'other' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="user-type-other">Anggota/Pegawai Lain</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="user-type-public" name="user_type" value="public" class="custom-control-input" {{ old('user_type') == 'public' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="user-type-public">Syarikat/Orang Awam</label>
                                                    </div>
                                                </div>
                                            </div>

                                            @php
                                                $pic = \App\Models\PersonInCharge::find(session('pic_id'));
                                            @endphp

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama <small class="text-danger">*</small></label>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nama" name="name" value="{{ old('name', $pic->name) }}" readonly required>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat Email <small class="text-danger">*</small></label>
                                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $pic->email) }}" readonly required>
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nombor Telefon <small class="text-danger">*</small></label>
                                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="no-telefon" name="phone_number" value="{{ old('phone_number', $pic->phone_number) }}" readonly required>
                                                        @error('phone_number')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Kementerian and Agensi -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Kementerian</label>
                                                        <input type="text" class="form-control" name="kementerian_display" value="{{ $pic->kementerian->nama ?? '' }}" readonly style="background-color: #f3f4f6;">
                                                        <input type="hidden" name="kementerian_id" value="{{ $pic->kementerian_id }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Bahagian/Agensi/Seksyen</label>
                                                        <select id="agensi-select" name="agensi_id" class="form-control select2 @error('agensi_id') is-invalid @enderror">
                                                            <option value="">Sila Pilih</option>
                                                            @php
                                                                $agensi_list = \App\Models\LookupAgensi::where('kementerian_id', $pic->kementerian_id)
                                                                    ->where('is_active', 1)
                                                                    ->orderBy('nama', 'ASC')
                                                                    ->get();
                                                            @endphp
                                                            @foreach($agensi_list as $agensi)
                                                                <option value="{{ $agensi->id }}" {{ old('agensi_id', $pic->agensi_id) == $agensi->id ? 'selected' : '' }}>{{ $agensi->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('agensi_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                            <hr class="my-4">

                                            <h5 class="font-weight-bold mb-3">2. Maklumat Aduan/Pertanyaan</h5>

                                            <!-- Jenis Aduan/Pertanyaan dropdown -->
                                            <div class="form-group">
                                                <label class="form-label">Jenis Aduan/Pertanyaan <small class="text-danger">*</small></label>
                                                <select id="ticket-type" name="ticket_type_id" class="form-control custom-select @error('ticket_type_id') is-invalid @enderror" required>
                                                    <option value="">Sila Pilih</option>
                                                    @php
                                                        $ticketTypes = \App\Models\TicketType::where('is_active', 1)->orderBy('order', 'ASC')->get();
                                                    @endphp
                                                    @foreach($ticketTypes as $type)
                                                        <option value="{{ $type->id }}" {{ old('ticket_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('ticket_type_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Conditional fields container -->
                                            <div id="conditional-fields-container" style="display: none;">
                                                <div class="form-group">
                                                    <label class="form-label">Nombor Serahan</label>
                                                    <input type="text" id="nombor-serahan" name="nombor_serahan" class="form-control @error('nombor_serahan') is-invalid @enderror" value="{{ old('nombor_serahan') }}">
                                                    @error('nombor_serahan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label">Lesen</label>
                                                    <select id="lesen" name="lesen_id" class="form-control custom-select @error('lesen_id') is-invalid @enderror">
                                                        <option value="">Sila Pilih</option>
                                                        @php
                                                            $lesens = \App\Models\LookupLesen::where('agensi_id', $pic->agensi_id)->get();
                                                        @endphp
                                                        @foreach($lesens as $lesen)
                                                            <option value="{{ $lesen->id }}" {{ old('lesen_id') == $lesen->id ? 'selected' : '' }}>{{ $lesen->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('lesen_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label">Jenis Permohonan</label>
                                                    <select id="jenis-permohonan" name="jenis_permohonan" class="form-control custom-select @error('jenis_permohonan') is-invalid @enderror">
                                                        <option value="">Sila Pilih</option>
                                                        <option value="Baharu" {{ old('jenis_permohonan') == 'Baharu' ? 'selected' : '' }}>Baharu</option>
                                                        <option value="Pembaharuan" {{ old('jenis_permohonan') == 'Pembaharuan' ? 'selected' : '' }}>Pembaharuan</option>
                                                        <option value="Pindaan" {{ old('jenis_permohonan') == 'Pindaan' ? 'selected' : '' }}>Pindaan</option>
                                                        <option value="Pembatalan" {{ old('jenis_permohonan') == 'Pembatalan' ? 'selected' : '' }}>Pembatalan</option>
                                                        <option value="Cetakan Semula" {{ old('jenis_permohonan') == 'Cetakan Semula' ? 'selected' : '' }}>Cetakan Semula</option>
                                                    </select>
                                                    @error('jenis_permohonan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- BL No field -->
                                            <div class="form-group">
                                                <label class="form-label">BL No</label>
                                                <input type="text" class="form-control @error('bl_no') is-invalid @enderror" name="bl_no" value="{{ old('bl_no') }}" placeholder="Enter BL Number">
                                                @error('bl_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Tajuk and Keterangan fields -->
                                            <div class="form-group">
                                                <label class="form-label">Tajuk Pertanyaan/Aduan <small class="text-danger">*</small></label>
                                                <input type="text" id="tajuk-aduan" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                                                @error('subject')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Keterangan <small class="text-danger">*</small></label>
                                                <textarea id="keterangan-aduan" name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                                @error('message')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Attachment fields -->
                                            <div class="form-group">
                                                <label class="form-label">Lampiran (Pilihan)</label>
                                                <small class="d-block text-muted mb-2">Format fail: .gif, .jpg, .png, .zip, .rar, .csv, .doc, .docx, .xls, .xlsx, .txt, .pdf | Max: 20MB</small>
                                                <div id="public-attachment-container">
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
                                                <button type="button" id="add-public-attachment-btn" class="btn btn-sm btn-secondary" onclick="showNextPublicAttachment()">Tambah Lampiran Lain</button>
                                            </div>

                                            <hr>
                                            <input type="hidden" name="dt" value="{{\Carbon\Carbon::now()}}">
                                            <input type="hidden" name="lastchange" value="{{\Carbon\Carbon::now()}}">
                                            <button type="submit" class="btn btn-primary btn-block">Hantar</button>
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
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        // Initialize Select2
        $(document).ready(function() {
            $('.select2').select2();
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

        function showNextPublicAttachment() {
            var attachmentRows = document.querySelectorAll('#public-attachment-container .attachment-row');
            var addButton = document.getElementById('add-public-attachment-btn');

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

        // Handle user type radio buttons
        const userTypeRadios = document.getElementsByName('user_type');
        const namaInput = document.getElementById('nama');
        const emailInput = document.getElementById('email');
        const telefonInput = document.getElementById('no-telefon');

        function updateUserFields() {
            const selectedUserType = document.querySelector('input[name="user_type"]:checked').value;
            if (selectedUserType === 'self') {
                namaInput.value = "{{ $pic->name }}";
                emailInput.value = "{{ $pic->email }}";
                telefonInput.value = "{{ $pic->phone_number }}";
                namaInput.readOnly = true;
                emailInput.readOnly = true;
                telefonInput.readOnly = true;
                namaInput.style.backgroundColor = '#f3f4f6';
                emailInput.style.backgroundColor = '#f3f4f6';
                telefonInput.style.backgroundColor = '#f3f4f6';
            } else {
                namaInput.value = '';
                emailInput.value = '';
                telefonInput.value = '';
                namaInput.readOnly = false;
                emailInput.readOnly = false;
                telefonInput.readOnly = false;
                namaInput.style.backgroundColor = '';
                emailInput.style.backgroundColor = '';
                telefonInput.style.backgroundColor = '';
            }
        }

        userTypeRadios.forEach(radio => {
            radio.addEventListener('change', updateUserFields);
        });

        // Show/hide conditional fields based on ticket type
        const ticketTypeSelect = document.getElementById('ticket-type');
        const conditionalFieldsContainer = document.getElementById('conditional-fields-container');
        const relevantTypes = ["Berkaitan Borang Permohonan", "Berkaitan Proses", "Berkaitan status permohonan"];

        ticketTypeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const selectedTypeName = selectedOption.text;

            if (relevantTypes.includes(selectedTypeName)) {
                conditionalFieldsContainer.style.display = 'block';
            } else {
                conditionalFieldsContainer.style.display = 'none';
            }
        });

        // Handle Agensi change - update Lesen dropdown
        $('#agensi-select').on('change', function() {
            var agensiId = $(this).val();

            if (agensiId) {
                // Fetch lesen for selected agensi
                $.ajax({
                    url: '/get-lesen/' + agensiId,
                    type: 'GET',
                    success: function(response) {
                        var lesenSelect = $('#lesen');
                        lesenSelect.html('<option value="">Sila Pilih</option>');

                        if (response.length > 0) {
                            $.each(response, function(index, lesen) {
                                lesenSelect.append('<option value="' + lesen.id + '">' + lesen.nama + '</option>');
                            });
                        }
                    }
                });
            } else {
                $('#lesen').html('<option value="">Sila Pilih</option>');
            }
        });

        // Form submission
        $('form').submit(function() {
            $(this).find("button[type='submit']").attr("disabled","disabled");
            $(this).find("button[type='submit']").text('Menghantar tiket sila tunggu...');
        });
    </script>
@endsection
