<x-petani-layout>
    <x-slot name="title">Produk Saya</x-slot>

    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Katalog Produk 🏪</h1>
            <p class="text-slate-500 font-medium mt-1">Kelola mangga yang Anda pasarkan di Marketplace.</p>
        </div>
        <a href="{{ route('petani.cek-kesegaran') }}" class="flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-black rounded-2xl shadow-lg shadow-primary-500/20 hover:bg-primary-600 transition-all active:scale-95">
            <span class="material-symbols-outlined">add_a_photo</span>
            TAMBAH PRODUK VIA SCAN
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl font-bold text-sm flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($produk as $p)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="relative aspect-[4/3] overflow-hidden">
                    @php
                        $fotos = $p->foto_batch;
                        $fotoUtama = !empty($fotos) && is_array($fotos) ? asset('storage/' . $fotos[0]) : 'https://images.unsplash.com/photo-1553279768-865429fa0078?q=80&w=1000&auto=format&fit=crop';
                    @endphp
                    <img src="{{ $fotoUtama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 right-4 flex gap-2">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-slate-900 text-[10px] font-black rounded-full shadow-sm">
                            {{ $p->jenis_mangga }}
                        </span>
                        @if($p->aktif)
                            <span class="px-3 py-1 bg-emerald-500 text-white text-[10px] font-black rounded-full shadow-lg shadow-emerald-500/20">AKTIF</span>
                        @else
                            <span class="px-3 py-1 bg-slate-500 text-white text-[10px] font-black rounded-full shadow-lg shadow-slate-500/20">NONAKTIF</span>
                        @endif
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                        <p class="text-white font-black text-xl tracking-tight">Rp {{ number_format($p->harga_per_kg, 0, ',', '.') }}<span class="text-xs font-medium text-white/60"> / kg</span></p>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Skor Kesegaran AI</p>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-black text-slate-900">{{ number_format($p->skor_kesegaran, 0) }}%</span>
                                <div class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Stok Tersedia</p>
                            <p class="text-lg font-black text-slate-900">{{ number_format($p->stok_tersedia_kg, 0) }} kg</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mb-6 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="material-symbols-outlined text-sm text-slate-400">location_on</span>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tight truncate">{{ $p->lahan->nama_lahan ?? 'Lahan Utama' }}</span>
                    </div>

                    <div class="flex gap-3">
                        <form action="{{ route('petani.produk.toggle', $p->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-3 {{ $p->aktif ? 'bg-slate-100 text-slate-600' : 'bg-emerald-50 text-emerald-600' }} font-bold rounded-xl text-[10px] uppercase tracking-widest hover:opacity-80 transition-all">
                                {{ $p->aktif ? 'Sembunyikan' : 'Tampilkan' }}
                            </button>
                        </form>
                        <form action="{{ route('petani.produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari marketplace?')" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-12 h-12 flex items-center justify-center bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-all group">
                                <span class="material-symbols-outlined text-sm group-hover:scale-110">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center">
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-5xl text-slate-300">inventory_2</span>
                </div>
                <h3 class="text-xl font-extrabold text-slate-900 mb-2">Belum ada produk</h3>
                <p class="text-slate-500 font-medium mb-8">Scan mangga Anda untuk mulai berjualan di marketplace.</p>
                <a href="{{ route('petani.cek-kesegaran') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary-500 text-white font-black rounded-2xl shadow-xl shadow-primary-500/20 hover:bg-primary-600 transition-all active:scale-95">
                    MULAI SCAN SEKARANG
                </a>
            </div>
        @endforelse
    </div>
</x-petani-layout>
