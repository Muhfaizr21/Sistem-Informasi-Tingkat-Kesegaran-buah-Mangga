    <x-petani-layout>
        <x-slot name="title">Laporan Panen</x-slot>

        <!-- Header Section -->
        <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Laporan Panen 🧺</h1>
                <p class="text-slate-500 font-medium">Pantau produktivitas dan kelola riwayat panen Anda secara digital.</p>
            </div>
            <button onclick="document.getElementById('modal-add-panen').classList.remove('hidden')"
                class="flex items-center gap-3 px-8 py-4 bg-secondary text-white font-black rounded-2xl shadow-xl shadow-secondary/20 hover:scale-105 transition-all active:scale-95 text-sm uppercase tracking-widest">
                <span class="material-symbols-outlined text-lg">add_task</span>
                Buat Laporan Baru
            </button>
        </div>

        @if(session('success'))
            <div
                class="mb-8 p-6 bg-primary-50 text-primary-600 rounded-3xl border border-primary-100 flex items-center gap-4 animate-in slide-in-from-top duration-500">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Statistics Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div
                class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm group hover:shadow-lg transition-all duration-500">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Total Produksi (Kg)</p>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tighter">{{ number_format($totalKg, 1) }} <span
                        class="text-sm font-medium text-slate-400 opacity-50 uppercase">Netto</span></h3>
            </div>
            <div
                class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm group hover:shadow-lg transition-all duration-500">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Rata-rata / Lahan</p>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tighter">{{ number_format($avgPerLahan, 1) }}
                    <span class="text-sm font-medium text-slate-400 opacity-50 uppercase">Kg</span></h3>
            </div>
            <div
                class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm group hover:shadow-lg transition-all duration-500">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Verified Status</p>
                <h3 class="text-3xl font-extrabold text-primary-500 tracking-tighter">
                    {{ $reports->where('status', 'verified')->count() }} <span
                        class="text-sm font-medium text-slate-400 opacity-50 uppercase">Items</span></h3>
            </div>
            <div
                class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm group hover:shadow-lg transition-all duration-500">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Pending Review</p>
                <h3 class="text-3xl font-extrabold text-secondary tracking-tighter">
                    {{ $reports->where('status', 'submitted')->count() }} <span
                        class="text-sm font-medium text-slate-400 opacity-50 uppercase">Items</span></h3>
            </div>
        </div>

        <!-- Reports Table / List -->
        <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div
                class="p-10 border-b border-slate-50 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-8 bg-slate-50/20">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Riwayat Produksi Lahan</h2>
                <form action="{{ route('petani.laporan-panen') }}" method="GET"
                    class="flex flex-wrap gap-4 w-full xl:w-auto">
                    <div class="relative flex-1 min-w-[200px]">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">map</span>
                        <select name="lahan_id" onchange="this.form.submit()"
                            class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-xs font-black uppercase tracking-widest focus:ring-4 focus:ring-primary-500/10 outline-none appearance-none cursor-pointer">
                            <option value="">Filter Lahan</option>
                            @foreach($lahan as $l)
                                <option value="{{ $l->id }}" {{ request('lahan_id') == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_lahan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="relative flex-1 min-w-[200px]">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">filter_list</span>
                        <select name="status" onchange="this.form.submit()"
                            class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-xs font-black uppercase tracking-widest focus:ring-4 focus:ring-primary-500/10 outline-none appearance-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Arsip Draft</option>
                            <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu
                                Verifikasi</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi
                            </option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th
                                class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                Metadata Waktu</th>
                            <th
                                class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                Lokasi Produksi</th>
                            <th
                                class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                Varietas</th>
                            <th
                                class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                Kuantitas</th>
                            <th
                                class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                Status</th>
                            <th
                                class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                                Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($reports as $report)
                            <tr class="hover:bg-slate-50/50 transition-all group">
                                <td class="px-10 py-8">
                                    <p class="text-sm font-extrabold text-slate-900 mb-1">
                                        {{ $report->tanggal_panen->format('d M Y') }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Pukul:
                                        {{ $report->created_at->format('H:i') }} WIB</p>
                                </td>
                                <td class="px-10 py-8">
                                    <p class="text-sm font-bold text-slate-700 mb-1">{{ $report->lahan->nama_lahan ?? 'N/A' }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-medium italic">Area:
                                        {{ $report->lahan->desa ?? 'N/A' }}</p>
                                </td>
                                <td class="px-10 py-8">
                                    <span
                                        class="px-4 py-1.5 bg-slate-100 rounded-xl text-[10px] font-black text-slate-600 uppercase tracking-tight">{{ $report->jenis_mangga }}</span>
                                </td>
                                <td class="px-10 py-8">
                                    <p class="text-xl font-extrabold text-slate-900 tracking-tighter">
                                        {{ number_format($report->jumlah_kg, 1) }} <span
                                            class="text-xs font-medium text-slate-400">Kg</span></p>
                                </td>
                                <td class="px-10 py-8">
                                    @if($report->status == 'verified')
                                        <span
                                            class="px-4 py-2 bg-primary-500/10 text-primary-500 rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 w-fit border border-primary-500/20 shadow-sm">
                                            <span class="material-symbols-outlined text-[16px] fill-1">verified</span> VERIFIED
                                        </span>
                                    @elseif($report->status == 'submitted')
                                        <span
                                            class="px-4 py-2 bg-secondary/10 text-secondary rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 w-fit border border-secondary/20 shadow-sm">
                                            <span class="material-symbols-outlined text-[16px]">schedule</span> PENDING
                                        </span>
                                    @else
                                        <span
                                            class="px-4 py-2 bg-slate-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 w-fit border border-slate-200">
                                            <span class="material-symbols-outlined text-[16px]">draft</span> DRAFT
                                        </span>
                                    @endif
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div
                                        class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button
                                            class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 rounded-xl hover:bg-primary-500 hover:text-white transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </button>
                                        @if($report->status != 'verified')
                                            <button
                                                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 rounded-xl hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-10 py-24 text-center">
                                    <div
                                        class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <span class="material-symbols-outlined text-slate-200 text-5xl">inventory_2</span>
                                    </div>
                                    <h4 class="text-lg font-extrabold text-slate-900 mb-2">Belum Ada Data Produksi</h4>
                                    <p class="text-sm text-slate-400 font-medium">Lakukan penginputan hasil panen untuk mulai
                                        memantau produktivitas lahan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Add Laporan Panen -->
        <div id="modal-add-panen"
            class="fixed inset-0 z-[100] hidden bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-6">
            <div
                class="bg-white w-full max-w-3xl rounded-5xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-500">
                <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/20">
                    <div>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Input Hasil Panen</h2>
                        <p class="text-sm text-slate-400 font-medium">Laporan akan diverifikasi oleh Admin Sistem.</p>
                    </div>
                    <button onclick="document.getElementById('modal-add-panen').classList.add('hidden')"
                        class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center hover:bg-slate-200 transition-all active:scale-90">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>

                <form action="{{ route('petani.laporan-panen.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-10 space-y-8 overflow-y-auto max-h-[75vh] custom-scrollbar">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Pilih
                                Lahan Produksi</label>
                            <select name="lahan_id"
                                class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold appearance-none cursor-pointer"
                                required>
                                @foreach($lahan as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama_lahan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Tanggal
                                Pelaksanaan Panen</label>
                            <input type="date" name="tanggal_panen" value="{{ date('Y-m-d') }}"
                                class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold"
                                required>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Jumlah
                                Kuantitas (Kg)</label>
                            <input type="number" step="0.1" name="jumlah_kg" placeholder="0.0"
                                class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold"
                                required>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Varietas
                                Mangga</label>
                            <select name="jenis_mangga"
                                class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold appearance-none cursor-pointer"
                                required>
                                <option value="Harum Manis">Harum Manis</option>
                                <option value="Gedong Gincu">Gedong Gincu</option>
                                <option value="Cengkir">Cengkir</option>
                                <option value="Manalagi">Manalagi</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Kondisi
                                Cuaca Saat Panen</label>
                            <input type="text" name="kondisi_cuaca" placeholder="Contoh: Cerah Terik, Berawan Sejuk"
                                class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold shadow-inner">
                        </div>

                        <div class="md:col-span-2">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Catatan
                                Observasi</label>
                            <textarea name="catatan" rows="4"
                                placeholder="Tambahkan informasi khusus mengenai kualitas atau kendala saat panen..."
                                class="w-full bg-slate-50 border-none rounded-[2rem] px-8 py-6 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold shadow-inner resize-none"></textarea>
                        </div>

                        <div class="md:col-span-2" x-data="{ 
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
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Dokumentasi
                                Hasil Panen</label>

                            <!-- Preview Grid -->
                            <div x-show="previews.length > 0" class="grid grid-cols-4 md:grid-cols-5 gap-4 mb-6">
                                <template x-for="preview in previews" :key="preview.id">
                                    <div
                                        class="relative aspect-square rounded-[1.5rem] overflow-hidden border-2 border-white shadow-md group/prev">
                                        <img :src="preview.url" class="w-full h-full object-cover">
                                        <button type="button" @click="removePreview(preview.id)"
                                            class="absolute top-1.5 right-1.5 w-7 h-7 bg-red-500 text-white rounded-xl flex items-center justify-center opacity-0 group-hover/prev:opacity-100 transition-opacity shadow-lg">
                                            <span class="material-symbols-outlined text-[16px]">close</span>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <div class="relative group">
                                <input type="file" name="foto_panen[]" multiple accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    @change="handleFiles">
                                <div
                                    class="w-full bg-slate-50 border-dashed border-4 border-slate-200 rounded-[2.5rem] px-8 py-12 text-center group-hover:border-secondary group-hover:bg-secondary/5 transition-all duration-300">
                                    <span
                                        class="material-symbols-outlined text-slate-300 text-5xl mb-4 group-hover:text-secondary transition-colors">add_photo_alternate</span>
                                    <p class="text-sm font-extrabold text-slate-600 mb-1">Unggah Dokumentasi Panen</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Pilih Beberapa
                                        Foto (JPG/PNG)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10">
                        <button type="submit"
                            class="w-full bg-secondary hover:bg-yellow-600 text-white font-black py-6 rounded-[2rem] shadow-2xl shadow-secondary/30 transition-all transform active:scale-95 uppercase tracking-[0.2em] text-xs">
                            Kirim Laporan Panen Ke Sistem
                        </button>
                        <div class="mt-6 flex items-center justify-center gap-2 text-slate-400">
                            <span class="material-symbols-outlined text-sm">shield_person</span>
                            <p class="text-[10px] font-bold uppercase tracking-widest">Laporan akan melewati tahap validasi
                                admin</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-petani-layout>