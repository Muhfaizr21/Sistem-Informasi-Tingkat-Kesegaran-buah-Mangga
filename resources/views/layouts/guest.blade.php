<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SI-Mangga') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-[#f0f9eb] via-[#fffce6] to-[#f7fee7] dark:from-[#0a0a0a] dark:to-[#0c0c0b] text-[#1b1b18] antialiased min-h-screen relative overflow-x-hidden">
        <!-- Decorative Background Elements -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] bg-[#10B981]/10 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[60%] h-[60%] bg-[#FFB800]/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="min-h-screen flex flex-col items-center justify-center p-6 lg:p-8 relative z-10">
            <div class="w-full max-w-[400px]">
                <div class="flex justify-center mb-8">
                    <a href="/" class="flex flex-col items-center gap-2">
                        <x-application-logo class="h-16 w-auto" />
                        <div class="text-xl font-bold tracking-tight">
                            <span class="text-[#1b1b18] dark:text-[#EDEDEC]">SI-</span><span class="text-[#FFB800]">Mangga</span>
                        </div>
                    </a>
                </div>

                <div class="bg-white dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06),inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-8 transition-all duration-750 opacity-100">
                    @if(isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500 dark:text-[#A1A09A]">
                        &copy; {{ date('Y') }} SI-Mangga. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
