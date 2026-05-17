<x-petani-layout>
    <x-slot name="title">Laporan Panen</x-slot>

    <!-- Header Section -->
    <div class="mb-12 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight mb-1">Laporan Panen 🧺</h1>
            <p class="text-sm text-slate-500 font-medium">Pantau produktivitas dan kelola riwayat panen Anda secara digital.</p>
        </div>
        <button onclick="document.getElementById('modal-add-panen').classList.remove('hidden')"
            class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-4 bg-[#FFB800] hover:bg-[#E0A400] text-emerald-950 font-black rounded-2xl shadow-md transition-all active:scale-[0.98] text-xs uppercase tracking-wider shrink-0">
            <span class="material-symbols-outlined text-lg">add_task</span>
            <span>Buat Laporan Baru</span>
        </button>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 text-emerald-700 rounded-2xl border border-emerald-100 flex items-center gap-3 animate-in slide-in-from-top duration-500">
            <span class="material-symbols-outlined text-xl">check_circle</span>
            <span class="font-extrabold text-xs uppercase tracking-tight">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-slate-50/60 p-6 md:p-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Produksi (Kg)</p>
            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">{{ number_format($totalKg, 1) }} <span class="text-xs font-medium text-slate-400 uppercase">Netto</span></h3>
        </div>
        <div class="bg-slate-50/60 p-6 md:p-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Rata-rata / Lahan</p>
            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">{{ number_format($avgPerLahan, 1) }} <span class="text-xs font-medium text-slate-400 uppercase">Kg</span></h3>
        </div>
        <div class="bg-slate-50/60 p-6 md:p-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Verified Status</p>
            <h3 class="text-2xl md:text-3xl font-extrabold text-emerald-650 tracking-tight">
                {{ $reports->where('status', 'verified')->count() }} <span class="text-xs font-medium text-slate-400 uppercase">Items</span>
            </h3>
        </div>
        <div class="bg-slate-50/60 p-6 md:p-8 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Pending Review</p>
            <h3 class="text-2xl md:text-3xl font-extrabold text-amber-600 tracking-tight">
                {{ $reports->where('status', 'submitted')->count() }} <span class="text-xs font-medium text-slate-400 uppercase">Items</span>
            </h3>
        </div>
    </div>

    <!-- Kecamatan Production Analysis & Yearly Rankings -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-12">
        
        <!-- Left Card: Kecamatan Production Trends -->
        <div class="bg-white p-6 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div>
                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 text-[10px] font-black rounded-full uppercase tracking-widest border border-emerald-500/20">Kecamatan Analytics</span>
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight mt-2">Produksi Tahunan Kecamatan</h3>
                    <p class="text-xs text-slate-500 font-medium">Tren produksi tahun 2011 - 2025 di wilayah kecamatan Anda</p>
                </div>
                <span class="material-symbols-outlined text-3xl text-emerald-600 bg-emerald-50 p-3 rounded-2xl shrink-0">insights</span>
            </div>

            <div class="space-y-3 max-h-[360px] overflow-y-auto pr-2 custom-scrollbar">
                @forelse($historicalStats as $stat)
                    <div class="flex items-center justify-between p-4 bg-slate-50/50 hover:bg-slate-50 rounded-xl border border-slate-100/60 transition-all">
                        <div class="flex items-center gap-3">
                            <span class="px-3.5 py-1.5 bg-slate-100 text-slate-800 text-[10px] font-black rounded-full uppercase tracking-wider">{{ $stat->tahun }}</span>
                            <div>
                                <p class="text-[10px] font-black text-slate-405 uppercase tracking-widest leading-none mb-1">{{ $stat->kecamatan->nama ?? 'Kecamatan' }}</p>
                                <p class="text-xs font-bold text-slate-600">Luas: {{ number_format($stat->luas_hektar, 2) }} Ha</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-emerald-650 uppercase tracking-widest">Total Produksi</p>
                            <p class="text-base font-black text-slate-800 tracking-tight">{{ number_format($stat->produksi_kuintal / 10, 2) }} <span class="text-xs font-medium text-slate-400">Ton</span></p>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <span class="material-symbols-outlined text-3xl text-slate-300 mb-2">analytics</span>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tidak ada data untuk kecamatan ini</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Card: Top Production per Year Ranking -->
        <div class="bg-[#064E3B] bg-gradient-to-br from-[#064E3B] to-[#022C22] p-6 md:p-8 rounded-[2.5rem] text-white shadow-xl relative overflow-hidden group">
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div>
                    <span class="px-3 py-1 bg-white/10 text-[#FFB800] text-[10px] font-black rounded-full uppercase tracking-widest border border-white/10">Yearly Leaderboard</span>
                    <h3 class="text-xl font-extrabold tracking-tight mt-2 text-white">Kecamatan Terbaik Per Tahun 🥇</h3>
                    <p class="text-xs text-emerald-200/70 font-medium">Kecamatan penghasil mangga tertinggi tiap tahunnya</p>
                </div>
                <span class="material-symbols-outlined text-3xl text-[#FFB800] bg-white/10 p-3 rounded-2xl shrink-0">trophy</span>
            </div>

            <div class="space-y-3 max-h-[360px] overflow-y-auto pr-2 custom-scrollbar">
                @foreach($topKecamatanPerYear as $year => $data)
                    <div class="flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 rounded-xl border border-white/5 transition-all">
                        <div class="flex items-center gap-3">
                            <span class="px-3.5 py-1.5 bg-[#FFB800] text-emerald-950 text-[10px] font-black rounded-full uppercase tracking-wider">{{ $year }}</span>
                            <div>
                                <p class="text-[10px] text-emerald-300/40 font-black uppercase tracking-widest leading-none mb-1">Kecamatan Juara</p>
                                <p class="text-xs font-black text-white tracking-wide uppercase">{{ $data['nama_kecamatan'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] text-[#FFB800] font-black uppercase tracking-widest">Produksi Tertinggi</p>
                            <p class="text-base font-black text-white tracking-tight">{{ number_format($data['produksi_ton'], 2) }} <span class="text-xs font-medium text-emerald-200/50">Ton</span></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Reports Table / List -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-150 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 bg-slate-50/20">
            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">Riwayat Produksi Lahan</h2>
            <form action="{{ route('petani.laporan-panen') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <div class="relative flex-1 sm:min-w-[180px]">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">map</span>
                    <select name="lahan_id" onchange="this.form.submit()"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3.5 text-xs font-black uppercase tracking-wider focus:ring-4 focus:ring-emerald-500/10 outline-none appearance-none cursor-pointer text-slate-700">
                        <option value="">Filter Lahan</option>
                        @foreach($lahan as $l)
                            <option value="{{ $l->id }}" {{ request('lahan_id') == $l->id ? 'selected' : '' }}>{{ $l->nama_lahan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="relative flex-1 sm:min-w-[180px]">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">filter_list</span>
                    <select name="status" onchange="this.form.submit()"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3.5 text-xs font-black uppercase tracking-wider focus:ring-4 focus:ring-emerald-500/10 outline-none appearance-none cursor-pointer text-slate-700">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Arsip Draft</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto rounded-[2rem] border border-slate-100 shadow-inner">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-8 py-5 text-[9px] font-black text-slate-450 uppercase tracking-widest">Metadata Waktu</th>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-450 uppercase tracking-widest">Lokasi Lahan</th>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-450 uppercase tracking-widest">Varietas</th>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-450 uppercase tracking-widest">Kuantitas</th>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-450 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-450 uppercase tracking-widest text-right">Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reports as $report)
                        <tr class="hover:bg-slate-50/50 transition-all group">
                            <td class="px-8 py-6">
                                <p class="text-sm font-extrabold text-slate-800 mb-0.5">{{ $report->tanggal_panen->format('d M Y') }}</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Pukul: {{ $report->created_at->format('H:i') }} WIB</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-xs font-bold text-slate-700 mb-0.5">{{ $report->lahan->nama_lahan ?? 'N/A' }}</p>
                                <p class="text-[9px] text-slate-400 font-medium italic">Area: {{ $report->lahan->desa ?? 'N/A' }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-slate-100 rounded-lg text-[9px] font-black text-slate-600 uppercase tracking-tight">{{ $report->jenis_mangga }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-lg font-extrabold text-slate-800 tracking-tight">
                                    {{ number_format($report->jumlah_kg, 1) }} <span class="text-xs font-medium text-slate-400">Kg</span>
                                </p>
                            </td>
                            <td class="px-8 py-6">
                                @if($report->status == 'verified')
                                    <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl text-[9px] font-black uppercase tracking-wider flex items-center gap-1.5 w-fit border border-emerald-100">
                                        <span class="material-symbols-outlined text-[14px]">verified</span> VERIFIED
                                    </span>
                                @elseif($report->status == 'submitted')
                                    <span class="px-3 py-1.5 bg-amber-50 text-amber-800 rounded-xl text-[9px] font-black uppercase tracking-wider flex items-center gap-1.5 w-fit border border-amber-100 animate-pulse">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span> PENDING
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-xl text-[9px] font-black uppercase tracking-wider flex items-center gap-1.5 w-fit border border-slate-200">
                                        <span class="material-symbols-outlined text-[14px]">draft</span> DRAFT
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </button>
                                    @if($report->status != 'verified')
                                        <button class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-base">edit</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                    <span class="material-symbols-outlined text-slate-300 text-3xl">inventory_2</span>
                                </div>
                                <h4 class="text-base font-extrabold text-slate-800 mb-1">Belum Ada Data Produksi</h4>
                                <p class="text-xs text-slate-400 font-medium">Lakukan penginputan hasil panen untuk mulai memantau produktivitas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Add Laporan Panen -->
    <div id="modal-add-panen" class="fixed inset-0 z-[100] hidden bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-2xl rounded-[2rem] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300 border border-slate-100">
            <div class="p-6 md:p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/20">
                <div>
                    <h2 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">Input Hasil Panen</h2>
                    <p class="text-xs text-slate-450 font-medium">Laporan akan diverifikasi oleh Admin Sistem.</p>
                </div>
                <button onclick="document.getElementById('modal-add-panen').classList.add('hidden')"
                    class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center hover:bg-slate-250 transition-all active:scale-90 shrink-0">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>

            <form action="{{ route('petani.laporan-panen.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 md:p-8 space-y-6 overflow-y-auto max-h-[70vh] custom-scrollbar">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Lahan Produksi</label>
                        <select name="lahan_id"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:ring-4 focus:ring-emerald-500/10 outline-none font-bold text-slate-700 appearance-none cursor-pointer" required>
                            @foreach($lahan as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_lahan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Pelaksanaan Panen</label>
                        <input type="date" name="tanggal_panen" value="{{ date('Y-m-d') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:ring-4 focus:ring-emerald-500/10 outline-none font-bold text-slate-700" required>
                    </div>

                    <div>
                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">Jumlah Kuantitas (Kg)</label>
                        <input type="number" step="0.1" name="jumlah_kg" placeholder="0.0"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:ring-4 focus:ring-emerald-500/10 outline-none font-bold text-slate-700" required>
                    </div>
                    <div>
                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">Varietas Mangga</label>
                        <select name="jenis_mangga"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:ring-4 focus:ring-emerald-500/10 outline-none font-bold text-slate-700 appearance-none cursor-pointer" required>
                            <option value="Harum Manis">Harum Manis</option>
                            <option value="Gedong Gincu">Gedong Gincu</option>
                            <option value="Cengkir">Cengkir</option>
                            <option value="Manalagi">Manalagi</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">Kondisi Cuaca Saat Panen</label>
                        <input type="text" name="kondisi_cuaca" placeholder="Contoh: Cerah Terik, Berawan Sejuk"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:ring-4 focus:ring-emerald-500/10 outline-none font-bold text-slate-700">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Observasi</label>
                        <textarea name="catatan" rows="3" placeholder="Tambahkan informasi khusus mengenai kualitas atau kendala..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-emerald-500/10 outline-none font-bold text-slate-700 resize-none"></textarea>
                    </div>

                    <div class="sm:col-span-2" x-data="{ 
                        previews: [],
                        handleFiles(e) {
                            const files = Array.from(e.target.files);
                            files.forEach(file => {
                                const reader = new FileReader();
                                reader.onload = (ev) => {
                                    this.previews.push({
                                        id: Date.now() + Math.random(),
                                        url: ev.target.result
                                    });
                                };
                                reader.readAsDataURL(file);
                            });
                        },
                        removePreview(id) {
                            this.previews = this.previews.filter(p => p.id !== id);
                        }
                    }">
                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-3">Dokumentasi Hasil Panen</label>

                        <!-- Preview Grid -->
                        <div x-show="previews.length > 0" class="grid grid-cols-4 sm:grid-cols-5 gap-3 mb-4">
                            <template x-for="preview in previews" :key="preview.id">
                                <div class="relative aspect-square rounded-xl overflow-hidden border border-slate-200 shadow-sm group/prev">
                                    <img :src="preview.url" class="w-full h-full object-cover">
                                    <button type="button" @click="removePreview(preview.id)"
                                        class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-lg flex items-center justify-center opacity-0 group-hover/prev:opacity-100 transition-opacity shadow-md">
                                        <span class="material-symbols-outlined text-xs">close</span>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="relative group">
                            <input type="file" name="foto_panen[]" multiple accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFiles">
                            <div class="w-full bg-slate-50 border-dashed border-2 border-slate-200 rounded-2xl px-6 py-8 text-center group-hover:border-emerald-500 group-hover:bg-emerald-500/5 transition-all duration-300">
                                <span class="material-symbols-outlined text-slate-350 text-4xl mb-2 group-hover:text-emerald-500 transition-colors">add_photo_alternate</span>
                                <p class="text-xs font-black text-slate-600 mb-0.5">Unggah Dokumentasi Panen</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Pilih Beberapa Foto (JPG/PNG)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4.5 rounded-xl shadow-md transition-all active:scale-[0.98] uppercase tracking-wider text-xs">
                        Kirim Laporan Panen Ke Sistem
                    </button>
                    <div class="mt-4 flex items-center justify-center gap-1.5 text-slate-400">
                        <span class="material-symbols-outlined text-sm">shield_person</span>
                        <p class="text-[9px] font-bold uppercase tracking-widest">Laporan akan melewati tahap validasi admin</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-petani-layout>