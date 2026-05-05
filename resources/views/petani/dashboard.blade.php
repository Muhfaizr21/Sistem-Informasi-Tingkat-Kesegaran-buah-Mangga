<x-petani-layout>
    <x-slot name="title">Dashboard Petani</x-slot>

    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Semangat Pagi, {{ Auth::user()->name }}! 🧑‍🌾</h1>
            <p class="text-gray-500 mt-1">Cek kondisi mangga dan lahan Anda hari ini.</p>
        </div>
    </div>

    <!-- Quick Actions Card -->
    <div class="bg-primary rounded-[2rem] p-6 md:p-8 mb-8 text-white shadow-xl shadow-primary/20 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-xl font-bold mb-2">Ingin Cek Kematangan Mangga?</h2>
            <p class="text-white/80 text-sm mb-6 max-w-xs">Gunakan AI Scanner kami untuk mendeteksi tingkat kesegaran mangga secara instan.</p>
            <a href="{{ route('petani.cek-kesegaran') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary font-bold rounded-xl shadow-lg hover:bg-gray-100 transition-all active:scale-95">
                <span class="material-symbols-outlined">center_focus_strong</span>
                Mulai Scan AI
            </a>
        </div>
        <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[150px] text-white/10 rotate-12 pointer-events-none">park</span>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm text-center">
            <span class="material-symbols-outlined text-primary mb-2">forest</span>
            <p class="text-[10px] font-bold text-gray-400 uppercase">Luas Lahan</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">2.5 Ha</p>
        </div>
        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm text-center">
            <span class="material-symbols-outlined text-secondary mb-2">potted_plant</span>
            <p class="text-[10px] font-bold text-gray-400 uppercase">Jumlah Pohon</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">150</p>
        </div>
        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm text-center">
            <span class="material-symbols-outlined text-blue-500 mb-2">water_drop</span>
            <p class="text-[10px] font-bold text-gray-400 uppercase">Kelembaban</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">65%</p>
        </div>
        <div class="bg-white dark:bg-gray-900 p-5 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm text-center">
            <span class="material-symbols-outlined text-orange-500 mb-2">thermostat</span>
            <p class="text-[10px] font-bold text-gray-400 uppercase">Suhu Lahan</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">31°C</p>
        </div>
    </div>

    <!-- Recent Harvest or Tasks -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
            <h2 class="font-bold text-gray-900 dark:text-white">Laporan Panen Terakhir</h2>
            <a href="{{ route('petani.laporan-panen') }}" class="text-xs font-bold text-primary hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-50">
            <div class="p-4 flex justify-between items-center hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center font-bold">HM</div>
                    <div>
                        <p class="text-sm font-bold">Harum Manis</p>
                        <p class="text-[10px] text-gray-500">Blok A - 04 Mei 2024</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-primary">45 Kg</p>
                    <p class="text-[10px] text-green-600 font-bold uppercase tracking-widest">GRADE A</p>
                </div>
            </div>
            <div class="p-4 flex justify-between items-center hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center font-bold">GG</div>
                    <div>
                        <p class="text-sm font-bold">Gedong Gincu</p>
                        <p class="text-[10px] text-gray-500">Blok C - 02 Mei 2024</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-primary">12 Kg</p>
                    <p class="text-[10px] text-green-600 font-bold uppercase tracking-widest">GRADE A+</p>
                </div>
            </div>
        </div>
    </div>
</x-petani-layout>
