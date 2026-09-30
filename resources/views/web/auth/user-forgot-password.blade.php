<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Forgot Password') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/forget-password.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .timer-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            text-align: center;
            display: none;
        }
        .timer-text {
            font-size: 1.3rem;
            font-weight: bold;
            color: #dd5454;
            margin-bottom: 8px;
        }
        .attempt-text {
            font-size: 0.95rem;
            color: #666;
        }
    </style>
</head>
<body>

<section class="forget-password-area">
    <div class="foreget-password-box">
        <div class="form-header text-center">
            <h1>{{ __('Forgot Password') }}</h1>
            <p id="instruction-text">{{ __('Enter your email or phone number') }}</p>
        </div>

        <!-- Step 1: Contact Input Form -->
        <form id="contact-form">
            @csrf
            <div class="input-group">
                <label for="contact" class="form-label">{{ __('Email or Phone') }}</label>
                <input
                    id="contact"
                    type="text"
                    name="contact"
                    placeholder="Enter email or phone"
                    required
                >
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary" id="send-otp-btn" style="background:#dd5454; border-color:#dd5454">
                    {{ __('Send OTP') }}
                </button>
            </div>
        </form>

        <!-- Step 2: OTP Verification Form (Hidden) -->
        <form id="otp-form" style="display:none;" method="POST" action="{{ route('user.forgot.password.verify.otp') }}">
            @csrf
            <input type="hidden" name="contact" id="hidden-contact">

            <div class="input-group">
                <label for="otp" class="form-label">{{ __('Enter OTP') }}</label>
                <input id="otp" type="text" name="otp" placeholder="Enter 6-digit OTP" maxlength="6" required >
            </div>


            <!-- Timer Section -->
            <div class="timer-section" id="timer-section">
                <div class="timer-text">
                    Time remaining: <span id="timer">03:00</span>
                </div>
                <div class="attempt-text">
                    Resend attempts left: <span id="attempts">3</span>/3
                </div>
            </div>


            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    {{ __('Verify OTP') }}
                </button>
            </div>


           <div class="d-grid gap-2 mt-3">
                <div class="d-grid gap-2 mt-3">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        id="resend-btn"
                        disabled
                        style="width:120px;margin-left:auto;"
                    >
                        {{ __('Resend OTP') }}
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-decoration-none"
               style="color: #dd5454; font-weight: 500;">
                <span style="font-size: 1.2rem;">←</span> {{ __('Back to Home') }}
            </a>
        </div>
    </div>
</section>

<script>
    // Variables
    let timeRemaining = 180; // 3 minutes = 180 seconds
    let timerInterval = null;
    let attemptsLeft = 3;
    let currentContact = '';

    const contactForm = document.getElementById('contact-form');
    const otpForm = document.getElementById('otp-form');
    const sendOtpBtn = document.getElementById('send-otp-btn');
    const resendBtn = document.getElementById('resend-btn');
    const contactInput = document.getElementById('contact');
    const hiddenContactInput = document.getElementById('hidden-contact');
    const timerSection = document.getElementById('timer-section');
    const instructionText = document.getElementById('instruction-text');

    // Step 1: Send OTP
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();

        currentContact = contactInput.value.trim();

        if (!currentContact) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please enter email or phone',
                confirmButtonColor: '#dd5454'
            });
            return;
        }

        sendOTP();
    });

    // Function to send OTP
    function sendOTP() {
        sendOtpBtn.disabled = true;
        sendOtpBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';

        fetch('{{ route('user.forgot.password.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ contact: currentContact })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'OTP Sent!',
                    text: 'Please check your email/phone',
                    confirmButtonColor: '#dd5454',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Switch to OTP form
                contactForm.style.display = 'none';
                otpForm.style.display = 'block';
                timerSection.style.display = 'block';
                instructionText.textContent = 'Enter the OTP sent to ' + currentContact;
                hiddenContactInput.value = currentContact;

                // Start timer
                startTimer();
            } else {
                throw new Error(data.message || 'Contact not found');
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Contact not found. Please try again.',
                confirmButtonColor: '#dd5454'
            });
        })
        .finally(() => {
            sendOtpBtn.disabled = false;
            sendOtpBtn.innerHTML = '{{ __('Send OTP') }}';
        });
    }

    // Timer function
    function startTimer() {
        timeRemaining = 180; // Reset to 3 minutes
        resendBtn.disabled = true;

        // Clear existing interval
        if (timerInterval) {
            clearInterval(timerInterval);
        }

        timerInterval = setInterval(() => {
            timeRemaining--;

            // Update timer display
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            document.getElementById('timer').textContent =
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            // Check if timer finished
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                resendBtn.disabled = false;
                document.getElementById('timer').textContent = 'Expired!';
                document.getElementById('timer').style.color = '#dc3545';
            }
        }, 1000);
    }

    // Resend OTP button
    resendBtn.addEventListener('click', function() {
        // Check attempts
        if (attemptsLeft <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Maximum Attempts Reached!',
                text: 'You have used all 3 attempts. Please start from the beginning.',
                confirmButtonColor: '#dd5454'
            }).then(() => {
                location.reload();
            });
            return;
        }

        // Decrease attempts
        attemptsLeft--;
        document.getElementById('attempts').textContent = attemptsLeft;

        // Show warning if last attempt
        if (attemptsLeft === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Last Attempt!',
                text: 'This was your last resend attempt. After this, you need to restart.',
                confirmButtonColor: '#dd5454'
            });
        }

        // Resend OTP
        resendBtn.disabled = true;
        resendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';

        fetch('{{ route('user.forgot.password.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ contact: currentContact })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'OTP Resent!',
                    text: 'A new OTP has been sent',
                    confirmButtonColor: '#dd5454',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Restart timer
                document.getElementById('timer').style.color = '#dd5454';
                startTimer();
            } else {
                throw new Error('Failed to resend OTP');
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to resend OTP. Please try again.',
                confirmButtonColor: '#dd5454'
            });
            resendBtn.disabled = false;
        })
        .finally(() => {
            resendBtn.innerHTML = '{{ __('Resend OTP') }}';
        });
    });

    // Success/Error messages from server
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#dd5454'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dd5454'
        });
    @endif

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
