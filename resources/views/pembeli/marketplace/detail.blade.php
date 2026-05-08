@extends('layouts.pembeli')

@section('title', $listing->jenis_mangga ?? 'Detail Produk')

@section('content')
<div class="relative min-h-screen pb-20">
    <!-- Breadcrumb -->
    <nav class="flex mb-10 animate-in fade-in slide-in-from-top duration-700" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[10px] font-black uppercase tracking-[0.2em]">
            <li class="inline-flex items-center text-gray-400 hover:text-[#FFB800] transition-colors">
                <a href="{{ route('pembeli.dashboard') }}">DASHBOARD</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-300 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ route('pembeli.marketplace.katalog') }}" class="text-gray-400 hover:text-[#FFB800] transition-colors">KATALOG</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center text-[#FFB800]">
                    <svg class="w-3 h-3 text-gray-300 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span>{{ $listing->jenis_mangga ?? 'DETAIL' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
        <!-- Gallery Column -->
        <div class="lg:col-span-5 space-y-6 animate-in fade-in slide-in-from-left duration-700">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-[#FFB800] to-orange-600 rounded-[3rem] blur opacity-20"></div>
                <div class="w-full aspect-square rounded-[4rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.15)] border-8 border-white relative group">
                    @php $foto = is_array($listing->foto_batch) ? ($listing->foto_batch[0] ?? null) : $listing->foto_batch; @endphp
                    @if($foto)
                        <img src="{{ str_starts_with($foto, 'http') ? $foto : asset('storage/' . $foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 {{ $listing->stok_tersedia_kg <= 0 ? 'grayscale' : '' }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <svg class="w-20 h-20 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    <div class="absolute bottom-8 left-8">
                        <div class="px-4 py-2 bg-white/90 backdrop-blur rounded-2xl shadow-xl border border-white flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-xs font-black text-[#1b1b18] uppercase tracking-widest">AI Verified Freshness</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-4 gap-4">
                @php $additionalImages = is_array($listing->foto_batch) ? array_slice($listing->foto_batch, 1) : []; @endphp
                @foreach($additionalImages as $foto)
                    <div class="aspect-square bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-[#FFB800] transition-all cursor-pointer group shadow-sm">
                        <img src="{{ str_starts_with($foto, 'http') ? $foto : asset('storage/' . $foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Info Column -->
        <div class="lg:col-span-7 space-y-10 animate-in fade-in slide-in-from-right duration-700">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    @if($listing->stok_tersedia_kg > 0)
                        <div class="px-6 py-2 bg-emerald-500 text-white rounded-full text-xs font-black uppercase tracking-[0.2em] shadow-xl shadow-emerald-200 animate-pulse">Tersedia</div>
                    @else
                        <div class="px-6 py-2 bg-red-500 text-white rounded-full text-xs font-black uppercase tracking-[0.2em] shadow-xl shadow-red-200">Habis Terjual</div>
                    @endif
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-emerald-100">AI Score: {{ number_format($listing->skor_kesegaran ?? 0, 0) }}%</span>
                    <span class="px-3 py-1 bg-[#FFB800]/10 text-[#FFB800] rounded-full text-[9px] font-black uppercase tracking-widest border border-[#FFB800]/10">Premium Batch</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black text-[#1b1b18] tracking-tight leading-none">{{ $listing->jenis_mangga ?? 'Mangga Premium' }}</h1>
                <div class="flex items-center gap-4">
                    <p class="text-4xl font-black text-[#FFB800]">Rp{{ number_format($listing->harga_per_kg, 0, ',', '.') }}</p>
                    <span class="text-lg text-gray-400 font-bold uppercase tracking-widest mt-2">/ Kilogram</span>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100 flex flex-col items-center text-center">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Tersedia</span>
                    <span class="text-xl font-black text-[#1b1b18]">{{ number_format($listing->stok_tersedia_kg, 0) }}kg</span>
                </div>
                <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100 flex flex-col items-center text-center">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Min. Order</span>
                    <span class="text-xl font-black text-[#1b1b18]">{{ number_format($listing->minimal_order_kg, 0) }}kg</span>
                </div>
                <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100 flex flex-col items-center text-center">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Kecamatan</span>
                    <span class="text-xl font-black text-[#1b1b18] truncate w-full px-2">{{ $listing->lahan?->kecamatan?->nama ?? 'Indramayu' }}</span>
                </div>
                <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100 flex flex-col items-center text-center text-[#FFB800]">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Akurasi AI</span>
                    <span class="text-xl font-black">99.8%</span>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.3em]">Spesifikasi & Deskripsi</h3>
                <p class="text-lg text-[#706f6c] leading-relaxed font-medium">
                    {{ $listing->deskripsi ?? 'Nikmati sensasi rasa mangga premium terbaik langsung dari tanah Indramayu. Setiap buah telah melalui proses seleksi ketat dan diagnosa AI untuk menjamin tingkat kemanisan, tekstur, dan kesegaran maksimal saat sampai di tangan Anda.' }}
                </p>
            </div>

            <div class="pt-10 border-t border-gray-100">
                <form action="{{ route('pembeli.cart.add') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-stretch">
                    @csrf
                    <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                    <div class="flex items-center bg-gray-50 rounded-[2rem] border border-gray-200 px-6 py-2">
                        <button type="button" onclick="const input = this.nextElementSibling.querySelector('input'); if(input.value > input.min) input.stepDown()" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-black transition-colors" {{ $listing->stok_tersedia_kg <= 0 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                        </button>
                        <div class="flex flex-col items-center px-4">
                            <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Jumlah (KG)</span>
                            <input type="number" name="jumlah_kg" value="{{ $listing->minimal_order_kg ?? 1 }}" min="{{ $listing->minimal_order_kg ?? 1 }}" max="{{ $listing->stok_tersedia_kg }}" 
                                   class="w-20 bg-transparent border-none focus:ring-0 text-center text-2xl font-black text-[#1b1b18] p-0" {{ $listing->stok_tersedia_kg <= 0 ? 'disabled' : '' }}>
                        </div>
                        <button type="button" onclick="const input = this.previousElementSibling.querySelector('input'); if(input.value < input.max) input.stepUp()" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-black transition-colors" {{ $listing->stok_tersedia_kg <= 0 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </button>
                    </div>
                    
                    @if($listing->stok_tersedia_kg > 0)
                        <button type="submit" class="flex-1 py-6 bg-[#1b1b18] text-white rounded-[2.2rem] font-black text-sm tracking-[0.2em] uppercase shadow-2xl shadow-black/20 hover:bg-black transition-all transform active:scale-[0.98] flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            MASUKKAN KERANJANG
                        </button>
                    @else
                        <button type="button" disabled class="flex-1 py-6 bg-gray-100 text-gray-400 rounded-[2.2rem] font-black text-sm tracking-[0.2em] uppercase cursor-not-allowed flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                            STOK HABIS
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-32 space-y-12 animate-in fade-in duration-1000">
        <div class="flex items-end justify-between mb-12">
            <div class="space-y-4">
                <h2 class="text-3xl lg:text-4xl font-black text-[#1b1b18] tracking-tight">Ulasan Pembeli ⭐</h2>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <span class="text-5xl font-black text-[#1b1b18]">{{ number_format($listing->average_rating ?? 0, 1) }}</span>
                        <div class="flex flex-col">
                            <div class="flex text-amber-400 gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="material-symbols-outlined text-sm {{ $i <= round($listing->average_rating ?? 0) ? 'fill-1' : '' }}">star</span>
                                @endfor
                            </div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">{{ $listing->review_count ?? 0 }} Ulasan Total</span>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($listing->review_count > 0)
                <a href="{{ route('pembeli.marketplace.reviews', $listing->id) }}" class="group flex items-center gap-3 px-8 py-4 bg-white text-[#1b1b18] rounded-2xl font-black text-[11px] tracking-widest uppercase hover:bg-[#1b1b18] hover:text-white transition-all shadow-sm border border-gray-100">
                    LIHAT SEMUA ULASAN
                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            @endif
        </div>

        @if($reviews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 group">
                        <div class="flex items-start justify-between mb-8">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-[#FFB800] font-black text-xl overflow-hidden border border-orange-100 shadow-inner">
                                    @if($review->pembeli->user->foto_profil)
                                        <img src="{{ asset('storage/' . $review->pembeli->user->foto_profil) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($review->pembeli->user->nama, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-black text-[#1b1b18] text-lg">{{ $review->pembeli->user->nama }}</h4>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $review->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex text-amber-400 gap-0.5 mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="material-symbols-outlined text-sm {{ $i <= $review->rating ? 'fill-1' : '' }}">star</span>
                                @endfor
                            </div>
                        </div>
                        
                        <p class="text-[#706f6c] font-medium leading-relaxed mb-8 italic text-lg">"{{ $review->komentar }}"</p>

                        @if($review->foto_review && count($review->foto_review) > 0)
                            <div class="flex gap-4 overflow-x-auto pb-4 custom-scrollbar">
                                @foreach($review->foto_review as $foto)
                                    <div class="w-24 h-24 rounded-[1.5rem] overflow-hidden border-2 border-white shrink-0 shadow-lg group-hover:scale-105 transition-transform">
                                        <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover cursor-zoom-in">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(auth()->check() && $review->pembeli_id == auth()->user()->pembeli?->id)
                            <div class="mt-6 pt-6 border-t border-gray-50 flex justify-end gap-3">
                                <form action="{{ route('pembeli.review.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-red-50 text-red-500 rounded-2xl font-black text-[10px] tracking-widest uppercase hover:bg-red-100 transition-all border border-red-100 shadow-sm">
                                        <span class="material-symbols-outlined text-sm">delete</span> HAPUS
                                    </button>
                                </form>
                                <a href="{{ route('pembeli.pesanan.show', $review->pesanan_id) }}" class="flex items-center gap-2 px-6 py-3 bg-emerald-50 text-emerald-600 rounded-2xl font-black text-[10px] tracking-widest uppercase hover:bg-emerald-100 transition-all border border-emerald-100 shadow-sm">
                                    <span class="material-symbols-outlined text-sm">edit</span> EDIT
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-24 bg-gray-50/50 rounded-[4rem] border-2 border-dashed border-gray-200">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm">
                    <span class="material-symbols-outlined text-gray-300 text-5xl">rate_review</span>
                </div>
                <h4 class="text-xl font-black text-gray-400 uppercase tracking-[0.2em]">Belum ada ulasan</h4>
                <p class="text-sm text-gray-400 font-bold uppercase tracking-widest opacity-60">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
            </div>
        @endif
    </div>

    <!-- Farmer Card -->
    <div class="mt-32 space-y-10 animate-in fade-in duration-1000">
        <h2 class="text-3xl font-black text-[#1b1b18] tracking-tight text-center">Tentang Petani</h2>
        
        <div class="bg-white rounded-[4rem] p-10 md:p-16 border border-gray-100 shadow-[0_40px_80px_-40px_rgba(0,0,0,0.1)] relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-12 opacity-[0.03] group-hover:opacity-[0.06] transition-opacity">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12a5 5 0 110-10 5 5 0 010 10zm0-2a3 3 0 100-6 3 3 0 000 6zm9 11a1 1 0 01-2 0v-2a3 3 0 00-3-3H8a3 3 0 00-3 3v2a1 1 0 01-2 0v-2a5 5 0 015-5h8a5 5 0 015 5v2z"></path></svg>
            </div>
            
            <div class="relative flex flex-col lg:flex-row items-center lg:items-start gap-12">
                <div class="w-48 h-48 rounded-[3rem] overflow-hidden shadow-2xl border-4 border-white rotate-3 group-hover:rotate-0 transition-transform duration-500">
                    @if($listing->petani?->user?->foto_profil)
                        <img src="{{ asset('storage/' . $listing->petani->user->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FFB800] to-orange-600 text-white text-6xl font-black">
                            {{ substr($listing->petani?->user?->nama ?? 'P', 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <div class="flex-1 text-center lg:text-left space-y-6">
                    <div>
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <div>
                                <h3 class="text-4xl font-black text-[#1b1b18] mb-2">{{ $listing->petani?->user?->nama ?? 'Petani Elite' }}</h3>
                                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                                    <div class="flex items-center gap-2 text-emerald-600 font-bold text-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3-.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        {{ number_format($listing->petani->review->avg('rating') ?? 5.0, 1) }} ({{ $listing->petani->review->count() }} Ulasan)
                                    </div>
                                    <div class="text-gray-400 font-bold text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        {{ $listing->lahan?->kecamatan?->nama ?? 'Indramayu' }}
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('pembeli.marketplace.petani', $listing->petani->id) }}" class="px-8 py-4 bg-gray-50 text-[#1b1b18] rounded-2xl font-black text-xs tracking-widest uppercase hover:bg-gray-100 transition-all border border-gray-100">LIHAT PROFIL</a>
                        </div>
                    </div>
                    
                    <p class="text-xl text-[#706f6c] leading-relaxed max-w-2xl font-medium italic">
                        "Berkomitmen menyajikan hasil bumi terbaik dengan ketulusan hati sejak {{ 2026 - ($listing->petani->pengalaman_tahun ?? 10) }}. Kami percaya teknologi AI membantu kami membuktikan kualitas yang selama ini kami jaga."
                    </p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pt-10 border-t border-gray-100">
                        <div class="text-center lg:text-left">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Pengalaman</p>
                            <p class="text-2xl font-black text-[#1b1b18]">{{ $listing->petani->pengalaman_tahun ?? 0 }} Tahun</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Lahan</p>
                            <p class="text-2xl font-black text-[#1b1b18]">{{ $listing->petani->lahan->count() }} Lokasi</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Terverifikasi</p>
                            <p class="text-2xl font-black text-emerald-500">PRO</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Respons</p>
                            <p class="text-2xl font-black text-[#1b1b18]">&lt; 1 Jam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
