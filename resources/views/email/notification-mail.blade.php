<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Notification') }}</title>
</head>

<body style="margin:0; padding:0; background-color:#f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <tr>
            <td align="center">

                <!-- Wrapper -->
                <table width="580" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- Top Accent Bar -->
                    <tr>
                        <td style="background-color:#4f46e5; height:5px; font-size:0; line-height:0;">&nbsp;</td>
                    </tr>

                    <!-- Header -->
                    <tr>
                        <td style="padding: 30px 40px 20px 40px; border-bottom: 1px solid #eeeeee;">
                            <h1 style="margin:0; font-size:20px; color:#1a1a2e; font-weight:600; letter-spacing:0.3px;">
                                🔔 {{ __('Notification') }}
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 28px 40px; color:#444444; font-size:15px; line-height:1.7;">
                            {!! nl2br(e($bodyText)) !!}
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="padding: 0 40px;">
                            <hr style="border:none; border-top:1px solid #eeeeee; margin:0;">
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 40px 30px 40px; text-align:center; color:#aaaaaa; font-size:12px; line-height:1.6;">
                            {{ __('This is an automated notification. Please do not reply to this email.') }}<br>
                            &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                        </td>
                    </tr>

                </table>
                <!-- End Wrapper -->

            </td>
        </tr>
    </table>

</body>

</html>
