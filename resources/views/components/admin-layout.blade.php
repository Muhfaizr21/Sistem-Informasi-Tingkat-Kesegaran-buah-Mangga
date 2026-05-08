<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin' }} - {{ config('app.name', 'Mangga Indramayu') }}</title>

    <!-- Localized Fonts & Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/material-symbols.css') }}">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-background text-on-background font-inter antialiased min-h-screen" x-data="{ sidebarOpen: false }">
    <!-- Mobile Header -->
    <header class="md:hidden bg-primary-container text-on-primary h-16 fixed top-0 left-0 right-0 z-[60] flex items-center justify-between px-4 shadow-md">
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-white/10 rounded-lg">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <span class="font-bold tracking-tight">Admin Portal</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs">
            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
        </div>
    </header>

    <!-- Sidebar Wrapper with Mobile Overlay -->
    <div 
        class="fixed inset-0 bg-black/50 z-[55] md:hidden transition-opacity duration-300" 
        x-show="sidebarOpen" 
        x-transition:enter="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="opacity-100" 
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false">
    </div>

    <div 
        class="fixed top-0 left-0 bottom-0 z-[56] transition-transform duration-300 md:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <x-admin.sidebar />
    </div>
    
    <x-admin.navbar />

    <!-- Main Content Canvas -->
    <main class="md:ml-[260px] pt-16 md:pt-[64px] min-h-screen p-4 md:p-container-padding flex flex-col gap-stack-lg md:gap-gutter">
        {{ $slot }}
    </main>

    @stack('scripts')
</body>
</html>
