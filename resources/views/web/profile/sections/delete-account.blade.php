@push('styles')
    <style>
        .delete-account-container {
            max-width: 800px;
            margin: 60px auto;
            /* Reduced top margin */
            padding: 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
        }

        .delete-account-container h2 {
            font-size: 28px;
            /* slightly smaller for better spacing */
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 20px;
            /* reduced bottom margin */
            text-align: center;
        }

        .delete-account-container p {
            font-size: 16px;
            /* slightly smaller */
            color: #4a4a4a;
            line-height: 1.6;
            margin-bottom: 20px;
            /* reduced bottom margin */
        }

        .alert-info {
            background-color: #e7f3ff;
            border: 1px solid #b8daff;
            color: #004085;
            font-size: 15px;
            padding: 15px;
            /* reduced padding */
            border-radius: 10px;
            margin-bottom: 20px;
            /* reduced margin */
        }

        .alert-info strong {
            font-weight: 600;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            /* reduced spacing */
        }

        .form-check-input {
            width: 1.5em;
            height: 1.5em;
            margin-right: 10px;
            cursor: pointer;
        }

        .form-check-label {
            font-size: 16px;
            color: #333;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-danger:disabled {
            background-color: #e57373;
            cursor: not-allowed;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .mx-2 {
            margin: 0 8px;
        }

        .text-danger {
            font-size: 14px;
            color: #dc3545;
            margin-top: 6px;
            display: block;
        }


        /* Responsive adjustments */
        .delete-account-container {
            margin-right: auto;
            margin-top: auto;
            padding: 30px 20px;
        }

        .delete-account-container h2 {
            font-size: 24px;
        }

        .delete-account-container p {
            font-size: 15px;
        }
    </style>
@endpush


@extends('web.profile.profile-master')
@section('trash-content')
    <div class="">
        <div class="rs-profile-head d-flex align-items-center justify-content-center br-8 p-16 mb-16" data-bg-color="#F6F7F9">
            <div class="profile-side-bar d-xl-none">
                <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
            </div>
            <h2 class="rs-profile-title">
                {{ __('Delete Your Account') }}
            </h2>
        </div>
        <div class="delete-account-container">
            <p>
                {{ __(' By deleting your account, all your posts, personal data, and associated information will be permanently removed from our platform. However, you can request account recovery by contacting our support team at') }}
                <a href="mailto:support@example.com">{{ __('support@example.com') }}</a>
                {{ __('within 07 days from today.') }}
            </p>
            <div class="alert-info">
                <strong>{{ __('Important:') }}</strong>
                {{ __('Once the 07-day period expires, your account and data cannot be recovered. Please ensure you understand the implications before proceeding.') }}
            </div>

            <form id="deleteAccountForm" action="{{ route('user.delete-account') }}" method="POST">
                @csrf
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                    <label class="form-check-label" for="agree">{{ __('I agree to the Terms and Conditions') }}</label>
                    @error('agree')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn-danger" id="deleteBtn"
                    disabled>{{ __('I Agree, Delete My Account') }}</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Enable/disable delete button based on checkbox
        document.getElementById('agree').addEventListener('change', function() {
            document.getElementById('deleteBtn').disabled = !this.checked;
        });

        // Handle form submission with SweetAlert2 confirmation
        document.getElementById('deleteAccountForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete your account. You can recover it within 30 days by contacting support@example.com.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete My Account',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn-danger mx-2',
                    cancelButton: 'btn-secondary mx-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Session Success Message with SweetAlert2 Toast
        @if (session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif
    </script>
@endpush
