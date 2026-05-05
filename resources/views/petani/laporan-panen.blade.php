<x-petani-layout>
    <x-slot name="title">Laporan Panen</x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Input Laporan Panen</h1>
        <p class="text-gray-500 mt-1">Catat hasil panen Anda untuk diproses oleh sistem.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Form Section -->
        <div class="bg-white dark:bg-gray-900 p-6 md:p-8 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm">
            <form action="{{ route('petani.laporan-panen.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih Varietas Mangga</label>
                    <select name="variety" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none" required>
                        <option value="Harum Manis">Harum Manis</option>
                        <option value="Gedong Gincu">Gedong Gincu</option>
                        <option value="Cengkir">Cengkir</option>
                        <option value="Manalagi">Manalagi</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Berat Total (Kg)</label>
                        <input type="number" name="weight" step="0.01" placeholder="Contoh: 50" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Grade</label>
                        <select name="grade" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none" required>
                            <option value="Grade A+">Grade A+</option>
                            <option value="Grade A">Grade A</option>
                            <option value="Grade B">Grade B</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Lokasi Lahan (Blok)</label>
                    <input type="text" name="location" placeholder="Contoh: Blok A-12" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Catatan Tambahan</label>
                    <textarea name="note" placeholder="Kondisi cuaca saat panen, dll..." class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none h-24"></textarea>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-green-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 transition-all transform active:scale-95">
                    Simpan Laporan Panen
                </button>
            </form>
        </div>

        <!-- Recent History Section -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold px-2">Riwayat Input Terakhir</h2>
            <div class="space-y-3">
                @forelse($reports as $report)
                <div class="bg-white dark:bg-gray-900 p-4 rounded-2xl border border-gray-100 dark:border-gray-800 flex justify-between items-center group hover:border-primary transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold">{{ $report->variety }} ({{ $report->location }})</p>
                            <p class="text-[10px] text-gray-500">Input: {{ $report->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-primary">{{ $report->weight }} Kg</p>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">{{ $report->grade }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                    <p class="text-gray-400 text-sm">Belum ada laporan panen.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-petani-layout>
