<x-buyer-layout>
    <x-slot name="title">Checkout</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left: Cart Items & Info -->
        <div class="lg:col-span-8 space-y-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Selesaikan Pesanan</h1>
            
            <!-- Shipping Address -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-primary">location_on</span>
                    <h2 class="font-bold text-gray-900 dark:text-white">Alamat Pengiriman</h2>
                </div>
                <div class="flex justify-between items-start">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-bold text-gray-900 dark:text-white mb-1">{{ Auth::user()->name }}</p>
                        <p>Jl. Mangga No. 123, Kelurahan Karanganyar</p>
                        <p>Kecamatan Indramayu, Kabupaten Indramayu</p>
                        <p>Jawa Barat, 45213</p>
                    </div>
                    <button class="text-xs font-bold text-primary hover:underline">Ubah Alamat</button>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">shopping_basket</span>
                        <h2 class="font-bold text-gray-900 dark:text-white">Rincian Produk</h2>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    <!-- Item 1 -->
                    <div class="p-6 flex gap-4">
                        <img src="https://images.unsplash.com/photo-1553279768-865429fa0078?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" class="w-20 h-20 object-cover rounded-xl" alt="Mangga Harum Manis">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 dark:text-white">Mangga Harum Manis Super</h3>
                            <p class="text-xs text-gray-500 mb-2">Grade A+ • Segar dari Kebun</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-primary">Rp 25.000 / kg</span>
                                <span class="text-sm font-medium text-gray-600">x 2kg</span>
                            </div>
                        </div>
                    </div>
                    <!-- Item 2 -->
                    <div class="p-6 flex gap-4">
                        <img src="https://images.unsplash.com/photo-1591073113125-e46713c829ed?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" class="w-20 h-20 object-cover rounded-xl" alt="Mangga Gedong Gincu">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 dark:text-white">Mangga Gedong Gincu</h3>
                            <p class="text-xs text-gray-500 mb-2">Khas Indramayu • Manis Alami</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-primary">Rp 35.000 / kg</span>
                                <span class="text-sm font-medium text-gray-600">x 1kg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Summary & Payment -->
        <div class="lg:col-span-4">
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-xl border border-gray-100 dark:border-gray-800 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Ringkasan Belanja</h2>
                
                <div class="space-y-4 text-sm mb-6">
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Total Harga (3 Barang)</span>
                        <span>Rp 85.000</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Biaya Pengiriman</span>
                        <span class="text-secondary font-bold">Gratis</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-gray-400 border-t border-dashed border-gray-200 dark:border-gray-700 pt-4">
                        <span>Biaya Jasa Aplikasi</span>
                        <span>Rp 2.000</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white pt-2">
                        <span>Total Tagihan</span>
                        <span class="text-primary">Rp 87.000</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Pilih Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button class="border-2 border-primary bg-primary/5 p-3 rounded-xl flex flex-col items-center gap-1">
                            <span class="material-symbols-outlined text-primary">account_balance</span>
                            <span class="text-[10px] font-bold">Transfer Bank</span>
                        </button>
                        <button class="border border-gray-200 dark:border-gray-800 p-3 rounded-xl flex flex-col items-center gap-1 hover:border-primary transition-colors">
                            <span class="material-symbols-outlined text-gray-500">payments</span>
                            <span class="text-[10px] font-bold">E-Wallet</span>
                        </button>
                    </div>
                </div>

                <button class="w-full bg-primary hover:bg-yellow-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary/30 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 uppercase tracking-wider text-sm">
                    Bayar Sekarang
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>

                <p class="mt-4 text-[10px] text-center text-gray-500 italic">
                    Pesanan Anda dilindungi oleh Garansi Kesegaran 100%.
                </p>
            </div>
        </div>
    </div>
</x-buyer-layout>
