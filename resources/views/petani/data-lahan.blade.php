<x-petani-layout>
    <x-slot name="title">Manajemen Data Lahan</x-slot>
    
    <!-- Leaflet GIS Local -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.draw.css') }}" />
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/vendor/leaflet/leaflet.draw.js') }}"></script>
    <style>
        .leaflet-draw-toolbar a { background-image: url("{{ asset('assets/vendor/leaflet/images/spritesheet.png') }}"); }
        .leaflet-draw-toolbar-top { margin-top: 10px !important; }
        .leaflet-container { font-family: inherit; }
    </style>

    <!-- Header Section -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Manajemen Lahan 🌳</h1>
            <p class="text-slate-500 font-medium">Kelola data lahan mangga Anda untuk optimasi hasil panen.</p>
        </div>
        <button onclick="openAddModal()" class="flex items-center gap-2 px-8 py-4 bg-primary-500 text-white font-bold rounded-2xl shadow-xl shadow-primary-500/20 hover:scale-105 transition-all active:scale-95 text-sm">
            <span class="material-symbols-outlined text-lg">add_location</span>
            Tambah Lahan Baru
        </button>
    </div>

    @if(session('success'))
        <div class="mb-8 p-6 bg-primary-50 text-primary-600 rounded-3xl border border-primary-100 flex items-center gap-4 animate-in slide-in-from-top duration-500">
            <span class="material-symbols-outlined text-2xl">check_circle</span>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-10">
        
        <!-- List View (Left) -->
        <div class="xl:col-span-8 space-y-8">
            <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Daftar Lahan Aktif</h2>
                    <div class="flex gap-3">
                        <button class="p-3 bg-white border border-slate-100 rounded-2xl text-primary-500 shadow-sm">
                            <span class="material-symbols-outlined text-lg">view_list</span>
                        </button>
                        <button class="p-3 bg-white border border-slate-100 rounded-2xl text-slate-400 shadow-sm">
                            <span class="material-symbols-outlined text-lg">map</span>
                        </button>
                    </div>
                </div>

                <div class="divide-y divide-slate-50">
                    @forelse($lahan as $item)
                    <div class="p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-8 hover:bg-slate-50/50 transition-all group">
                        <div class="flex items-center gap-8 flex-1">
                            <div class="w-24 h-24 bg-slate-100 rounded-[2rem] overflow-hidden shadow-inner relative shrink-0">
                                @if($item->foto_lahan && count($item->foto_lahan) > 0)
                                    <img src="{{ Storage::url($item->foto_lahan[0]) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <span class="material-symbols-outlined text-4xl">image</span>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-1 bg-white/90 backdrop-blur-md rounded-lg text-[9px] font-black uppercase text-primary-500 shadow-sm border border-slate-100">{{ $item->status }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xl font-extrabold text-slate-900 mb-1 truncate">{{ $item->nama_lahan }}</h3>
                                <p class="text-xs text-slate-400 font-medium flex items-center gap-1 mb-4">
                                    <span class="material-symbols-outlined text-sm">location_on</span>
                                    {{ $item->desa }}, Kec. {{ $item->kecamatan->nama_kecamatan ?? 'N/A' }}
                                </p>
                                <div class="flex flex-wrap gap-4">
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl">
                                        <span class="material-symbols-outlined text-[16px] text-primary-500">straighten</span>
                                        <span class="text-[11px] font-black text-slate-600 uppercase tracking-tight">{{ $item->luas_hektar }} Ha</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl">
                                        <span class="material-symbols-outlined text-[16px] text-secondary">park</span>
                                        <span class="text-[11px] font-black text-slate-600 uppercase tracking-tight">{{ $item->jumlah_pohon }} Pohon</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl">
                                        <span class="material-symbols-outlined text-[16px] text-blue-500">calendar_month</span>
                                        <span class="text-[11px] font-black text-slate-600 uppercase tracking-tight">Tanam: {{ $item->tahun_tanam }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 w-full md:w-auto shrink-0">
                            <button class="flex-1 md:flex-none px-6 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-black text-slate-600 hover:bg-slate-50 transition-all uppercase tracking-widest">Detail</button>
                            <button onclick="editLahan({{ json_encode($item) }})" class="flex-1 md:flex-none px-6 py-3 bg-blue-50 text-blue-600 rounded-2xl text-xs font-black hover:bg-blue-100 transition-all uppercase tracking-widest">Edit</button>
                            <form action="{{ route('petani.data-lahan.destroy', $item->id) }}" method="POST" class="inline flex-1 md:flex-none" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lahan ini? Semua histori data akan diarsipkan.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full px-6 py-3 bg-red-50 text-red-500 rounded-2xl text-xs font-black hover:bg-red-100 transition-all uppercase tracking-widest">Hapus</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="p-24 text-center">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="material-symbols-outlined text-slate-200 text-5xl">location_off</span>
                        </div>
                        <h4 class="text-lg font-extrabold text-slate-900 mb-2">Belum Ada Data Lahan</h4>
                        <p class="text-sm text-slate-400 font-medium max-w-xs mx-auto">Tambahkan data lahan pertama Anda untuk mulai memantau produktivitas dan rekomendasi AI.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Info (Right) -->
        <div class="xl:col-span-4 space-y-8">
            <!-- Map View Preview -->
            <div class="bg-white p-8 rounded-[3.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                <h3 class="text-xl font-extrabold text-slate-900 mb-6">Sebaran Geografis</h3>
                <div class="aspect-square bg-slate-50 rounded-[2.5rem] overflow-hidden relative border border-slate-100 shadow-inner group-hover:shadow-lg transition-all duration-500 z-10">
                    <div id="mini-map" class="absolute inset-0 z-10"></div>
                </div>
                <a href="{{ route('petani.wilayah-produksi') }}" class="w-full mt-8 py-4 flex items-center justify-center gap-2 bg-slate-900 text-white font-black rounded-3xl hover:bg-black transition-all active:scale-95 text-[11px] uppercase tracking-widest">
                    Buka Peta Interaktif
                </a>
            </div>

            <!-- Guidelines Card -->
            <div class="bg-primary-600 p-10 rounded-[3.5rem] text-white shadow-2xl shadow-primary-500/20 relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-8 backdrop-blur-md border border-white/20">
                        <span class="material-symbols-outlined text-white text-2xl">lightbulb</span>
                    </div>
                    <h4 class="text-xl font-extrabold mb-4 tracking-tight">Tips Penginputan</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <span class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center shrink-0 font-bold text-[10px]">1</span>
                            <p class="text-xs text-white/80 font-medium leading-relaxed italic">Gunakan koordinat GPS yang diambil langsung di tengah lahan.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center shrink-0 font-bold text-[10px]">2</span>
                            <p class="text-xs text-white/80 font-medium leading-relaxed italic">Upload minimal 3 foto representatif untuk verifikasi admin.</p>
                        </li>
                    </ul>
                </div>
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white/5 rounded-full blur-[100px] group-hover:scale-150 transition-transform duration-1000"></div>
            </div>
        </div>
    </div>

    <!-- Modal Add Lahan -->
    <div id="modal-add-lahan" class="fixed inset-0 z-[100] hidden bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-6" x-data="{ step: 1 }">
        <div class="bg-white w-full max-w-3xl rounded-5xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-500">
            <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/20">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Registrasi Lahan</h2>
                    <p class="text-sm text-slate-400 font-medium">Lengkapi metadata produksi untuk integrasi AI.</p>
                </div>
                <button onclick="document.getElementById('modal-add-lahan').classList.add('hidden')" class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center hover:bg-slate-200 transition-all active:scale-90">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            
            <form action="{{ route('petani.data-lahan.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8 overflow-y-auto max-h-[75vh] custom-scrollbar">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Nama Identitas Lahan</label>
                        <input type="text" name="nama_lahan" placeholder="Contoh: Kebun Mangga Blok Utara 01" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold" required>
                    </div>

                    <div class="p-6 bg-slate-50 rounded-4xl border border-slate-100 space-y-6 md:col-span-2">
                        <div class="flex justify-between items-center mb-2">
                             <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Geospasial Coordinates</p>
                             <button type="button" onclick="getLocation('add')" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-[10px] font-black rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">
                                <span class="material-symbols-outlined text-sm">my_location</span>
                                Gunakan Lokasi Saat Ini
                             </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Latitude</label>
                                <input type="text" name="latitude" id="add-latitude" placeholder="-6.321200" class="w-full bg-white border-none rounded-2xl px-6 py-4 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Longitude</label>
                                <input type="text" name="longitude" id="add-longitude" placeholder="108.324500" class="w-full bg-white border-none rounded-2xl px-6 py-4 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold shadow-sm" required>
                            </div>
                        </div>
                        
                        <!-- Drawing Map -->
                        <div class="mt-6">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Gambar Area Lahan (Polygon)</label>
                            <div id="map-add-polygon" class="w-full h-64 rounded-3xl border border-slate-200 z-10 shadow-inner overflow-hidden"></div>
                            <input type="hidden" name="koordinat_polygon" id="add-koordinat-polygon">
                            <p class="mt-2 text-[10px] text-slate-400 font-medium italic">* Gunakan tool polygon di peta untuk menggambar batas lahan Anda.</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Kecamatan Lokasi</label>
                        <select name="kecamatan_id" id="add-kecamatan-id" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold appearance-none" required>
                            @foreach($kecamatan as $k)
                                <option value="{{ $k->id }}" {{ ($petani->kecamatan_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Nama Desa</label>
                        <input type="text" name="desa" id="add-desa" placeholder="Masukan Nama Desa" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Luas Area (Hektar)</label>
                        <input type="number" step="0.01" name="luas_hektar" placeholder="0.5" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Utama Varietas</label>
                        <select name="jenis_mangga" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold appearance-none" required>
                            <option value="Harum Manis">Harum Manis</option>
                            <option value="Gedong Gincu">Gedong Gincu</option>
                            <option value="Manalagi">Manalagi</option>
                            <option value="Cengkir / Indramayu">Cengkir / Indramayu</option>
                            <option value="Golek">Golek</option>
                            <option value="Apel">Apel</option>
                            <option value="Kweni">Kweni</option>
                            <option value="Madu">Madu</option>
                            <option value="Podang">Podang</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Jumlah Pohon Aktif</label>
                        <input type="number" name="jumlah_pohon" placeholder="100" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Tahun Mulai Tanam</label>
                        <input type="number" name="tahun_tanam" placeholder="2020" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 px-1">Status Operasional Lahan</label>
                        <div class="grid grid-cols-3 gap-6">
                            <label class="cursor-pointer group">
                                <input type="radio" name="status" value="produktif" class="hidden peer" checked>
                                <div class="px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-center text-[10px] font-black uppercase tracking-widest peer-checked:bg-primary-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-primary-500/30 transition-all duration-300">Produktif</div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="status" value="persiapan" class="hidden peer">
                                <div class="px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-center text-[10px] font-black uppercase tracking-widest peer-checked:bg-secondary peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-secondary/30 transition-all duration-300">Persiapan</div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="status" value="tidak_aktif" class="hidden peer">
                                <div class="px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-center text-[10px] font-black uppercase tracking-widest peer-checked:bg-red-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-red-500/30 transition-all duration-300">Non-Aktif</div>
                            </label>
                        </div>
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
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 px-1">Dokumentasi Visual Lahan</label>
                        
                        <!-- Preview Grid -->
                        <div x-show="previews.length > 0" class="grid grid-cols-4 md:grid-cols-5 gap-4 mb-6">
                            <template x-for="preview in previews" :key="preview.id">
                                <div class="relative aspect-square rounded-[1.5rem] overflow-hidden border-2 border-white shadow-md group/prev">
                                    <img :src="preview.url" class="w-full h-full object-cover">
                                    <button type="button" @click="removePreview(preview.id)" class="absolute top-1.5 right-1.5 w-7 h-7 bg-red-500 text-white rounded-xl flex items-center justify-center opacity-0 group-hover/prev:opacity-100 transition-opacity shadow-lg">
                                        <span class="material-symbols-outlined text-[16px]">close</span>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="relative group">
                            <input type="file" name="foto_lahan[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFiles">
                            <div class="w-full bg-slate-50 border-dashed border-4 border-slate-200 rounded-[2.5rem] px-8 py-12 text-center group-hover:border-primary-500 group-hover:bg-primary-50/30 transition-all duration-300">
                                <span class="material-symbols-outlined text-slate-300 text-5xl mb-4 group-hover:text-primary-500 transition-colors">cloud_upload</span>
                                <p class="text-sm font-extrabold text-slate-600 mb-1">Unggah Foto Lahan</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Pilih Minimal 3 Foto (JPG/PNG)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-10">
                    <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-black py-6 rounded-[2rem] shadow-2xl shadow-primary-500/30 transition-all transform active:scale-95 uppercase tracking-[0.2em] text-xs">
                        Finalisasi Registrasi Lahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Edit Lahan -->
    <div id="modal-edit-lahan" class="fixed inset-0 z-[100] hidden bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-3xl rounded-5xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-500">
            <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/20">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Data Lahan</h2>
                    <p class="text-sm text-slate-400 font-medium">Perbarui informasi geospasial dan profil lahan Anda.</p>
                </div>
                <button onclick="document.getElementById('modal-edit-lahan').classList.add('hidden')" class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center hover:bg-slate-200 transition-all active:scale-90">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            
            <form id="form-edit-lahan" action="" method="POST" enctype="multipart/form-data" class="p-10 space-y-8 overflow-y-auto max-h-[75vh] custom-scrollbar">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Nama Identitas Lahan</label>
                        <input type="text" name="nama_lahan" id="edit-nama-lahan" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold" required>
                    </div>

                    <div class="p-6 bg-slate-50 rounded-4xl border border-slate-100 space-y-6 md:col-span-2">
                        <div class="flex justify-between items-center mb-2">
                             <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Geospasial Coordinates</p>
                             <button type="button" onclick="getLocation('edit')" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-[10px] font-black rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">
                                <span class="material-symbols-outlined text-sm">my_location</span>
                                Update ke Lokasi Saat Ini
                             </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Latitude</label>
                                <input type="text" name="latitude" id="edit-latitude" class="w-full bg-white border-none rounded-2xl px-6 py-4 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Longitude</label>
                                <input type="text" name="longitude" id="edit-longitude" class="w-full bg-white border-none rounded-2xl px-6 py-4 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold shadow-sm" required>
                            </div>
                        </div>

                        <!-- Drawing Map Edit -->
                        <div class="mt-6">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Edit Area Lahan (Polygon)</label>
                            <div id="map-edit-polygon" class="w-full h-64 rounded-3xl border border-slate-200 z-10 shadow-inner overflow-hidden"></div>
                            <input type="hidden" name="koordinat_polygon" id="edit-koordinat-polygon">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Kecamatan Lokasi</label>
                        <select name="kecamatan_id" id="edit-kecamatan-id" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold appearance-none" required>
                            @foreach($kecamatan as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Nama Desa</label>
                        <input type="text" name="desa" id="edit-desa" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Luas Area (Hektar)</label>
                        <input type="number" step="0.01" name="luas_hektar" id="edit-luas" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Utama Varietas</label>
                        <select name="jenis_mangga" id="edit-jenis-mangga" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold appearance-none" required>
                            <option value="Harum Manis">Harum Manis</option>
                            <option value="Gedong Gincu">Gedong Gincu</option>
                            <option value="Manalagi">Manalagi</option>
                            <option value="Cengkir / Indramayu">Cengkir / Indramayu</option>
                            <option value="Golek">Golek</option>
                            <option value="Apel">Apel</option>
                            <option value="Kweni">Kweni</option>
                            <option value="Madu">Madu</option>
                            <option value="Podang">Podang</option>
                        </select>
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
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 px-1">Update Dokumentasi Visual</label>
                        
                        <!-- Preview Grid -->
                        <div x-show="previews.length > 0" class="grid grid-cols-4 md:grid-cols-5 gap-4 mb-6">
                            <template x-for="preview in previews" :key="preview.id">
                                <div class="relative aspect-square rounded-[1.5rem] overflow-hidden border-2 border-white shadow-md group/prev">
                                    <img :src="preview.url" class="w-full h-full object-cover">
                                    <button type="button" @click="removePreview(preview.id)" class="absolute top-1.5 right-1.5 w-7 h-7 bg-red-500 text-white rounded-xl flex items-center justify-center opacity-0 group-hover/prev:opacity-100 transition-opacity shadow-lg">
                                        <span class="material-symbols-outlined text-[16px]">close</span>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="relative group">
                            <input type="file" name="foto_lahan[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFiles">
                            <div class="w-full bg-slate-50 border-dashed border-4 border-slate-200 rounded-[2.5rem] px-8 py-12 text-center group-hover:border-blue-500 group-hover:bg-blue-50/30 transition-all duration-300">
                                <span class="material-symbols-outlined text-slate-300 text-5xl mb-4 group-hover:text-blue-500 transition-colors">cloud_upload</span>
                                <p class="text-sm font-extrabold text-slate-600 mb-1">Tambah Foto Baru</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Pilih Foto (JPG/PNG)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-10">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-6 rounded-[2rem] shadow-2xl shadow-blue-500/30 transition-all transform active:scale-95 uppercase tracking-[0.2em] text-xs">
                        Simpan Perubahan Lahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let addMap, editMap, drawControl, drawnItems;

        function initDrawMap(elementId, hiddenInputId, initialData = null) {
            const container = document.getElementById(elementId);
            if (!container) return;

            // Cleanup if already exists
            if (elementId === 'map-add-polygon' && addMap) addMap.remove();
            if (elementId === 'map-edit-polygon' && editMap) editMap.remove();

            const map = L.map(elementId).setView([-6.3276, 108.3249], 15);
            if (elementId === 'map-add-polygon') addMap = map;
            else editMap = map;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            const items = new L.FeatureGroup();
            map.addLayer(items);

            if (initialData) {
                const polygon = L.polygon(initialData, { color: '#10B981', weight: 3, fillOpacity: 0.4 }).addTo(items);
                map.fitBounds(polygon.getBounds());
            }

            const drawControl = new L.Control.Draw({
                draw: {
                    polygon: {
                        allowIntersection: false,
                        showArea: true,
                        drawError: { color: '#e1e100', message: '<strong>Peringatan:</strong> Batas tidak boleh berpotongan!' },
                        shapeOptions: { color: '#10B981' }
                    },
                    polyline: false, circle: false, rectangle: false, marker: false, circlemarker: false
                },
                edit: { featureGroup: items, remove: true }
            });

            map.addControl(drawControl);

            map.on(L.Draw.Event.CREATED, function (e) {
                items.clearLayers();
                const layer = e.layer;
                items.addLayer(layer);
                updateHiddenInput(layer, hiddenInputId);
            });

            map.on(L.Draw.Event.EDITED, function (e) {
                e.layers.eachLayer(function (layer) {
                    updateHiddenInput(layer, hiddenInputId);
                });
            });

            map.on(L.Draw.Event.DELETED, function (e) {
                document.getElementById(hiddenInputId).value = '';
            });

            return map;
        }

        function updateHiddenInput(layer, inputId) {
            const coords = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);
            document.getElementById(inputId).value = JSON.stringify(coords);
        }

        function openAddModal() {
            document.getElementById('modal-add-lahan').classList.remove('hidden');
            setTimeout(() => {
                initDrawMap('map-add-polygon', 'add-koordinat-polygon');
            }, 300);
        }

        function editLahan(lahan) {
            const modal = document.getElementById('modal-edit-lahan');
            const form = document.getElementById('form-edit-lahan');
            form.action = `/petani/data-lahan/${lahan.id}`;
            document.getElementById('edit-nama-lahan').value = lahan.nama_lahan;
            document.getElementById('edit-latitude').value = lahan.latitude;
            document.getElementById('edit-longitude').value = lahan.longitude;
            document.getElementById('edit-kecamatan-id').value = lahan.kecamatan_id;
            document.getElementById('edit-desa').value = lahan.desa;
            document.getElementById('edit-luas').value = lahan.luas_hektar;
            document.getElementById('edit-jenis-mangga').value = lahan.jenis_mangga;
            document.getElementById(`edit-status-${lahan.status}`).checked = true;
            
            // Set initial polygon data if exists
            document.getElementById('edit-koordinat-polygon').value = lahan.koordinat_polygon ? JSON.stringify(lahan.koordinat_polygon) : '';

            modal.classList.remove('hidden');
            setTimeout(() => {
                initDrawMap('map-edit-polygon', 'edit-koordinat-polygon', lahan.koordinat_polygon);
            }, 300);
        }

        function getLocation(type) {
            if (navigator.geolocation) {
                const btn = event.currentTarget;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">sync</span> Mencari...';
                btn.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        document.getElementById(`${type}-latitude`).value = lat.toFixed(6);
                        document.getElementById(`${type}-longitude`).value = lon.toFixed(6);
                        
                        // Pan map to current location
                        if (type === 'add' && addMap) addMap.setView([lat, lon], 18);
                        if (type === 'edit' && editMap) editMap.setView([lat, lon], 18);

                        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
                            .then(response => response.json())
                            .then(data => {
                                const addr = data.address;
                                const desaName = addr.village || addr.suburb || addr.neighbourhood || addr.hamlet || '';
                                if (desaName) document.getElementById(`${type}-desa`).value = desaName;

                                const districtName = addr.city_district || addr.suburb || addr.district || addr.town || addr.city || '';
                                if (districtName) {
                                    fetch('{{ route("petani.kecamatan.sync") }}', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                        body: JSON.stringify({ name: districtName })
                                    })
                                    .then(res => res.json())
                                    .then(syncData => {
                                        const select = document.getElementById(`${type}-kecamatan-id`);
                                        let optionExists = false;
                                        for (let i = 0; i < select.options.length; i++) {
                                            if (select.options[i].value == syncData.id) {
                                                select.selectedIndex = i;
                                                optionExists = true;
                                                break;
                                            }
                                        }
                                        if (!optionExists) {
                                            const newOption = new Option(syncData.nama, syncData.id, true, true);
                                            select.add(newOption);
                                        }
                                    });
                                }
                                btn.innerHTML = '<span class="material-symbols-outlined text-sm text-green-300">check_circle</span> Berhasil!';
                                btn.classList.replace('bg-blue-600', 'bg-green-600');
                                setTimeout(() => {
                                    btn.innerHTML = originalText;
                                    btn.classList.replace('bg-green-600', 'bg-blue-600');
                                    btn.disabled = false;
                                }, 2000);
                            })
                            .catch(() => {
                                btn.innerHTML = originalText;
                                btn.disabled = false;
                            });
                    },
                    () => {
                        alert("Gagal mengambil lokasi. Pastikan GPS aktif.");
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                );
            }
        }

        // Initialize Mini Map (Interactive GIS Sebaran)
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('mini-map', {
                zoomControl: false,
                attributionControl: false
            }).setView([-6.3276, 108.3249], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            const lahanData = @json($lahan);
            const bounds = [];

            lahanData.forEach(l => {
                if (l.koordinat_polygon && l.koordinat_polygon.length > 0) {
                    const polygon = L.polygon(l.koordinat_polygon, {
                        color: "#10B981",
                        fillColor: "#10B981",
                        fillOpacity: 0.4,
                        weight: 2
                    }).addTo(map);
                    polygon.bindPopup(`<b class="text-xs">${l.nama_lahan}</b><br><span class="text-[10px]">${l.luas_hektar} Ha</span>`);
                    bounds.push(polygon.getBounds());
                } else if (l.latitude && l.longitude) {
                    const marker = L.circleMarker([l.latitude, l.longitude], {
                        radius: 8,
                        fillColor: "#10B981",
                        color: "#fff",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(map);
                    marker.bindPopup(`<b class="text-xs">${l.nama_lahan}</b>`);
                    bounds.push(marker.getLatLng());
                }
            });

            if (bounds.length > 0) {
                if (lahanData.some(l => l.koordinat_polygon)) {
                     const group = new L.featureGroup(map._layers);
                     map.fitBounds(group.getBounds().pad(0.2));
                } else {
                     map.setView(bounds[0], 15);
                }
            }
        });
    </script>
</x-petani-layout>
