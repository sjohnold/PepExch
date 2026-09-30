<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Reset Password') }}</title>
    <!-- Use a CDN for Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a2a47; 
            color: #fff;
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            overflow: hidden;
            font-family: sans-serif;
            margin: 0;
        }
        .reset-password-container {
            width: 90%;
            max-width: 500px;
            background-color: #233a59;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            padding: 2rem;
        }
        .form-header h1 {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
            color: #fff;
        }
        .form-header p {
            color: #adb5bd;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .form-label {
            color: #adb5bd;
            margin-bottom: 0.25rem; 
            font-size: 0.9rem; 
        }
        .form-control {
            background-color: #fff;
            border: none;
            color: black;
            padding: 0.5rem;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .form-control::placeholder {
            color: #6c757d;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            width: 100%;
            font-weight: bold;
            font-size: 1rem;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
        .mb-3-small {
            margin-bottom: 0.75rem !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                overflow-y: auto; 
                height: auto;
                padding: 1rem;
            }
            .reset-password-container {
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
                padding: 1.5rem;
            }
            .form-header h1 {
                font-size: 1.25rem;
            }
            .form-header p {
                font-size: 0.8rem;
            }
            .form-label, .form-control {
                font-size: 0.85rem;
            }
            .btn-primary {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="reset-password-container">
        <div class="form-header text-center">
            <h1>{{ __('Reset Your Password') }}</h1>
            <p>{{ __('Enter your new password below.') }}</p>
        </div>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3 mb-3-small">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 mb-3-small">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 mb-3-small">
                <label for="password-confirm" class="form-label">{{ __('Confirm New Password') }}</label>
                <input id="password-confirm" type="password" class="form-control" 
                       name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
            </div>
        </form>
    </div>
</body>
</html>
