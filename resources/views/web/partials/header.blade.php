<!-- sign_in_popup -->
<section class="rs-product-make-offer" id="sign_in_popup" style="display:none;">
    <div class="rs-product-make-offer-content">
        <button type="button" class="rs-product-make-offer-close" onclick="toggleModal('sign_in_popup')">
            <i class="fas fa-times"></i>
        </button>

        <div class="text-center mb-4">
            <img src="{{ ($applogo->logo_url ? $applogo->logo_url : asset('assets/frontend/img/logo/header-logo.png')) . '?v=' . time() }}"
                 alt="Logo" class="mx-auto h-8 mb-4" style="max-height: 32px">
            <h2 class="rs-product-make-offer-title">{{ __('Prijavite se') }}</h2>
            <p>{{ __('Dobrodošli nazad! Prijavite se na svoj nalog.') }}</p>
        </div>

        <form action="{{ route('user.login.submit') }}" method="POST" id="login-form-popup">
            @csrf
            <div class="rs-input-item mb-3">
                <label>{{ __('Email ili Telefon') }}</label>
                <input type="text" name="contact" id="login-contact" placeholder="Email ili telefon" required value="{{ old('contact') }}">
                @error('contact')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>
            <div class="rs-input-item mb-4">
                <label>{{ __('Lozinka') }}</label>
                <div class="position-relative">
                    <input type="password" name="password" id="login-password" class="password-input" placeholder="********" required>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="login-btn w-100">
                <i class="fas fa-sign-in-alt"></i> {{ __('Prijavi se') }}
            </button>
            
            <div class="text-center mt-4">
                <p style="font-size: 14px;">Nemate nalog? <a href="#" onclick="toggleModal('sign_in_popup'); toggleModal('sign_up_popup')" class="text-green-600 font-bold" style="color: #10b981;">Registrujte se</a></p>
                <a href="{{route('user.forgot.password')}}" class="text-muted text-sm mt-2 d-block">{{ __('Zaboravljena lozinka?') }}</a>
            </div>
        </form>
    </div>
</section>

<!-- sign_up_popup -->
<section class="rs-product-make-offer" id="sign_up_popup" style="display:none;">
    <div class="rs-product-make-offer-content">
        <button type="button" class="rs-product-make-offer-close" onclick="toggleModal('sign_up_popup')">
            <i class="fas fa-times"></i>
        </button>

        <div class="text-center mb-4">
            <h2 class="rs-product-make-offer-title">{{ __('Registracija') }}</h2>
            <p>{{ __('Kreirajte nalog brzo i lako.') }}</p>
        </div>

        <form action="{{ route('user.register.submit') }}" method="POST">
            @csrf
            <div class="rs-input-item mb-2">
                <label>{{ __('Ime i prezime') }}</label>
                <input type="text" name="name" placeholder="Vaše ime" required>
            </div>
            <div class="rs-input-item mb-2">
                <label>{{ __('Email') }}</label>
                <input type="email" name="email" placeholder="vash@email.com" required>
            </div>
            <div class="rs-input-item mb-2">
                <label>{{ __('Telefon') }}</label>
                <div class="d-flex gap-2">
                    <select id="country_code_popup" class="number-select" style="width: 80px;">
                        <option value="">...</option>
                    </select>
                    <input type="text" name="phone_display" placeholder="Broj telefona" style="flex: 1;">
                </div>
                <input type="hidden" name="phone_no">
            </div>
            <div class="rs-input-item mb-4">
                <label>{{ __('Lozinka') }}</label>
                <input type="password" name="password" placeholder="********" required>
            </div>

            <button type="submit" class="rs-btn-primary w-100">
                {{ __('Registruj se') }}
            </button>
            
            <div class="text-center mt-4">
                <p style="font-size: 14px;">Već imate nalog? <a href="#" onclick="toggleModal('sign_up_popup'); toggleModal('sign_in_popup')" class="text-green-600 font-bold" style="color: #10b981;">Prijavite se</a></p>
            </div>
        </form>
    </div>
</section>

<!-- backdrop -->
<div class="modal_backdrop" onclick="closeAllModals()"></div>

