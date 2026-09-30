<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Forgot Password') }}</title>

    <!-- Use a CDN for Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/forget-password.css') }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ $fav->fav_url ? $fav->fav_url : asset('assets/frontend/img/logo/favicon.png') }}">
</head>


<body>


<!-- OTP Modal -->
<section class="modal_container" id="otp_popup">
    <div class="modal_content">
        <div class="foreget-password-box">

            <div class="form-header text-center">
                <h1>Enter OTP</h1>
                <p>Please type the OTP sent to your email</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="input-group">
                    <label for="otp" class="form-label text-start">OTP Code</label>
                    <input id="otp" type="text" class="" name="otp" placeholder="Enter OTP" required autofocus>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" style="background: #dd5454; border-color:#dd5454">Verify OTP</button>
                </div>
            </form>
            <a href="#" class="text-end mt-2" style="color: #ffffff">Resend OTP</a>
        </div>
    </div>
</section>


    <!-- Backdrop -->
    <div class="modal_backdrop" onclick="closeAllModals()"></div>



    <section class="forget-password-area">
        <div class="foreget-password-box">

            <div class="form-header text-center">
                <h1>{{ __('Forgot Password') }}</h1>
                <p>{{ __('Enter your email address to receive a password reset link.') }}</p>
            </div>

            <form method="POST" action="{{ route('user.forgot.password.update') }}">
                @csrf
                <div class="input-group">
                    <label for="email" class="form-label">{{ __('Email / Phone') }}</label>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" placeholder="Please Enter Your Email or Phone" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" onclick="toggleModal('otp_popup')"
                        style="background: #dd5454; border-color:#dd5454">{{ __('Send OTP') }}</button>
                </div>
            </form>
        </div>
    </section>



    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            const backdrop = document.querySelector('.modal_backdrop');
            const allModals = document.querySelectorAll('.modal_container');

            if (!modal || !backdrop) return;

            // Close all modals first
            allModals.forEach(m => {
                m.classList.remove('active');
                m.style.display = 'none';
            });

            // Open current modal
            modal.style.display = 'flex';
            backdrop.style.display = 'block';

            setTimeout(() => {
                modal.classList.add('active');
                backdrop.classList.add('active');
            }, 10);
        }

        function closeAllModals() {
            const allModals = document.querySelectorAll('.modal_container');
            const backdrop = document.querySelector('.modal_backdrop');

            allModals.forEach(m => {
                m.classList.remove('active');
                m.style.display = 'none';
            });

            backdrop.classList.remove('active');
            setTimeout(() => {
                backdrop.style.display = 'none';
            }, 300);
        }
    </script>

</body>

</html>
