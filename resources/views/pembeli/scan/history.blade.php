@extends('layouts.pembeli')

@section('title', 'Riwayat Scan AI')

@section('content')
<div class="relative animate-in fade-in duration-700">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div>
            <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
                <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
                Analysis Archive
            </div>
            <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3rem); line-height: 1.1; color: var(--leaf-dark);">
                Riwayat <span style="color: var(--gold);">Analisis AI</span>
            </h1>
            <p class="text-sm mt-2" style="color: var(--text-light);">Tinjau kembali hasil pengecekan kesegaran mangga yang telah Anda lakukan.</p>
        </div>
        
        <a href="{{ route('pembeli.scan') }}" class="px-8 py-4 rounded-xl font-black text-[0.7rem] uppercase tracking-widest transition-all shadow-xl active:scale-95 flex items-center gap-3 no-underline"
                style="background: var(--gold); color: white; box-shadow: 0 10px 25px rgba(212,160,23,0.3);">
            <span class="material-symbols-outlined text-[20px]">add_a_photo</span>
            Scan Lagi
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($scans as $scan)
        <div class="bg-white rounded-[2.5rem] overflow-hidden border shadow-sm hover:shadow-md transition-all group animate-in zoom-in-95 duration-500" style="border-color: var(--gold-pale);">
            <div class="aspect-square bg-var(--gold-pale) relative overflow-hidden">
                <img src="{{ str_starts_with($scan->path_foto, 'http') ? $scan->path_foto : asset('storage/' . $scan->path_foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-4 right-4">
                    <div class="px-3 py-1 bg-white/90 backdrop-blur rounded-full text-[10px] font-black shadow-sm border border-white" style="color: var(--gold);">
                        {{ $scan->skor_kesegaran }}% FRESH
                    </div>
                </div>
            </div>
            <div class="p-8">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 style="font-family: 'Lora', serif; font-size: 1.25rem; font-weight: 600; color: var(--leaf-dark);" class="leading-tight mb-1">{{ $scan->jenis_mangga }}</h3>
                        <p class="text-[0.6rem] font-bold uppercase tracking-widest" style="color: var(--text-light);">{{ $scan->created_at->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                    <span class="text-[8px] px-3 py-1 rounded-full font-black uppercase tracking-tighter" style="background: var(--gold-pale); color: var(--gold);">{{ str_replace('_', ' ', $scan->kategori) }}</span>
                </div>
                
                <div class="grid grid-cols-4 gap-2 pt-6 border-t text-center" style="border-color: var(--gold-pale);">
                    <div>
                        <p class="text-[0.5rem] uppercase font-bold mb-1" style="color: var(--text-light);">Warna</p>
                        <p class="font-black text-[0.6rem]" style="color: var(--gold);">{{ $scan->persentase_warna }}%</p>
                    </div>
                    <div>
                        <p class="text-[0.5rem] uppercase font-bold mb-1" style="color: var(--text-light);">Tekstur</p>
                        <p class="font-black text-[0.6rem]" style="color: var(--mango-orange);">{{ $scan->skor_tekstur }}</p>
                    </div>
                    <div>
                        <p class="text-[0.5rem] uppercase font-bold mb-1" style="color: var(--text-light);">Ukuran</p>
                        <p class="font-black text-[0.6rem]" style="color: var(--mango-green);">{{ $scan->diameter_cm }}cm</p>
                    </div>
                    <div>
                        <p class="text-[0.5rem] uppercase font-bold mb-1" style="color: var(--text-light);">Berat</p>
                        <p class="font-black text-[0.6rem]" style="color: var(--gold);">{{ $scan->berat_gram }}g</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between pt-6 mt-6 border-t" style="border-color: var(--gold-pale);">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full {{ $scan->skor_kepercayaan > 80 ? 'bg-emerald-500' : 'bg-amber-500' }}"></div>
                        <span class="text-[9px] font-bold uppercase tracking-widest" style="color: var(--text-light);">AI: {{ $scan->skor_kepercayaan }}%</span>
                    </div>
                    
                    <form action="{{ route('pembeli.scan.destroy', $scan->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="w-10 h-10 flex items-center justify-center rounded-xl transition-all btn-delete" style="color: var(--text-light); background: var(--cream);" title="Hapus Riwayat">
                            <span class="material-symbols-outlined text-[20px] hover:text-red-500">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center bg-white rounded-[3.5rem] border-2 border-dashed" style="border-color: var(--gold-pale);">
            <div class="w-20 h-20 bg-var(--gold-pale) rounded-full flex items-center justify-center mx-auto mb-8">
                <span class="material-symbols-outlined text-4xl opacity-20" style="color: var(--gold);">history</span>
            </div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);" class="mb-2">Belum Ada Riwayat</h3>
            <p class="text-sm mb-10" style="color: var(--text-light);">Mulai pindai mangga Anda untuk melihat hasil analisis AI di sini.</p>
            <a href="{{ route('pembeli.scan') }}" class="inline-flex items-center px-10 py-5 rounded-xl font-black text-[0.7rem] uppercase tracking-widest transition-all shadow-xl no-underline" style="background: var(--gold); color: white;">
                Scan Sekarang
                <span class="material-symbols-outlined text-sm ml-2">add_a_photo</span>
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-16">
        {{ $scans->links() }}
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        const form = this.closest('.delete-form');
        Swal.fire({
            title: 'Hapus Riwayat?',
            text: "Data hasil scan ini akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#D4A017',
            cancelButtonColor: '#7A6E52',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
@endif
</script>
@endpush
@endsection
