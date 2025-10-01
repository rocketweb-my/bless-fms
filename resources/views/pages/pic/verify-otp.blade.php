@extends('layouts.master_public')
@section('css')
<style>
    .verify-container {
        max-width: 500px;
        margin: 50px auto;
    }
    .card {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 20px;
    }
    .otp-input {
        width: 100%;
        font-size: 24px;
        text-align: center;
        letter-spacing: 10px;
        padding: 15px;
        border: 2px solid #ddd;
        border-radius: 8px;
    }
    .otp-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    #loading, #resend-loading {
        display: none;
    }
    .timer {
        font-size: 14px;
        color: #666;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="verify-container">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">
                    <i class="fa fa-shield"></i> Verify OTP
                </h4>
                <p class="mb-0 mt-2" style="font-size: 14px;">Enter the 6-digit code sent to</p>
                <p class="mb-0" style="font-size: 14px;"><strong>{{ session('pic_email') }}</strong></p>
            </div>
            <div class="card-body p-4">
                <div id="alert-container"></div>

                <form id="verifyForm">
                    @csrf
                    <div class="form-group">
                        <label for="otp">OTP Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control otp-input" id="otp" name="otp" placeholder="000000" maxlength="6" required pattern="[0-9]{6}" inputmode="numeric">
                        <small class="form-text text-muted text-center d-block mt-2">
                            <i class="fa fa-clock-o"></i> <span class="timer">Code expires in 10 minutes</span>
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg mt-4" id="verifyBtn">
                        <span id="btnText">Verify OTP</span>
                        <span id="loading">
                            <i class="fa fa-spinner fa-spin"></i> Verifying...
                        </span>
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="text-muted mb-2">Didn't receive the code?</p>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="resendBtn">
                        <span id="resend-text"><i class="fa fa-refresh"></i> Resend OTP</span>
                        <span id="resend-loading">
                            <i class="fa fa-spinner fa-spin"></i> Sending...
                        </span>
                    </button>
                    <p class="mt-3">
                        <a href="{{ route('pic.login') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back to Login
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <p class="text-muted"><small><i class="fa fa-info-circle"></i> Check your spam folder if you don't see the email</small></p>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Auto-format OTP input to only accept numbers
    $('#otp').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Verify OTP
    $('#verifyForm').on('submit', function(e) {
        e.preventDefault();

        // Disable button and show loading
        $('#verifyBtn').prop('disabled', true);
        $('#btnText').hide();
        $('#loading').show();
        $('#alert-container').empty();

        $.ajax({
            url: "{{ route('pic.verify.otp') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#alert-container').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle"></i> ${response.message}
                        </div>
                    `);

                    // Redirect to create ticket page
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1500);
                }
            },
            error: function(xhr) {
                let message = 'Invalid OTP. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                $('#alert-container').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle"></i> ${message}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                `);

                // Re-enable button
                $('#verifyBtn').prop('disabled', false);
                $('#btnText').show();
                $('#loading').hide();
                $('#otp').val('').focus();
            }
        });
    });

    // Resend OTP
    $('#resendBtn').on('click', function() {
        $('#resendBtn').prop('disabled', true);
        $('#resend-text').hide();
        $('#resend-loading').show();
        $('#alert-container').empty();

        $.ajax({
            url: "{{ route('pic.resend.otp') }}",
            method: 'POST',
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                if (response.success) {
                    $('#alert-container').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle"></i> ${response.message}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    `);
                }

                // Re-enable button after 60 seconds
                setTimeout(function() {
                    $('#resendBtn').prop('disabled', false);
                    $('#resend-text').show();
                    $('#resend-loading').hide();
                }, 60000);
            },
            error: function(xhr) {
                let message = 'Failed to resend OTP.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                $('#alert-container').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle"></i> ${message}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                `);

                $('#resendBtn').prop('disabled', false);
                $('#resend-text').show();
                $('#resend-loading').hide();
            }
        });
    });

    // Auto-submit when 6 digits entered
    $('#otp').on('input', function() {
        if (this.value.length === 6) {
            $('#verifyForm').submit();
        }
    });
});
</script>
@endsection
