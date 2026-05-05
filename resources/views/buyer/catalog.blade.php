<x-buyer-layout>
    <x-slot name="title">Katalog Mangga</x-slot>

    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Katalog Mangga Segar</h1>
            <p class="text-gray-500 mt-2 text-lg">Pilih varietas mangga terbaik langsung dari petani Indramayu.</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <div class="relative flex-1 md:w-64">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input type="text" placeholder="Cari mangga..." class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl focus:ring-2 focus:ring-primary outline-none shadow-sm">
            </div>
            <button class="p-3 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm text-gray-500">
                <span class="material-symbols-outlined">filter_list</span>
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($products as $product)
        <div class="group bg-white dark:bg-gray-900 rounded-[2.5rem] overflow-hidden border border-gray-50 dark:border-gray-800 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
            <div class="aspect-square relative overflow-hidden">
                <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=400&q=80' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $product->name }}">
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-bold text-primary uppercase tracking-widest shadow-sm">{{ $product->grade }}</span>
                </div>
                <div class="absolute top-4 right-4">
                    <button class="w-10 h-10 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">favorite</span>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-gray-900 dark:text-white leading-tight group-hover:text-primary transition-colors">{{ $product->name }}</h3>
                </div>
                <p class="text-xs text-gray-400 mb-4 line-clamp-1">{{ $product->variety }} • Stok: {{ $product->stock }}kg</p>
                
                <div class="flex items-center justify-between mt-auto">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Harga /Kg</p>
                        <p class="text-lg font-black text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('buyer.checkout') }}" class="w-12 h-12 bg-gray-900 dark:bg-primary rounded-2xl flex items-center justify-center text-white shadow-lg shadow-gray-200 dark:shadow-primary/20 hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">shopping_bag</span>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <span class="material-symbols-outlined text-gray-200 text-6xl mb-4">inventory_2</span>
            <p class="text-gray-400">Belum ada produk mangga yang tersedia.</p>
        </div>
        @endforelse
    </div>
</x-buyer-layout>
