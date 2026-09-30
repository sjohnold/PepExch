@extends('web.profile.profile-master')
@section('user-change-password')
    <div class="rs-profile-head d-flex align-items-center justify-content-center br-8 p-16 mb-16" data-bg-color="#F6F7F9">
        <div class="profile-side-bar d-xl-none">
            <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
        </div>
        <h2 class="rs-profile-title">
            {{ __('Change Password') }}
        </h2>
    </div>

    <div class="rs-password-change-area p-24">
        <form action="{{ route('user.change-password') }}" method="POST">
            @csrf <!-- Required for Laravel form security -->
            <div class="rs-password-change-input-box">
                <div class="rs-password-change-input-item p-relative">
                    <h4 class="rs-password-change-title">{{ __('Current Password') }}</h4>
                    <input type="password" name="current_password" placeholder="********" class="passwordInput">
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="rs-password-change-input-item p-relative">
                    <h4 class="rs-password-change-title">{{ __('New Password') }}</h4>
                    <input type="password" name="password" placeholder="********" class="passwordInput">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="rs-password-change-input-item p-relative mb-0">
                    <h4 class="rs-password-change-title">{{ __('Confirm Password') }}</h4>
                    <input type="password" name="password_confirmation" placeholder="********" class="passwordInput">
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <label id="Visible_Password" class="custom-checkbox justify-content-end mt-12">
                    {{__('Visible Password')}}
                    <input type="checkbox" name="negotiable">
                    <span class="checkmark password_checkmark">
                        <svg class="checkmark-svg" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 20 20" fill="none">
                            <path
                                d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14.03 8.20001L9.35999 12.86C9.21999 13.01 9.02999 13.08 8.82999 13.08C8.63999 13.08 8.44999 13.01 8.29999 12.86L5.97 10.53C5.68 10.24 5.68 9.75997 5.97 9.46997C6.26 9.17997 6.74 9.17997 7.03 9.46997L8.82999 11.27L12.97 7.14001C13.26 6.84001 13.74 6.84001 14.03 7.14001C14.32 7.43001 14.32 7.90001 14.03 8.20001Z"
                                fill="#DD5454"></path>
                        </svg>
                    </span>
                </label>
            </div>

            <div class="rs-password-change-btn p-24 mt-16" data-bg-color="#F6F7F9">
                <button type="submit" class="rs-btn br-8">{{ __('Save Password') }} </button>
            </div>
        </form>
    </div>
@endsection



@push('script')
    <script>
        // Define SweetAlert2 Toast Mixin (matches OTP verification style)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        // Success Alert
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        // Error Alert
        @if ($errors->any())
            Toast.fire({
                icon: 'error',
                title: '{{ $errors->first() }}'
            });
        @endif

        // Toggle Password Visibility
        document.querySelectorAll('.togglePassword').forEach(icon => {
            icon.addEventListener('click', () => {
                const input = icon.previousElementSibling;
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });
    </script>
@endpush
