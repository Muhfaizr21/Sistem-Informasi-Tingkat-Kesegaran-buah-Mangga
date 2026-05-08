@extends('layouts.pembeli')

@section('content')
<div class="min-h-screen bg-[#fafafa] pb-24">
    <!-- Hero Section -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-12 lg:py-20">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="space-y-4">
                    <a href="{{ route('pembeli.marketplace.detail', $listing->id) }}" class="inline-flex items-center gap-2 text-xs font-black text-gray-400 hover:text-[#FFB800] transition-colors uppercase tracking-[0.2em]">
                        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Produk
                    </a>
                    <h1 class="text-4xl lg:text-5xl font-black text-[#1b1b18] tracking-tight">Semua Ulasan</h1>
                    <p class="text-lg text-[#706f6c] font-medium max-w-2xl leading-relaxed">
                        Apa kata pembeli tentang <span class="text-[#FFB800] font-black">{{ $listing->jenis_mangga }}</span> dari <span class="font-black text-[#1b1b18]">{{ $listing->petani->user->nama }}</span>?
                    </p>
                </div>
                
                <div class="bg-orange-50/50 rounded-[2.5rem] p-8 border border-orange-100/50 flex items-center gap-10">
                    <div class="text-center">
                        <p class="text-xs font-black text-orange-800/50 uppercase tracking-widest mb-2">Rating</p>
                        <div class="flex items-center gap-2">
                            <span class="text-4xl font-black text-[#1b1b18]">{{ number_format($reviews->total() > 0 ? $reviews->avg('rating') : 0, 1) }}</span>
                            <span class="material-symbols-outlined text-[#FFB800] text-3xl fill-1">star</span>
                        </div>
                    </div>
                    <div class="w-px h-12 bg-orange-200/30"></div>
                    <div class="text-center">
                        <p class="text-xs font-black text-orange-800/50 uppercase tracking-widest mb-2">Total</p>
                        <p class="text-4xl font-black text-[#1b1b18]">{{ $reviews->total() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Grid -->
    <div class="max-w-7xl mx-auto px-6 mt-12 lg:mt-20">
        @if($reviews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($reviews as $review)
                    <div x-data="{ editing: false }" class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 group animate-in fade-in slide-in-from-bottom duration-700">
                        <!-- View Mode -->
                        <div x-show="!editing">
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
                                        <h4 class="font-black text-[#1b1b18] text-lg">
                                            {{ $review->pembeli->user->nama }}
                                            @if(auth()->check() && $review->pembeli_id == auth()->user()->pembeli?->id)
                                                <span class="text-[10px] text-[#FFB800] ml-2 font-black tracking-widest">(SAYA)</span>
                                            @endif
                                        </h4>
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
                                    <button @click="editing = true" class="flex items-center gap-2 px-6 py-3 bg-[#FFB800]/10 text-[#FFB800] rounded-2xl font-black text-[10px] tracking-widest uppercase hover:bg-[#FFB800]/20 transition-all border border-[#FFB800]/20 shadow-sm">
                                        <span class="material-symbols-outlined text-sm">edit</span> EDIT ULASAN
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Edit Mode -->
                        <div x-show="editing" x-cloak>
                            <form action="{{ route('pembeli.review.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-6">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">Rating Anda</label>
                                    <div class="flex gap-2" x-data="{ currentRating: {{ $review->rating }} }">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="rating" value="{{ $i }}" class="hidden" x-model="currentRating">
                                                <span class="material-symbols-outlined text-3xl transition-colors" 
                                                      :class="currentRating >= {{ $i }} ? 'text-[#FFB800] fill-1' : 'text-gray-200'">star</span>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">Komentar</label>
                                    <textarea name="komentar" rows="4" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm font-medium focus:ring-[#FFB800] focus:border-[#FFB800]" placeholder="Bagikan pengalaman Anda...">{{ $review->komentar }}</textarea>
                                </div>

                                <div class="mb-8">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">Ganti Foto (Opsional)</label>
                                    <input type="file" name="foto_review[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="button" @click="editing = false" class="px-6 py-3 rounded-2xl font-black text-[10px] tracking-widest uppercase text-gray-400 hover:bg-gray-50 transition-all">BATAL</button>
                                    <button type="submit" class="px-8 py-3 bg-[#FFB800] text-white rounded-2xl font-black text-[10px] tracking-widest uppercase hover:bg-[#e6a600] transition-all shadow-lg shadow-[#FFB800]/20">SIMPAN PERUBAHAN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-20">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-32 bg-white rounded-[4rem] border-2 border-dashed border-gray-100">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <span class="material-symbols-outlined text-4xl text-gray-300">rate_review</span>
                </div>
                <h3 class="text-xl font-black text-[#1b1b18] mb-2">Belum ada ulasan</h3>
                <p class="text-gray-400 font-medium">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
            </div>
        @endif
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        height: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #FFB800;
        border-radius: 10px;
    }
    .fill-1 { font-variation-settings: 'FILL' 1; }
</style>
@endsection
