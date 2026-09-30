<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('Your OTP') }}</title>
</head>

<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 20px; text-align: center;">
            <h2 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;">{{ __('Welcome') }}, {{ $user->name }}!</h2>
        </div>

        <!-- Body -->
        <div style="padding: 40px 30px;">
            <p style="color: #333333; font-size: 16px; margin-bottom: 30px;">
                {{ __('Your verification code is') }}:
            </p>

            <!-- OTP Box -->
            <div style="background-color: #f8f9fa; border: 2px dashed #667eea; border-radius: 8px; padding: 25px; text-align: center; margin: 30px 0;">
                <div style="font-size: 36px; font-weight: bold; color: #667eea; letter-spacing: 8px; font-family: 'Courier New', monospace;">
                    {{ $otp }}
                </div>
            </div>

            <p style="color: #666666; font-size: 14px; margin-top: 30px;">
                {{ __('If you did not register, please ignore this email') }}.
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f8f9fa; padding: 20px 30px; border-top: 1px solid #e9ecef;">
            <p style="color: #666666; font-size: 14px; margin: 0;">
                {{ __('Best regards') }}
            </p>
        </div>

    </div>
</body>

</html>