<header>
    <div class="rs-header-area">
        <div class="container">
            <div class="rs-header-top">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-lg-4 col-md-3 col-6">
                        <div class="rs-header-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ ($applogo->logo_url ? $applogo->logo_url : asset('assets/frontend/img/logo/header-logo.png')) . '?v=' . time() }}"
                                    alt="" style="max-height: 32px">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-9 col-6">
                        <div class="rs-header-top-right d-flex align-items-center justify-content-end gap-2">
                            @auth
                                <a href="{{ route('user.show-notifications') }}"
                                    class="rs-header-notification d-flex align-items-center d-none d-md-block">
                                    <i class="rs-header-notification-icon">
                                        <img src="{{ asset('assets/frontend/img/icon/bell.svg') }}" alt="">
                                    </i>
                                    <span class="alert-badge">{{ getUnreadNotificationsCount(true) }}</span>
                                </a>
                            @endauth

                            @auth
                                <a href="{{ route('wishlist.index') }}"
                                    class="rs-header-notification d-flex align-items-center d-none d-md-block">
                                    <i class="rs-header-notification-icon">
                                        <img src="{{ asset('assets/frontend/img/icon/heart.svg') }}" alt="">
                                    </i>
                                    <span class="alert-badge wishlist-count" id="wishlist-count">
                                        {{ $wishListcount }}
                                    </span>
                                </a>
                            @endauth
                            @auth
                                <a href="{{ route('product-ad') }}"
                                    class="rs-header-btn d-flex align-items-center d-none d-md-block">
                                    {{ __('Post Your Ad') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none">
                                        <path
                                            d="M15 7H9V1C9 0.448 8.552 0 8 0C7.448 0 7 0.448 7 1V7H1C0.448 7 0 7.448 0 8C0 8.552 0.448 9 1 9H7V15C7 15.552 7.448 16 8 16C8.552 16 9 15.552 9 15V9H15C15.552 9 16 8.552 16 8C16 7.448 15.552 7 15 7Z"
                                            fill="white" />
                                    </svg>
                                </a>
                            @else
                                <a onclick="toggleModal('sign_in_popup')"
                                    class="rs-header-btn d-flex align-items-center d-none d-md-block">
                                    {{ __('Post Your Ad') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none">
                                        <path
                                            d="M15 7H9V1C9 0.448 8.552 0 8 0C7.448 0 7 0.448 7 1V7H1C0.448 7 0 7.448 0 8C0 8.552 0.448 9 1 9H7V15C7 15.552 7.448 16 8 16C8.552 16 9 15.552 9 15V9H15C15.552 9 16 8.552 16 8C16 7.448 15.552 7 15 7Z"
                                            fill="white" />
                                    </svg>
                                </a>
                            @endauth
                            <div class="tp-header-author p-relative">
                                <a href="javascript:void(0)" class="rs-header-abtar">
                                    @if (auth()->check())
                                        <div class="tp-header-author-thumb-more p-absolute bg-white rounded shadow-sm"
                                            style="padding: 8px 0; min-width: 200px; box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;">

                                            <a href="{{ route('user.profile') }}"
                                                class="{{ request()->routeIs('user.profile') ? 'active-menu' : '' }}">
                                                <i class="fal fa-user"></i>
                                                {{ __('Profile') }}
                                            </a>

                                            <a href="{{ route('chat.index') }}"
                                                class="{{ request()->routeIs('chat.index') ? 'active-menu' : '' }}">
                                                <i class="fal fa-envelope"></i>
                                                {{ __('Messages') }}
                                            </a>

                                            <a href="{{ route('wishlist.index') }}"
                                                class="{{ request()->routeIs('wishlist.index') ? 'active-menu' : '' }}">
                                                <i class="fal fa-heart"></i>
                                                {{ __('Wishlists') }}
                                            </a>

                                            <a href="{{ route('user.my-ads') }}"
                                                class="{{ request()->routeIs('user.my-ads') ? 'active-menu' : '' }}">
                                                <i class="fal fa-bullhorn"></i>
                                                {{ __('My Ads') }}
                                            </a>



                                            <a href="javascript:void(0)" onclick="logout(this)" class="logout-link">
                                                <i class="fal fa-sign-out"></i>
                                                {{ __('Logout') }}

                                                <form method="POST" action="{{ route('user.logout') }}" style="display:none;">
                                                    @csrf
                                                </form>
                                            </a>


                                        </div>

                                        <div
                                            class="tp-header-author-content mr-12 text-end d-flex align-items-center justify-content-between gap-2">
                                            <a href="#" class="tp-header-author-name d-block">
                                                {{ strlen(auth()->user()?->name) > 15 ? substr(auth()->user()?->name, 0, 15) . '...' : auth()->user()?->name ?? 'Guest' }}
                                                <br>
                                                <span>
                                                    {{ auth()->user()?->getRoleNames()?->first() ?? 'User' }}
                                                </span>
                                            </a>
                                            <div class="tp-header-author-img p-relative">
                                                <img src="{{ auth()->user()->profilePhotoPath ?? asset('media/demo-img.png') }}"
                                                    alt="{{ auth()->user()->profilePhotoPath ?? asset('media/demo-img.png') }}"
                                                    class="border-radius-100">
                                            </div>
                                        </div>
                                    @else
                                        <a href="#" onclick="toggleModal('sign_in_popup')"
                                            class="rs-sign-in-btn d-flex align-items-center justify-content-center gap-6">
                                            <i class="fas fa-sign-out-alt fs-4"></i>
                                            {{ __('Sign In') }}
                                        </a>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rs-header-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-7 col-md-12">
                        <div class="rs-header-main-menu d-none d-lg-block">
                            <nav class="tp-mobile-menu-active">
                                <ul>
                                    @include('web.partials.navigation-menu')
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-5 col-md-12">
                        <div class="rs-header-form">

                            <form action="{{ route('products') }}" method="GET"
                                class="d-flex align-items-center position-relative">
                                <input type="text" name="product_search" id="searchInput" maxlength="255"
                                    placeholder="Search Product Here." value="{{ request('product_search') }}"
                                    autocomplete="off">
                                <button type="submit" class="rs-header-search-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z"
                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M22 22L20 20" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>

                                <!-- Suggestion dropdown -->
                                <ul id="suggestionBox" class="suggestion-box"></ul>
                            </form>


                            <div class="rs-offcanvas-btn">
                                <button class="d-lg-none d-md-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M2.94801 5.07455C1.84307 5.08612 0.938738 4.19953 0.927183 3.09559C0.915628 1.99165 1.8012 1.08634 2.90614 1.07477C4.01108 1.0632 4.91541 1.94979 4.92696 3.05373C4.93852 4.15767 4.05295 5.06299 2.94801 5.07455ZM11.9266 2.98046C11.915 1.87652 11.0107 0.989939 9.90576 1.0015C8.80082 1.01307 7.91524 1.91839 7.9268 3.02233C7.93835 4.12627 8.84268 5.01285 9.94762 5.00129C11.0526 4.98972 11.9381 4.0844 11.9266 2.98046ZM18.9262 2.9072C18.9146 1.80326 18.0103 0.916674 16.9054 0.928239C15.8004 0.939805 14.9149 1.84512 14.9264 2.94906C14.938 4.053 15.8423 4.93959 16.9472 4.92802C18.0522 4.91645 18.9378 4.01114 18.9262 2.9072ZM5.00023 10.0533C4.98867 8.9494 4.08435 8.06282 2.97941 8.07439C1.87447 8.08595 0.988893 8.99127 1.00045 10.0952C1.012 11.1991 1.91633 12.0857 3.02127 12.0742C4.12621 12.0626 5.01178 11.1573 5.00023 10.0533ZM11.9998 9.98008C11.9883 8.87614 11.084 7.98956 9.97902 8.00112C8.87408 8.01269 7.98851 8.91801 8.00006 10.0219C8.01162 11.1259 8.91595 12.0125 10.0209 12.0009C11.1258 11.9893 12.0114 11.084 11.9998 9.98008ZM18.9995 9.90681C18.9879 8.80287 18.0836 7.91629 16.9786 7.92786C15.8737 7.93942 14.9881 8.84474 14.9997 9.94868C15.0112 11.0526 15.9156 11.9392 17.0205 11.9276C18.1254 11.9161 19.011 11.0108 18.9995 9.90681ZM5.07349 17.053C5.06194 15.949 4.15761 15.0624 3.05267 15.074C1.94773 15.0856 1.06216 15.9909 1.07371 17.0948C1.08527 18.1988 1.9896 19.0853 3.09454 19.0738C4.19948 19.0622 5.08505 18.1569 5.07349 17.053ZM12.0731 16.9797C12.0616 15.8758 11.1572 14.9892 10.0523 15.0007C8.94735 15.0123 8.06178 15.9176 8.07333 17.0216C8.08489 18.1255 8.98921 19.0121 10.0942 19.0005C11.1991 18.989 12.0847 18.0836 12.0731 16.9797ZM19.0727 16.9064C19.0612 15.8025 18.1568 14.9159 17.0519 14.9275C15.947 14.939 15.0614 15.8444 15.0729 16.9483C15.0845 18.0522 15.9888 18.9388 17.0938 18.9273C18.1987 18.9157 19.0843 18.0104 19.0727 16.9064Z"
                                            fill="#16a34a" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


@push('script')
    <script>
        $(document).ready(function() {
            let suggestionBox = $('#suggestionBox');
            let typingTimer;
            const typingInterval = 1000; // 1 second

            $('#searchInput').on('keyup', function() {
                clearTimeout(typingTimer); // clear previous timer
                let query = $(this).val().trim();
                if (!query) {
                    suggestionBox.hide();
                    return;
                }

                // set new timer to trigger AJAX after 1 second of inactivity
                typingTimer = setTimeout(() => {
                    $.ajax({
                        url: "{{ route('search.suggestions') }}",
                        method: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            console.log(data);

                            if (data.length > 0) {
                                let html = '';
                                data.forEach(item => {
                                    html +=
                                        `<li class="suggest-item">${item}</li>`;
                                });
                                suggestionBox.html(html).show();
                            } else {
                                suggestionBox.hide();
                            }
                        }
                    });
                }, typingInterval);
            });
            // Click on suggestion to populate input
            $(document).on('click', '.suggest-item', function() {
                let text = $(this).text();
                $('#searchInput').val(text);
                suggestionBox.hide();
            });

            // Hide suggestions if clicked outside
            $(document).click(function(e) {
                if (!$(e.target).closest('form').length) {
                    suggestionBox.hide();
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->has('contact') || $errors->has('password'))
                toggleModal('sign_in_popup');
            @endif

            @if($errors->has('name') || $errors->has('email') || $errors->has('phone_no'))
                toggleModal('sign_up_popup');
            @endif
        });
    </script>


    <script>
        const registrationForm = document.getElementById('registration-form');
        registrationForm?.addEventListener('submit', function(e) {
            const termsCheckbox = document.getElementById('terms');

            if (termsCheckbox && !termsCheckbox.checked) {
                e.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Terms Required!',
                    text: 'Please accept the Terms and Conditions to continue',
                    confirmButtonColor: '#dd5454'
                });
            }
        });
    </script>

    <script>
        // Set demo login credentials
        function setUserLoginCredential() {
            const demoEmail = "{{ config('app.root_email') }}";
            const demoPassword = "{{ config('app.root_password') }}";

            document.getElementById('login-contact').value = demoEmail;
            document.getElementById('login-password').value = demoPassword;
        }
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('country_code');
    const phoneInput = document.querySelector('input[name="phone_display"]');
    const phoneHidden = document.querySelector('input[name="phone_no"]');

    if (!select || !phoneInput || !phoneHidden) return;

    fetch('https://restcountries.com/v3.1/all?fields=name,idd,flag,cca2')
        .then(response => response.json())
        .then(data => {
            select.innerHTML = '';

            data.sort((a, b) => a.name.common.localeCompare(b.name.common));

            data.forEach(country => {
                if (country.idd.root) {
                    const dialCode = country.idd.root + (country.idd.suffixes ? country.idd.suffixes[0] : '');
                    const option = document.createElement('option');
                    option.value = dialCode;
                    option.textContent = `${country.flag} ${dialCode}`;

                    if ('{{ old('country_code') }}' === dialCode) {
                        option.selected = true;
                    } else if (dialCode === '+880' && !'{{ old('country_code') }}') {
                        option.selected = true;
                    }

                    select.appendChild(option);
                }
            });

            function updatePhoneWithCode() {
                const countryCode = select.value;
                const phoneNumber = phoneInput.value;
                phoneHidden.value = countryCode + phoneNumber;
            }

            select.addEventListener('change', updatePhoneWithCode);
            phoneInput.addEventListener('input', updatePhoneWithCode);
            updatePhoneWithCode();
        })
        .catch(error => {
            console.error('Error loading countries:', error);
            if (select) {
                select.innerHTML = `<option value="+880">🇧🇩 +880</option>`;
            }
        });
});
</script>

@endpush
