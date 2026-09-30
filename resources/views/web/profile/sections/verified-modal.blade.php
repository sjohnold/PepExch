<div id="verifiedModal" class="rs-product-make-offer" style="display:none;">
    <div class="rs-product-make-offer-content">
        <button class="rs-product-make-offer-close" id="closeVerified"><i class="fas fa-times"></i></button>
        <h2 class="rs-product-make-offer-title">{{ __('Get Verified ') }}</h2>
        <p>{{ __('Buy smarter. Make an offer and get the best deal. ') }}</p>

        {{-- Step 1: Contact --}}
        <form id="sendOtpForm">
            @csrf
            <div id="phoneStep">
                <label>{{ __('Phone or Email') }}</label>
                <input type="text" id="phoneInput" name="contact" placeholder="Enter Phone or Email"
                    value="{{ optional(auth()->user())->email ?? (optional(auth()->user())->phone_no ?? '') }}">
                <button type="button" id="submitPhone">{{ __('Submit') }}</button>
            </div>
        </form>


        {{-- Step 2: OTP --}}
        <div id="otpStep" style="display:none;">
            <label>{{ __('Enter OTP') }}</label>
            <form id="verifyOtpForm">
                <div class="d-flex align-items-center justify-content-between gap-8">
                    @csrf
                    <input type="text" name="otp[]" maxlength="1" class="otp-box text-center" placeholder="--">
                    <input type="text" name="otp[]" maxlength="1" class="otp-box text-center" placeholder="--">
                    <input type="text" name="otp[]" maxlength="1" class="otp-box text-center" placeholder="--">
                    <input type="text" name="otp[]" maxlength="1" class="otp-box text-center" placeholder="--">
                </div>
                <p id="timer" class="text-center fns-16 fnw-400 m-0" data-color="#687387">
                    {{ __('Resend code in 00:59 sec ') }}
                </p>
                <button id="resendOTPBtn" class="d-none" type="button">
                    {{ __('Resend OTP') }}
                </button>
                <input type="hidden" name="email" value="{{ auth()->user()->email ?? '' }}">
                <input type="hidden" name="phone_no" value="{{ auth()->user()->phone_no ?? '' }}">
                <button type="submit">{{ __('Get Verified ') }}</button>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            const sendOtpForm = document.getElementById('sendOtpForm');
            const submitPhone = document.getElementById('submitPhone');
            const resentOtpBtn = document.getElementById('resendOTPBtn');
            const verifyOtpForm = document.getElementById('verifyOtpForm');
            const phoneInput = document.getElementById('phoneInput');
            const phoneStep = document.getElementById('phoneStep');
            const otpStep = document.getElementById('otpStep');
            const closeBtn = document.getElementById('closeVerified');
            let enteredContact = '';

            // Close button
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    document.getElementById('verifiedModal').style.display = 'none';
                });
            }

            // Submit phone or email
            if (submitPhone && phoneInput) {
                submitPhone.addEventListener('click', function(e) {
                    e.preventDefault();

                    const contact = phoneInput.value.trim();
                    if (contact === "") {
                        phoneInput.style.border = "1px solid #DD5454";
                        Toast.fire({
                            icon: 'error',
                            title: 'Please enter a valid phone or email.'
                        });
                        return;
                    }
                    enteredContact = contact;
                    phoneInput.style.border = "";

                    const token = sendOtpForm.querySelector('input[name="_token"]').value;

                    axios.post("{{ route('user.verify.submit') }}", {
                            contact: contact,
                            _token: token
                        })
                        .then(function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: response.data.success || 'OTP sent successfully!'
                            });
                            phoneStep.style.display = 'none';
                            otpStep.style.display = 'block';
                            window.startCountdown(
                                120);
                        })
                        .catch(function(error) {
                            const msg = error.response?.data?.errors?.contact?.[0] ||
                                'Something went wrong!';
                            Toast.fire({
                                icon: 'error',
                                title: 'Please Enter The Correct Credentials'
                            });
                        });
                });
            }

            // Resend OTP
            if (resentOtpBtn) {
                resentOtpBtn.addEventListener('click', function() {
                    const contact = enteredContact;
                    const token = sendOtpForm.querySelector('input[name="_token"]').value;

                    axios.post("{{ route('user.resend.otp') }}", {
                            contact: contact,
                            _token: token,
                        })
                        .then(function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: response.data.success || 'New OTP sent!'
                            });
                            resentOtpBtn.classList.add('d-none');
                            window.startCountdown(
                                120); // Call startCountdown from min.js with 10 seconds
                        })
                        .catch(function(error) {
                            const msg = error.response?.data?.errors?.contact?.[0] ||
                                'Failed to resend OTP';
                            Toast.fire({
                                icon: 'error',
                                title: msg
                            });
                        });
                });
            }

            // Verify OTP
            if (verifyOtpForm) {
                verifyOtpForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    let otp = [];
                    let allFilled = true;
                    const otpBoxes = document.querySelectorAll('.otp-box');

                    otpBoxes.forEach(box => {
                        if (box.value.trim() === "") {
                            box.style.border = "1px solid #DD5454";
                            allFilled = false;
                        } else {
                            box.style.border = "";
                            otp.push(box.value);
                        }
                    });

                    if (!allFilled) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Please fill all OTP fields.'
                        });
                        return;
                    }

                    const token = verifyOtpForm.querySelector('input[name="_token"]').value;
                    const email = verifyOtpForm.querySelector('input[name="email"]').value;
                    const phone_no = verifyOtpForm.querySelector('input[name="phone_no"]').value;

                    axios.post("{{ route('user.verify.otp.submit') }}", {
                            otp: otp.join(''),
                            contact: enteredContact,
                            email: email,
                            phone_no: phone_no,
                            _token: token
                        })
                        .then(function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: 'OTP verified successfully!'
                            }).then(() => {
                                document.getElementById('verifiedModal').style.display = 'none';
                                location.reload();
                            });
                        })
                        .catch(function(error) {
                            const msg = error.response?.data?.errors?.otp?.[0] ||
                                'Invalid OTP. Please try again.';
                            Toast.fire({
                                icon: 'error',
                                title: msg
                            });
                        });
                });
            }
        });
    </script>
@endpush

<style>
    #resendOTPBtn {
        border: none;
        background-color: white;
        color: var(--tp-red-color);
        font-size: 15px;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.3s ease;
        width: 150px
    }

    #resendOTPBtn:hover {
        border: 1px solid #dd5454;
    }
</style>
