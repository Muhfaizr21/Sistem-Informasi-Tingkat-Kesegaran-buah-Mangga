@extends('layouts.pembeli')

@section('title', 'Petani Favorit Saya')

@section('content')
<div class="min-h-screen pb-24">
    <!-- Header Section -->
    <div class="mb-12 animate-in fade-in slide-in-from-left duration-700">
        <h1 class="text-4xl md:text-5xl font-black text-[#1b1b18] tracking-tight mb-4">
            Petani <span class="text-[#FFB800]">Favorit</span> Saya
        </h1>
        <p class="text-lg text-[#706f6c] font-medium leading-relaxed max-w-2xl">
            Kumpulan petani terpercaya yang selalu memberikan kualitas terbaik untuk Anda.
        </p>
    </div>

    <!-- Favorites Grid -->
    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($favorites as $fav)
                @php $petani = $fav->petani; @endphp
                <div class="bg-white rounded-[3rem] overflow-hidden border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_50px_-15px_rgba(0,0,0,0.1)] transition-all group animate-in zoom-in-95 duration-500">
                    <div class="p-10">
                        <div class="flex items-center gap-6 mb-8">
                            <div class="w-20 h-20 rounded-3xl bg-orange-50 overflow-hidden border-2 border-white shadow-inner flex items-center justify-center text-[#FFB800] font-black text-2xl">
                                @if($petani->user->foto_profil)
                                    <img src="{{ asset('storage/' . $petani->user->foto_profil) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($petani->user->nama, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-[#1b1b18] group-hover:text-[#FFB800] transition-colors line-clamp-1">{{ $petani->user->nama }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-full text-[8px] font-black uppercase tracking-widest border border-emerald-100 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[10px] fill-1">verified</span>
                                        Terverifikasi
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-gray-400 uppercase tracking-widest">Kelompok Tani</span>
                                <span class="font-black text-[#1b1b18]">{{ $petani->kelompok_tani ?? 'Mandiri' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-gray-400 uppercase tracking-widest">Produk Aktif</span>
                                <span class="font-black text-[#FFB800]">{{ $petani->listings->count() }} Varietas</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('pembeli.marketplace.petani', $petani->id) }}" class="flex-1 py-4 bg-gray-50 text-[#1b1b18] rounded-2xl text-[10px] font-black text-center uppercase tracking-widest hover:bg-gray-100 transition-all">
                                PROFIL
                            </a>
                            <button onclick="toggleFavorit({{ $petani->id }}, this)" class="w-14 py-4 bg-orange-100 text-[#FFB800] rounded-2xl flex items-center justify-center hover:bg-orange-200 transition-all active:scale-90">
                                <span class="material-symbols-outlined fill-1">favorite</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-16">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="text-center py-32 bg-white rounded-[4rem] border-2 border-dashed border-gray-100 animate-in zoom-in-95 duration-700">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                <span class="material-symbols-outlined text-4xl text-gray-300">favorite</span>
            </div>
            <h3 class="text-xl font-black text-[#1b1b18] mb-2">Belum ada petani favorit</h3>
            <p class="text-gray-400 font-medium mb-8">Mulai jelajahi marketplace dan simpan petani pilihan Anda.</p>
            <a href="{{ route('pembeli.marketplace.katalog') }}" class="inline-flex items-center px-10 py-5 bg-[#FFB800] text-white rounded-2xl font-black text-xs tracking-widest uppercase hover:bg-[#1b1b18] transition-all shadow-xl shadow-orange-900/20">
                JELAJAHI MARKETPLACE
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
function toggleFavorit(id, btn) {
    btn.disabled = true;
    btn.classList.add('opacity-50');
    
    fetch("{{ route('pembeli.favorit.toggle') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ petani_id: id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'removed') {
            // Re-render or remove card? For simplicity, we just reload if in favorit page
            window.location.reload();
        }
    })
    .finally(() => {
        btn.disabled = false;
        btn.classList.remove('opacity-50');
    });
}
</script>
@endpush
@endsection
