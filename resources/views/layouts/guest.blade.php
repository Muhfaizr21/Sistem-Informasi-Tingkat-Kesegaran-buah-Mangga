<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SI-Mangga') }} - Authentication</title>

        <!-- Localized Fonts -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fonts.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --gold: #D4A017;
                --gold-light: #F5C842;
                --gold-pale: #FFF8E1;
                --mango-orange: #E8821A;
                --mango-green: #4A7C3F;
                --leaf-dark: #1E3A1A;
                --earth: #7B4F2E;
                --cream: #FAF5E4;
                --text-dark: #1A1A0F;
                --text-mid: #3D3520;
                --text-light: #7A6E52;
            }
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="min-h-screen" style="background: var(--cream);">
        <x-navbar />

        <div class="flex flex-col lg:grid lg:grid-cols-2" style="min-height: calc(100vh - 72px); margin-top: 72px;">
            <!-- Left Panel: Green with features -->
            <div class="relative overflow-hidden px-6 sm:px-8 lg:px-[8%] py-10 lg:py-20 flex flex-col justify-center"
                style="background: linear-gradient(160deg, var(--mango-green) 0%, var(--leaf-dark) 100%);">
                <!-- Batik pattern overlay -->
                <div class="absolute inset-0" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%23D4A017' stroke-width='0.5' opacity='0.1'%3E%3Cellipse cx='50' cy='50' rx='40' ry='25'/%3E%3Cellipse cx='50' cy='50' rx='25' ry='15'/%3E%3Ccircle cx='50' cy='50' r='6'/%3E%3C/g%3E%3C/svg%3E&quot;);"></div>

                <div class="relative z-10">
                    <h2 class="text-2xl lg:text-[2.8rem]" style="font-family: 'Playfair Display', serif; color: white; line-height: 1.1; margin-bottom: 16px;">
                        Selamat Datang di<br><span style="color: var(--gold);">SI-Mangga</span>
                    </h2>
                    <p class="text-sm lg:text-base leading-relaxed max-w-[380px] mb-8 lg:mb-12" style="color: rgba(255,255,255,0.6);">
                        Platform cerdas untuk penilaian kesegaran mangga Indramayu. Masuk dan mulai optimalkan hasil panen Anda hari ini.
                    </p>

                    <div class="hidden sm:flex flex-col gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-lg shrink-0 border" style="background: rgba(212,160,23,0.2); border-color: rgba(212,160,23,0.4);">🥭</div>
                            <span class="text-sm leading-snug" style="color: rgba(255,255,255,0.75);">Deteksi kualitas 4 varietas mangga khas Indramayu secara real-time</span>
                        </div>
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-lg shrink-0 border" style="background: rgba(212,160,23,0.2); border-color: rgba(212,160,23,0.4);">📊</div>
                            <span class="text-sm leading-snug" style="color: rgba(255,255,255,0.75);">Analitik panen berbasis Big Data untuk keputusan yang lebih tepat</span>
                        </div>
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-lg shrink-0 border" style="background: rgba(212,160,23,0.2); border-color: rgba(212,160,23,0.4);">🤖</div>
                            <span class="text-sm leading-snug" style="color: rgba(255,255,255,0.75);">AI Computer Vision dengan akurasi 97% — tercepat di kelasnya</span>
                        </div>
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-[10px] flex items-center justify-center text-lg shrink-0 border" style="background: rgba(212,160,23,0.2); border-color: rgba(212,160,23,0.4);">🌾</div>
                            <span class="text-sm leading-snug" style="color: rgba(255,255,255,0.75);">Terhubung langsung dengan 5.000+ pembeli dan eksportir nasional</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Form -->
            <div class="flex-1 flex flex-col justify-center px-6 sm:px-8 lg:px-[10%] py-10 lg:py-20" style="background: var(--cream);">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-8 lg:mb-12">
                    <div class="w-14 h-14 bg-[#4A7C3F] rounded-full flex items-center justify-center shadow-[0_3px_10px_rgba(74,124,63,0.3)] overflow-hidden">
                        <img src="/storage/logo/logo.png" class="h-10 w-10 object-contain" alt="Logo" />
                    </div>
                    <span style="font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--leaf-dark);">SI-<span style="color: var(--gold);">Mangga</span></span>
                </div>

                <!-- Form Content -->
                <div class="w-full max-w-[420px]">
                    @if(isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>

                <!-- Copyright -->
                <div class="mt-10 text-center text-[0.72rem]" style="color: var(--text-light);">
                    © {{ date('Y') }} SI-Mangga · Indramayu, Jawa Barat
                </div>
            </div>
        </div>

        <x-footer />
    </body>
</html>
