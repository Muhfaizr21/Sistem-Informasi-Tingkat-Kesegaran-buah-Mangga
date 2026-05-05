<x-buyer-layout>
    <x-slot name="title">Dashboard Pembeli</x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Halo, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-gray-500 mt-1">Selamat datang kembali. Ada mangga segar yang menunggumu hari ini.</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Total Pesanan</p>
            <div class="flex items-center justify-between">
                <span class="text-3xl font-extrabold text-gray-900 dark:text-white">12</span>
                <span class="material-symbols-outlined text-primary p-3 bg-primary/10 rounded-2xl">shopping_bag</span>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Dalam Pengiriman</p>
            <div class="flex items-center justify-between">
                <span class="text-3xl font-extrabold text-gray-900 dark:text-white">1</span>
                <span class="material-symbols-outlined text-secondary p-3 bg-secondary/10 rounded-2xl">local_shipping</span>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Poin MangoFresh</p>
            <div class="flex items-center justify-between">
                <span class="text-3xl font-extrabold text-gray-900 dark:text-white">450</span>
                <span class="material-symbols-outlined text-accent p-3 bg-accent/10 rounded-2xl">loyalty</span>
            </div>
        </div>
    </div>

    <!-- Featured Section -->
    <div class="bg-primary/10 rounded-[2rem] p-8 mb-8 flex flex-col md:flex-row items-center gap-8 border border-primary/20">
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Panen Raya Mangga Gedong Gincu!</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Nikmati diskon hingga 20% untuk pembelian minimal 5kg mangga Gedong Gincu kualitas ekspor.</p>
            <a href="{{ route('buyer.catalog') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:bg-yellow-500 transition-all">
                Cek Katalog Sekarang
            </a>
        </div>
        <img src="https://images.unsplash.com/photo-1591073113125-e46713c829ed?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" class="w-full md:w-64 h-48 object-cover rounded-2xl rotate-3 shadow-xl" alt="Promo">
    </div>

    <!-- Recent Orders Preview -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
            <h2 class="font-bold text-gray-900 dark:text-white">Pesanan Terakhir</h2>
            <a href="{{ route('buyer.order-history') }}" class="text-xs font-bold text-primary hover:underline">Lihat Semua</a>
        </div>
        <div class="p-6 text-center py-12">
            <span class="material-symbols-outlined text-gray-200 text-6xl mb-4">inventory_2</span>
            <p class="text-gray-500 text-sm">Belum ada pesanan aktif saat ini.</p>
        </div>
    </div>
</x-buyer-layout>
