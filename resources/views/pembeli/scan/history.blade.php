@extends('layouts.pembeli')

@section('title', 'Riwayat Scan AI')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h1 class="text-3xl font-bold text-[#1b1b18] mb-1">Riwayat Analisis AI</h1>
        <p class="text-[#706f6c]">Lihat kembali hasil pengecekan kesegaran mangga yang telah Anda lakukan.</p>
    </div>
    <a href="{{ route('pembeli.scan') }}" class="px-6 py-3 bg-[#F53003] text-white rounded-2xl font-bold hover:bg-[#FF4433] transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Scan Lagi
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
    @forelse($scans as $scan)
    <div class="bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_50px_-15px_rgba(0,0,0,0.1)] transition-all group">
        <div class="aspect-square bg-gray-50 relative overflow-hidden">
            <img src="{{ asset('storage/' . $scan->path_foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            <div class="absolute top-4 right-4">
                <div class="px-3 py-1 bg-white/90 backdrop-blur rounded-full text-[10px] font-black text-[#F53003] shadow-sm border border-white">
                    {{ $scan->skor_kesegaran }}% FRESH
                </div>
            </div>
        </div>
        <div class="p-8">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-xl text-[#1b1b18] leading-tight mb-1">{{ $scan->jenis_mangga }}</h3>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">{{ $scan->created_at->format('d M Y, H:i') }}</p>
                </div>
                <span class="text-[9px] px-3 py-1 bg-gray-100 rounded-full font-black text-gray-500 uppercase tracking-tighter">{{ $scan->kategori }}</span>
            </div>
            
            <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-50">
                <div>
                    <p class="text-[9px] text-gray-400 uppercase font-bold mb-1">Akurasi AI</p>
                    <p class="font-bold text-sm text-[#1b1b18]">{{ $scan->skor_kepercayaan }}%</p>
                </div>
                <div>
                    <p class="text-[9px] text-gray-400 uppercase font-bold mb-1">Cacat</p>
                    <p class="font-bold text-sm {{ $scan->cacat_terdeteksi ? 'text-red-500' : 'text-emerald-500' }}">
                        {{ $scan->cacat_terdeteksi ? 'Terdeteksi' : 'Aman' }}
                    </p>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-gray-50 flex justify-end">
                <form action="{{ route('pembeli.scan.destroy', $scan->id) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="w-10 h-10 flex items-center justify-center rounded-xl text-gray-300 hover:text-red-500 hover:bg-red-50 transition-all btn-delete" title="Hapus Riwayat">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center glass-card rounded-[2rem]">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <h3 class="text-xl font-bold">Belum Ada Riwayat</h3>
        <p class="text-[#706f6c] mb-6">Mulai pindai mangga Anda untuk melihat hasil analisis AI di sini.</p>
        <a href="{{ route('pembeli.scan') }}" class="px-8 py-3 bg-[#F53003] text-white rounded-2xl font-bold hover:bg-[#FF4433] transition-all">Scan Sekarang</a>
    </div>
    @endforelse
</div>

<div class="mt-10">
    {{ $scans->links() }}
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        const form = this.closest('.delete-form');
        Swal.fire({
            title: 'Hapus Riwayat?',
            text: "Data hasil scan ini akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F53003',
            cancelButtonColor: '#706f6c',
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
