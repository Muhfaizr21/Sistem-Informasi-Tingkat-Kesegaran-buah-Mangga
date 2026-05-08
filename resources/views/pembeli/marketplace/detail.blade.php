@extends('layouts.pembeli')

@section('title', $listing->jenis_mangga ?? 'Detail Produk')

@section('content')
<div class="relative animate-in fade-in duration-700">
    <!-- Breadcrumb -->
    <nav class="flex mb-10" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[0.65rem] font-bold uppercase tracking-[0.2em]">
            <li class="inline-flex items-center">
                <a href="{{ route('pembeli.dashboard') }}" class="no-underline transition-colors hover:text-var(--gold)" style="color: var(--text-light);">DASHBOARD</a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-[14px] mx-2" style="color: var(--text-light);">chevron_right</span>
                    <a href="{{ route('pembeli.marketplace.katalog') }}" class="no-underline transition-colors hover:text-var(--gold)" style="color: var(--text-light);">KATALOG</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center" style="color: var(--gold);">
                    <span class="material-symbols-outlined text-[14px] mx-2">chevron_right</span>
                    <span>{{ $listing->jenis_mangga ?? 'DETAIL' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
        <!-- Gallery Column -->
        <div class="lg:col-span-5 space-y-6">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-var(--gold) to-var(--mango-orange) rounded-[3rem] blur opacity-20 group-hover:opacity-40 transition-opacity"></div>
                <div class="relative aspect-square rounded-[3.5rem] overflow-hidden border-4 bg-white shadow-2xl" style="border-color: var(--gold-pale);">
                    @php $foto = is_array($listing->foto_batch) ? ($listing->foto_batch[0] ?? null) : $listing->foto_batch; @endphp
                    @if($foto)
                        <img src="{{ str_starts_with($foto, 'http') ? $foto : asset('storage/' . $foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 {{ $listing->stok_tersedia_kg <= 0 ? 'grayscale' : '' }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-var(--gold-pale)">
                            <span class="material-symbols-outlined text-6xl opacity-20">image</span>
                        </div>
                    @endif
                    
                    <div class="absolute bottom-8 left-8">
                        <div class="px-4 py-2 bg-white/90 backdrop-blur rounded-2xl shadow-xl border border-white flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full animate-pulse" style="background: var(--mango-green);"></div>
                            <span class="text-[0.65rem] font-black text-var(--text-dark) uppercase tracking-widest">AI Verified Freshness</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-4 gap-4">
                @php $additionalImages = is_array($listing->foto_batch) ? array_slice($listing->foto_batch, 1) : []; @endphp
                @foreach($additionalImages as $foto)
                    <div class="aspect-square bg-white rounded-2xl overflow-hidden border-2 hover:border-var(--gold) transition-all cursor-pointer group shadow-sm" style="border-color: var(--gold-pale);">
                        <img src="{{ str_starts_with($foto, 'http') ? $foto : asset('storage/' . $foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Info Column -->
        <div class="lg:col-span-7 space-y-10">
            <div class="space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    @if($listing->stok_tersedia_kg > 0)
                        <div class="px-5 py-2 bg-emerald-500 text-white rounded-full text-[0.65rem] font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-500/20">Tersedia</div>
                    @else
                        <div class="px-5 py-2 bg-red-500 text-white rounded-full text-[0.65rem] font-black uppercase tracking-[0.2em] shadow-lg shadow-red-500/20">Habis</div>
                    @endif
                    <div class="px-3 py-1.5 rounded-full text-[0.6rem] font-black uppercase tracking-widest border" style="background: rgba(16, 185, 129, 0.05); color: #10B981; border-color: rgba(16, 185, 129, 0.1);">AI Score: {{ number_format($listing->skor_kesegaran ?? 0, 0) }}%</div>
                    <div class="px-3 py-1.5 rounded-full text-[0.6rem] font-black uppercase tracking-widest border" style="background: var(--gold-pale); color: var(--gold); border-color: rgba(212,160,23,0.1);">Premium Batch</div>
                </div>
                
                <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); line-height: 1.1; color: var(--leaf-dark);">
                    {{ $listing->jenis_mangga ?? 'Mangga Premium' }}
                </h1>
                
                <div class="flex items-baseline gap-4">
                    <p class="text-4xl font-black" style="color: var(--gold);">Rp{{ number_format($listing->harga_per_kg, 0, ',', '.') }}</p>
                    <span class="text-sm font-bold uppercase tracking-widest" style="color: var(--text-light);">/ kg</span>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="p-6 rounded-[2rem] border flex flex-col items-center text-center transition-colors hover:bg-var(--gold-pale)/30" style="background: var(--cream); border-color: var(--gold-pale);">
                    <span class="text-[0.65rem] font-black uppercase tracking-widest mb-2" style="color: var(--text-light);">Stok Tersedia</span>
                    <span class="text-xl font-black" style="color: var(--text-dark);">{{ number_format($listing->stok_tersedia_kg, 0) }}kg</span>
                </div>
                <div class="p-6 rounded-[2rem] border flex flex-col items-center text-center transition-colors hover:bg-var(--gold-pale)/30" style="background: var(--cream); border-color: var(--gold-pale);">
                    <span class="text-[0.65rem] font-black uppercase tracking-widest mb-2" style="color: var(--text-light);">Min. Order</span>
                    <span class="text-xl font-black" style="color: var(--text-dark);">{{ number_format($listing->minimal_order_kg, 0) }}kg</span>
                </div>
                <div class="p-6 rounded-[2rem] border flex flex-col items-center text-center transition-colors hover:bg-var(--gold-pale)/30" style="background: var(--cream); border-color: var(--gold-pale);">
                    <span class="text-[0.65rem] font-black uppercase tracking-widest mb-2" style="color: var(--text-light);">Kecamatan</span>
                    <span class="text-xl font-black truncate w-full px-2" style="color: var(--text-dark);">{{ $listing->lahan?->kecamatan?->nama ?? 'Indramayu' }}</span>
                </div>
                <div class="p-6 rounded-[2rem] border flex flex-col items-center text-center transition-colors hover:bg-var(--gold-pale)/30" style="background: var(--cream); border-color: var(--gold-pale);">
                    <span class="text-[0.65rem] font-black uppercase tracking-widest mb-2" style="color: var(--gold);">Akurasi AI</span>
                    <span class="text-xl font-black" style="color: var(--gold);">99.8%</span>
                </div>
            </div>

            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em]" style="color: var(--mango-green);">
                    <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
                    Product Description
                </div>
                <p class="text-lg leading-relaxed font-medium" style="color: var(--text-mid);">
                    {{ $listing->deskripsi ?? 'Nikmati sensasi rasa mangga premium terbaik langsung dari tanah Indramayu. Setiap buah telah melalui proses seleksi ketat dan diagnosa AI untuk menjamin tingkat kemanisan, tekstur, dan kesegaran maksimal.' }}
                </p>
            </div>

            <!-- Action Area -->
            <div class="pt-10 border-t" style="border-color: var(--gold-pale);">
                <form action="{{ route('pembeli.cart.add') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-stretch">
                    @csrf
                    <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                    <div class="flex items-center bg-white rounded-2xl border px-6 py-2" style="border-color: var(--gold-pale);">
                        <button type="button" onclick="const input = this.nextElementSibling.querySelector('input'); if(parseInt(input.value) > parseInt(input.min)) input.stepDown()" class="w-10 h-10 flex items-center justify-center text-var(--text-light) hover:text-var(--gold) transition-colors" {{ $listing->stok_tersedia_kg <= 0 ? 'disabled' : '' }}>
                            <span class="material-symbols-outlined">remove</span>
                        </button>
                        <div class="flex flex-col items-center px-4">
                            <span class="text-[0.6rem] font-black text-var(--text-light) uppercase tracking-widest">Qty (KG)</span>
                            <input type="number" name="jumlah_kg" value="{{ $listing->minimal_order_kg ?? 1 }}" min="{{ $listing->minimal_order_kg ?? 1 }}" max="{{ $listing->stok_tersedia_kg }}" 
                                   class="w-20 bg-transparent border-none focus:ring-0 text-center text-2xl font-black p-0" style="color: var(--text-dark);" {{ $listing->stok_tersedia_kg <= 0 ? 'disabled' : '' }}>
                        </div>
                        <button type="button" onclick="const input = this.previousElementSibling.querySelector('input'); if(parseInt(input.value) < parseInt(input.max)) input.stepUp()" class="w-10 h-10 flex items-center justify-center text-var(--text-light) hover:text-var(--gold) transition-colors" {{ $listing->stok_tersedia_kg <= 0 ? 'disabled' : '' }}>
                            <span class="material-symbols-outlined">add</span>
                        </button>
                    </div>
                    
                    @if($listing->stok_tersedia_kg > 0)
                        <button type="submit" class="flex-1 py-5 rounded-2xl font-black text-[0.75rem] tracking-[0.2em] uppercase transition-all shadow-xl active:scale-[0.98] flex items-center justify-center gap-3"
                                style="background: var(--text-dark); color: white; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            Tambah ke Keranjang
                        </button>
                    @else
                        <button type="button" disabled class="flex-1 py-5 bg-gray-100 text-gray-400 rounded-2xl font-black text-[0.75rem] tracking-[0.2em] uppercase cursor-not-allowed flex items-center justify-center gap-3">
                            <span class="material-symbols-outlined">block</span>
                            Stok Habis
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-32 space-y-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
            <div>
                <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
                    <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
                    Customer Reviews
                </div>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--leaf-dark);">Apa Kata <span style="color: var(--gold);">Pembeli</span></h2>
            </div>
            
            <div class="flex items-center gap-6">
                @if($listing->review_count > 0)
                <a href="{{ route('pembeli.marketplace.reviews', $listing->id) }}" class="text-[0.65rem] font-bold uppercase tracking-widest transition-colors hover:text-var(--gold)" style="color: var(--text-light);">Lihat Semua Ulasan ({{ $listing->review_count }})</a>
                @endif
                <div class="flex items-center gap-4">
                    <span class="text-5xl font-black" style="color: var(--text-dark);">{{ number_format($listing->average_rating ?? 0, 1) }}</span>
                    <div class="flex flex-col">
                        <div class="flex text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined text-[18px] {{ $i <= round($listing->average_rating ?? 0) ? 'fill-1' : '' }}">star</span>
                            @endfor
                        </div>
                        <span class="text-[0.65rem] font-black uppercase tracking-widest mt-1" style="color: var(--text-light);">{{ $listing->review_count ?? 0 }} Total Ulasan</span>
                    </div>
                </div>
            </div>
        </div>

        @if($reviews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-[3rem] p-10 border border-var(--gold-pale) shadow-sm hover:shadow-xl transition-all duration-500 group">
                        <div class="flex items-start justify-between mb-8">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-xl overflow-hidden border shadow-inner" style="background: var(--gold-pale); border-color: var(--gold-pale); color: var(--gold);">
                                    @if($review->pembeli->user->foto_profil)
                                        <img src="{{ asset('storage/' . $review->pembeli->user->foto_profil) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($review->pembeli->user->nama, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-black text-[1.1rem]" style="color: var(--text-dark);">
                                        {{ $review->pembeli->user->nama }}
                                        @if(auth()->check() && $review->pembeli_id == auth()->user()->pembeli?->id)
                                            <span class="text-[10px] text-var(--gold) ml-1">(SAYA)</span>
                                        @endif
                                    </h4>
                                    <p class="text-[0.6rem] font-black uppercase tracking-widest" style="color: var(--text-light);">{{ $review->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex text-amber-400 gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="material-symbols-outlined text-[14px] {{ $i <= $review->rating ? 'fill-1' : '' }}">star</span>
                                @endfor
                            </div>
                        </div>
                        
                        <p class="font-medium leading-relaxed mb-8 italic text-lg" style="color: var(--text-mid);">"{{ $review->komentar }}"</p>

                        @if($review->foto_review && count($review->foto_review) > 0)
                            <div class="flex gap-4 overflow-x-auto pb-4 custom-scrollbar">
                                @foreach($review->foto_review as $foto)
                                    <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-white shrink-0 shadow-lg hover:scale-105 transition-transform">
                                        <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover cursor-zoom-in">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(auth()->check() && $review->pembeli_id == auth()->user()->pembeli?->id)
                            <div class="mt-6 pt-6 border-t border-var(--gold-pale) flex justify-end gap-3">
                                <form action="{{ route('pembeli.review.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-red-50 text-red-500 rounded-2xl font-black text-[10px] tracking-widest uppercase hover:bg-red-100 transition-all border border-red-100">
                                        <span class="material-symbols-outlined text-sm">delete</span> HAPUS
                                    </button>
                                </form>
                                <a href="{{ route('pembeli.marketplace.reviews', $listing->id) }}" class="flex items-center gap-2 px-6 py-3 bg-var(--gold-pale) text-var(--gold) rounded-2xl font-black text-[10px] tracking-widest uppercase hover:bg-var(--gold-pale)/80 transition-all border border-var(--gold-pale)">
                                    <span class="material-symbols-outlined text-sm">edit</span> EDIT DI HALAMAN ULASAN
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-24 bg-white rounded-[4rem] border-2 border-dashed" style="border-color: var(--gold-pale);">
                <div class="w-20 h-20 bg-var(--gold-pale) rounded-full flex items-center justify-center mx-auto mb-8">
                    <span class="material-symbols-outlined text-4xl opacity-20" style="color: var(--gold);">rate_review</span>
                </div>
                <h4 class="text-xl font-black uppercase tracking-[0.2em]" style="color: var(--text-light);">Belum ada ulasan</h4>
                <p class="text-[0.65rem] font-black uppercase tracking-widest opacity-60" style="color: var(--text-light);">Jadilah yang pertama memberikan ulasan!</p>
            </div>
        @endif
    </div>

    <!-- Farmer Card -->
    <div class="mt-32 space-y-10">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.2rem; color: var(--leaf-dark);" class="text-center">Tentang <span style="color: var(--gold);">Petani</span></h2>
        
        <div class="bg-white rounded-[4rem] p-10 md:p-16 border border-var(--gold-pale) shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-12 opacity-[0.03] group-hover:opacity-[0.06] transition-opacity">
                <span class="material-symbols-outlined text-[200px]" style="color: var(--gold);">agriculture</span>
            </div>
            
            <div class="relative flex flex-col lg:flex-row items-center lg:items-start gap-12">
                <div class="w-48 h-48 rounded-[3rem] overflow-hidden shadow-2xl border-4 border-white rotate-3 group-hover:rotate-0 transition-transform duration-500">
                    @if($listing->petani?->user?->foto_profil)
                        <img src="{{ asset('storage/' . $listing->petani->user->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white text-6xl font-black" style="background: var(--gold);">
                            {{ substr($listing->petani?->user?->nama ?? 'P', 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <div class="flex-1 text-center lg:text-left space-y-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                        <div>
                            <h3 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--leaf-dark);" class="mb-2">{{ $listing->petani?->user?->nama ?? 'Petani Elite' }}</h3>
                            <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                                <div class="flex items-center gap-2 font-bold text-sm" style="color: var(--mango-green);">
                                    <span class="material-symbols-outlined text-[18px] fill-1">star</span>
                                    {{ number_format($listing->petani->review->avg('rating') ?? 5.0, 1) }} ({{ $listing->petani->review->count() }} Ulasan)
                                </div>
                                <div class="font-bold text-sm flex items-center gap-2" style="color: var(--text-light);">
                                    <span class="material-symbols-outlined text-[18px]">location_on</span>
                                    {{ $listing->lahan?->kecamatan?->nama ?? 'Indramayu' }}
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('pembeli.marketplace.petani', $listing->petani->id) }}" class="px-8 py-4 rounded-xl font-black text-[0.65rem] tracking-widest uppercase transition-all border no-underline" style="background: var(--cream); border-color: var(--gold-pale); color: var(--text-dark);">LIHAT PROFIL</a>
                    </div>
                    
                    <p class="text-xl leading-relaxed max-w-2xl font-medium italic" style="color: var(--text-mid);">
                        "Berkomitmen menyajikan hasil bumi terbaik dengan ketulusan hati. Kami percaya teknologi AI membantu kami membuktikan kualitas yang selama ini kami jaga."
                    </p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pt-10 border-t" style="border-color: var(--gold-pale);">
                        <div class="text-center lg:text-left">
                            <p class="text-[0.65rem] font-black uppercase tracking-widest mb-1" style="color: var(--text-light);">Pengalaman</p>
                            <p class="text-2xl font-black" style="color: var(--text-dark);">{{ $listing->petani->pengalaman_tahun ?? 5 }} Thn</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-[0.65rem] font-black uppercase tracking-widest mb-1" style="color: var(--text-light);">Total Lahan</p>
                            <p class="text-2xl font-black" style="color: var(--text-dark);">{{ $listing->petani->lahan->count() }} Lokasi</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-[0.65rem] font-black uppercase tracking-widest mb-1" style="color: var(--text-light);">Status</p>
                            <p class="text-2xl font-black" style="color: var(--mango-green);">VERIFIED</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-[0.65rem] font-black uppercase tracking-widest mb-1" style="color: var(--text-light);">Respons</p>
                            <p class="text-2xl font-black" style="color: var(--text-dark);">&lt; 1 Jam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
