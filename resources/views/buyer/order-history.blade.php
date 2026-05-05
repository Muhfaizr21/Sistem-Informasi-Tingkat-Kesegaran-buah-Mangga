<x-buyer-layout>
    <x-slot name="title">Riwayat Pesanan</x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Riwayat Pesanan</h1>
        <p class="text-gray-500 mt-1">Pantau status pengiriman dan riwayat belanja Anda.</p>
    </div>

    <div class="space-y-4">
        <!-- Order 1 -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 hover:border-primary transition-all">
            <div class="flex flex-col md:flex-row justify-between gap-4 md:items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined">local_shipping</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">ORD-20240505-001</span>
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase">Dikirim</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Dipesan pada: 05 Mei 2024 • 14:20 WIB</p>
                    </div>
                </div>
                <div class="flex items-center justify-between md:justify-end gap-8">
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Total Pembayaran</p>
                        <p class="text-sm font-bold text-primary">Rp 87.000</p>
                    </div>
                    <button class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-bold rounded-lg hover:bg-primary hover:text-white transition-all">
                        Lihat Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- Order 2 -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 opacity-75 grayscale hover:grayscale-0 hover:opacity-100 transition-all">
            <div class="flex flex-col md:flex-row justify-between gap-4 md:items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-100 text-gray-500 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">ORD-20240428-042</span>
                            <span class="px-2 py-0.5 bg-gray-200 text-gray-600 text-[10px] font-bold rounded-full uppercase">Selesai</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Dipesan pada: 28 April 2024 • 09:15 WIB</p>
                    </div>
                </div>
                <div class="flex items-center justify-between md:justify-end gap-8">
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Total Pembayaran</p>
                        <p class="text-sm font-bold text-primary">Rp 120.000</p>
                    </div>
                    <button class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-bold rounded-lg hover:bg-primary hover:text-white transition-all">
                        Lihat Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-buyer-layout>
