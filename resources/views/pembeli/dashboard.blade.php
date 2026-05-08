@extends('layouts.pembeli')

@section('title', 'Dashboard Pembeli')

@section('content')
<div class="relative animate-in fade-in duration-700">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <div>
            <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
                <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
                Buyer Dashboard
            </div>
            <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3.2rem); line-height: 1.1; color: var(--leaf-dark);">
                Selamat Datang, <br>
                <span style="color: var(--gold);">{{ explode(' ', $user->nama)[0] }}</span>
            </h1>
        </div>
        <div class="flex flex-col items-end gap-2">
            <div class="px-4 py-2 rounded-full border flex items-center gap-2 shadow-sm bg-white" style="border-color: var(--gold);">
                <div class="w-2 h-2 rounded-full animate-pulse" style="background: var(--mango-green);"></div>
                <span class="text-[0.65rem] font-bold uppercase tracking-widest" style="color: var(--text-mid);">AI Core Connected</span>
            </div>
            <p class="text-[0.8rem]" style="color: var(--text-light);">{{ now()->format('l, d F Y') }}</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
        <div class="bg-white p-6 rounded-3xl border border-var(--gold)/20 shadow-sm hover:shadow-md transition-shadow group">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110" style="background: var(--gold-pale);">
                <span class="material-symbols-outlined" style="color: var(--gold);">center_focus_strong</span>
            </div>
            <p class="text-[0.65rem] font-bold uppercase tracking-widest mb-1" style="color: var(--text-light);">Total Analisis</p>
            <p class="text-2xl font-black" style="color: var(--leaf-dark);">{{ number_format($stats['total_scan'] ?? 0) }} <span class="text-sm font-medium">Scan</span></p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-var(--gold)/20 shadow-sm hover:shadow-md transition-shadow group">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110" style="background: var(--gold-pale);">
                <span class="material-symbols-outlined" style="color: var(--gold);">shopping_cart</span>
            </div>
            <p class="text-[0.65rem] font-bold uppercase tracking-widest mb-1" style="color: var(--text-light);">Pesanan Aktif</p>
            <p class="text-2xl font-black" style="color: var(--leaf-dark);">{{ number_format($stats['total_pesanan'] ?? 0) }} <span class="text-sm font-medium">Order</span></p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-var(--gold)/20 shadow-sm hover:shadow-md transition-shadow group">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110" style="background: var(--gold-pale);">
                <span class="material-symbols-outlined fill-1" style="color: var(--gold);">favorite</span>
            </div>
            <p class="text-[0.65rem] font-bold uppercase tracking-widest mb-1" style="color: var(--text-light);">Petani Favorit</p>
            <p class="text-2xl font-black" style="color: var(--leaf-dark);">{{ count($favorite_petani ?? []) }} <span class="text-sm font-medium">Mitra</span></p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-var(--gold)/20 shadow-sm hover:shadow-md transition-shadow group">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4 transition-transform group-hover:scale-110" style="background: var(--gold-pale);">
                <span class="material-symbols-outlined" style="color: var(--gold);">verified_user</span>
            </div>
            <p class="text-[0.65rem] font-bold uppercase tracking-widest mb-1" style="color: var(--text-light);">Status Akun</p>
            <p class="text-2xl font-black uppercase tracking-tight" style="color: var(--leaf-dark);">Elite <span class="text-sm font-medium">Buyer</span></p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Left Column: AI Scanner & Market -->
        <div class="lg:col-span-8 space-y-12">
            <!-- Premium AI Banner -->
            <div class="relative rounded-[2.5rem] p-10 overflow-hidden shadow-2xl group" style="background: var(--leaf-dark);">
                <!-- Animated circles overlay -->
                <div class="absolute top-0 right-0 w-64 h-64 border-2 rounded-full opacity-10 -mr-20 -mt-20 border-var(--gold)"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 border-8 rounded-full opacity-5 -ml-10 -mb-10 border-var(--gold)"></div>
                
                <div class="relative z-10 max-w-lg">
                    <h2 style="font-family: 'Playfair Display', serif; font-size: 2.2rem; color: white; line-height: 1.2; margin-bottom: 1.5rem;">
                        Identifikasi Kesegaran <br>
                        <span style="color: var(--gold);">Detik Ini Juga.</span>
                    </h2>
                    <p class="text-sm leading-relaxed mb-8" style="color: rgba(255,255,255,0.6);">
                        Algoritma Computer Vision kami dilatih dengan ribuan dataset mangga Indramayu untuk memberikan akurasi grading hingga 97%.
                    </p>
                    <a href="{{ route('pembeli.scan') }}" class="inline-flex items-center gap-3 px-8 py-4 rounded-xl font-bold text-[0.75rem] uppercase tracking-widest transition-all hover:-translate-y-1 shadow-lg" 
                       style="background: var(--gold); color: white; box-shadow: 0 10px 20px rgba(212,160,23,0.3);">
                        Mulai Analisis AI
                        <span class="material-symbols-outlined text-sm">arrow_forward_ios</span>
                    </a>
                </div>

                <div class="absolute right-10 bottom-0 opacity-10 hidden lg:block translate-y-10 group-hover:translate-y-0 transition-transform duration-700">
                    <span class="material-symbols-outlined" style="font-size: 200px; color: var(--gold);">center_focus_strong</span>
                </div>
            </div>

            <!-- Recommendations -->
            <div class="space-y-6">
                <div class="flex items-end justify-between border-b pb-4" style="border-color: var(--gold);">
                    <div>
                        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--leaf-dark);">Panen Terpilih</h3>
                        <p class="text-xs mt-1" style="color: var(--text-light);">Mangga kualitas grade A langsung dari petani</p>
                    </div>
                    <a href="{{ route('pembeli.marketplace.katalog') }}" class="text-[0.65rem] font-bold uppercase tracking-[0.15em] transition-colors hover:text-var(--mango-green)" style="color: var(--gold);">Jelajahi Semua</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($recent_listings ?? [] as $listing)
                        <div class="bg-white rounded-3xl p-4 border border-var(--gold)/10 shadow-sm hover:shadow-md transition-all group overflow-hidden">
                            <div class="relative aspect-[16/10] rounded-2xl overflow-hidden mb-5">
                                @php $foto = is_array($listing?->foto_batch) ? ($listing?->foto_batch[0] ?? null) : $listing?->foto_batch; @endphp
                                @if($foto)
                                    <img src="{{ str_starts_with($foto, 'http') ? $foto : asset('storage/' . $foto) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-var(--gold-pale) flex items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl opacity-20">image</span>
                                    </div>
                                @endif
                                
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    <div class="px-3 py-1 bg-white/90 backdrop-blur rounded-full text-[9px] font-black tracking-tighter uppercase shadow-sm border border-white" style="color: var(--mango-green);">
                                        {{ number_format($listing?->skor_kesegaran ?? 0, 0) }}% FRESH
                                    </div>
                                </div>
                            </div>

                            <div class="px-2">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark);">{{ $listing?->jenis_mangga }}</h4>
                                    <span class="font-bold text-sm" style="color: var(--gold);">Rp{{ number_format($listing?->harga_per_kg ?? 0, 0, ',', '.') }}/kg</span>
                                </div>
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="material-symbols-outlined text-[14px]" style="color: var(--text-light);">location_on</span>
                                    <span class="text-[0.7rem] font-medium" style="color: var(--text-light);">{{ $listing?->lahan?->kecamatan?->nama ?? 'Indramayu' }}</span>
                                </div>

                                <a href="{{ route('pembeli.marketplace.detail', $listing?->id) }}" class="w-full py-3.5 rounded-xl text-[0.65rem] font-bold uppercase tracking-widest transition-all flex items-center justify-center gap-2 group/btn" 
                                   style="background: var(--text-dark); color: white;">
                                    Beli Sekarang
                                    <span class="material-symbols-outlined text-sm group-hover/btn:translate-x-1 transition-transform">shopping_cart</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center rounded-[2rem] border-2 border-dashed" style="border-color: var(--gold); background: rgba(212,160,23,0.03);">
                            <span class="material-symbols-outlined text-5xl mb-4 opacity-20">inventory_2</span>
                            <p class="text-sm font-medium" style="color: var(--text-light);">Belum ada penawaran mangga premium saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar Actions -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Navigation Card -->
            <div class="bg-white rounded-[2rem] p-8 border border-var(--gold)/20 shadow-sm">
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--leaf-dark); margin-bottom: 1.5rem;">Pintasan Cepat</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('pembeli.pesanan.index') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:bg-var(--gold-pale) group no-underline">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors group-hover:bg-white" style="background: var(--gold-pale);">
                            <span class="material-symbols-outlined text-[20px]" style="color: var(--gold);">shopping_bag</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest" style="color: var(--text-dark);">Pesanan Saya</p>
                            <p class="text-[0.65rem]" style="color: var(--text-light);">Cek status pengiriman</p>
                        </div>
                    </a>

                    <a href="{{ route('pembeli.alamat.index') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:bg-var(--gold-pale) group no-underline">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors group-hover:bg-white" style="background: var(--gold-pale);">
                            <span class="material-symbols-outlined text-[20px]" style="color: var(--gold);">location_on</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest" style="color: var(--text-dark);">Buku Alamat</p>
                            <p class="text-[0.65rem]" style="color: var(--text-light);">Kelola lokasi pengiriman</p>
                        </div>
                    </a>

                    <a href="{{ route('pembeli.favorit.index') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:bg-var(--gold-pale) group no-underline">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors group-hover:bg-white" style="background: var(--gold-pale);">
                            <span class="material-symbols-outlined text-[20px] fill-1" style="color: var(--gold);">favorite</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest" style="color: var(--text-dark);">Mitra Petani</p>
                            <p class="text-[0.65rem]" style="color: var(--text-light);">Lihat petani langganan</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Favorite Petani Sidebar -->
            <div class="bg-white rounded-[2rem] p-8 border border-var(--gold)/20 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-6 opacity-5 pointer-events-none">
                    <span class="material-symbols-outlined text-7xl" style="color: var(--gold);">favorite</span>
                </div>
                
                <div class="flex items-center justify-between mb-6 border-b pb-4" style="border-color: var(--gold-pale);">
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--leaf-dark);">Petani Favorit</h3>
                    <a href="{{ route('pembeli.favorit.index') }}" class="text-[0.6rem] font-bold uppercase tracking-widest" style="color: var(--gold);">Semua</a>
                </div>

                <div class="space-y-5">
                    @forelse($favorite_petani ?? [] as $fav)
                        <a href="{{ route('pembeli.marketplace.petani', $fav?->petani?->id) }}" class="flex items-center gap-4 group/fav no-underline">
                            <div class="w-12 h-12 rounded-xl overflow-hidden border border-var(--gold-pale) shadow-sm group-hover/fav:scale-110 transition-transform">
                                @if($fav?->petani?->user?->foto_profil)
                                    <img src="{{ asset('storage/' . $fav?->petani?->user?->foto_profil) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-var(--gold-pale) text-var(--gold) font-bold">
                                        {{ substr($fav?->petani?->user?->nama ?? '', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold group-hover/fav:text-var(--gold) transition-colors" style="color: var(--text-dark);">{{ $fav?->petani?->user?->nama ?? 'Petani' }}</p>
                                <p class="text-[0.65rem] uppercase tracking-wider" style="color: var(--text-light);">{{ $fav?->petani?->listings?->count() ?? 0 }} Produk</p>
                            </div>
                            <span class="material-symbols-outlined text-sm opacity-20 group-hover/fav:opacity-100 group-hover/fav:translate-x-1 transition-all">arrow_forward_ios</span>
                        </a>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-[0.7rem] italic" style="color: var(--text-light);">Belum ada petani favorit.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
