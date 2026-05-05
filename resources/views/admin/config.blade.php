<x-admin-layout>
    <x-slot name="title">Konfigurasi</x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-on-surface">Konfigurasi Sistem</h1>
        <p class="text-base text-on-surface-variant mt-1">Kelola pengaturan aplikasi, integrasi, dan pemeliharaan data.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Settings Navigation -->
        <div class="lg:col-span-1 space-y-2">
            <button class="w-full flex items-center gap-3 px-6 py-3 bg-primary-container text-on-primary rounded-xl font-bold shadow-lg shadow-primary-container/20">
                <span class="material-symbols-outlined">settings</span> Umum
            </button>
            <button class="w-full flex items-center gap-3 px-6 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-xl font-medium transition-colors">
                <span class="material-symbols-outlined">api</span> API & Integrasi
            </button>
            <button class="w-full flex items-center gap-3 px-6 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-xl font-medium transition-colors">
                <span class="material-symbols-outlined">security</span> Keamanan
            </button>
            <button class="w-full flex items-center gap-3 px-6 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-xl font-medium transition-colors">
                <span class="material-symbols-outlined">database</span> Cadangan Data
            </button>
        </div>

        <!-- Right: Settings Form -->
        <div class="lg:col-span-2 space-y-8">
            <!-- App Identity Section -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 md:p-8 space-y-6">
                <h3 class="text-lg font-bold border-b border-outline-variant pb-4">Identitas Aplikasi</h3>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-bold text-on-surface-variant uppercase mb-2">Nama Aplikasi</label>
                            <input type="text" value="Mangga Indramayu" class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-primary-container transition-all">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-on-surface-variant uppercase mb-2">Versi Sistem</label>
                            <input type="text" value="v1.0.4-stable" disabled class="w-full bg-surface-container-high border border-outline-variant rounded-lg px-4 py-2.5 outline-none opacity-60">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[12px] font-bold text-on-surface-variant uppercase mb-2">Deskripsi Sistem</label>
                        <textarea class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-primary-container transition-all h-24">Sistem Informasi Terpadu Pemantauan Kualitas dan Distribusi Mangga Indramayu.</textarea>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 md:p-8 space-y-6">
                <h3 class="text-lg font-bold border-b border-outline-variant pb-4">Pengaturan Notifikasi</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-xl">
                        <div>
                            <p class="text-sm font-bold">Notifikasi Email</p>
                            <p class="text-xs text-on-surface-variant">Kirim laporan harian ke admin pusat.</p>
                        </div>
                        <div class="w-12 h-6 bg-primary-container rounded-full relative cursor-pointer">
                            <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-xl">
                        <div>
                            <p class="text-sm font-bold">Alert Anomali</p>
                            <p class="text-xs text-on-surface-variant">Notifikasi instan saat kualitas drop.</p>
                        </div>
                        <div class="w-12 h-6 bg-primary-container rounded-full relative cursor-pointer">
                            <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3">
                <button class="px-6 py-2.5 text-on-surface-variant font-bold hover:bg-surface-container-high rounded-lg transition-colors">Batalkan</button>
                <button class="px-8 py-2.5 bg-primary-container text-on-primary font-bold rounded-lg shadow-lg shadow-primary-container/20 hover:bg-primary transition-all active:scale-95">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</x-admin-layout>
