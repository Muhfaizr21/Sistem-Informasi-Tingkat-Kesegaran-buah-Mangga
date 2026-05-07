<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Buyer' }} - {{ config('app.name', 'SI-Mangga') }}</title>

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
                        primary: "#FBBF24", // Mango Yellow
                        secondary: "#10B981", // Fresh Green
                        accent: "#3B82F6", // Ocean Blue
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-950 font-inter antialiased min-h-screen flex flex-col">
    <!-- Buyer Navigation -->
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ route('landing') }}" class="flex items-center gap-2">
                        <img src="{{ asset('storage/logo/logo si-mangga.png') }}" alt="SI-Mangga" class="block h-8 w-auto object-contain" />
                        <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">SI-<span class="text-primary">Mangga</span></span>
                    </a>
                    <div class="hidden md:flex gap-6">
                        <a href="{{ route('buyer.catalog') }}" class="text-sm font-medium {{ request()->routeIs('buyer.catalog') ? 'text-primary' : 'text-gray-500 hover:text-gray-900' }}">Katalog</a>
                        <a href="{{ route('buyer.market-analytics') }}" class="text-sm font-medium {{ request()->routeIs('buyer.market-analytics') ? 'text-primary' : 'text-gray-500 hover:text-gray-900' }}">Analisis Pasar</a>
                        <a href="{{ route('buyer.order-history') }}" class="text-sm font-medium {{ request()->routeIs('buyer.order-history') ? 'text-primary' : 'text-gray-500 hover:text-gray-900' }}">Pesanan Saya</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-full">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 text-white text-[10px] flex items-center justify-center rounded-full">3</span>
                    </button>
                    <div class="h-8 w-px bg-gray-200"></div>
                    <a href="{{ route('buyer.account-setting') }}" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-xs group-hover:bg-primary group-hover:text-white transition-colors">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 hidden sm:block">{{ Auth::user()->name ?? 'User' }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors" title="Keluar">
                            <span class="material-symbols-outlined">logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} SI-Mangga Indramayu. Bangga Buatan Lokal.</p>
        </div>
    </footer>
</body>
</html>
