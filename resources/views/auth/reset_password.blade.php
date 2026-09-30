<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ __('Password Reset Notification') }}</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0f2f5;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #1e3a8a; /* Dark blue */
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
            text-align: center;
        }
        .button-container {
            margin-top: 30px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #1e3a8a; /* Dark blue */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>




<body>
    <div class="container">
        <div class="header">
            <h2>{{ __('Reset Your Password') }}</h2>
        </div>
        <div class="content">
            <p>{{ __('You are receiving this email because we received a password reset request for your account.') }}</p>
            <div class="button-container">
                <a href="{{ $resetLink }}" class="button">{{ __('Reset Password') }}</a>
            </div>
            <p style="margin-top: 25px; font-size: 14px; color: #555;">{{ __('If you did not request a password reset, you can safely ignore this email.') }}</p>
            <p style="font-size: 14px; color: #555;">{{ __('This password reset link will expire in') }} {{ config('auth.passwords.users.expire') }}{{ __(' minutes.') }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
        </div>
    </div>
</body>
</html>

