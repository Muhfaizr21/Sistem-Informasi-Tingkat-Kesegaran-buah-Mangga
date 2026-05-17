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
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-inter antialiased min-h-screen" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Wrapper with Mobile Overlay -->
    <div 
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[55] md:hidden transition-opacity duration-300" 
        x-show="sidebarOpen" 
        x-cloak
        x-transition:enter="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="opacity-100" 
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false">
    </div>

    <!-- Sidebar Slide Drawer -->
    <div 
        class="fixed top-0 left-0 bottom-0 w-[260px] z-[56] transition-transform duration-300 md:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        x-cloak>
        <x-admin.sidebar />
    </div>
    
    <!-- Top Responsive App Bar Navbar -->
    <x-admin.navbar />

    <main class="md:ml-[260px] min-h-screen pt-20 px-4 pb-4 md:pt-24 md:px-8 md:pb-8 flex flex-col gap-6 overflow-x-hidden">
        {{ $slot }}
    </main>

    @stack('scripts')
</body>
</html>
