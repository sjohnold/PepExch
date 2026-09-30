<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ $fav->fav_url ? $fav->fav_url : asset('assets/img/icon/favicon.png') }}">

    <title>{{ $appname->value }}</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

</head>

<body>
    <section class="login-section">
        <div class="card loginCard">
            <div class="card-body">
                <div class="page-content text-center">
                    <img src="{{ $applogo->logo_url ?? asset('assets/images/logo.svg') }}" alt="{{ __('logo') }}"
                        loading="lazy" style="max-height:80px; max-width:200px; width:auto; height:auto;" />
                    <h2 class="pageTitle text-white mt-3">{{ __('Welcome to') }}</h2>
                    <p class="pagePera text-white">{{ __('Login to your account.!') }}</p>
                </div>

                <form action="{{ route('admin.login') }}" method="POST"> @csrf
                    <div class="form-outline form-white mb-4">
                        <div class="form-outline form-white mb-3">
                            <input type="text" value="{{ old('email') }}" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ __('Email Address') }}">
                            @error('email')
                                <span class="text text-danger" role="alert">
                                    <span>{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-outline form-white mb-3">
                        <div class="position-relative passwordInput">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('Password') }}">
                            <span class="eye">
                                <i id="togglePassword" class="fas fa-eye-slash"
                                    onclick="togglePasswordVisibility()">
                                </i>
                            </span>
                        </div>
                        @error('password')
                            <span class="text text-danger" role="alert">
                                <span>{{ $message }}</span>
                            </span>
                        @enderror
                    </div>


                    <button class="btn loginButton mt-2" type="submit">{{ __('Login') }}</button>
                    @if (app()->environment('local'))
                        <div class="card rounded mt-4" style="width: 100% !important;border-radius: 6px !important;">
                            <div class="card-body py-2 position-relative text-white">
                                <span class="demoCredential">{{ __('Email') }}:
                                    {{ config('app.root_email') }}</span> <br>
                                <span class="demoCredential">{{ __('Password') }}:
                                    {{ config('app.root_password') }}</span>
                                <button onclick="setLoginCredential()"
                                    class="btn btn-sm btn-outline-dark  position-absolute"
                                    style="right: 10px;top: calc(50% - 15px);" type="button">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>

    </section>

    <!-- Sweet-Alert-link -->
    <script src="{{ asset('assets/scripts/sweetalert2.min.js') }}"></script>

    <script>
        const demoEmail = "{{ config('app.root_email') }}"
        const demoPass = "{{ config('app.root_password') }}"

        function togglePasswordVisibility() {
            const password = document.querySelector("#password");
            const toggleIcon = document.querySelector("#togglePassword");

            const isHidden = password.type === "password";

            password.type = isHidden ? "text" : "password";

            // Update icon classes
            toggleIcon.classList.toggle("fa-eye", isHidden);
            toggleIcon.classList.toggle("fa-eye-slash", !isHidden);
        }

        const setLoginCredential = function() {
            var password = document.getElementById("password");
            var email = document.getElementById("email");

            email.value = demoEmail;
            password.value = demoPass;
        }
    </script>

</body>

</html>
