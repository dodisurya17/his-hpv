<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HIS HPV') }} — Masuk</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon-180.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy-deep: #14235C;
            --navy: #1B3B78;
            --blue: #2E5AAC;
            --red: #E0483E;
            --ice: #F3F7FC;
            --ink: #1D2733;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        .font-display {
            font-family: 'Baloo 2', 'Inter', sans-serif;
        }
    </style>
</head>

<body class="antialiased text-[var(--ink)]" style="background-color: var(--ice);">
    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- Brand panel -->
        <div class="relative lg:w-[45%] flex flex-col justify-between overflow-hidden px-8 py-10 sm:px-14 sm:py-14"
            style="background: linear-gradient(160deg, var(--navy-deep) 0%, var(--navy) 55%, var(--blue) 100%);">

            <!-- decorative dot pattern -->
            <div class="pointer-events-none absolute inset-0 opacity-[0.12]"
                style="background-image: radial-gradient(currentColor 1.5px, transparent 1.5px); background-size: 22px 22px; color: #ffffff;"></div>

            <a href="/" class="relative z-10 inline-flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'HIS HPV') }}" class="h-14 w-14 drop-shadow-lg rounded-md">
                <span class="font-display text-2xl font-bold text-white tracking-tight">HIS HPV</span>
            </a>

            <div class="relative z-10 max-w-sm">
                <h1 class="font-display text-3xl sm:text-4xl font-bold text-white leading-tight">
                    Melindungi generasi dari HPV.
                </h1>
                <p class="mt-4 text-[15px] leading-relaxed text-blue-100/90">
                    Masuk untuk memantau jadwal, status, dan catatan vaksinasi HPV dengan mudah dan aman.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-2 text-sm text-blue-100/80">
                <svg class="h-4 w-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 1.5l6.5 2.9v5.1c0 4.6-3 8.7-6.5 9.9-3.5-1.2-6.5-5.3-6.5-9.9V4.4L10 1.5zm-1 10.4L6.4 9.3l1.06-1.06L9 9.88l3.54-3.54L13.6 7.4 9 12z" clip-rule="evenodd" />
                </svg>
                <span>Data terenkripsi &amp; hanya untuk petugas terverifikasi</span>
            </div>
        </div>

        <!-- Form panel -->
        <div class="flex flex-1 items-center justify-center px-6 py-12 sm:px-10">
            <div class="w-full max-w-md">
                <div class="mb-8 flex justify-center lg:hidden">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'HIS HPV') }}" class="h-16 w-16">
                </div>

                <div class="rounded-3xl bg-white px-7 py-9 shadow-[0_10px_40px_-12px_rgba(20,35,92,0.18)] sm:px-10 sm:py-10">
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'HIS HPV') }}. Semua hak dilindungi.
                </p>
            </div>
        </div>
    </div>
</body>

</html>