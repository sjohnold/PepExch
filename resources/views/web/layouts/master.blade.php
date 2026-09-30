<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $appname->value }}</title>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/page-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/header-sticky.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/fixing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/flatpickr.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Place favicon.ico in the root directory -->
    <link rel="icon" type="image/x-icon"
        href="{{ $fav->fav_url ? $fav->fav_url : asset('assets/frontend/img/logo/favicon.png') }}">
    <style>
        :root {
            --tp-theme-color: {{ $themeColors['primary_color'] ?? '#358cef' }};
            --tp-red-color: {{ $themeColors['primary_color'] ?? '#358cef' }};
            --tp-heading-color: {{ $themeColors['text_color'] ?? '#17181d' }};
            --bs-heading-color: {{ $themeColors['text_color'] ?? '#17181d' }};
            --Primary: {{ $themeColors['primary_color'] ?? '#dd5454' }};
            --tp-orange-color: {{ $themeColors['text_color'] ?? '#17181d' }};
            --theme-font-family: {!! $themeColors['font_family'] ?? "'Poppins', sans-serif" !!};

        }
        body { font-family: var(--theme-font-family); }
    </style>
    {{-- stack section --}}
    @stack('styles')
</head>

<body class="div">
    <!-- scrollToTop -->
    <div class="scrollToTop active-progress">
        <div class="arrowUp">
            <i class="fal fa-arrow-up"></i>
        </div>
        <div class="water" style="transform: translate(0px, 47%);">
            <svg viewBox="0 0 560 20" class="water_wave water_wave_back">
                <use xlink:href="#wave"></use>
            </svg>
            <svg viewBox="0 0 560 20" class="water_wave water_wave_front">
                <use xlink:href="#wave"></use>
            </svg>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 560 20" style="display: none;">
                <symbol id="wave">
                    <path
                        d="M420,20c21.5-0.4,38.8-2.5,51.1-4.5c13.4-2.2,26.5-5.2,27.3-5.4C514,6.5,518,4.7,528.5,2.7c7.1-1.3,17.9-2.8,31.5-2.7c0,0,0,0,0,0v20H420z"
                        fill="#"
                        style="transition: stroke-dashoffset 10ms linear; stroke-dasharray: 301.839, 301.839; stroke-dashoffset: 140.858px;">
                    </path>
                    <path
                        d="M420,20c-21.5-0.4-38.8-2.5-51.1-4.5c-13.4-2.2-26.5-5.2-27.3-5.4C326,6.5,322,4.7,311.5,2.7C304.3,1.4,293.6-0.1,280,0c0,0,0,0,0,0v20H420z"
                        fill="#"
                        style="transition: stroke-dashoffset 10ms linear; stroke-dasharray: 301.839, 301.839; stroke-dashoffset: 140.858px;">
                    </path>
                    <path
                        d="M140,20c21.5-0.4,38.8-2.5,51.1-4.5c13.4-2.2,26.5-5.2,27.3-5.4C234,6.5,238,4.7,248.5,2.7c7.1-1.3,17.9-2.8,31.5-2.7c0,0,0,0,0,0v20H140z"
                        fill="#"
                        style="transition: stroke-dashoffset 10ms linear; stroke-dasharray: 301.839, 301.839; stroke-dashoffset: 140.858px;">
                    </path>
                    <path
                        d="M140,20c-21.5-0.4-38.8-2.5-51.1-4.5c-13.4-2.2-26.5-5.2-27.3-5.4C46,6.5,42,4.7,31.5,2.7C24.3,1.4,13.6-0.1,0,0c0,0,0,0,0,0l0,20H140z"
                        fill="#"
                        style="transition: stroke-dashoffset 10ms linear; stroke-dasharray: 301.839, 301.839; stroke-dashoffset: 140.858px;">
                    </path>
                </symbol>
            </svg>
        </div>
    </div>

    <!-- Loader -->
    @include('web.partials.loader')
    <!-- Begin magic cursor -->
    <div id="magic-cursor" class="cursor-black-bg">
        <div id="ball"></div>
    </div>
    <!-- End magic cursor -->

    {{-- header sticky --}}
    @include('web.partials.header-sticky')

    <!-- header start -->
    @include('web.partials.header')
    @include('web.partials.offCanvas')
    <div class="tp-offcanvas-overlay"></div>
    <!-- header end -->
    <main>
        @yield('content')

    </main>

    @include('web.partials.offer')
    <div class="tp-offcanvas-overlay"></div>


    <!-- footer start -->
    @include('web.partials.footer')
    <!-- footer end -->




    <script src="{{ asset('assets/frontend/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/frontend/js/jarallax.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/wow.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/price-filter.js') }}"></script>
    {{-- <script src="{{ asset('assets/frontend/js/header-sticky.js') }}"></script> --}}
    <script src="{{ asset('assets/frontend/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/page-modal.js') }}"></script>

    <!-- Review Modal -->
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                icon: 'success',
                title: "{{ session('success') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                icon: 'error',
                title: "{{ session('error') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif

    <script>
        function confirmAlert(event, wishlistUrl, isInWishlist) {
            @guest
            if (event) event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Oops! Login First',
                html: 'You need to log in to save your favorite products to wishlist!',
                showCancelButton: true,
                confirmButtonText: 'Login Now',
                cancelButtonText: 'Maybe Later',
                confirmButtonColor: '#dd5454',
                cancelButtonColor: '#95a5a6',
            }).then((result) => {
                if (result.isConfirmed) {
                    toggleModal('sign_in_popup');
                }
            });

            return false;
        @endguest



        // Logged-in user
        if (event) event.preventDefault();
        // Check if item is already in wishlist
        if (isInWishlist) {
            // Show remove confirmation
            Swal.fire({
                icon: 'warning',
                iconHtml: '<i class="fas fa-heart-broken" style="color: #ff6b6b;"></i>',
                title: 'Remove from Wishlist?',
                html: 'Do you want to remove this item from your wishlist?',
                showCancelButton: true,
                confirmButtonText: 'Yes, Remove',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#95a5a6',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = wishlistUrl;
                }
            });
        } else {
            // Show add confirmation
            Swal.fire({
                icon: 'success',
                iconHtml: '<i class="fas fa-heart" style="color: #ff6b6b;"></i>',
                title: 'Add to Wishlist?',
                html: 'Save this product to your wishlist for later!',
                showCancelButton: true,
                confirmButtonText: 'Yes, Save It',
                cancelButtonText: 'Not Now',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#95a5a6',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = wishlistUrl;
                }
            });
        }

        return false;
        }


        function logout(el) {
            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out from this account!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dd5454",
                cancelButtonColor: "#aaa",
                confirmButtonText: "Yes, Logout"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = el.querySelector('form');
                    if (form) {
                        form.submit();
                    }
                }
            });
            return false;
        }
    </script>


    @if (session('login_success'))
        <script>
            Swal.fire({
                title: '<strong style="font-size: 28px;">Welcome Back!</strong>',
                html: '<p style="font-size: 17px; margin-top: 15px; color: #555;">{{ session('login_success') }}</p>',
                icon: 'success',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
                position: 'center',
                backdrop: true,
                width: '480px',
                padding: '2.5em',
                iconColor: '#28a745',
                background: '#fff',
                color: '#333',
                customClass: {
                    popup: 'swal2-show',
                    backdrop: 'swal2-backdrop-show',
                    icon: 'swal2-icon-show'
                }
            });
        </script>
    @endif

    @if (session('logout_success'))
        <script>
            Swal.fire({
                title: '<strong style="font-size: 28px;">Logged Out Successfully</strong>',
                html: '<p style="font-size: 17px; margin-top: 15px; color: #555;">{{ session('logout_success') }}</p>',
                icon: 'info',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
                position: 'center',
                backdrop: true,
                width: '480px',
                padding: '2.5em',
                iconColor: '#17a2b8',
                background: '#fff',
                color: '#333',
                customClass: {
                    popup: 'swal2-show',
                    backdrop: 'swal2-backdrop-show',
                    icon: 'swal2-icon-show'
                }
            });
        </script>
    @endif
    @stack('script')
</body>

</html>
