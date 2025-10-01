<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket Successfully Submitted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .tracking-id {
            font-size: 28px;
            font-weight: bold;
            color: #4CAF50;
            letter-spacing: 4px;
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border: 2px dashed #4CAF50;
            border-radius: 8px;
            text-align: center;
        }
        .message {
            color: #666;
            margin: 15px 0;
            line-height: 1.6;
        }
        .ticket-details {
            background-color: #f9f9f9;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .ticket-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .ticket-details td {
            padding: 8px;
            border-bottom: 1px solid #e0e0e0;
        }
        .ticket-details td:first-child {
            font-weight: bold;
            color: #333;
            width: 35%;
        }
        .ticket-details td:last-child {
            color: #666;
        }
        .ticket-details tr:last-child td {
            border-bottom: none;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #45a049;
        }
        .info-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 5px 0;
            color: #1976D2;
            font-size: 14px;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        .footer p {
            margin: 5px 0;
        }
        .success-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✓</div>
            <h1>Ticket Successfully Submitted</h1>
        </div>
        <div class="content">
            <p class="message">Dear <strong>{{ $data['name'] }}</strong>,</p>
            <p class="message">Thank you for submitting your support ticket. We have received your request and our team will respond as soon as possible.</p>

            <p class="message" style="margin-top: 25px; margin-bottom: 10px;"><strong>Your Tracking ID:</strong></p>
            <div class="tracking-id">
                {{ $data['trackid'] }}
            </div>
            <p class="message" style="text-align: center; font-size: 14px; color: #999; margin-top: 5px;">
                Please save this tracking ID for future reference
            </p>

            <div class="ticket-details">
                <table>
                    <tr>
                        <td>Subject:</td>
                        <td>{{ $data['subject'] }}</td>
                    </tr>
                    <tr>
                        <td>Category:</td>
                        <td>{{ $data['category'] }}</td>
                    </tr>
                    <tr>
                        <td>Priority:</td>
                        <td>{{ $data['priority'] }}</td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>{{ $data['status'] }}</td>
                    </tr>
                    <tr>
                        <td>Submitted:</td>
                        <td>{{ \Carbon\Carbon::parse($data['created_at'])->format('d M Y, h:i A') }}</td>
                    </tr>
                </table>
            </div>

            <div class="info-box">
                <p><strong>ℹ️ What happens next?</strong></p>
                <p>• We reply to all tickets as soon as possible, within 24 to 48 hours</p>
                <p>• You will receive an email notification when our staff replies to your ticket</p>
                <p>• You can track your ticket status using the tracking ID above</p>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('public.search') }}" class="button">Track Your Ticket</a>
            </div>

            <p class="message" style="margin-top: 30px; font-size: 14px;">
                If you have any questions or need to add more information to your ticket, please reply to this email with your tracking ID.
            </p>
        </div>
        <div class="footer">
            <p>This is an automated message from {{ config('app.name') }}.</p>
            <p>Please do not reply directly to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
