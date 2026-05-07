@extends('layouts.pembeli')

@section('title', 'Profil Petani: ' . ($petani->user->nama ?? 'Anonim'))

@section('content')
<div class="mb-8">
    <a href="javascript:history.back()" class="text-sm font-medium text-[#706f6c] hover:text-[#FFB800] flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>
</div>

<!-- Header Profile -->
<div class="glass-card rounded-[2rem] p-8 md:p-12 mb-12 relative overflow-hidden">
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-100 rounded-full blur-[100px] opacity-30"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-10">
        <div class="w-32 h-32 md:w-48 md:h-48 rounded-3xl bg-gray-200 overflow-hidden shadow-xl border-4 border-white">
            @if($petani->user?->foto_profil)
                <img src="{{ asset('storage/' . $petani->user->foto_profil) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-mango text-white text-5xl font-bold">
                    {{ substr($petani->user->nama ?? 'P', 0, 1) }}
                </div>
            @endif
        </div>
        
        <div class="flex-1 text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold mb-4">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Petani Terverifikasi
            </div>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
                <h1 class="text-4xl font-bold text-[#1b1b18]">{{ $petani->user->nama ?? 'Anonim' }}</h1>
                <button id="btn-favorit" data-id="{{ $petani->id }}" class="flex items-center gap-2 px-6 py-2 rounded-2xl font-bold transition-all {{ $isFavorited ? 'bg-orange-100 text-[#FFB800] border-orange-200' : 'bg-white text-[#706f6c] border-[#19140015]' }} border">
                    <svg class="w-5 h-5 {{ $isFavorited ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    <span>{{ $isFavorited ? 'Favorit Saya' : 'Favoritkan' }}</span>
                </button>
            </div>
            <p class="text-lg text-[#706f6c] mb-6">Kelompok Tani: <span class="text-[#1b1b18] font-semibold">{{ $petani->kelompok_tani ?? 'Mandiri' }}</span></p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl">
                <div class="p-4 bg-white/50 rounded-2xl border border-white/20">
                    <p class="text-[10px] uppercase font-bold text-[#706f6c] mb-1">Pengalaman</p>
                    <p class="text-lg font-bold">{{ $petani->pengalaman_tahun }} Thn</p>
                </div>
                <div class="p-4 bg-white/50 rounded-2xl border border-white/20">
                    <p class="text-[10px] uppercase font-bold text-[#706f6c] mb-1">Total Lahan</p>
                    <p class="text-lg font-bold">{{ $petani->lahan->count() }} Lokasi</p>
                </div>
                <div class="p-4 bg-white/50 rounded-2xl border border-white/20">
                    <p class="text-[10px] uppercase font-bold text-[#706f6c] mb-1">Rating</p>
                    <p class="text-lg font-bold text-amber-500">★ {{ number_format($petani->review->avg('rating') ?? 5.0, 1) }}</p>
                </div>
                <div class="p-4 bg-white/50 rounded-2xl border border-white/20">
                    <p class="text-[10px] uppercase font-bold text-[#706f6c] mb-1">Varietas</p>
                    <p class="text-lg font-bold">{{ count(array_unique($petani->lahan->pluck('jenis_mangga')->toArray())) }} Jenis</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Left Column: Products -->
    <div class="lg:col-span-2 space-y-12">
        <section>
            <h2 class="text-2xl font-bold mb-6">Mangga Sedang Panen</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($petani->listings as $listing)
                <a href="{{ route('pembeli.marketplace.detail', $listing->id) }}" class="glass-card rounded-3xl overflow-hidden hover:shadow-xl transition-all group">
                    <div class="aspect-video bg-gray-100 relative">
                        @if(is_array($listing->foto_batch) && count($listing->foto_batch) > 0)
                            <img src="{{ asset('storage/' . $listing->foto_batch[0]) }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 bg-white/90 backdrop-blur rounded-lg text-[10px] font-bold text-emerald-600">AI: {{ $listing->skor_kesegaran ?? 0 }}%</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-1">{{ $listing->jenis_mangga ?? 'Mangga' }}</h3>
                        <p class="text-sm text-[#706f6c] mb-4">{{ $listing->lahan?->kecamatan?->nama ?? 'Lokasi tidak diketahui' }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-[#FFB800]">Rp{{ number_format($listing->harga_per_kg ?? 0, 0, ',', '.') }}/kg</span>
                            <span class="text-xs text-mango font-bold">Detail →</span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-2 py-12 text-center text-gray-400 italic">Belum ada batch panen yang dijual.</div>
                @endforelse
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-bold mb-6">Histori Panen Terakhir</h2>
            <div class="space-y-4">
                {{-- Data histori panen bisa diambil dari LaporanPanen --}}
                <div class="p-6 bg-white border border-[#19140010] rounded-2xl flex justify-between items-center">
                    <div>
                        <p class="font-bold">Panen Harum Manis</p>
                        <p class="text-xs text-[#706f6c]">Mei 2026 • Lahan Jatibarang</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-emerald-600">+500 kg</p>
                        <p class="text-[10px] text-[#706f6c]">Terverifikasi</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Right Column: Info & Reviews -->
    <div class="space-y-8">
        <section class="glass-card rounded-3xl p-8">
            <h2 class="text-xl font-bold mb-6">Ulasan Pembeli</h2>
            <div class="space-y-6">
                @forelse($petani->review()->latest()->limit(5)->get() as $rev)
                <div class="pb-6 border-b border-[#19140005] last:border-0 last:pb-0">
                    <div class="flex justify-between items-center mb-2">
                        <p class="font-bold text-sm">{{ $rev->pembeli?->user?->nama ?? 'Anonim' }}</p>
                        <span class="text-amber-500 text-xs">★ {{ $rev->rating }}</span>
                    </div>
                    <p class="text-xs text-[#706f6c] leading-relaxed italic">"{{ $rev->komentar }}"</p>
                </div>
                @empty
                <p class="text-center text-gray-400 text-sm italic">Belum ada ulasan.</p>
                @endforelse
            </div>
        </section>

        <section class="glass-card rounded-3xl p-8">
            <h2 class="text-xl font-bold mb-4">Lokasi Lahan</h2>
            <div class="space-y-3">
                @foreach($petani->lahan as $lahan)
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 bg-mango rounded-full"></div>
                    <div>
                        <p class="text-sm font-bold">{{ $lahan->nama_lahan }}</p>
                        <p class="text-[10px] text-[#706f6c]">{{ $lahan->desa }}, {{ $lahan->kecamatan?->nama ?? 'Lokasi tidak diketahui' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#btn-favorit').click(function() {
        const btn = $(this);
        const petaniId = btn.data('id');
        
        btn.prop('disabled', true).addClass('opacity-50');
        
        $.ajax({
            url: "{{ route('pembeli.favorit.toggle') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                petani_id: petaniId
            },
            success: function(response) {
                if (response.status === 'added') {
                    btn.removeClass('bg-white text-[#706f6c] border-[#19140015]')
                       .addClass('bg-orange-100 text-[#FFB800] border-orange-200');
                    btn.find('svg').addClass('fill-current');
                    btn.find('span').text('Favorit Saya');
                } else {
                    btn.removeClass('bg-orange-100 text-[#FFB800] border-orange-200')
                       .addClass('bg-white text-[#706f6c] border-[#19140015]');
                    btn.find('svg').removeClass('fill-current');
                    btn.find('span').text('Favoritkan');
                }
            },
            error: function(xhr) {
                alert('Gagal memproses permintaan.');
            },
            complete: function() {
                btn.prop('disabled', false).removeClass('opacity-50');
            }
        });
    });
});
</script>
@endpush
