<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Petani' }} - {{ config('app.name', 'MangoFresh') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#10B981", // Fresh Green for Farmer
                        secondary: "#FBBF24", // Mango Yellow
                        dark: "#064E3B",
                    }
                }
            }
        }
    </script>
    <style>
        .active-nav-item { @apply text-primary font-bold; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-950 font-inter antialiased min-h-screen pb-20 md:pb-0">
    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex flex-col w-64 bg-white dark:bg-gray-900 h-screen fixed left-0 top-0 border-r border-gray-200 dark:border-gray-800 z-50">
        <div class="p-6">
            <a href="{{ route('landing') }}" class="flex items-center gap-2">
                <x-application-logo class="block h-8 w-auto fill-current text-primary" />
                <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Mango<span class="text-primary">Fresh</span></span>
            </a>
            <p class="text-[10px] font-bold text-gray-400 uppercase mt-1 tracking-widest">Portal Petani</p>
        </div>
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('petani.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('petani.dashboard') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-500 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">dashboard</span> Dashboard
            </a>
            <a href="{{ route('petani.cek-kesegaran') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('petani.cek-kesegaran') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-500 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">center_focus_strong</span> Cek Kesegaran
            </a>
            <a href="{{ route('petani.data-lahan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('petani.data-lahan') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-500 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">map</span> Data Lahan
            </a>
            <a href="{{ route('petani.laporan-panen') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('petani.laporan-panen') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-500 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">analytics</span> Laporan Panen
            </a>
        </nav>
        <div class="p-4 border-t border-gray-100">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-red-600 transition-colors">
                    <span class="material-symbols-outlined">logout</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Top Bar -->
    <header class="md:hidden bg-white dark:bg-gray-900 border-b border-gray-100 p-4 sticky top-0 z-40 flex justify-between items-center">
        <span class="font-bold text-lg text-gray-900 dark:text-white">Mango<span class="text-primary">Fresh</span></span>
        <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-xs">
            {{ substr(Auth::user()->name ?? 'P', 0, 1) }}
        </div>
    </header>

    <!-- Main Content -->
    <main class="md:ml-64 p-4 md:p-8">
        {{ $slot }}
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 px-6 py-3 flex justify-between items-center z-50">
        <a href="{{ route('petani.dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('petani.dashboard') ? 'text-primary' : 'text-gray-400' }}">
            <span class="material-symbols-outlined">home</span>
            <span class="text-[10px] font-medium mt-1">Beranda</span>
        </a>
        <a href="{{ route('petani.cek-kesegaran') }}" class="flex flex-col items-center {{ request()->routeIs('petani.cek-kesegaran') ? 'text-primary' : 'text-gray-400' }}">
            <span class="material-symbols-outlined text-3xl">center_focus_strong</span>
            <span class="text-[10px] font-medium mt-1">Scan</span>
        </a>
        <a href="{{ route('petani.data-lahan') }}" class="flex flex-col items-center {{ request()->routeIs('petani.data-lahan') ? 'text-primary' : 'text-gray-400' }}">
            <span class="material-symbols-outlined">map</span>
            <span class="text-[10px] font-medium mt-1">Lahan</span>
        </a>
        <a href="{{ route('petani.profil') }}" class="flex flex-col items-center {{ request()->routeIs('petani.profil') ? 'text-primary' : 'text-gray-400' }}">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px] font-medium mt-1">Profil</span>
        </a>
    </nav>
</body>
</html>
