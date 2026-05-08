<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SI-Mangga') - Pembeli</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Instrument Sans', sans-serif; 
            background: linear-gradient(135deg, #f0f9eb 0%, #fffce6 50%, #f7fee7 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        .mango-gradient { background: linear-gradient(135deg, #FFB800 0%, #10B981 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(26, 26, 0, 0.1); }
        .text-mango { color: #FFB800; }
        .bg-mango { background-color: #FFB800; }
        .fill-1 { font-variation-settings: 'FILL' 1; }
    </style>
    @stack('styles')
</head>
<body class="antialiased text-[#1b1b18] relative">
    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-[#10B981]/5 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute top-[20%] -right-[5%] w-[30%] h-[30%] bg-[#FFB800]/5 rounded-full blur-[100px]"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[35%] h-[35%] bg-[#10B981]/5 rounded-full blur-[110px]"></div>
    </div>

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-md border-b border-[#19140015]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('pembeli.dashboard') }}" class="flex items-center gap-2 sm:gap-3">
                        <img src="{{ asset('storage/logo/logo si-mangga.png') }}" class="h-8 sm:h-12 w-auto object-contain" alt="SI-Mangga Logo" />
                        <span class="text-lg sm:text-2xl font-black tracking-tight text-[#1b1b18] mt-1">SI-<span class="text-[#FFB800]">Mangga</span></span>
                    </a>
                </div>
                
                <div class="flex items-center gap-2 sm:gap-6">
                    <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                        <a href="{{ route('pembeli.marketplace.katalog') }}" class="{{ request()->routeIs('pembeli.marketplace.*') ? 'text-[#FFB800]' : 'text-[#706f6c] hover:text-[#FFB800]' }} transition-colors">Marketplace</a>
                        <a href="{{ route('pembeli.pesanan.index') }}" class="{{ request()->routeIs('pembeli.pesanan.*') ? 'text-[#FFB800]' : 'text-[#706f6c] hover:text-[#FFB800]' }} transition-colors relative">
                            Pesanan Saya
                            @php
                                $activeOrderCount = Auth::user()->pembeli?->pesanan()->whereIn('status', ['menunggu_bayar', 'menunggu_verifikasi', 'dikonfirmasi', 'dikemas', 'dikirim'])->count() ?? 0;
                            @endphp
                            @if($activeOrderCount > 0)
                                <span class="absolute -top-2 -right-4 inline-flex items-center justify-center px-1.5 py-0.5 text-[8px] font-black leading-none text-white bg-[#FFB800] rounded-full border border-white">{{ $activeOrderCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pembeli.scan.history') }}" class="{{ request()->routeIs('pembeli.scan.history') ? 'text-[#FFB800]' : 'text-[#706f6c] hover:text-[#FFB800]' }} transition-colors">Riwayat Scan</a>
                        <a href="{{ route('pembeli.scan') }}" class="{{ request()->is('pembeli/scan') ? 'text-[#FFB800]' : 'text-[#706f6c] hover:text-[#FFB800]' }} transition-colors">Scan AI</a>
                    </div>

                    <div class="flex items-center gap-1 sm:gap-4">
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

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-[#19140015] mt-auto md:pb-0 pb-20 relative z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <a href="{{ route('pembeli.dashboard') }}" class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('storage/logo/logo si-mangga.png') }}" class="h-10 w-auto object-contain grayscale opacity-80" alt="SI-Mangga Logo" />
                        <span class="text-2xl font-black tracking-tight text-[#1b1b18] mt-1">SI-<span class="text-[#FFB800]">Mangga</span></span>
                    </a>
                    <p class="text-sm text-gray-400 font-medium leading-relaxed max-w-sm">
                        Platform AI terdepan untuk memastikan kualitas dan tingkat kesegaran mangga dari tanah Indramayu langsung ke tangan Anda.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-xs font-black text-[#1b1b18] uppercase tracking-widest mb-4">Pintasan</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('pembeli.marketplace.katalog') }}" class="text-sm text-gray-400 hover:text-[#FFB800] transition-colors font-medium">Marketplace</a></li>
                        <li><a href="{{ route('pembeli.scan') }}" class="text-sm text-gray-400 hover:text-[#FFB800] transition-colors font-medium">Scan AI</a></li>
                        <li><a href="{{ route('pembeli.pesanan.index') }}" class="text-sm text-gray-400 hover:text-[#FFB800] transition-colors font-medium">Pesanan Saya</a></li>
                        <li><a href="{{ route('pembeli.favorit.index') }}" class="text-sm text-gray-400 hover:text-[#FFB800] transition-colors font-medium">Petani Favorit</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black text-[#1b1b18] uppercase tracking-widest mb-4">Bantuan</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('pembeli.bantuan.cara-pemesanan') }}" class="text-sm text-gray-400 hover:text-[#FFB800] transition-colors font-medium">Cara Pemesanan</a></li>
                        <li><a href="{{ route('pembeli.bantuan.tentang') }}" class="text-sm text-gray-400 hover:text-[#FFB800] transition-colors font-medium">Tentang SI-Mangga</a></li>
                        <li><a href="{{ route('pembeli.bantuan.hubungi-kami') }}" class="text-sm text-gray-400 hover:text-[#FFB800] transition-colors font-medium">Hubungi Kami</a></li>
                        <li><a href="{{ route('pembeli.bantuan.kebijakan-privasi') }}" class="text-sm text-gray-400 hover:text-[#FFB800] transition-colors font-medium">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-[#19140015] flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-400 font-medium">
                    &copy; {{ date('Y') }} SI-Mangga. All rights reserved.
                </p>
                <div class="flex items-center gap-4">
                    <!-- Social icons -->
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-[#FFB800] hover:bg-orange-50 transition-all border border-gray-100">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-[#FFB800] hover:bg-orange-50 transition-all border border-gray-100">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

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
