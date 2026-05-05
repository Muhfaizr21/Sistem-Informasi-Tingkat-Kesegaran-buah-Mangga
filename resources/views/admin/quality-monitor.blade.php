<x-admin-layout>
    <x-slot name="title">Monitor Kualitas</x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-on-surface">Monitor Kualitas Real-Time</h1>
        <p class="text-base text-on-surface-variant mt-1">Pemantauan live sensor tingkat kesegaran dan kesehatan komoditas.</p>
    </div>

    <!-- Live Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 flex flex-col gap-4 relative overflow-hidden group">
            <div class="flex justify-between items-center z-10">
                <span class="text-xs font-bold text-on-surface-variant uppercase">Rata-rata Kesegaran</span>
                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full animate-pulse">LIVE</span>
            </div>
            <div class="z-10">
                <div class="text-4xl font-bold text-on-surface">88%</div>
                <div class="text-xs text-on-tertiary-container mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                    Sangat Segar
                </div>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-5 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-[100px]">verified</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 flex flex-col gap-4 relative overflow-hidden group">
            <div class="flex justify-between items-center z-10">
                <span class="text-xs font-bold text-on-surface-variant uppercase">Laju Kematangan</span>
                <span class="text-on-surface-variant text-[10px] font-medium">Blok B-02</span>
            </div>
            <div class="z-10">
                <div class="text-4xl font-bold text-secondary">Normal</div>
                <div class="text-xs text-on-surface-variant mt-1">Sesuai standar musim</div>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-5 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-[100px]">trending_up</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 flex flex-col gap-4 relative overflow-hidden group">
            <div class="flex justify-between items-center z-10">
                <span class="text-xs font-bold text-on-surface-variant uppercase">Total Batch Aktif</span>
                <span class="text-on-surface-variant text-[10px] font-medium">Hari ini</span>
            </div>
            <div class="z-10">
                <div class="text-4xl font-bold text-on-surface">42</div>
                <div class="text-xs text-on-surface-variant mt-1">Dalam proses monitoring</div>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-5 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-[100px]">inventory_2</span>
            </div>
        </div>
    </div>

    <!-- Detailed Monitoring Table -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-outline-variant flex justify-between items-center">
            <h3 class="text-lg font-bold">Log Monitoring Batch</h3>
            <button class="text-primary text-sm font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-[18px]">refresh</span>
                Refresh Data
            </button>
        </div>
        <table class="w-full text-left">
            <thead>
                <tr class="bg-surface-container-low text-[10px] font-bold text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">
                    <th class="px-6 py-4">Batch ID</th>
                    <th class="px-6 py-4">Varietas</th>
                    <th class="px-6 py-4">Asal Lahan</th>
                    <th class="px-6 py-4">Score Kesegaran</th>
                    <th class="px-6 py-4 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant">
                <tr class="hover:bg-surface-container-low transition-colors">
                    <td class="px-6 py-4 font-mono text-xs">#MNG-8821</td>
                    <td class="px-6 py-4 text-sm font-medium">Harum Manis</td>
                    <td class="px-6 py-4 text-sm">Blok A-1</td>
                    <td class="px-6 py-4">
                        <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full w-[92%]"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">OPTIMAL</span>
                    </td>
                </tr>
                <tr class="hover:bg-surface-container-low transition-colors">
                    <td class="px-6 py-4 font-mono text-xs">#MNG-8822</td>
                    <td class="px-6 py-4 text-sm font-medium">Gedong Gincu</td>
                    <td class="px-6 py-4 text-sm">Blok C-4</td>
                    <td class="px-6 py-4">
                        <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                            <div class="bg-yellow-500 h-full w-[75%]"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded-full">STABIL</span>
                    </td>
                </tr>
                <tr class="hover:bg-surface-container-low transition-colors">
                    <td class="px-6 py-4 font-mono text-xs">#MNG-8823</td>
                    <td class="px-6 py-4 text-sm font-medium">Cengkir</td>
                    <td class="px-6 py-4 text-sm">Blok B-2</td>
                    <td class="px-6 py-4">
                        <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                            <div class="bg-red-500 h-full w-[45%]"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">RESIKO</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-admin-layout>
