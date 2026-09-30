<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('OTP Verify') }}</title>
</head>

<body>
    <div class="container">

        <h2>{{ __('OTP Verify') }}</h2>

        @if (session('success'))
            <div class="alert alert-success" style="color:green">
                {{ session('success') }}
            </div>
        @endif

        @error('otp')
            <div class="alert alert-danger" style="color:REd">
                {{ $message }}
            </div>
        @enderror

        <form action="{{ route('user.verify.otp.submit') }}" method="POST" id="otpForm">
            @csrf
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

            <div class="form-group">
                <label for="otp">{{ __('OTP') }}</label>
                <input type="text" name="otp" id="otp" value="{{ session('otp') }}" required>
            </div>

            <button type="submit">{{ __('Submit OTP') }} </button>
        </form>

        <form action="{{ route('user.resend.otp') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
            <div id="otp-timer">
                {{ __('Resend OTP in') }} <span id="countdown-display">2</span> {{ __('seconds ') }}
            </div>
            <button id="resend-otp-button" type="submit" disabled>{{ __('Resend OTP') }}</button>



        </form>
    </div>
</body>

</html>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownDisplay = document.getElementById('countdown-display');
        const resendButton = document.getElementById('resend-otp-button');
        let countdown = 6;
        let timer;

        function startTimer() {
            resendButton.disabled = true;
            countdownDisplay.textContent = countdown;
            timer = setInterval(function() {
                countdown--;
                countdownDisplay.textContent = countdown;

                if (countdown <= 0) {
                    clearInterval(timer);
                    resendButton.disabled = false;
                    countdownDisplay.textContent = '';
                    document.getElementById('otp-timer').innerHTML =
                        'Click "Resend OTP" to get a new code.';
                }
            }, 1000);
        }

        startTimer();
    });
</script>
