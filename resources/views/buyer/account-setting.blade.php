<x-buyer-layout>
    <x-slot name="title">Pengaturan Akun</x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Pengaturan Akun</h1>
        <p class="text-gray-500 mt-1">Kelola informasi pribadi dan alamat pengiriman Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left: Profile Summary -->
        <div class="lg:col-span-4">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-800 shadow-sm text-center">
                <div class="relative inline-block mb-4">
                    <div class="w-32 h-32 rounded-full bg-primary/20 flex items-center justify-center text-primary text-4xl font-bold border-4 border-white dark:border-gray-800 shadow-lg">
                        {{ substr(Auth::user()->name ?? 'B', 0, 1) }}
                    </div>
                    <button class="absolute bottom-1 right-1 w-10 h-10 bg-primary text-white rounded-full border-4 border-white dark:border-gray-800 flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-sm">photo_camera</span>
                    </button>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                <div class="mt-6 pt-6 border-t border-gray-50 dark:border-gray-800 flex justify-around">
                    <div class="text-center">
                        <p class="text-lg font-bold text-primary">12</p>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Order</p>
                    </div>
                    <div class="text-center">
                        <p class="text-lg font-bold text-primary">450</p>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Poin</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Settings Form -->
        <div class="lg:col-span-8">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-800 shadow-sm">
                <form action="#" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" value="{{ Auth::user()->email }}" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nomor WhatsApp</label>
                            <input type="text" placeholder="0812xxxxxx" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pekerjaan</label>
                            <input type="text" placeholder="Contoh: Pedagang Buah" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Alamat Utama Pengiriman</label>
                        <textarea placeholder="Jl. Raya Indramayu No..." class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none h-32"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" class="px-6 py-3 text-gray-500 font-bold hover:bg-gray-100 rounded-xl transition-all">Batalkan</button>
                        <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:bg-yellow-500 transition-all transform active:scale-95">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-buyer-layout>
