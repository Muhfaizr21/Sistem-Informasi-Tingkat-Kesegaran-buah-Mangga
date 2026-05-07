<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SI-Mangga') - Pembeli</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; background-color: #FDFDFC; }
        .mango-gradient { background: linear-gradient(135deg, #FFB800 0%, #10B981 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(26, 26, 0, 0.1); }
        .text-mango { color: #FFB800; }
        .bg-mango { background-color: #FFB800; }
    </style>
    @stack('styles')
</head>
<body class="antialiased text-[#1b1b18]">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-md border-b border-[#19140015]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('pembeli.dashboard') }}" class="flex items-center gap-2">
                        <img src="{{ asset('storage/logo/logo si-mangga.png') }}" class="h-8 w-auto object-contain" alt="SI-Mangga Logo" />
                        <span class="text-xl font-black tracking-tight text-[#1b1b18]">SI-<span class="text-[#FFB800]">Mangga</span></span>
                    </a>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                        <a href="{{ route('pembeli.marketplace.katalog') }}" class="{{ request()->routeIs('pembeli.marketplace.*') ? 'text-[#FFB800]' : 'text-[#706f6c] hover:text-[#FFB800]' }} transition-colors">Marketplace</a>
                        <a href="{{ route('pembeli.pesanan.index') }}" class="{{ request()->routeIs('pembeli.pesanan.*') ? 'text-[#FFB800]' : 'text-[#706f6c] hover:text-[#FFB800]' }} transition-colors">Pesanan Saya</a>
                        <a href="{{ route('pembeli.scan.history') }}" class="{{ request()->routeIs('pembeli.scan.history') ? 'text-[#FFB800]' : 'text-[#706f6c] hover:text-[#FFB800]' }} transition-colors">Riwayat Scan</a>
                        <a href="{{ route('pembeli.scan') }}" class="{{ request()->routeIs('pembeli.scan') ? 'text-[#FFB800]' : 'text-[#706f6c] hover:text-[#FFB800]' }} transition-colors">Scan AI</a>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Notification Bell -->
                        <a href="{{ route('pembeli.notifications.index') }}" class="relative p-2 text-[#706f6c] hover:text-[#FFB800] transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @php
                                $unreadCount = Auth::user()->notifications()->where('sudah_dibaca', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-[10px] font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-[#FFB800] rounded-full">{{ $unreadCount }}</span>
                            @endif
                        </a>

                        <!-- Cart Icon -->
                        <a href="{{ route('pembeli.cart.index') }}" class="relative p-2 text-[#706f6c] hover:text-[#FFB800] transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            @if(session()->has('cart') && count(session('cart')) > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-[10px] font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-[#FFB800] rounded-full">{{ count(session('cart')) }}</span>
                            @endif
                        </a>

                        <div class="h-6 w-px bg-gray-200"></div>

                        <!-- User Profile Link -->
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 group">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform">
                                @if(Auth::user()->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs font-black text-[#FFB800]">{{ substr(Auth::user()->nama, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="hidden lg:block text-left">
                                <p class="text-[10px] font-black text-[#1b1b18] leading-none mb-1 group-hover:text-[#FFB800] transition-colors">{{ explode(' ', Auth::user()->nama)[0] }}</p>
                                <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest leading-none">{{ Auth::user()->role }}</p>
                            </div>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 text-[#706f6c] hover:text-red-500 transition-colors" title="Keluar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:pb-8 pb-24">
        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 w-full z-50 bg-white/90 backdrop-blur-xl border-t border-gray-100 pb-safe">
        <div class="flex justify-around items-center h-16 px-2">
            <a href="{{ route('pembeli.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('pembeli.dashboard') ? 'text-[#FFB800]' : 'text-gray-400 hover:text-gray-600' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="text-[9px] font-black uppercase tracking-widest">Home</span>
            </a>
            
            <a href="{{ route('pembeli.marketplace.katalog') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('pembeli.marketplace.*') ? 'text-[#FFB800]' : 'text-gray-400 hover:text-gray-600' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span class="text-[9px] font-black uppercase tracking-widest">Toko</span>
            </a>

            <!-- Scan Button Prominent -->
            <div class="relative w-full flex justify-center -mt-6">
                <a href="{{ route('pembeli.scan') }}" class="flex items-center justify-center w-14 h-14 bg-[#FFB800] text-white rounded-full shadow-lg shadow-orange-900/30 hover:bg-[#FF4433] hover:scale-105 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </a>
            </div>

            <a href="{{ route('pembeli.pesanan.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('pembeli.pesanan.*') ? 'text-[#FFB800]' : 'text-gray-400 hover:text-gray-600' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="text-[9px] font-black uppercase tracking-widest">Pesanan</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('profile.*') ? 'text-[#FFB800]' : 'text-gray-400 hover:text-gray-600' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="text-[9px] font-black uppercase tracking-widest">Profil</span>
            </a>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
