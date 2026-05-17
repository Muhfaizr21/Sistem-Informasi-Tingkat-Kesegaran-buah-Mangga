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
        <div class="relative w-full group focus-within:ring-2 focus-within:ring-emerald-500/20 rounded-xl transition-shadow">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
            <input
                class="w-full h-10 pl-10 pr-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-slate-100 focus:outline-none focus:border-emerald-500 focus:bg-white dark:focus:bg-slate-900 transition-colors"
                placeholder="Cari data, petani, atau transaksi..." type="text" />
        </div>
    </div>

    <!-- Right Side: Trailing Icons & Profile -->
    <div class="flex items-center gap-2 shrink-0 ml-4">
        <button
            class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined text-[22px]"
                style="font-variation-settings: 'FILL' 0;">notifications</span>
        </button>
        <button
            class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 0;">history</span>
        </button>
        <div class="relative ml-2 flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-700">
            <div class="text-right hidden sm:block">
                <div class="text-xs font-bold text-slate-900 dark:text-white leading-none">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-[9px] text-slate-400 dark:text-slate-500 mt-1 uppercase font-bold tracking-wider">Super Admin</div>
            </div>
            <button
                class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors border border-slate-200 dark:border-slate-700 overflow-hidden">
                <span class="material-symbols-outlined text-[24px]"
                    style="font-variation-settings: 'FILL' 1;">account_circle</span>
            </button>
        </div>
    </div>
</header>
