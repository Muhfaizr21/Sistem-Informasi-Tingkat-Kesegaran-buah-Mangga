<!-- TopAppBar Component -->
<header
    class="fixed top-0 right-0 w-[calc(100%-16rem)] border-b border-slate-200 bg-white dark:bg-slate-900 font-inter text-base border-b border-slate-200 dark:border-slate-800 z-40">
    <div class="flex justify-between items-center px-8 h-16 ml-64 w-[calc(100%-16rem)] ml-0 w-full">
        <!-- Left Side: Search Bar -->
        <div class="flex items-center flex-1 max-w-md">
            <div
                class="relative w-full group focus-within:ring-2 focus-within:ring-blue-900/10 rounded-md transition-shadow">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input
                    class="w-full h-10 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-md text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:border-blue-900 focus:bg-white transition-colors"
                    placeholder="Cari data, petani, atau transaksi..." type="text" />
            </div>
        </div>
        <!-- Right Side: Trailing Icons & Profile -->
        <div class="flex items-center gap-2">
            <button
                class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined"
                    style="font-variation-settings: 'FILL' 0;">notifications</span>
            </button>
            <button
                class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">history</span>
            </button>
            <div class="relative ml-2 flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-700">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-semibold text-slate-900 dark:text-white leading-none">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 uppercase font-bold tracking-wider">Super Admin</div>
                </div>
                <button
                    class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <span class="material-symbols-outlined"
                        style="font-variation-settings: 'FILL' 1;">account_circle</span>
                </button>
            </div>
        </div>
    </div>
</header>
