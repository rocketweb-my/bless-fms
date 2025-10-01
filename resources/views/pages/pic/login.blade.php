@extends('layouts.master_public')
@section('css')
<style>
    .login-container {
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
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    #loading {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="login-container">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">
                    <i class="fa fa-user-circle"></i> Person In Charge Login
                </h4>
                <p class="mb-0 mt-2" style="font-size: 14px;">Enter your registered email to receive OTP</p>
            </div>
            <div class="card-body p-4">
                <div id="alert-container"></div>

                <form id="loginForm">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <small class="form-text text-muted">Please use your registered email address</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg mt-4" id="submitBtn">
                        <span id="btnText">Request OTP</span>
                        <span id="loading">
                            <i class="fa fa-spinner fa-spin"></i> Sending...
                        </span>
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="text-muted mb-2">Not registered as Person In Charge?</p>
                    <p class="text-muted"><small>Please contact administrator to register</small></p>
                    <a href="{{ route('public.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <p class="text-muted"><small><i class="fa fa-lock"></i> Secure login with OTP verification</small></p>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        // Disable button and show loading
        $('#submitBtn').prop('disabled', true);
        $('#btnText').hide();
        $('#loading').show();
        $('#alert-container').empty();

        $.ajax({
            url: "{{ route('pic.request.otp') }}",
            method: 'POST',
            data: $(this).serialize(),
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

                    // Redirect to verify page after 2 seconds
                    setTimeout(function() {
                        window.location.href = "{{ route('pic.verify.form') }}";
                    }, 2000);
                }
            },
            error: function(xhr) {
                let message = 'An error occurred. Please try again.';
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
                $('#submitBtn').prop('disabled', false);
                $('#btnText').show();
                $('#loading').hide();
            }
        });
    });
});
</script>
@endsection
