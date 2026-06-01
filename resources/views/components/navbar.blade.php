<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="scrolled ? 'shadow-[0_2px_20px_rgba(212,160,23,0.12)]' : ''"
    class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-[5%] h-[72px] border-b-2 border-[#D4A017] transition-all duration-300"
    style="background: rgba(250,245,228,0.92); backdrop-filter: blur(12px);">

    <!-- Brand -->
    <a href="{{ route('landing') }}" class="flex items-center gap-3 no-underline">
        <div class="w-12 h-12 sm:w-11 sm:h-11 bg-[#4A7C3F] rounded-full flex items-center justify-center shadow-[0_3px_10px_rgba(74,124,63,0.3)] overflow-hidden">
            <img src="{{ \App\Models\SystemSetting::get('app_logo') ? (str_starts_with(\App\Models\SystemSetting::get('app_logo'), 'http') ? \App\Models\SystemSetting::get('app_logo') : asset(\App\Models\SystemSetting::get('app_logo'))) : asset('storage/logo/logo.png') }}" class="h-9 w-9 sm:h-8 sm:w-8 object-contain" alt="Logo" />
        </div>
        <span style="font-family: 'Playfair Display', serif; font-size: 1.35rem; color: #1E3A1A;">{{ \App\Models\SystemSetting::get('app_name', 'SI-Mangga') }}</span>
    </a>

    <!-- Desktop Links -->
    <ul class="hidden md:flex items-center gap-9 list-none m-0 p-0">
        <li><a href="{{ route('landing') }}" class="text-sm font-medium uppercase tracking-[0.04em] text-[#3D3520] no-underline relative pb-1 hover:text-[#D4A017] transition-colors group" style="@if(request()->routeIs('landing')) color: #4A7C3F; @endif">
            Beranda
            <span class="absolute bottom-0 left-0 h-[2px] bg-[#4A7C3F] transition-all duration-300 @if(request()->routeIs('landing')) w-full @else w-0 group-hover:w-full group-hover:bg-[#D4A017] @endif"></span>
        </a></li>
        <li><a href="{{ route('panduan') }}" class="text-sm font-medium uppercase tracking-[0.04em] text-[#3D3520] no-underline relative pb-1 hover:text-[#D4A017] transition-colors group" style="@if(request()->routeIs('panduan')) color: #4A7C3F; @endif">
            Fitur
            <span class="absolute bottom-0 left-0 h-[2px] bg-[#4A7C3F] transition-all duration-300 @if(request()->routeIs('panduan')) w-full @else w-0 group-hover:w-full group-hover:bg-[#D4A017] @endif"></span>
        </a></li>
        <li><a href="{{ route('tentang-kami') }}" class="text-sm font-medium uppercase tracking-[0.04em] text-[#3D3520] no-underline relative pb-1 hover:text-[#D4A017] transition-colors group" style="@if(request()->routeIs('tentang-kami')) color: #4A7C3F; @endif">
            Tentang
            <span class="absolute bottom-0 left-0 h-[2px] bg-[#4A7C3F] transition-all duration-300 @if(request()->routeIs('tentang-kami')) w-full @else w-0 group-hover:w-full group-hover:bg-[#D4A017] @endif"></span>
        </a></li>
        <li><a href="{{ route('kontak') }}" class="text-sm font-medium uppercase tracking-[0.04em] text-[#3D3520] no-underline relative pb-1 hover:text-[#D4A017] transition-colors group" style="@if(request()->routeIs('kontak')) color: #4A7C3F; @endif">
            Kontak
            <span class="absolute bottom-0 left-0 h-[2px] bg-[#4A7C3F] transition-all duration-300 @if(request()->routeIs('kontak')) w-full @else w-0 group-hover:w-full group-hover:bg-[#D4A017] @endif"></span>
        </a></li>
    </ul>

    <!-- Desktop Auth Buttons -->
    <div class="hidden md:flex items-center gap-3">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="px-5 py-2 border-2 border-[#1E3A1A] bg-transparent text-[#1E3A1A] font-semibold text-[0.8rem] uppercase tracking-[0.08em] rounded no-underline transition-all hover:bg-[#1E3A1A] hover:text-white">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2 border-2 border-[#1E3A1A] bg-transparent text-[#1E3A1A] font-semibold text-[0.8rem] uppercase tracking-[0.08em] rounded no-underline transition-all hover:bg-[#1E3A1A] hover:text-white">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-[9px] border-2 border-[#D4A017] bg-[#D4A017] text-white font-bold text-[0.8rem] uppercase tracking-[0.08em] rounded no-underline transition-all hover:bg-[#E8821A] hover:border-[#E8821A]">Daftar</a>
                @endif
            @endauth
        @endif
    </div>

    <!-- Mobile Hamburger -->
    <div class="flex items-center md:hidden">
        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded text-[#3D3520] hover:text-[#D4A017] hover:bg-[#FFF8E1] transition">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        class="absolute top-[72px] left-0 right-0 border-b-2 border-[#D4A017] md:hidden"
        style="background: rgba(250,245,228,0.97); backdrop-filter: blur(12px);">
        <div class="px-[5%] py-4 space-y-2">
            <a href="{{ route('landing') }}" class="block py-2 text-sm font-medium uppercase tracking-[0.04em] text-[#3D3520] no-underline hover:text-[#D4A017]">Beranda</a>
            <a href="{{ route('panduan') }}" class="block py-2 text-sm font-medium uppercase tracking-[0.04em] text-[#3D3520] no-underline hover:text-[#D4A017]" style="@if(request()->routeIs('panduan')) color: #4A7C3F; @endif">Fitur</a>
            <a href="{{ route('tentang-kami') }}" class="block py-2 text-sm font-medium uppercase tracking-[0.04em] text-[#3D3520] no-underline hover:text-[#D4A017]" style="@if(request()->routeIs('tentang-kami')) color: #4A7C3F; @endif">Tentang</a>
            <a href="{{ route('kontak') }}" class="block py-2 text-sm font-medium uppercase tracking-[0.04em] text-[#3D3520] no-underline hover:text-[#D4A017]" style="@if(request()->routeIs('kontak')) color: #4A7C3F; @endif">Kontak</a>
            <div class="pt-3 border-t border-[#D4A017]/20 flex flex-col gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="block py-2 text-sm font-semibold text-[#4A7C3F] no-underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-sm font-semibold text-[#1E3A1A] no-underline">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block py-2 text-sm font-bold text-[#D4A017] no-underline">Daftar</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
