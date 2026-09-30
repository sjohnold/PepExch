<!DOCTYPE html>
<html>

<head>
    <title>{{ __('Welcome - New Contact Form Submission') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #1a73e8;
        }

        .label {
            font-weight: bold;
        }

        p {
            margin: 10px 0;
        }

        .greeting {
            font-size: 1.2em;
            color: #2c3e50;
        }

        .footer {
            font-size: 0.9em;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ __('Welcome to Our Platform!') }}</h1>
        <p class="greeting">{{ __('Hey') }} {{ $contact->name }},</p>
        <p>{{ __('Thank you for reaching out to us! We have received your form data, and we are looking forward to connecting with you soon.') }}
        </p>

        <p class="footer">{{ __('Best regards') }}</p>
    </div>
</body>

</html>
