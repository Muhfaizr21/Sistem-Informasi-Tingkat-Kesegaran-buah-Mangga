<x-admin-layout>
    <x-slot name="title">Laporan Panen</x-slot>

    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-on-surface">Rekapitulasi Panen Nasional</h1>
            <p class="text-base text-on-surface-variant mt-1">Pantau total produksi dari seluruh kelompok tani mitra.</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">filter_list</span> Filter
            </button>
            <button class="bg-primary-container text-on-primary px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">download</span> Ekspor Excel
            </button>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-2xl">
            <p class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Total Produksi</p>
            <p class="text-2xl font-bold text-on-surface">{{ $reports->sum('jumlah_kg') }} <span class="text-xs font-normal">Kg</span></p>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-2xl">
            <p class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Total Laporan</p>
            <p class="text-2xl font-bold text-on-surface">{{ $reports->count() }}</p>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-2xl">
            <p class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Rata-rata Grade</p>
            <p class="text-2xl font-bold text-primary">A</p>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-2xl">
            <p class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Varietas Unggul</p>
            <p class="text-2xl font-bold text-secondary">H. Manis</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-surface-container-low text-[10px] font-bold text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Petani</th>
                    <th class="px-6 py-4">Varietas</th>
                    <th class="px-6 py-4 text-center">Berat (Kg)</th>
                    <th class="px-6 py-4 text-center">Grade</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant">
                @forelse($reports as $report)
                <tr class="hover:bg-surface-container-low transition-colors">
                    <td class="px-6 py-4 text-sm">{{ $report->tanggal_panen ? $report->tanggal_panen->format('d/m/Y') : $report->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center text-[10px] font-bold text-primary">
                                {{ substr($report->petani->user->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium">{{ $report->petani->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-on-surface">{{ $report->jenis_mangga }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-center">{{ $report->jumlah_kg }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $report->grade }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant text-sm italic">Belum ada data laporan panen dari petani.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
