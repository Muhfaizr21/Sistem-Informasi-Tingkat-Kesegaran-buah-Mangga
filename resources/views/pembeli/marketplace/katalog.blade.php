@extends('layouts.pembeli')

@section('title', 'Marketplace Mangga Premium')

@section('content')
<div class="relative animate-in fade-in duration-700">
    <!-- Premium Header & Search -->
    <div class="mb-12">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
            <div class="animate-in fade-in slide-in-from-left duration-700">
                <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
                    <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
                    Fresh Collection
                </div>
                <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3.2rem); line-height: 1.1; color: var(--leaf-dark);">
                    Eksplorasi <br>
                    <span style="color: var(--gold);">Mangga Terbaik</span>
                </h1>
            </div>
            
            <div class="w-full lg:w-auto animate-in fade-in slide-in-from-right duration-700">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1 sm:w-80 group">
                        <input type="text" id="quick-search" placeholder="Cari varietas favoritmu..." 
                               class="w-full pl-12 pr-4 py-4 bg-white border border-var(--gold)/20 rounded-2xl focus:ring-4 focus:ring-var(--gold)/10 focus:border-var(--gold) outline-none transition-all shadow-sm group-hover:shadow-md">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-var(--text-light) group-hover:text-var(--gold) transition-colors" style="color: var(--text-light);">
                            <span class="material-symbols-outlined">search</span>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('filter-modal').classList.remove('hidden')" 
                            class="inline-flex items-center justify-center px-6 py-4 rounded-2xl font-bold text-white transition-all shadow-lg active:scale-95"
                            style="background: var(--text-dark); box-shadow: 0 10px 20px rgba(0,0,0,0.15);">
                        <span class="material-symbols-outlined text-[20px] mr-2">tune</span>
                        Filter Cerdas
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters Display -->
    @if(request()->anyFilled(['varietas', 'kecamatan', 'min_harga', 'max_harga']))
    <div class="flex flex-wrap gap-2 mb-8 animate-in fade-in duration-500">
        <span class="text-[0.65rem] font-bold uppercase tracking-widest flex items-center mr-2" style="color: var(--text-light);">Filter Aktif:</span>
        @if(request('varietas'))
            <span class="px-3 py-1.5 bg-white border border-var(--gold)/30 rounded-full text-[0.65rem] font-bold flex items-center gap-2" style="color: var(--gold);">
                Varietas: {{ request('varietas') }}
                <a href="{{ request()->fullUrlWithQuery(['varietas' => null]) }}"><span class="material-symbols-outlined text-[14px]">close</span></a>
            </span>
        @endif
        <a href="{{ route('pembeli.marketplace.katalog') }}" class="text-[0.65rem] font-bold hover:text-var(--gold) underline ml-2" style="color: var(--text-light);">Bersihkan Semua</a>
    </div>
    @endif

    <!-- Main Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
        @forelse($listings as $listing)
        <div class="group bg-white rounded-3xl p-4 border border-var(--gold)/10 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col relative overflow-hidden">
            <!-- Image Area -->
            <div class="relative aspect-[16/10] sm:aspect-[4/5] rounded-2xl overflow-hidden mb-6">
                @php $foto = is_array($listing->foto_batch) ? ($listing->foto_batch[0] ?? null) : $listing->foto_batch; @endphp
                @if($foto)
                    <img src="{{ str_starts_with($foto, 'http') ? $foto : asset('storage/' . $foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 {{ $listing->stok_tersedia_kg <= 0 ? 'grayscale' : '' }}">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="background: var(--gold-pale);">
                        <span class="material-symbols-outlined text-4xl opacity-20">image</span>
                    </div>
                @endif

                <!-- Badge AI -->
                <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                    <div class="px-3 py-1.5 bg-white/90 backdrop-blur rounded-full shadow-sm border border-white flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full animate-pulse" style="background: var(--mango-green);"></div>
                        <span class="text-[10px] font-black uppercase tracking-tighter" style="color: var(--text-dark);">AI: {{ number_format($listing->skor_kesegaran ?? 0, 0) }}% FRESH</span>
                    </div>
                    @if($listing->stok_tersedia_kg <= 0)
                    <div class="px-3 py-1.5 bg-red-500 text-white rounded-full shadow-lg flex items-center gap-2">
                        <span class="text-[9px] font-black uppercase tracking-widest">STOK HABIS</span>
                    </div>
                    @endif
                </div>

                <!-- Rating Badge -->
                <div class="absolute top-4 right-4 px-3 py-1.5 bg-white/90 backdrop-blur rounded-full shadow-sm border border-white flex items-center gap-1.5 text-amber-500 font-black text-[11px] z-10">
                    <span class="material-symbols-outlined text-sm fill-1">star</span>
                    <span style="color: var(--text-dark);">{{ number_format($listing->average_rating ?? 0, 1) }}</span>
                </div>
            </div>

            <!-- Info Area -->
            <div class="px-2 flex-1 flex flex-col">
                <div class="mb-4">
                    <div class="flex justify-between items-start gap-2 mb-2">
                        <h3 style="font-family: 'Lora', serif; font-size: 1.15rem; font-weight: 600; color: var(--leaf-dark);" class="group-hover:text-var(--gold) transition-colors leading-tight">
                            {{ $listing->jenis_mangga ?? 'Mangga Premium' }}
                        </h3>
                        @if($listing->stok_tersedia_kg > 0)
                            <span class="text-[8px] font-black px-2 py-1 rounded-lg uppercase tracking-widest border" style="background: var(--gold-pale); border-color: rgba(212,160,23,0.2); color: var(--gold);">
                                {{ number_format($listing->stok_tersedia_kg, 0) }}KG
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]" style="color: var(--text-light);">location_on</span>
                        <span class="text-[0.7rem] font-medium" style="color: var(--text-light);">{{ $listing->lahan?->kecamatan?->nama ?? 'Indramayu' }}</span>
                    </div>
                </div>

                <div class="mt-auto flex items-end justify-between pt-4 border-t" style="border-color: var(--gold-pale);">
                    <div>
                        <p class="text-[0.6rem] font-bold uppercase tracking-widest mb-1" style="color: var(--text-light);">Harga /kg</p>
                        <p class="text-xl font-black" style="color: var(--text-dark);">Rp{{ number_format($listing->harga_per_kg, 0, ',', '.') }}</p>
                    </div>

                    @if($listing->stok_tersedia_kg > 0)
                    <form action="{{ route('pembeli.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                        <input type="hidden" name="jumlah_kg" value="{{ $listing->minimal_order_kg ?? 1 }}">
                        <button type="submit" class="w-12 h-12 text-white rounded-xl flex items-center justify-center hover:-translate-y-1 transition-all shadow-lg active:scale-95 group/btn"
                                style="background: var(--gold); box-shadow: 0 8px 15px rgba(212,160,23,0.3);">
                            <span class="material-symbols-outlined text-[24px]">add_shopping_cart</span>
                        </button>
                    </form>
                    @else
                    <button disabled class="w-12 h-12 bg-gray-100 text-gray-300 rounded-xl flex items-center justify-center cursor-not-allowed">
                        <span class="material-symbols-outlined">block</span>
                    </button>
                    @endif
                </div>

                <a href="{{ route('pembeli.marketplace.detail', $listing->id) }}" class="mt-4 block text-center py-2 text-[0.65rem] font-bold uppercase tracking-[0.2em] transition-colors hover:text-var(--gold)" style="color: var(--text-light);">
                    Lihat Detail Produk
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed" style="border-color: var(--gold-pale);">
            <div class="w-20 h-20 bg-var(--gold-pale) rounded-full flex items-center justify-center mx-auto mb-6" style="background: var(--gold-pale);">
                <span class="material-symbols-outlined text-4xl" style="color: var(--gold);">inventory_2</span>
            </div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--leaf-dark);" class="mb-2">Belum ada mangga tersedia</h3>
            <p class="text-sm max-w-sm mx-auto mb-8" style="color: var(--text-light);">Coba ubah kriteria filter Anda atau kembali lagi nanti untuk stok segar terbaru.</p>
            <a href="{{ route('pembeli.marketplace.katalog') }}" class="inline-block px-8 py-3 rounded-xl font-bold text-white transition-all shadow-lg" style="background: var(--text-dark);">Refresh Katalog</a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-16 flex justify-center">
        @if($listings->hasPages())
            <nav class="flex items-center gap-2 bg-white p-2 rounded-2xl border border-var(--gold)/10 shadow-sm" style="border-color: rgba(212,160,23,0.1);">
                @if ($listings->onFirstPage())
                    <span class="w-10 h-10 flex items-center justify-center opacity-20">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $listings->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center hover:bg-var(--gold-pale) rounded-xl transition-all" style="background: var(--gold-pale);">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </a>
                @endif

                @foreach ($listings->getUrlRange(1, $listings->lastPage()) as $page => $url)
                    @if ($page == $listings->currentPage())
                        <span class="w-10 h-10 flex items-center justify-center text-white font-black text-[10px] rounded-xl shadow-lg" style="background: var(--gold); box-shadow: 0 4px 10px rgba(212,160,23,0.3);">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center font-bold text-[10px] rounded-xl transition-all" style="color: var(--text-light);">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if ($listings->hasMorePages())
                    <a href="{{ $listings->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center hover:bg-var(--gold-pale) rounded-xl transition-all" style="background: var(--gold-pale);">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                @else
                    <span class="w-10 h-10 flex items-center justify-center opacity-20">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </span>
                @endif
            </nav>
        @endif
    </div>
