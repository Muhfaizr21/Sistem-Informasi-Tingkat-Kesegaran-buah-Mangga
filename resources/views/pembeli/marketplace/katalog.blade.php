@extends('layouts.pembeli')

@section('title', 'Marketplace Mangga Premium')

@section('content')
<div class="relative min-h-screen pb-20">
    <!-- Premium Header & Search -->
    <div class="mb-12">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
            <div class="animate-in fade-in slide-in-from-left duration-700">
                <h1 class="text-4xl md:text-5xl font-black text-[#1b1b18] tracking-tight mb-3">
                    Eksplorasi <span class="text-[#F53003]">Mangga Terbaik</span>
                </h1>
                <p class="text-lg text-[#706f6c] max-w-xl leading-relaxed">
                    Katalog eksklusif hasil kurasi langsung dari petani Indramayu, diverifikasi dengan diagnosa AI tingkat tinggi.
                </p>
            </div>
            
            <div class="w-full lg:w-auto animate-in fade-in slide-in-from-right duration-700">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1 sm:w-80 group">
                        <input type="text" id="quick-search" placeholder="Cari varietas favoritmu..." 
                               class="w-full pl-12 pr-4 py-4 bg-white border border-[#19140015] rounded-2xl focus:ring-4 focus:ring-[#F53003]/10 focus:border-[#F53003] outline-none transition-all shadow-sm group-hover:shadow-md">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-[#F53003] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('filter-modal').classList.remove('hidden')" 
                            class="inline-flex items-center justify-center px-6 py-4 bg-[#1b1b18] text-white rounded-2xl font-bold hover:bg-black transition-all shadow-xl shadow-black/10 active:scale-95">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Filter Cerdas
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters Display -->
    @if(request()->anyFilled(['varietas', 'kecamatan', 'min_harga', 'max_harga']))
    <div class="flex flex-wrap gap-2 mb-8 animate-in fade-in duration-500">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center mr-2">Filter Aktif:</span>
        @if(request('varietas'))
            <span class="px-3 py-1.5 bg-orange-50 text-[#F53003] border border-orange-100 rounded-full text-xs font-bold flex items-center gap-2">
                Varietas: {{ request('varietas') }}
                <a href="{{ request()->fullUrlWithQuery(['varietas' => null]) }}"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"></path></svg></a>
            </span>
        @endif
        <a href="{{ route('pembeli.marketplace.katalog') }}" class="text-xs font-bold text-gray-400 hover:text-[#F53003] underline">Bersihkan Semua</a>
    </div>
    @endif

    <!-- Main Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
        @forelse($listings as $listing)
        <div class="group bg-white rounded-[2.5rem] border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_50px_-15px_rgba(0,0,0,0.1)] transition-all duration-500 flex flex-col relative overflow-hidden">
            <!-- Image Area -->
            <div class="aspect-[4/5] bg-gray-50 relative overflow-hidden">
                @php $foto = is_array($listing->foto_batch) ? ($listing->foto_batch[0] ?? null) : $listing->foto_batch; @endphp
                @if($foto)
                    <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif

                <!-- Badge AI -->
                <div class="absolute top-5 left-5 z-10">
                    <div class="px-3 py-1.5 bg-white/90 backdrop-blur rounded-full shadow-sm border border-white flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[10px] font-black text-[#1b1b18] uppercase tracking-tighter">AI: {{ number_format($listing->skor_kesegaran ?? 0, 0) }}% FRESH</span>
                    </div>
                </div>

                <!-- Favorite Toggle (Mock) -->
                <button class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/20 backdrop-blur border border-white/30 flex items-center justify-center text-white hover:bg-white hover:text-red-500 transition-all z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </button>

                <!-- Overlay Actions -->
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                    <a href="{{ route('pembeli.marketplace.detail', $listing->id) }}" class="p-4 bg-white text-black rounded-2xl font-bold hover:scale-110 transition-transform flex items-center gap-2">
                        Detail
                    </a>
                </div>
            </div>

            <!-- Info Area -->
            <div class="p-8 flex-1 flex flex-col">
                <div class="mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-[#1b1b18] leading-tight group-hover:text-[#F53003] transition-colors">{{ $listing->jenis_mangga ?? 'Mangga Premium' }}</h3>
                        <span class="text-[9px] font-black px-2 py-1 bg-gray-100 rounded-lg text-gray-500 uppercase tracking-widest border border-gray-100">STOK: {{ number_format($listing->stok_tersedia_kg, 0) }}KG</span>
                    </div>
                    <p class="text-xs text-[#706f6c] flex items-center font-medium">
                        <svg class="w-3 h-3 mr-1.5 text-[#F53003]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        {{ $listing->lahan?->kecamatan?->nama ?? 'Indramayu' }}
                    </p>
                </div>

                <div class="mt-auto flex items-end justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Harga /kg</p>
                        <p class="text-2xl font-black text-[#1b1b18]">Rp{{ number_format($listing->harga_per_kg, 0, ',', '.') }}</p>
                    </div>

                    <form action="{{ route('pembeli.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                        <input type="hidden" name="jumlah_kg" value="{{ $listing->minimal_order_kg ?? 1 }}">
                        <button type="submit" class="w-14 h-14 bg-[#F53003] text-white rounded-2xl flex items-center justify-center hover:bg-black transition-all hover:rotate-6 shadow-lg shadow-orange-900/20 active:scale-90">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center bg-gray-50 rounded-[3rem] border border-dashed border-gray-200">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl shadow-gray-200/50">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 4v16"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-[#1b1b18] mb-2">Belum ada mangga tersedia</h3>
            <p class="text-[#706f6c] max-w-sm mx-auto">Coba ubah kriteria filter Anda atau kembali lagi nanti untuk stok segar terbaru.</p>
            <a href="{{ route('pembeli.marketplace.katalog') }}" class="mt-8 inline-block px-8 py-3 bg-[#1b1b18] text-white rounded-2xl font-bold hover:bg-black transition-all shadow-lg">Refresh Katalog</a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($listings->hasPages())
    <div class="mt-16 flex justify-center">
        <div class="glass-panel p-2 rounded-2xl inline-flex items-center gap-2">
            {{ $listings->links('vendor.pagination.simple-tailwind') }}
        </div>
    </div>
    @endif
</div>

<!-- Elite Filter Modal -->
<div id="filter-modal" class="hidden fixed inset-0 z-[200] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-xl animate-in fade-in duration-300" onclick="document.getElementById('filter-modal').classList.add('hidden')"></div>
        
        <div class="relative bg-white rounded-[3rem] w-full max-w-lg p-10 shadow-2xl animate-in zoom-in-95 duration-300 border border-white/20">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-3xl font-black tracking-tight">Filter Cerdas</h2>
                    <p class="text-sm text-gray-400 mt-1">Sesuaikan preferensi mangga Anda</p>
                </div>
                <button onclick="document.getElementById('filter-modal').classList.add('hidden')" class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('pembeli.marketplace.katalog') }}" method="GET" class="space-y-8">
                <div class="space-y-4">
                    <label class="text-[10px] uppercase tracking-widest text-gray-400 font-bold ml-1">Varietas & Nama</label>
                    <input type="text" name="varietas" value="{{ request('varietas') }}" placeholder="Contoh: Gedong Gincu..." 
                           class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-[#F53003] focus:ring-4 focus:ring-[#F53003]/10 outline-none transition-all font-medium">
                </div>
                
                <div class="space-y-4">
                    <label class="text-[10px] uppercase tracking-widest text-gray-400 font-bold ml-1">Zona Kecamatan</label>
                    <select name="kecamatan" class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-[#F53003] focus:ring-4 focus:ring-[#F53003]/10 outline-none transition-all font-medium appearance-none">
                        <option value="">Semua Wilayah Indramayu</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}" {{ request('kecamatan') == $kec->id ? 'selected' : '' }}>{{ $kec->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="space-y-4">
                    <label class="text-[10px] uppercase tracking-widest text-gray-400 font-bold ml-1">Rentang Harga (Rp)</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" name="min_harga" value="{{ request('min_harga') }}" placeholder="Min" 
                               class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-[#F53003] outline-none transition-all font-medium">
                        <input type="number" name="max_harga" value="{{ request('max_harga') }}" placeholder="Max" 
                               class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-[#F53003] outline-none transition-all font-medium">
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <a href="{{ route('pembeli.marketplace.katalog') }}" class="flex-1 py-5 bg-gray-50 text-gray-400 text-center rounded-[1.5rem] font-bold text-xs tracking-widest uppercase hover:bg-gray-100 transition-all">Reset</a>
                    <button type="submit" class="flex-[2] py-5 bg-[#F53003] text-white rounded-[1.5rem] font-black text-xs tracking-widest uppercase shadow-xl shadow-orange-900/20 hover:bg-[#FF4433] transition-all">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
