<!DOCTYPE html>
<html lang="sr" style="scroll-behavior: smooth; overscroll-behavior: none;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava — {{ $appname->value }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $fav->fav_url ? $fav->fav_url : asset('assets/frontend/img/logo/favicon.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #064e3b 0%, #047857 40%, #10b981 100%);
            padding: 20px;
        }
        .login-container {
            display: flex;
            max-width: 900px;
            width: 100%;
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-left {
            flex: 1;
            background: linear-gradient(160deg, #022c22, #064e3b, #047857);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            top: -80px; right: -80px;
        }
        .login-left::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.1);
            bottom: -60px; left: -60px;
        }
        .login-left img { max-height: 80px; margin-bottom: 30px; position: relative; z-index: 1; }
        .login-left h2 {
            font-size: 28px; font-weight: 800; margin-bottom: 12px;
            position: relative; z-index: 1;
        }
        .login-left p {
            font-size: 14px; opacity: 0.85; line-height: 1.7; max-width: 280px;
            position: relative; z-index: 1;
        }
        .login-left .decorative-icons {
            margin-top: 30px; display: flex; gap: 20px; font-size: 28px; opacity: 0.3;
            position: relative; z-index: 1;
        }
        .login-right {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-right h3 {
            font-size: 24px; font-weight: 700; color: #064e3b; margin-bottom: 6px;
        }
        .login-right .subtitle {
            font-size: 13px; color: #6b7280; margin-bottom: 30px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap i.field-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; font-size: 14px;
        }
        .input-wrap input {
            width: 100%; padding: 14px 14px 14px 42px;
            border: 2px solid #e5e7eb; border-radius: 14px;
            font-size: 14px; font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s, box-shadow 0.3s;
            outline: none; background: #f9fafb;
        }
        .input-wrap input:focus {
            border-color: #10b981; background: #fff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }
        .input-wrap .toggle-pw {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: #9ca3af; font-size: 14px;
            transition: color 0.2s;
        }
        .input-wrap .toggle-pw:hover { color: #047857; }
        .error-msg { color: #dc2626; font-size: 12px; margin-top: 4px; }
        .login-btn {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; border: none; border-radius: 14px;
            font-size: 15px; font-weight: 700; font-family: 'Poppins', sans-serif;
            cursor: pointer; transition: transform 0.2s, box-shadow 0.3s;
            letter-spacing: 0.5px;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
        }
        .login-btn:active { transform: translateY(0); }
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 24px 0; color: #d1d5db; font-size: 12px;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #e5e7eb;
        }
        .social-btns { display: flex; gap: 12px; }
        .social-btns a {
            flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px; border: 2px solid #e5e7eb; border-radius: 12px;
            text-decoration: none; color: #374151; font-size: 13px; font-weight: 500;
            transition: border-color 0.3s, background 0.3s;
        }
        .social-btns a:hover { border-color: #10b981; background: #f0fdf4; }
        .social-btns a img { height: 20px; }
        .bottom-link {
            text-align: center; margin-top: 24px; font-size: 13px; color: #6b7280;
        }
        .bottom-link a {
            color: #059669; font-weight: 600; text-decoration: none;
        }
        .bottom-link a:hover { text-decoration: underline; }
        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-container { max-width: 440px; border-radius: 20px; }
            .login-right { padding: 40px 28px; }
        }
    </style>
</head>
<body>

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: "{{ session('success') }}", showConfirmButton: false, timer: 3000, timerProgressBar: true });
        });
    </script>
    @endif
    @if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: "{{ session('error') }}", showConfirmButton: false, timer: 3000, timerProgressBar: true });
        });
    </script>
    @endif
    @if (session('logout_success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: "{{ session('logout_success') }}", showConfirmButton: false, timer: 3000, timerProgressBar: true });
        });
    </script>
    @endif

    <div class="login-container">
        {{-- LEFT PANEL --}}
        <div class="login-left">
            <img src="{{ ($applogo->logo_url ? $applogo->logo_url : asset('assets/frontend/img/logo/header-logo.png')) . '?v=' . time() }}" alt="PepExch">
            <h2>Dobrodošli na PepExch</h2>
            <p>Platforma za razmenu stvari bez novca. Zameni, promeni — bilo šta, bilo gde.</p>
            <div class="decorative-icons">
                <i class="fas fa-exchange-alt"></i>
                <i class="fas fa-handshake"></i>
                <i class="fas fa-recycle"></i>
            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="login-right">
            <h3>Prijavi se</h3>
            <p class="subtitle">Unesite podatke za pristup vašem nalogu</p>

            <form action="{{ route('user.login.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="contact">Email ili telefon</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="text" name="contact" id="contact" placeholder="npr. korisnik@email.com" value="{{ old('contact') }}" autocomplete="email">
                    </div>
                    @error('contact')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="passwordInput">Lozinka</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" name="password" id="passwordInput" placeholder="••••••••" autocomplete="current-password">
                        <i class="far fa-eye toggle-pw" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Prijavi se
                </button>
            </form>

            <div class="divider">ili</div>

            <div class="social-btns">
                <a href="{{ route('social.auth.redirect', 'google') }}">
                    <img src="{{ asset('assets/frontend/img/icon/Google-Icon.svg') }}" alt="Google">
                    Google
                </a>
                <a href="{{ route('social.auth.redirect', 'facebook') }}">
                    <i class="fab fa-facebook" style="color: #1877F2; font-size: 20px;"></i>
                    Facebook
                </a>
            </div>

            <div class="bottom-link">
                Nemate nalog? <a href="{{ route('register') }}">Registrujte se</a>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', () => {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                togglePassword.classList.toggle('fa-eye', !isHidden);
                togglePassword.classList.toggle('fa-eye-slash', isHidden);
            });
        }
    </script>
</body>
</html>
