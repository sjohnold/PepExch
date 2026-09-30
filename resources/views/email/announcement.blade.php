<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: Arial, sans-serif;">

    <div style="max-width: 580px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">

        {{-- Top Accent Bar --}}
        <div style="height: 4px; background-color: #4f46e5;"></div>

        {{-- Body --}}
        <div style="padding: 40px;">

            {{-- Type Badge --}}
            <span style="font-size: 11px; font-weight: 600; color: #4f46e5; text-transform: uppercase; letter-spacing: 1px;">
                {{ $type }}
            </span>

            {{-- Title --}}
            <h2 style="margin: 12px 0 20px; color: #111827; font-size: 20px; font-weight: 700;">
                {{ $title }}
            </h2>

            {{-- Divider --}}
            <div style="height: 1px; background-color: #e5e7eb; margin-bottom: 24px;"></div>

            {{-- Message --}}
            <p style="margin: 0; color: #4b5563; font-size: 15px; line-height: 1.8;">
                {{ $body }}
            </p>

        </div>

        {{-- Footer --}}
        <div style="padding: 16px 40px; background-color: #f9fafb; border-top: 1px solid #e5e7eb;">
            <p style="margin: 0; color: #9ca3af; font-size: 12px; text-align: center;">
                This is an automated message. Please do not reply.
            </p>
        </div>

    </div>

</body>
</html>
