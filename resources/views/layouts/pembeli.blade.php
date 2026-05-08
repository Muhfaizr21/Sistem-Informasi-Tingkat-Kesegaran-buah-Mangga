<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SI-Mangga: Platform Marketplace & Monitoring Kesegaran Mangga Indramayu Terpercaya. Beli mangga segar langsung dari petani.">
    <meta name="keywords" content="mangga indramayu, harum manis, gedong gincu, cengkir, petani mangga, marketplace buah">
    <meta name="author" content="SI-Mangga Team">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="SI-Mangga - Marketplace Mangga Indramayu">
    <meta property="og:description" content="Platform Marketplace & Monitoring Kesegaran Mangga Indramayu Terpercaya.">
    <meta property="og:image" content="{{ asset('storage/logo/logo.png') }}">

    <title>@yield('title', 'SI-Mangga') - Pembeli</title>

    <!-- Localized Fonts & Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/material-symbols.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

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

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--cream);
            color: var(--text-dark);
        }

        .premium-shadow {
            box-shadow: 0 20px 50px -15px rgba(30, 58, 26, 0.1);
        }

        .glass-nav {
            background: rgba(250, 245, 228, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 2px solid var(--gold);
        }

        .fill-1 { font-variation-settings: 'FILL' 1; }
        
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="antialiased selection:bg-[#D4A017]/30 selection:text-[#1E3A1A]">
    <!-- Batik pattern overlay -->
    <div class="fixed inset-0 z-[-1] opacity-[0.03] pointer-events-none" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%23D4A017' stroke-width='1'%3E%3Cellipse cx='50' cy='50' rx='40' ry='25'/%3E%3Cellipse cx='50' cy='50' rx='25' ry='15'/%3E%3Ccircle cx='50' cy='50' r='6'/%3E%3C/g%3E%3C/svg%3E&quot;);"></div>

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 w-full glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-[5%]">
            <div class="flex justify-between h-[72px]">
                <div class="flex items-center">
                    <a href="{{ route('pembeli.dashboard') }}" class="flex items-center gap-3 no-underline">
                        <div class="w-11 h-11 bg-[#4A7C3F] rounded-full flex items-center justify-center shadow-[0_3px_10px_rgba(74,124,63,0.3)] overflow-hidden">
                            <img src="{{ asset('storage/logo/logo.png') }}" class="h-8 w-8 object-contain" alt="Logo" />
                        </div>
                        <span style="font-family: 'Playfair Display', serif; font-size: 1.3rem; color: var(--leaf-dark); font-weight: 900;">SI-<span style="color: var(--gold);">Mangga</span></span>
                    </a>
                </div>
                
                <div class="flex items-center gap-2 sm:gap-6">
                    <div class="hidden md:flex items-center gap-8 text-[0.72rem] font-bold uppercase tracking-[0.1em]">
                        <a href="{{ route('pembeli.marketplace.katalog') }}" 
                           class="transition-colors no-underline"
                           style="color: {{ request()->routeIs('pembeli.marketplace.*') ? 'var(--mango-green)' : 'var(--text-light)' }};">
                           Marketplace
                        </a>
                        <a href="{{ route('pembeli.pesanan.index') }}" 
                           class="transition-colors no-underline relative"
                           style="color: {{ request()->routeIs('pembeli.pesanan.*') ? 'var(--mango-green)' : 'var(--text-light)' }};">
                            Pesanan
                            @php
                                $activeOrderCount = Auth::user()->pembeli?->pesanan()->whereIn('status', ['menunggu_bayar', 'menunggu_verifikasi', 'dikonfirmasi', 'dikemas', 'dikirim'])->count() ?? 0;
                            @endphp
                            @if($activeOrderCount > 0)
                                <span class="absolute -top-2 -right-3 w-4 h-4 flex items-center justify-center text-[8px] text-white rounded-full" style="background: var(--mango-orange);">{{ $activeOrderCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pembeli.scan') }}" 
                           class="transition-colors no-underline"
                           style="color: {{ request()->routeIs('pembeli.scan') ? 'var(--mango-green)' : 'var(--text-light)' }};">
                           Scan AI
                        </a>
                        <a href="{{ route('pembeli.scan.history') }}" 
                           class="transition-colors no-underline"
                           style="color: {{ request()->routeIs('pembeli.scan.history') ? 'var(--mango-green)' : 'var(--text-light)' }};">
                           Riwayat Scan
                        </a>
                    </div>

                    <div class="flex items-center gap-1 sm:gap-4 ml-4">
                        <!-- Cart -->
                        <a href="{{ route('pembeli.cart.index') }}" class="p-2 transition-colors relative group" style="color: var(--text-light);">
                            <span class="material-symbols-outlined text-[24px] group-hover:text-var(--gold) transition-colors">shopping_cart</span>
                            @php
                                $cartItems = session('cart', []);
                                $cartCount = 0;
                                foreach ($cartItems as $item) {
                                    $cartCount += $item['jumlah'];
                                }
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] flex items-center justify-center text-[9px] text-white rounded-full border-2 border-white px-1 font-black" style="background: var(--mango-orange);">{{ $cartCount }}</span>
                            @endif
                        </a>

                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click.stop="open = !open" class="p-2 transition-colors relative" style="color: var(--text-light);">
                                <span class="material-symbols-outlined text-[22px] group-hover:text-var(--gold) transition-colors">notifications</span>
                                @php 
                                                                        $unreadNotifications = Auth::user()->notifications()->where('sudah_dibaca', false)->latest()->take(5)->get();
                                    $unreadCount = Auth::user()->notifications()->where('sudah_dibaca', false)->count(); 
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="absolute top-1 right-1 w-4 h-4 flex items-center justify-center text-[8px] text-white rounded-full border border-white" style="background: var(--mango-orange);">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                @endif
                            </button>

                            <!-- Dropdown Panel -->
                            <div x-show="open" 
                                 x-cloak
                                 style="display: none;"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="absolute right-0 mt-4 w-80 bg-white rounded-3xl shadow-2xl border border-var(--gold-pale) overflow-hidden z-[100]">
                                <div class="p-5 border-b flex justify-between items-center" style="background: var(--cream); border-color: var(--gold-pale);">
                                    <h4 class="text-xs font-black uppercase tracking-widest" style="color: var(--leaf-dark);">Notifications</h4>
                                    @if($unreadCount > 0)
                                        <form action="{{ route('pembeli.notifications.readAll') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[9px] font-black uppercase tracking-tighter text-var(--gold) hover:underline">Mark all read</button>
                                        </form>
                                    @endif
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    @forelse($unreadNotifications as $notif)
                                        <div class="p-5 border-b hover:bg-var(--gold-pale)/10 transition-colors" style="border-color: var(--gold-pale);">
                                            <p class="text-[0.7rem] font-bold mb-1" style="color: var(--text-dark);">{{ $notif->judul }}</p>
                                            <p class="text-[0.65rem] leading-relaxed mb-2" style="color: var(--text-light);">{{ $notif->pesan }}</p>
                                            <p class="text-[0.55rem] font-black uppercase tracking-tighter opacity-40">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                    @empty
                                        <div class="p-10 text-center">
                                            <span class="material-symbols-outlined text-4xl opacity-10 mb-2">notifications_off</span>
                                            <p class="text-[0.65rem] font-bold uppercase tracking-widest opacity-30">No new alerts</p>
                                        </div>
                                    @endforelse
                                </div>
                                <a href="{{ route('pembeli.notifications.index') }}" class="block p-4 text-center text-[0.65rem] font-black uppercase tracking-widest hover:bg-var(--gold-pale) transition-colors border-t" style="color: var(--gold); border-color: var(--gold-pale);">View All History</a>
                            </div>
                        </div>

                        <!-- User -->
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 pl-4 border-l-2" style="border-color: rgba(212,160,23,0.2);">
                            <div class="w-9 h-9 rounded-full border flex items-center justify-center overflow-hidden" style="background: var(--gold-pale); border-color: rgba(212,160,23,0.3);">
                                @if(Auth::user()->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs font-bold" style="color: var(--gold);">{{ substr(Auth::user()->nama, 0, 1) }}</span>
                                @endif
                            </div>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 transition-colors" style="color: var(--text-light);">
                                <span class="material-symbols-outlined text-[22px] hover:text-red-500">logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-[5%] py-10 md:pb-12 pb-24 min-h-[calc(100vh-144px)]">
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 w-full z-50 bg-white/90 backdrop-blur-xl border-t-2 pb-safe" style="border-color: var(--gold);">
        <div class="flex justify-around items-center h-16">
            <a href="{{ route('pembeli.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 no-underline transition-colors"
               style="color: {{ request()->routeIs('pembeli.dashboard') ? 'var(--mango-green)' : 'var(--text-light)' }};">
                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('pembeli.dashboard') ? 'fill-1' : '' }}">home</span>
                <span class="text-[8px] font-bold uppercase tracking-wider">Home</span>
            </a>
            
            <a href="{{ route('pembeli.marketplace.katalog') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 no-underline transition-colors"
               style="color: {{ request()->routeIs('pembeli.marketplace.*') ? 'var(--mango-green)' : 'var(--text-light)' }};">
                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('pembeli.marketplace.*') ? 'fill-1' : '' }}">storefront</span>
                <span class="text-[8px] font-bold uppercase tracking-wider">Toko</span>
            </a>

            <div class="relative w-full flex justify-center -mt-8">
                <a href="{{ route('pembeli.scan') }}" class="flex items-center justify-center w-14 h-14 text-white rounded-full shadow-lg border-4 hover:scale-105 transition-all"
                   style="background: var(--mango-green); border-color: var(--cream);">
                    <span class="material-symbols-outlined text-[28px]">center_focus_strong</span>
                </a>
            </div>

            <a href="{{ route('pembeli.pesanan.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 no-underline transition-colors"
               style="color: {{ request()->routeIs('pembeli.pesanan.*') ? 'var(--mango-green)' : 'var(--text-light)' }};">
                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('pembeli.pesanan.*') ? 'fill-1' : '' }}">shopping_bag</span>
                <span class="text-[8px] font-bold uppercase tracking-wider">Pesanan</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 no-underline transition-colors"
               style="color: {{ request()->routeIs('profile.*') ? 'var(--mango-green)' : 'var(--text-light)' }};">
                <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('profile.*') ? 'fill-1' : '' }}">person</span>
                <span class="text-[8px] font-bold uppercase tracking-wider">Profil</span>
            </a>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

