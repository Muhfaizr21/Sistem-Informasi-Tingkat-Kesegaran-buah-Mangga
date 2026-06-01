<x-petani-layout>
    <x-slot name="title">Edit Produk</x-slot>

    <!-- Header Section -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-3 py-1 bg-primary-500/10 text-primary-500 text-[10px] font-black rounded-full uppercase tracking-widest">Manajemen Produk</span>
                <span class="px-3 py-1 bg-blue-500/10 text-blue-500 text-[10px] font-black rounded-full uppercase tracking-widest">Marketplace Listing</span>
            </div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Edit Produk 🏪</h1>
            <p class="text-slate-500 font-medium mt-1">Lengkapi atau ubah detail informasi produk mangga Anda di marketplace.</p>
        </div>
        <a href="{{ route('petani.produk.index') }}" class="flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all active:scale-95 text-xs uppercase tracking-widest">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Katalog
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-12 p-6 bg-red-50 text-red-600 rounded-3xl border border-red-100 space-y-2 animate-in slide-in-from-top duration-500">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl">error</span>
                <span class="font-bold text-sm uppercase tracking-widest">Terjadi Kesalahan Validasi</span>
            </div>
            <ul class="list-disc list-inside text-xs font-bold text-red-500 pl-7 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Left: Product Scan Preview & Stats -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden p-6 text-center space-y-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Foto Hasil Pindaian</p>
                
                @php
                    $fotos = $produk->foto_batch;
                    $fotoUtama = !empty($fotos) && is_array($fotos) ? asset('storage/' . $fotos[0]) : 'https://images.unsplash.com/photo-1553279768-865429fa0078?q=80&w=1000&auto=format&fit=crop';
                @endphp
                <div class="w-full aspect-[4/3] rounded-[2rem] overflow-hidden border border-slate-100 shadow-inner bg-slate-50 relative group">
                    <img src="{{ $fotoUtama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Foto Produk">
                    <div class="absolute top-4 right-4">
                        @if($produk->aktif)
                            <span class="px-4 py-1.5 bg-emerald-500 text-white text-[10px] font-black rounded-full shadow-lg shadow-emerald-500/20 uppercase tracking-widest">AKTIF</span>
                        @else
                            <span class="px-4 py-1.5 bg-amber-500 text-white text-[10px] font-black rounded-full shadow-lg shadow-amber-500/20 uppercase tracking-widest">DRAFT</span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-slate-50 pt-6 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 px-4 py-3 rounded-2xl text-center border border-slate-100">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Skor Kesegaran</p>
                            <p class="text-xl font-black text-slate-900">{{ number_format($produk->skor_kesegaran, 0) }}%</p>
                        </div>
                        <div class="bg-slate-50 px-4 py-3 rounded-2xl text-center border border-slate-100">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Batch ID</p>
                            <p class="text-xs font-black text-slate-900 truncate uppercase" title="{{ $produk->batch_id }}">{{ $produk->batch_id ?? '--' }}</p>
                        </div>
                    </div>

                    @if($produk->scan)
                        <div class="bg-slate-50 p-4 rounded-2xl text-left border border-slate-100 space-y-2">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Data Hasil Scan AI</p>
                            <div class="flex justify-between items-center text-xs font-bold text-slate-700">
                                <span>Kategori:</span>
                                <span class="text-primary-500 uppercase tracking-wider">{{ str_replace('_', ' ', $produk->scan->kategori) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs font-bold text-slate-700">
                                <span>Estimasi Ukuran:</span>
                                <span>{{ $produk->scan->berat_gram }}g / {{ $produk->scan->diameter_cm }}cm</span>
                            </div>
                            <div class="flex justify-between items-center text-xs font-bold text-slate-700">
                                <span>Akurasi AI:</span>
                                <span>{{ $produk->scan->skor_kepercayaan }}%</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Edit Form -->
        <div class="lg:col-span-8">
            <div class="bg-white p-10 md:p-14 rounded-[4rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-10 opacity-5">
                    <span class="material-symbols-outlined text-[120px]">edit_note</span>
                </div>

                <form action="{{ route('petani.produk.update', $produk->id) }}" method="POST" class="space-y-12 relative z-10">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <h3 class="text-xl font-extrabold text-slate-900 border-b border-slate-50 pb-6 tracking-tight">Formulir Informasi Produk</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Varietas Mangga -->
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Varietas / Jenis Mangga</label>
                                <input type="text" name="jenis_mangga" value="{{ old('jenis_mangga', $produk->jenis_mangga) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
                                @error('jenis_mangga')
                                    <p class="text-xs text-red-500 font-bold mt-2 px-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Asal Lahan -->
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Asal Lahan Panen</label>
                                <div class="relative">
                                    <select name="lahan_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner appearance-none" required>
                                        @foreach($lahan as $l)
                                            <option value="{{ $l->id }}" {{ $produk->lahan_id == $l->id ? 'selected' : '' }}>
                                                {{ $l->nama_lahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="material-symbols-outlined absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xl">expand_more</span>
                                </div>
                                @error('lahan_id')
                                    <p class="text-xs text-red-500 font-bold mt-2 px-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Per Kg -->
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Harga per Kg (Rp)</label>
                                <div class="relative">
                                    <input type="number" name="harga_per_kg" value="{{ old('harga_per_kg', round($produk->harga_per_kg)) }}" min="0" class="w-full bg-slate-50 border-none rounded-2xl pl-14 pr-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-400 text-sm">Rp</span>
                                </div>
                                @error('harga_per_kg')
                                    <p class="text-xs text-red-500 font-bold mt-2 px-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok Tersedia -->
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Stok Tersedia (Kg)</label>
                                <div class="relative">
                                    <input type="number" name="stok_tersedia_kg" value="{{ old('stok_tersedia_kg', round($produk->stok_tersedia_kg)) }}" min="0" class="w-full bg-slate-50 border-none rounded-2xl pr-14 pl-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 font-black text-slate-400 text-sm">Kg</span>
                                </div>
                                @error('stok_tersedia_kg')
                                    <p class="text-xs text-red-500 font-bold mt-2 px-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Minimal Order -->
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Minimal Order (Kg)</label>
                                <div class="relative">
                                    <input type="number" name="minimal_order_kg" value="{{ old('minimal_order_kg', round($produk->minimal_order_kg)) }}" min="0.1" step="0.1" class="w-full bg-slate-50 border-none rounded-2xl pr-14 pl-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 font-black text-slate-400 text-sm">Kg</span>
                                </div>
                                @error('minimal_order_kg')
                                    <p class="text-xs text-red-500 font-bold mt-2 px-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Deskripsi Produk -->
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Deskripsi Produk</label>
                            <textarea name="deskripsi" rows="5" class="w-full bg-slate-50 border-none rounded-[2rem] px-8 py-6 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner resize-none" placeholder="Masukkan deskripsi detail mengenai keunggulan, rasa, dan pengemasan mangga Anda...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="text-xs text-red-500 font-bold mt-2 px-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Marketplace Toggle -->
                        <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 flex items-center justify-between gap-6 hover:border-primary-500/30 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-primary-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                                    <span class="material-symbols-outlined">storefront</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-extrabold text-slate-900 mb-0.5">Tampilkan di Marketplace</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Jika dinonaktifkan, produk akan disimpan sebagai Draft</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="aktif" value="1" class="sr-only peer" {{ old('aktif', $produk->aktif) ? 'checked' : '' }}>
                                <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-500"></div>
                            </label>
                        </div>

                    </div>

                    <div class="pt-10 border-t border-slate-50 flex justify-end gap-4">
                        <a href="{{ route('petani.produk.index') }}" class="px-10 py-5 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                            Batal
                        </a>
                        <button type="submit" class="px-12 py-5 bg-primary-500 text-white font-black rounded-2xl shadow-2xl shadow-primary-500/30 hover:scale-105 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-petani-layout>
