@extends('layouts.pembeli')

@section('title', 'Manajemen Alamat')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-[#1b1b18] mb-1">Daftar Alamat</h1>
        <p class="text-[#706f6c]">Kelola alamat pengiriman Anda untuk memudahkan proses checkout.</p>
    </div>
    
    <button type="button" onclick="document.getElementById('address-modal').classList.remove('hidden')" class="px-6 py-3 bg-[#F53003] text-white rounded-2xl font-bold shadow-lg shadow-orange-200 hover:bg-[#FF4433] transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Alamat Baru
    </button>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse($alamats as $alamat)
    <div class="glass-card rounded-3xl p-8 relative overflow-hidden group {{ $alamat->utama ? 'border-[#F53003] bg-orange-50/20' : '' }}">
        @if($alamat->utama)
        <div class="absolute top-0 right-0">
            <span class="bg-[#F53003] text-white text-[10px] font-bold px-4 py-1 rounded-bl-xl uppercase">Utama</span>
        </div>
        @endif

        <div class="flex justify-between items-start mb-4">
            <span class="px-2 py-1 bg-gray-100 text-[10px] font-bold uppercase tracking-wider rounded text-[#706f6c]">{{ $alamat->label }}</span>
        </div>

        <h3 class="text-xl font-bold mb-1">{{ $alamat->nama_penerima }}</h3>
        <p class="text-[#706f6c] font-medium mb-3">{{ $alamat->no_telepon }}</p>
        <p class="text-sm text-[#706f6c] leading-relaxed mb-6">{{ $alamat->alamat_lengkap }}, {{ $alamat->kecamatan?->nama ?? 'Lokasi tidak diketahui' }}, {{ $alamat->kota }}, {{ $alamat->kode_pos }}</p>

        <div class="flex items-center gap-4">
            @if(!$alamat->utama)
            <form action="{{ route('pembeli.alamat.utama', $alamat->id) }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-[#F53003] hover:underline">Set Utama</button>
            </form>
            @endif
            <button type="button" onclick="editAddress({{ json_encode($alamat) }})" class="text-xs font-bold text-[#706f6c] hover:text-[#1b1b18]">Edit</button>
            <form action="{{ route('pembeli.alamat.destroy', $alamat->id) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs font-bold text-red-500 hover:underline">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center glass-card rounded-3xl">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-[#1b1b18]">Belum Ada Alamat</h3>
        <p class="text-[#706f6c]">Tambahkan alamat pengiriman untuk mulai berbelanja.</p>
    </div>
    @endforelse
</div>

<!-- Modal Form -->
<div id="address-modal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal()"></div>
        
        <div class="relative bg-white rounded-[2rem] w-full max-w-2xl p-8 md:p-10 shadow-2xl">
            <div class="flex justify-between items-center mb-8">
                <h2 id="modal-title" class="text-2xl font-bold">Tambah Alamat Baru</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="address-form" action="{{ route('pembeli.alamat.store') }}" method="POST" class="space-y-6">
                @csrf
                <div id="method-field"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">Label Alamat</label>
                        <input type="text" name="label" id="form-label" placeholder="Rumah, Kantor, Toko..." class="w-full px-4 py-3 bg-gray-50 border border-[#19140015] rounded-2xl focus:ring-2 focus:ring-[#F53003] outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Nama Penerima</label>
                        <input type="text" name="nama_penerima" id="form-nama" placeholder="Nama Lengkap" class="w-full px-4 py-3 bg-gray-50 border border-[#19140015] rounded-2xl focus:ring-2 focus:ring-[#F53003] outline-none transition-all" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">Nomor Telepon</label>
                        <input type="text" name="no_telepon" id="form-telp" placeholder="0812..." class="w-full px-4 py-3 bg-gray-50 border border-[#19140015] rounded-2xl focus:ring-2 focus:ring-[#F53003] outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Kecamatan (Indramayu)</label>
                        <select name="kecamatan_id" id="form-kecamatan" class="w-full px-4 py-3 bg-gray-50 border border-[#19140015] rounded-2xl focus:ring-2 focus:ring-[#F53003] outline-none transition-all" required>
                            <option value="">Pilih Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" id="form-alamat" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW..." class="w-full px-4 py-3 bg-gray-50 border border-[#19140015] rounded-2xl focus:ring-2 focus:ring-[#F53003] outline-none transition-all" required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">Kota/Kabupaten</label>
                        <input type="text" name="kota" id="form-kota" value="Indramayu" class="w-full px-4 py-3 bg-gray-50 border border-[#19140015] rounded-2xl focus:ring-2 focus:ring-[#F53003] outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Kode Pos</label>
                        <input type="text" name="kode_pos" id="form-pos" placeholder="452xx" class="w-full px-4 py-3 bg-gray-50 border border-[#19140015] rounded-2xl focus:ring-2 focus:ring-[#F53003] outline-none transition-all" required>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="utama" id="form-utama" value="1" class="w-5 h-5 text-[#F53003] border-[#19140015] rounded focus:ring-[#F53003]">
                    <label for="form-utama" class="text-sm font-medium text-[#706f6c]">Jadikan Alamat Utama</label>
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="button" onclick="closeModal()" class="flex-1 px-6 py-4 bg-gray-100 text-center rounded-2xl font-bold text-gray-600 hover:bg-gray-200 transition-colors">Batal</button>
                    <button type="submit" class="flex-[2] px-6 py-4 bg-[#F53003] text-white rounded-2xl font-bold shadow-lg shadow-orange-200 hover:bg-[#FF4433] transition-all">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editAddress(alamat) {
        document.getElementById('modal-title').innerText = 'Edit Alamat';
        document.getElementById('address-form').action = `/pembeli/alamat/${alamat.id}`;
        document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('form-label').value = alamat.label;
        document.getElementById('form-nama').value = alamat.nama_penerima;
        document.getElementById('form-telp').value = alamat.no_telepon;
        document.getElementById('form-kecamatan').value = alamat.kecamatan_id;
        document.getElementById('form-alamat').value = alamat.alamat_lengkap;
        document.getElementById('form-kota').value = alamat.kota;
        document.getElementById('form-pos').value = alamat.kode_pos;
        document.getElementById('form-utama').checked = alamat.utama;

        document.getElementById('address-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('address-modal').classList.add('hidden');
        document.getElementById('address-form').reset();
        document.getElementById('modal-title').innerText = 'Tambah Alamat Baru';
        document.getElementById('address-form').action = "{{ route('pembeli.alamat.store') }}";
        document.getElementById('method-field').innerHTML = '';
    }
</script>
@endpush
@endsection
