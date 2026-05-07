@extends('layouts.pembeli')

@section('title', 'Manajemen Alamat')

@section('content')
<div x-data="{ 
    modalOpen: false, 
    editMode: false,
    formAction: '{{ route('pembeli.alamat.store') }}',
    formMethod: 'POST',
    addressData: {
        id: '',
        label: '',
        nama_penerima: '',
        no_telepon: '',
        kecamatan_id: '',
        kecamatan_nama: 'Pilih Kecamatan',
        alamat_lengkap: '',
        kota: 'Indramayu',
        kode_pos: '',
        utama: false
    },
    kecamatans: {{ $kecamatans->toJson() }},
    
    openAddModal() {
        this.editMode = false;
        this.modalOpen = true;
        this.formAction = '{{ route('pembeli.alamat.store') }}';
        this.formMethod = 'POST';
        this.addressData = {
            id: '', label: '', nama_penerima: '', no_telepon: '', 
            kecamatan_id: '', kecamatan_nama: 'Pilih Kecamatan',
            alamat_lengkap: '', kota: 'Indramayu', kode_pos: '', utama: false
        };
    },
    
    openEditModal(alamat) {
        this.editMode = true;
        this.modalOpen = true;
        this.formAction = `/pembeli/alamat/${alamat.id}`;
        this.formMethod = 'PUT';
        this.addressData = {
            id: alamat.id,
            label: alamat.label,
            nama_penerima: alamat.nama_penerima,
            no_telepon: alamat.no_telepon,
            kecamatan_id: alamat.kecamatan_id,
            kecamatan_nama: alamat.kecamatan ? alamat.kecamatan.nama : 'Pilih Kecamatan',
            alamat_lengkap: alamat.alamat_lengkap,
            kota: alamat.kota,
            kode_pos: alamat.kode_pos,
            utama: !!alamat.utama
        };
    }
}">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1b1b18] mb-1">Daftar Alamat</h1>
            <p class="text-[#706f6c]">Kelola alamat pengiriman Anda untuk memudahkan proses checkout.</p>
        </div>
        
        <button type="button" @click="openAddModal()" class="px-6 py-3 bg-[#FFB800] text-white rounded-2xl font-bold shadow-lg shadow-orange-200 hover:bg-[#10B981] transition-all flex items-center gap-2">
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
        <div class="glass-card rounded-3xl p-8 relative overflow-hidden group {{ $alamat->utama ? 'border-[#FFB800] bg-orange-50/20 shadow-lg shadow-orange-100' : '' }}">
            @if($alamat->utama)
            <div class="absolute top-0 right-0">
                <span class="bg-[#FFB800] text-white text-[10px] font-bold px-4 py-1 rounded-bl-xl uppercase tracking-tighter">Utama</span>
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
                    <button type="submit" class="text-xs font-bold text-[#FFB800] hover:underline">Set Utama</button>
                </form>
                @endif
                <button type="button" @click="openEditModal({{ json_encode($alamat->load('kecamatan')) }})" class="text-xs font-bold text-[#706f6c] hover:text-[#1b1b18]">Edit</button>
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
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-[#1b1b18]">Belum Ada Alamat</h3>
            <p class="text-[#706f6c]">Tambahkan alamat pengiriman untuk mulai berbelanja.</p>
        </div>
        @endforelse
    </div>

    <!-- Modal Form (Alpine JS) -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-[60] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="modalOpen = false"></div>
            
            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" 
                 class="relative bg-white rounded-[2.5rem] w-full max-w-2xl p-8 md:p-12 shadow-2xl overflow-visible">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-black tracking-tight" x-text="editMode ? 'Edit Alamat' : 'Tambah Alamat Baru'"></h2>
                    <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form :action="formAction" method="POST" class="space-y-6">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Label Alamat</label>
                            <input type="text" name="label" x-model="addressData.label" placeholder="Rumah, Kantor, Toko..." class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.2rem] focus:ring-2 focus:ring-[#FFB800] outline-none transition-all font-bold" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Penerima</label>
                            <input type="text" name="nama_penerima" x-model="addressData.nama_penerima" placeholder="Nama Lengkap" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.2rem] focus:ring-2 focus:ring-[#FFB800] outline-none transition-all font-bold" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nomor Telepon</label>
                            <input type="text" name="no_telepon" x-model="addressData.no_telepon" placeholder="0812..." class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.2rem] focus:ring-2 focus:ring-[#FFB800] outline-none transition-all font-bold" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Kecamatan (Indramayu)</label>
                            <div x-data="{ 
                                open: false, 
                                search: '', 
                                get filteredKecamatans() {
                                    if (this.search === '') return kecamatans;
                                    return kecamatans.filter(k => k.nama.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                select(kec) {
                                    addressData.kecamatan_id = kec.id;
                                    addressData.kecamatan_nama = kec.nama;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" class="relative">
                                <input type="hidden" name="kecamatan_id" :value="addressData.kecamatan_id" required>
                                
                                <button type="button" @click="open = !open" 
                                        class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.2rem] focus:ring-2 focus:ring-[#FFB800] outline-none transition-all flex justify-between items-center text-left">
                                    <span x-text="addressData.kecamatan_nama" :class="addressData.kecamatan_id ? 'text-[#1b1b18] font-bold' : 'text-gray-400 font-bold'"></span>
                                    <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <div x-show="open" @click.away="open = false" 
                                     class="absolute z-[70] w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                                    <div class="p-3 border-b border-gray-50">
                                        <input type="text" x-model="search" placeholder="Cari kecamatan..." 
                                               class="w-full px-4 py-2 bg-gray-50 border-none rounded-xl text-sm focus:ring-1 focus:ring-[#FFB800] outline-none">
                                    </div>
                                    <div class="max-h-48 overflow-y-auto">
                                        <template x-for="kec in filteredKecamatans" :key="kec.id">
                                            <div @click="select(kec)" 
                                                 class="px-4 py-3 hover:bg-orange-50 cursor-pointer transition-colors text-sm font-bold"
                                                 :class="addressData.kecamatan_id == kec.id ? 'bg-orange-50 text-[#FFB800]' : 'text-[#1b1b18]'">
                                                <span x-text="kec.nama"></span>
                                            </div>
                                        </template>
                                        <div x-show="filteredKecamatans.length === 0" class="px-4 py-8 text-center text-gray-400 text-[10px] font-black uppercase">
                                            Tidak ditemukan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" x-model="addressData.alamat_lengkap" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW..." class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-2 focus:ring-[#FFB800] outline-none transition-all font-bold resize-none" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Kota/Kabupaten</label>
                            <input type="text" name="kota" x-model="addressData.kota" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.2rem] focus:ring-2 focus:ring-[#FFB800] outline-none transition-all font-bold" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Kode Pos</label>
                            <input type="text" name="kode_pos" x-model="addressData.kode_pos" placeholder="452xx" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.2rem] focus:ring-2 focus:ring-[#FFB800] outline-none transition-all font-bold" required>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <input type="checkbox" name="utama" id="form-utama" value="1" x-model="addressData.utama" class="w-5 h-5 text-[#FFB800] border-gray-300 rounded focus:ring-[#FFB800]">
                        <label for="form-utama" class="text-xs font-black text-[#1b1b18] uppercase tracking-widest">Jadikan Alamat Utama</label>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" @click="modalOpen = false" class="flex-1 px-8 py-5 bg-gray-100 text-center rounded-[1.5rem] font-black text-[10px] tracking-widest uppercase text-gray-400 hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="flex-[2] px-8 py-5 bg-[#1b1b18] text-white rounded-[1.5rem] font-black text-[10px] tracking-widest uppercase shadow-xl shadow-black/10 hover:bg-black transition-all active:scale-95">Simpan Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
