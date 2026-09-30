<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-style-mode" content="1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $fontFamily = $themeColors['font_family'] ?? "'Poppins', sans-serif";
    @endphp
    <title>{{ $appname->value ?? 'PepExch' }}</title>
    <style>
        :root {
            --theme-primary: {{ $themeColors['primary_color'] ?? '#10b981' }};
            --theme-primary-dark: {{ $themeColors['secondary_color'] ?? '#059669' }};
            --theme-text: {{ $themeColors['text_color'] ?? '#17181d' }};
            --theme-font-family: {!! $fontFamily !!};
        }
        body {
            font-family: var(--theme-font-family);
            color: var(--theme-text);
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/notification.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ $fav->fav_url ?? asset('assets/frontend/img/logo/favicon.png') }}">

    <link href="{{ asset('summernote/summernote-bs5.css') }}" rel="stylesheet">
    <!-- Add Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @yield('style')
    @stack('style')
    <!-- Place favicon.ico in the root directory -->

</head>

<body class="body-area">
    <!-- back-to-top-start -->
    <button class="back-to-top" type="button"><i class="far fa-arrow-up"></i></button>
    <!-- dashboard-start -->
    <div class="dashboard-wrapper">
        <!-- sidebar-area-start -->
        @include('partials.sidebar')
        <!-- sidebar-area-end -->
        <!-- overlay- -->
        <div class="tp-sidebar-overlay d-md-block d-lg-none"></div>
        <!-- page__body-start -->
        <div class="page__body-wrapper">
            <!-- header-start -->
            @include('partials.header')
            <!-- header-end -->
            <!-- demo_main_content_area-start -->
            <div class="demo_main_content_area">
                @yield('content')
            </div>
            <!-- demo_main_content_area-end -->
        </div>
        <!-- page__body-end -->
    </div>
    <!-- dashboard-end -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/font') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('summernote/summernote-bs5.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>



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

    @stack('scripts')
</body>

</html>
