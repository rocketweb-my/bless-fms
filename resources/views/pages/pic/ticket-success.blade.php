@extends('layouts.master_public')
@section('css')
<style>
    .success-container {
        max-width: 600px;
        margin: 50px auto;
    }
    .card {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    .card-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 30px;
    }
    .tracking-id {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 2px dashed #28a745;
        margin: 20px 0;
    }
    .tracking-id h3 {
        color: #28a745;
        font-weight: bold;
        margin: 0;
        font-size: 28px;
        letter-spacing: 2px;
    }
    .success-icon {
        font-size: 64px;
        color: white;
        margin-bottom: 10px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="success-container">
        <div class="card">
            <div class="card-header text-center">
                <div class="success-icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <h4 class="mb-0">Ticket Submitted Successfully!</h4>
                <p class="mb-0 mt-2" style="font-size: 14px;">Your request has been received</p>
            </div>
            <div class="card-body p-4 text-center">
                <p class="mb-3">Thank you for submitting your ticket. Our team has been notified and will respond to you shortly.</p>

                <div class="tracking-id">
                    <p class="mb-2 text-muted"><strong>Your Tracking ID:</strong></p>
                    <h3>{{ $ticket->trackid }}</h3>
                    <small class="text-muted">Please save this tracking ID for future reference</small>
                </div>

                <div class="alert alert-info mt-4" role="alert">
                    <i class="fa fa-info-circle"></i> You will receive a confirmation email at <strong>{{ $ticket->email }}</strong> with your ticket details.
                </div>

                <div class="ticket-details mt-4 text-left">
                    <h5 class="mb-3"><i class="fa fa-file-text"></i> Ticket Details</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%;">Subject:</th>
                            <td>{{ $ticket->subject }}</td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td>{{ $ticket->category_detail->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Priority:</th>
                            <td>
                                <span class="badge badge-{{ $ticket->priority == '1' ? 'danger' : ($ticket->priority == '2' ? 'warning' : 'info') }}">
                                    {{ $ticket->priority == '1' ? 'High' : ($ticket->priority == '2' ? 'Medium' : 'Low') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td><span class="badge badge-primary">{{ $ticket->status_detail ?? 'New' }}</span></td>
                        </tr>
                        <tr>
                            <th>Submitted:</th>
                            <td>{{ \Carbon\Carbon::parse($ticket->dt)->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('pic.create.ticket') }}" class="btn btn-success btn-block">
                            <i class="fa fa-plus"></i> Create Another Ticket
                        </a>
                    </div>
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('pic.logout') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('public.index') }}" class="text-primary">
                        <i class="fa fa-home"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <p class="text-muted">
                <small>
                    <i class="fa fa-question-circle"></i>
                    Need help? Contact our support team at {{ env('MAIL_FROM_ADDRESS', 'support@example.com') }}
                </small>
            </p>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Copy tracking ID to clipboard functionality
    $('.tracking-id h3').on('click', function() {
        const trackingId = $(this).text();
        const tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(trackingId).select();
        document.execCommand('copy');
        tempInput.remove();

        // Show tooltip or alert
        alert('Tracking ID copied to clipboard!');
    });
});
</script>
@endsection
