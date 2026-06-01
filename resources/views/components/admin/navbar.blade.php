<!-- TopAppBar Component -->
<header
    class="fixed top-0 left-0 right-0 md:left-[260px] h-16 border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 z-40 flex items-center justify-between px-4 md:px-8 font-inter text-base transition-all duration-300">
    
    <!-- Left Side: Mobile Toggle & Search Bar -->
    <div class="flex items-center gap-3 flex-1 max-w-md">
        <!-- Mobile Sidebar Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[24px]">menu</span>
        </button>

        <!-- Search Bar -->
        <form id="admin-header-search-form" action="{{ route('admin.quality-monitor') }}" method="GET" class="relative w-full group focus-within:ring-2 focus-within:ring-emerald-500/20 rounded-xl transition-shadow flex-1">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
            <input
                id="admin-header-search-input"
                name="search"
                value="{{ request('search') }}"
                class="w-full h-10 pl-10 pr-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-slate-100 focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 transition-colors"
                placeholder="Cari data, petani, atau ketik perintah (misal: 'dashboard', 'panen')..." type="text" />
            @if(request('tab'))
                <input type="hidden" name="tab" value="{{ request('tab') }}" />
            @endif
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}" />
            @endif
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchForm = document.getElementById('admin-header-search-form');
                const searchInput = document.getElementById('admin-header-search-input');

                if (searchForm && searchInput) {
                    const path = window.location.pathname;
                    if (path.includes('/admin/users')) {
                        searchForm.action = '{{ route('admin.users') }}';
                    } else if (path.includes('/admin/pesanan')) {
                        searchForm.action = '{{ route('admin.pesanan.index') }}';
                    } else if (path.includes('/admin/verifikasi-pembayaran')) {
                        searchForm.action = '{{ route('admin.verifikasi-pembayaran') }}';
                    } else {
                        searchForm.action = '{{ route('admin.quality-monitor') }}';
                    }

                    // Spotlight Search / Direct Command Navigation
                    searchForm.addEventListener('submit', function(e) {
                        const query = searchInput.value.trim().toLowerCase();
                        if (!query) return;

                        const commands = {
                            'dashboard': '{{ route('admin.dashboard') }}',
                            'beranda': '{{ route('admin.dashboard') }}',
                            'home': '{{ route('admin.dashboard') }}',
                            
                            'sinkronisasi': '{{ route('admin.sync-hub') }}',
                            'sync': '{{ route('admin.sync-hub') }}',
                            
                            'pengguna': '{{ route('admin.users') }}',
                            'user': '{{ route('admin.users') }}',
                            'petani': '{{ route('admin.users') }}',
                            'pembeli': '{{ route('admin.users') }}',
                            'member': '{{ route('admin.users') }}',
                            
                            'lahan': '{{ route('admin.mapping') }}',
                            'map': '{{ route('admin.mapping') }}',
                            'pemetaan': '{{ route('admin.mapping') }}',
                            
                            'kualitas': '{{ route('admin.quality-monitor') }}',
                            'monitor': '{{ route('admin.quality-monitor') }}',
                            'qc': '{{ route('admin.quality-monitor') }}',
                            'anomali': '{{ route('admin.quality-monitor') }}',
                            'scan': '{{ route('admin.quality-monitor') }}',
                            
                            'panen': '{{ route('admin.harvest-report') }}',
                            'laporan': '{{ route('admin.harvest-report') }}',
                            
                            'api': '{{ route('admin.api-integration') }}',
                            'integrasi': '{{ route('admin.api-integration') }}',
                            
                            'pesanan': '{{ route('admin.pesanan.index') }}',
                            'transaksi': '{{ route('admin.pesanan.index') }}',
                            'order': '{{ route('admin.pesanan.index') }}',
                            
                            'verifikasi': '{{ route('admin.verifikasi-pembayaran') }}',
                            'pembayaran': '{{ route('admin.verifikasi-pembayaran') }}',
                            'bukti': '{{ route('admin.verifikasi-pembayaran') }}',
                            
                            'penarikan': '{{ route('admin.penarikan.index') }}',
                            'dana': '{{ route('admin.penarikan.index') }}',
                            'tarik': '{{ route('admin.penarikan.index') }}',
                            'saldo': '{{ route('admin.penarikan.index') }}',
                            
                            'konfigurasi': '{{ route('admin.config') }}',
                            'setting': '{{ route('admin.config') }}',
                            'pengaturan': '{{ route('admin.config') }}',
                            'logo': '{{ route('admin.config') }}',
                            
                            'profil': '{{ route('admin.profile') }}',
                            'akun': '{{ route('admin.profile') }}',
                            'profile': '{{ route('admin.profile') }}',
                        };

                        for (const key in commands) {
                            if (query === key || key.includes(query) || query.includes(key)) {
                                e.preventDefault();
                                window.location.href = commands[key];
                                return;
                            }
                        }
                    });
                }
            });
        </script>
    </div>

    <!-- Right Side: Profile -->
    <div class="flex items-center gap-2 shrink-0 ml-4">
        <div class="relative ml-2 flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <div class="text-xs font-bold text-slate-900 dark:text-white leading-none">{{ Auth::user()->nama ?? 'Admin' }}</div>
                <div class="text-[9px] text-slate-400 dark:text-slate-500 mt-1 uppercase font-bold tracking-wider">Super Admin</div>
            </div>
            <a href="{{ route('admin.profile') }}"
                class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors border border-slate-200 dark:border-slate-700 overflow-hidden shrink-0">
                @if(Auth::user()->foto_profil)
                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="w-full h-full object-cover" />
                @else
                    <span class="material-symbols-outlined text-[24px]"
                        style="font-variation-settings: 'FILL' 1;">account_circle</span>
                @endif
            </a>
        </div>
    </div>
</header>
