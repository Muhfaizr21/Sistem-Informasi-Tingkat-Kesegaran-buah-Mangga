<!-- SideNavBar Component -->
<aside
    class="fixed left-0 top-0 h-full w-64 border-r border-slate-800 bg-[#001F3F] dark:bg-slate-950 font-inter text-sm antialiased border-r border-slate-800 z-50">
    <div class="flex flex-col h-full py-6">
        <!-- Brand Logo Area -->
        <div class="px-6 mb-8 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center overflow-hidden shrink-0 border border-white/20">
                <img src="{{ asset('storage/logo/logo si-mangga.png') }}" class="w-full h-full object-contain" alt="Logo" />
            </div>
            <div>
                <div class="text-xl font-bold tracking-tight text-white leading-tight">SI-Mangga</div>
                <div class="text-slate-400 text-xs font-medium tracking-wide uppercase">Admin Pusat</div>
            </div>
        </div>
        <!-- Primary Navigation -->
        <nav class="flex-1 overflow-y-auto px-4 space-y-1">
            <!-- Dashboard -->
            <a class="flex items-center gap-3 px-3 py-2.5 rounded border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-emerald-500 bg-white/10 text-white font-semibold' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all"
                href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('admin.dashboard') ? '1' : '0' }};">dashboard</span>
                Dashboard
            </a>
            
            <!-- Manajemen Pengguna -->
            <a class="flex items-center gap-3 px-3 py-2.5 rounded border-l-4 {{ request()->routeIs('admin.users') ? 'border-emerald-500 bg-white/10 text-white font-semibold' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all"
                href="{{ route('admin.users') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('admin.users') ? '1' : '0' }};">group</span>
                Manajemen Pengguna
            </a>

            <!-- Pemetaan Lahan -->
            <a class="flex items-center gap-3 px-3 py-2.5 rounded border-l-4 {{ request()->routeIs('admin.mapping') ? 'border-emerald-500 bg-white/10 text-white font-semibold' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all"
                href="{{ route('admin.mapping') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('admin.mapping') ? '1' : '0' }};">map</span>
                Pemetaan Lahan
            </a>

            <!-- Monitor Kualitas -->
            <a class="flex items-center gap-3 px-3 py-2.5 rounded border-l-4 {{ request()->routeIs('admin.quality-monitor') ? 'border-emerald-500 bg-white/10 text-white font-semibold' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all"
                href="{{ route('admin.quality-monitor') }}">
                <span class="material-symbols-outlined"
                    style="font-variation-settings: 'FILL' {{ request()->routeIs('admin.quality-monitor') ? '1' : '0' }};">screenshot_region</span>
                Monitor Kualitas
            </a>

            <!-- Laporan Panen -->
            <a class="flex items-center gap-3 px-3 py-2.5 rounded border-l-4 {{ request()->routeIs('admin.harvest-report') ? 'border-emerald-500 bg-white/10 text-white font-semibold' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all"
                href="{{ route('admin.harvest-report') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('admin.harvest-report') ? '1' : '0' }};">analytics</span>
                Laporan Panen
            </a>

            <!-- Integrasi API -->
            <a class="flex items-center gap-3 px-3 py-2.5 rounded border-l-4 {{ request()->routeIs('admin.api-integration') ? 'border-emerald-500 bg-white/10 text-white font-semibold' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all"
                href="{{ route('admin.api-integration') }}">
                <span class="material-symbols-outlined"
                    style="font-variation-settings: 'FILL' {{ request()->routeIs('admin.api-integration') ? '1' : '0' }};">settings_input_component</span>
                Integrasi API
            </a>

            <!-- Konfigurasi -->
            <a class="flex items-center gap-3 px-3 py-2.5 rounded border-l-4 {{ request()->routeIs('admin.config') ? 'border-emerald-500 bg-white/10 text-white font-semibold' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }} transition-all"
                href="{{ route('admin.config') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('admin.config') ? '1' : '0' }};">settings</span>
                Konfigurasi
            </a>
        </nav>
        <!-- Footer Navigation -->
        <div class="px-4 mt-auto pt-4 border-t border-white/10 space-y-1">
            <a class="flex items-center gap-3 px-3 py-2.5 rounded text-slate-400 hover:bg-white/5 hover:text-white transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">help</span>
                Pusat Bantuan
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded text-slate-400 hover:bg-white/5 hover:text-white transition-colors duration-200">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</aside>
