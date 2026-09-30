<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Reset Password') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/forget-password.css') }}">

    <!-- SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .password-wrapper {
            position: relative;
            width: 100%;
        }
        .password-wrapper input {
            width: 100%;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 1.1rem;
            user-select: none;
        }
        .password-toggle:hover {
            color: #dd5454;
        }
    </style>
</head>

<body>

<section class="forget-password-area">
    <div class="foreget-password-box">
        <div class="form-header text-center">
            <h1>{{ __('Reset Password') }}</h1>
            <p>{{ __('Enter your new password below') }}</p>
        </div>

        <form method="POST" action="{{route('user.forgot.password.store')}}">
            @csrf

            <!-- New Password -->
            <div class="input-group">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <div class="password-wrapper">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="@error('password') is-invalid @enderror"
                        placeholder="Enter new password"
                        required
                        style="padding-right: 40px;"
                    >
                    <i class="fa-regular fa-eye password-toggle" onclick="togglePassword('password', this)"></i>
                </div>

                @error('password')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="input-group mt-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <div class="password-wrapper">
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm new password"
                        required
                        style="padding-right: 40px;"
                    >
                    <i class="fa-regular fa-eye password-toggle" onclick="togglePassword('password_confirmation', this)"></i>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit"
                        class="btn btn-primary"
                        style="background:#dd5454; border-color:#dd5454">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('user.forgot.password') }}" class="text-decoration-none"
               style="color: #dd5454; font-weight: 500;">
                <span style="font-size: 1.2rem;">←</span> {{ __('Back to Forgot Password') }}
            </a>
        </div>
    </div>
</section>

<script>
    // Toggle password visibility
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Success message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#dd5454'
        });
    @endif

    // Error message
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dd5454'
        }).then(() => {
            window.location.href = '{{ route('user.forgot.password') }}';
        });
    @endif

    // Validation errors
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validation Error!',
            html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#dd5454'
        });
    @endif
</script>

</body>
</html>
