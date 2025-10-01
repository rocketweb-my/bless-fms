<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Code</title>
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
        .content {
            padding: 30px;
            text-align: center;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #4CAF50;
            letter-spacing: 8px;
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border: 2px dashed #4CAF50;
            border-radius: 8px;
            display: inline-block;
        }
        .message {
            color: #666;
            margin: 20px 0;
            line-height: 1.6;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        .warning {
            color: #ff5722;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>OTP Verification</h1>
        </div>
        <div class="content">
            <p class="message">Hello <strong>{{ $personInCharge->name }}</strong>,</p>
            <p class="message">You have requested an OTP to access the Helpdesk System. Please use the following code:</p>

            <div class="otp-code">
                {{ $otp }}
            </div>

            <p class="message">This code will expire in <strong>10 minutes</strong>.</p>
            <p class="warning">
                ⚠️ Do not share this code with anyone. Our team will never ask for your OTP.
            </p>
        </div>
        <div class="footer">
            <p>This is an automated message from the Helpdesk System.</p>
            <p>If you did not request this OTP, please ignore this email.</p>
        </div>
    </div>
</body>
</html>
