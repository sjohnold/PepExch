<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $theme = app('shared_data')['themeColors'] ?? [];
            $fontFamily = $theme['font_family'] ?? "'Poppins', sans-serif";
        @endphp

        <title inertia>{{ config('app.name', 'PepExch') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">

        <style>
            :root {
                --theme-primary: {{ $theme['primary_color'] ?? '#10b981' }};
                --theme-primary-dark: {{ $theme['secondary_color'] ?? '#059669' }};
                --theme-text: {{ $theme['text_color'] ?? '#17181d' }};
                --theme-font-family: {!! $fontFamily !!};
            }
        </style>

        <!-- Scripts -->
        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased h-full bg-gray-50" style="font-family: var(--theme-font-family); color: var(--theme-text);">
        @inertia
    </body>
</html>
