@extends('layouts.pembeli')

@section('title', 'Petani Favorit Saya')

@section('content')
<div class="relative animate-in fade-in duration-700">
    <!-- Header Section -->
    <div class="mb-12 animate-in fade-in slide-in-from-left duration-700">
        <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
            <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
            Trusted Partners
        </div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3rem); line-height: 1.1; color: var(--leaf-dark);">
            Petani <span style="color: var(--gold);">Favorit</span> Saya
        </h1>
        <p class="text-sm mt-2" style="color: var(--text-light);">Kumpulan petani terpercaya yang selalu memberikan kualitas terbaik untuk Anda.</p>
    </div>

    <!-- Favorites Grid -->
    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($favorites as $fav)
                @php $petani = $fav->petani; @endphp
                <div class="bg-white rounded-[2.5rem] overflow-hidden border shadow-sm hover:shadow-md transition-all group animate-in zoom-in-95 duration-500" style="border-color: var(--gold-pale);">
                    <div class="p-8">
                        <div class="flex items-center gap-6 mb-8">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center font-black text-2xl overflow-hidden border-2 shadow-sm" style="background: var(--gold-pale); border-color: white; color: var(--gold);">
                                @if($petani->user->foto_profil)
                                    <img src="{{ asset('storage/' . $petani->user->foto_profil) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($petani->user->nama, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <h3 style="font-family: 'Lora', serif; font-size: 1.25rem; font-weight: 600; color: var(--leaf-dark);" class="group-hover:text-var(--gold) transition-colors line-clamp-1">{{ $petani->user->nama }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest border flex items-center gap-1" style="background: rgba(16, 185, 129, 0.05); color: #10B981; border-color: rgba(16, 185, 129, 0.1);">
                                        <span class="material-symbols-outlined text-[10px] fill-1">verified</span>
                                        VERIFIED
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-[0.65rem] font-bold uppercase tracking-widest">
                                <span style="color: var(--text-light);">Kelompok Tani</span>
                                <span style="color: var(--text-dark);">{{ $petani->kelompok_tani ?? 'Mandiri' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[0.65rem] font-bold uppercase tracking-widest">
                                <span style="color: var(--text-light);">Produk Aktif</span>
                                <span style="color: var(--gold);">{{ $petani->listings->count() }} Varietas</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('pembeli.marketplace.petani', $petani->id) }}" class="flex-1 py-4 rounded-xl text-[10px] font-black text-center uppercase tracking-widest transition-all no-underline" style="background: var(--cream); border: 1px solid var(--gold-pale); color: var(--text-dark);">
                                PROFIL
                            </a>
                            <button onclick="toggleFavorit({{ $petani->id }}, this)" class="w-14 py-4 rounded-xl flex items-center justify-center transition-all active:scale-90" style="background: var(--gold-pale); color: var(--gold);">
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
        <div class="text-center py-32 bg-white rounded-[4rem] border-2 border-dashed" style="border-color: var(--gold-pale);">
            <div class="w-20 h-20 bg-var(--gold-pale) rounded-full flex items-center justify-center mx-auto mb-8">
                <span class="material-symbols-outlined text-4xl opacity-20" style="color: var(--gold);">favorite</span>
            </div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);" class="mb-2">Belum Ada Petani Favorit</h3>
            <p class="text-sm mb-10" style="color: var(--text-light);">Mulai jelajahi marketplace dan simpan petani pilihan Anda.</p>
            <a href="{{ route('pembeli.marketplace.katalog') }}" class="inline-flex items-center px-10 py-5 rounded-xl font-black text-[0.7rem] uppercase tracking-widest transition-all shadow-xl no-underline" style="background: var(--gold); color: white;">
                JELAJAHI MARKETPLACE
                <span class="material-symbols-outlined text-sm ml-2">explore</span>
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