</div>

<!-- Elite Filter Modal -->
<div id="filter-modal" class="hidden fixed inset-0 z-[200] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
        <div class="fixed inset-0 backdrop-blur-xl animate-in fade-in duration-300" style="background: rgba(30, 58, 26, 0.6);" onclick="document.getElementById('filter-modal').classList.add('hidden')"></div>
        
        <div class="relative bg-white rounded-[3rem] w-full max-w-lg p-10 shadow-2xl animate-in zoom-in-95 duration-300 border border-white/20">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);">Filter Cerdas</h2>
                    <p class="text-[0.7rem] uppercase tracking-widest font-bold" style="color: var(--gold);">Sesuaikan preferensi Anda</p>
                </div>
                <button onclick="document.getElementById('filter-modal').classList.add('hidden')" class="w-12 h-12 rounded-full flex items-center justify-center transition-colors" style="color: var(--text-light);">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <form action="{{ route('pembeli.marketplace.katalog') }}" method="GET" class="space-y-8">
                <div class="space-y-3">
                    <label class="text-[0.65rem] uppercase tracking-[0.15em] font-bold ml-1" style="color: var(--text-light);">Varietas & Nama</label>
                    <input type="text" name="varietas" value="{{ request('varietas') }}" placeholder="Contoh: Gedong Gincu..." 
                           class="w-full px-6 py-4 border border-transparent rounded-2xl focus:bg-white focus:border-var(--gold) outline-none transition-all font-medium" style="background: rgba(212,160,23,0.05);">
                </div>
                
                <div class="space-y-3">
                    <label class="text-[0.65rem] uppercase tracking-[0.15em] font-bold ml-1" style="color: var(--text-light);">Zona Kecamatan</label>
                    <div class="relative">
                        <select name="kecamatan" class="w-full px-6 py-4 border border-transparent rounded-2xl focus:bg-white focus:border-var(--gold) outline-none transition-all font-medium appearance-none" style="background: rgba(212,160,23,0.05);">
                            <option value="">Semua Wilayah Indramayu</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}" {{ request('kecamatan') == $kec->id ? 'selected' : '' }}>{{ $kec->nama }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none opacity-40">keyboard_arrow_down</span>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <label class="text-[0.65rem] uppercase tracking-[0.15em] font-bold ml-1" style="color: var(--text-light);">Rentang Harga (Rp)</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" name="min_harga" value="{{ request('min_harga') }}" placeholder="Min" 
                               class="w-full px-6 py-4 border border-transparent rounded-2xl focus:bg-white focus:border-var(--gold) outline-none transition-all font-medium" style="background: rgba(212,160,23,0.05);">
                        <input type="number" name="max_harga" value="{{ request('max_harga') }}" placeholder="Max" 
                               class="w-full px-6 py-4 border border-transparent rounded-2xl focus:bg-white focus:border-var(--gold) outline-none transition-all font-medium" style="background: rgba(212,160,23,0.05);">
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <a href="{{ route('pembeli.marketplace.katalog') }}" class="flex-1 py-5 text-center rounded-2xl font-bold text-[0.7rem] uppercase tracking-widest hover:opacity-80 transition-all" style="background: var(--gold-pale); color: var(--gold);">Reset</a>
                    <button type="submit" class="flex-[2] py-5 text-white rounded-2xl font-black text-[0.7rem] uppercase tracking-widest transition-all" style="background: var(--text-dark);">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
