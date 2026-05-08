@php
    $notifications = \App\Models\Notifikasi::where('pengguna_id', Auth::id())
        ->latest()
        ->take(10)
        ->get();
    $unreadCount = $notifications->where('sudah_dibaca', false)->count();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Petani' }} - {{ config('app.name', 'SI-Mangga') }}</title>

    <!-- Localized Fonts & Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/material-symbols.css') }}">
    
    <!-- Leaflet GIS Local -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" />
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#10B981',
                            600: '#059669',
                            700: '#047857',
                        },
                        secondary: "#FFB800",

                        dark: "#064E3B",
                    },
                    borderRadius: {
                        '4xl': '2rem',
                        '5xl': '2.5rem',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .dark .glass { background: rgba(15, 23, 42, 0.8); }
        .nav-active { @apply bg-primary-500 text-white shadow-lg shadow-primary-500/30 scale-[1.02]; }
        body { background-color: #f8fafc; background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px); background-size: 24px 24px; }
    </style>
</head>
<body class="text-slate-900 antialiased font-sans min-h-screen" x-data="{ sidebarOpen: false }">
    <!-- Desktop Sidebar -->
    <aside class="hidden lg:flex flex-col w-72 bg-white/80 backdrop-blur-xl h-screen fixed left-0 top-0 rounded-r-[3.5rem] border-r border-slate-100 shadow-2xl z-50">
        <div class="p-8">
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <img src="{{ asset('storage/logo/logo.png') }}" class="w-10 h-10 object-contain" alt="SI-Mangga Logo" />
                <div>
                    <h1 class="font-extrabold text-xl tracking-tight text-[#1b1b18] leading-none">SI-<span class="text-[#FFB800]">Mangga</span></h1>

                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Farmer Ecosystem</p>
                </div>
            </a>
        </div>

        <nav class="flex-1 px-6 space-y-2 overflow-y-auto custom-scrollbar">
            <x-nav-item route="petani.dashboard" icon="dashboard" label="Dashboard" />
            <x-nav-item route="petani.wilayah-produksi" icon="explore" label="Wilayah Produksi" />
            <x-nav-item route="petani.rekomendasi" icon="tips_and_updates" label="Rekomendasi AI" />
            <x-nav-item route="petani.cek-kesegaran" icon="center_focus_strong" label="Cek Kesegaran" />
            <x-nav-item route="petani.produk.index" icon="storefront" label="Produk Saya" />
            <x-nav-item route="petani.pesanan.index" icon="shopping_bag" label="Pesanan Masuk" />

            <x-nav-item route="petani.data-lahan" icon="map" label="Data Lahan" />
            <x-nav-item route="petani.laporan-panen" icon="analytics" label="Laporan Panen" />
            <x-nav-item route="petani.laporan-penjualan" icon="receipt_long" label="Laporan Penjualan" />
            
            <div class="pt-6 pb-2 px-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Akun Saya</p>
            </div>
            <x-nav-item route="petani.profil" icon="person" label="Profil Saya" />
        </nav>

        <div class="p-6">
            <div class="bg-slate-50 rounded-3xl p-4 mb-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center text-primary-500 font-bold shadow-sm">
                    {{ substr(Auth::user()->nama ?? 'P', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-black text-slate-900 truncate">{{ Auth::user()->nama }}</p>
                    <p class="text-[10px] text-slate-400 truncate">Petani Aktif</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-500 font-bold rounded-2xl hover:bg-red-100 transition-all active:scale-95 text-xs">
                    <span class="material-symbols-outlined text-sm">logout</span> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Header -->
    <header class="lg:hidden glass fixed top-0 left-0 right-0 z-40 px-6 py-4 flex justify-between items-center border-b border-slate-100">
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = true" class="w-10 h-10 flex items-center justify-center text-slate-500">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <h1 class="font-extrabold text-lg text-slate-900">SI-<span class="text-primary-500">Mangga</span></h1>

        </div>
        <a href="{{ route('petani.profil') }}" class="w-10 h-10 rounded-2xl bg-primary-500/10 flex items-center justify-center text-primary-500 font-bold">
            {{ substr(Auth::user()->nama ?? 'P', 0, 1) }}
        </a>
    </header>

    <!-- Mobile Sidebar Overlay -->
    <template x-if="true">
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-[100] lg:hidden">
            <div @click="sidebarOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="absolute left-0 top-0 bottom-0 w-80 bg-white p-6 shadow-2xl flex flex-col transform transition-transform duration-300"
                 x-transition:enter="translate-x-[-100%]" x-transition:enter-end="translate-x-0"
                 x-transition:leave="translate-x-0" x-transition:leave-end="translate-x-[-100%]">
                <!-- Mobile Sidebar Content (Same as desktop but adapted) -->
                <div class="flex justify-between items-center mb-10">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/logo/logo.png') }}" class="w-10 h-10 object-contain" alt="SI-Mangga Logo" />
                        <h1 class="font-extrabold text-xl text-slate-900">SI-<span class="text-primary-500">Mangga</span></h1>

                    </div>
                    <button @click="sidebarOpen = false" class="text-slate-400"><span class="material-symbols-outlined">close</span></button>
                </div>
                <nav class="flex-1 space-y-2">
                    <x-nav-item route="petani.dashboard" icon="dashboard" label="Dashboard" />
                    <x-nav-item route="petani.wilayah-produksi" icon="explore" label="Wilayah Produksi" />
                    <x-nav-item route="petani.rekomendasi" icon="tips_and_updates" label="Rekomendasi AI" />
                    <x-nav-item route="petani.cek-kesegaran" icon="center_focus_strong" label="Cek Kesegaran" />
                    <x-nav-item route="petani.produk.index" icon="storefront" label="Produk Saya" />
                    <x-nav-item route="petani.pesanan.index" icon="shopping_bag" label="Pesanan Masuk" />

                    <x-nav-item route="petani.data-lahan" icon="map" label="Data Lahan" />
                    <x-nav-item route="petani.laporan-panen" icon="analytics" label="Laporan Panen" />
                    <x-nav-item route="petani.laporan-penjualan" icon="receipt_long" label="Laporan Penjualan" />
                    <x-nav-item route="petani.profil" icon="person" label="Profil Saya" />
                </nav>
            </div>
        </div>
    </template>

    <!-- Main Content Area -->
    <main class="lg:ml-72 pt-24 lg:pt-0 pb-32 lg:pb-8 px-4 md:px-8">
        <!-- Desktop Top Navbar -->
        <header class="hidden lg:flex items-center justify-between py-6 sticky top-0 z-30 bg-[#f8fafc]/80 backdrop-blur-md">
            <div>
                <h2 class="text-sm font-black text-slate-400 uppercase tracking-widest">Dashboard Petani</h2>
                <p class="text-xs text-slate-500 font-medium">Selamat datang kembali, {{ Auth::user()->nama }}! 👋</p>
            </div>

            <div class="flex items-center gap-6">
                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="w-12 h-12 flex items-center justify-center bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-100 relative">
                        <span class="material-symbols-outlined text-slate-500">notifications</span>
                        @if($unreadCount > 0)
                        <span class="absolute top-3 right-3 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        @endif
                    </button>
                    <!-- Notification Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition x-cloak 
                         class="absolute right-0 mt-4 w-96 bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-50">
                        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                            <div>
                                <h3 class="font-black text-slate-900 text-sm uppercase tracking-widest">Notifikasi</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Aktivitas Lahan & Cuaca</p>
                            </div>
                            @if($unreadCount > 0)
                            <form action="{{ route('petani.notifikasi.read-all') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] font-black text-primary-500 uppercase tracking-widest hover:underline">Tandai Semua Dibaca</button>
                            </form>
                            @endif
                        </div>
                        <div class="max-h-[400px] overflow-y-auto">
                            @forelse($notifications as $notif)
                            <div class="p-5 border-b border-slate-50 hover:bg-slate-50 transition-all group flex gap-4 {{ !$notif->sudah_dibaca ? 'bg-primary-50/30' : '' }}">
                                <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center
                                    {{ $notif->tipe === 'warning' ? 'bg-amber-100 text-amber-600' : 
                                       ($notif->tipe === 'danger' ? 'bg-red-100 text-red-600' : 'bg-primary-100 text-primary-600') }}">
                                    <span class="material-symbols-outlined text-xl">
                                        {{ $notif->kategori === 'cuaca' ? 'cloudy_snowing' : ($notif->kategori === 'ai' ? 'smart_toy' : 'notifications') }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="text-xs font-black text-slate-900 truncate pr-4">{{ $notif->judul }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</p>
                                    </div>
                                    <p class="text-[11px] text-slate-500 leading-relaxed mb-3">{{ $notif->pesan }}</p>
                                    
                                    <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @if(!$notif->sudah_dibaca)
                                        <form action="{{ route('petani.notifikasi.read', $notif->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[9px] font-black text-primary-500 uppercase tracking-widest hover:underline">Tandai Dibaca</button>
                                        </form>
                                        @endif
                                        <form action="{{ route('petani.notifikasi.destroy', $notif->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[9px] font-black text-red-500 uppercase tracking-widest hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="p-10 text-center">
                                <span class="material-symbols-outlined text-4xl text-slate-200 mb-2">notifications_off</span>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum ada notifikasi</p>
                            </div>
                            @endforelse
                        </div>
                        @if($notifications->count() > 0)
                        <div class="p-4 bg-slate-50/50 text-center border-t border-slate-50">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Sinkron Melalui SI-Mangga Intelligence</p>

                        </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-3 p-1.5 pr-4 bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-100 group">
                        <div class="w-9 h-9 rounded-xl bg-primary-500 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-primary-500/20">
                            {{ substr(Auth::user()->nama ?? 'P', 0, 1) }}
                        </div>
                        <div class="text-left hidden xl:block">
                            <p class="text-xs font-black text-slate-900 leading-none mb-1 group-hover:text-primary-500 transition-colors">{{ Auth::user()->nama }}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest leading-none">Petani Premium</p>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 text-sm group-hover:rotate-180 transition-transform">expand_more</span>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition x-cloak 
                         class="absolute right-0 mt-4 w-56 bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-50 p-2">
                        <a href="{{ route('petani.profil') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-2xl transition-all group">
                            <span class="material-symbols-outlined text-sm group-hover:text-primary-500">settings</span>
                            <span class="text-xs font-bold group-hover:text-slate-900">Pengaturan Profil</span>
                        </a>
                        <div class="h-px bg-slate-100 my-2 mx-4"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-2xl transition-all group">
                                <span class="material-symbols-outlined text-sm">logout</span>
                                <span class="text-xs font-bold">Keluar Sistem</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto pt-4 lg:pt-0">
            {{ $slot }}
        </div>
    </main>

    <!-- Mobile Bottom Navigation (Modern Style) -->
    <nav class="lg:hidden fixed bottom-6 left-6 right-6 z-40 bg-white/80 backdrop-blur-2xl border border-white/20 shadow-[0_20px_50px_rgba(0,0,0,0.15)] rounded-full px-8 py-4 flex justify-between items-center">
        <a href="{{ route('petani.dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('petani.dashboard') ? 'text-primary-500 scale-110' : 'text-slate-400' }} transition-all">
            <span class="material-symbols-outlined !text-[28px]">home</span>
        </a>
        <a href="{{ route('petani.rekomendasi') }}" class="flex flex-col items-center {{ request()->routeIs('petani.rekomendasi') ? 'text-primary-500 scale-110' : 'text-slate-400' }} transition-all">
            <span class="material-symbols-outlined !text-[28px]">tips_and_updates</span>
        </a>
        <a href="{{ route('petani.cek-kesegaran') }}" class="w-14 h-14 bg-primary-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-primary-500/40 -mt-12 border-4 border-slate-50 transition-all active:scale-90">
            <span class="material-symbols-outlined !text-3xl">center_focus_strong</span>
        </a>
        <a href="{{ route('petani.wilayah-produksi') }}" class="flex flex-col items-center {{ request()->routeIs('petani.wilayah-produksi') ? 'text-primary-500 scale-110' : 'text-slate-400' }} transition-all">
            <span class="material-symbols-outlined !text-[28px]">explore</span>
        </a>
        <a href="{{ route('petani.profil') }}" class="flex flex-col items-center {{ request()->routeIs('petani.profil') ? 'text-primary-500 scale-110' : 'text-slate-400' }} transition-all">
            <span class="material-symbols-outlined !text-[28px]">person</span>
        </a>
    </nav>
</body>
</html>
