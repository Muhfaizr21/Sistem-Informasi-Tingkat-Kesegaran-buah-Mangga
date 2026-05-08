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
}" class="relative animate-in fade-in duration-700">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div>
            <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
                <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
                Location Settings
            </div>
            <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3rem); line-height: 1.1; color: var(--leaf-dark);">
                Daftar <span style="color: var(--gold);">Alamat</span>
            </h1>
            <p class="text-sm mt-2" style="color: var(--text-light);">Kelola alamat pengiriman Anda untuk memudahkan proses checkout.</p>
        </div>
        
        <button type="button" @click="openAddModal()" class="px-8 py-4 rounded-xl font-black text-[0.7rem] uppercase tracking-widest transition-all shadow-xl active:scale-95 flex items-center gap-3 no-underline"
                style="background: var(--gold); color: white; box-shadow: 0 10px 25px rgba(212,160,23,0.3);">
            <span class="material-symbols-outlined text-[20px]">add_location</span>
            Tambah Alamat
        </button>
    </div>

    @if(session('success'))
    <div class="mb-8 p-6 rounded-2xl flex items-center gap-4 shadow-sm animate-in zoom-in duration-500" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1);">
        <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined">check</span>
        </div>
        <span class="font-bold text-emerald-700">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($alamats as $alamat)
        <div class="bg-white rounded-[2.5rem] p-8 border shadow-sm relative overflow-hidden group transition-all hover:shadow-md" style="border-color: {{ $alamat->utama ? 'var(--gold)' : 'var(--gold-pale)' }}; background: {{ $alamat->utama ? 'var(--cream)' : 'white' }};">
            @if($alamat->utama)
            <div class="absolute top-0 right-0">
                <span class="text-white text-[9px] font-black px-5 py-2 rounded-bl-2xl uppercase tracking-widest" style="background: var(--gold);">Utama</span>
            </div>
            @endif

            <div class="flex justify-between items-start mb-6">
                <span class="px-3 py-1 bg-white border rounded-lg text-[9px] font-black uppercase tracking-widest" style="color: var(--text-light); border-color: var(--gold-pale);">{{ $alamat->label }}</span>
            </div>

            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--leaf-dark);" class="mb-1">{{ $alamat->nama_penerima }}</h3>
            <p class="text-[0.7rem] font-bold uppercase tracking-widest mb-4" style="color: var(--text-mid);">{{ $alamat->no_telepon }}</p>
            <div class="pt-4 border-t mb-8" style="border-color: var(--gold-pale);">
                <p class="text-sm font-medium leading-relaxed" style="color: var(--text-mid);">
                    {{ $alamat->alamat_lengkap }}<br>
                    {{ $alamat->kecamatan?->nama ?? 'Indramayu' }}, {{ $alamat->kota }} {{ $alamat->kode_pos }}
                </p>
            </div>

            <div class="flex items-center gap-6">
                @if(!$alamat->utama)
                <form action="{{ route('pembeli.alamat.utama', $alamat->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-[10px] font-black uppercase tracking-widest transition-colors hover:text-var(--gold)" style="color: var(--text-light);">Set Utama</button>
                </form>
                @endif
                <button type="button" @click="openEditModal({{ json_encode($alamat->load('kecamatan')) }})" class="text-[10px] font-black uppercase tracking-widest transition-colors hover:text-var(--text-dark)" style="color: var(--text-light);">Edit</button>
                <form action="{{ route('pembeli.alamat.destroy', $alamat->id) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-400 hover:text-red-600 transition-colors">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center bg-white rounded-[3.5rem] border-2 border-dashed" style="border-color: var(--gold-pale);">
            <div class="w-20 h-20 bg-var(--gold-pale) rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-4xl opacity-20" style="color: var(--gold);">location_off</span>
            </div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);" class="mb-2">Belum Ada Alamat</h3>
            <p class="text-sm" style="color: var(--text-light);">Tambahkan alamat pengiriman untuk mulai berbelanja.</p>
        </div>
        @endforelse
    </div>

    <!-- Modal Form (Alpine JS) -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-[200] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-black/60 backdrop-blur-md" @click="modalOpen = false"></div>
            
            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" 
                 class="relative bg-white rounded-[3rem] w-full max-w-2xl p-10 md:p-14 shadow-2xl border" style="border-color: var(--gold-pale);">
                <div class="flex justify-between items-center mb-10">
                    <h2 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--leaf-dark);" x-text="editMode ? 'Edit Alamat' : 'Alamat Baru'"></h2>
                    <button @click="modalOpen = false" class="w-10 h-10 rounded-full bg-var(--gold-pale) flex items-center justify-center hover:bg-var(--gold)/20 transition-colors" style="color: var(--gold);">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <form :action="formAction" method="POST" class="space-y-8">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[0.65rem] font-bold uppercase tracking-[0.15em] ml-2" style="color: var(--text-light);">Label Alamat</label>
                            <input type="text" name="label" x-model="addressData.label" placeholder="Rumah, Kantor..." class="w-full px-6 py-4 bg-var(--cream) border rounded-2xl focus:ring-4 focus:ring-var(--gold-pale) outline-none transition-all font-bold" style="border-color: var(--gold-pale); color: var(--text-dark);" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[0.65rem] font-bold uppercase tracking-[0.15em] ml-2" style="color: var(--text-light);">Nama Penerima</label>
                            <input type="text" name="nama_penerima" x-model="addressData.nama_penerima" placeholder="Nama Lengkap" class="w-full px-6 py-4 bg-var(--cream) border rounded-2xl focus:ring-4 focus:ring-var(--gold-pale) outline-none transition-all font-bold" style="border-color: var(--gold-pale); color: var(--text-dark);" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[0.65rem] font-bold uppercase tracking-[0.15em] ml-2" style="color: var(--text-light);">Nomor Telepon</label>
                            <input type="text" name="no_telepon" x-model="addressData.no_telepon" placeholder="08..." class="w-full px-6 py-4 bg-var(--cream) border rounded-2xl focus:ring-4 focus:ring-var(--gold-pale) outline-none transition-all font-bold" style="border-color: var(--gold-pale); color: var(--text-dark);" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[0.65rem] font-bold uppercase tracking-[0.15em] ml-2" style="color: var(--text-light);">Kecamatan (Indramayu)</label>
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
                                        class="w-full px-6 py-4 bg-var(--cream) border rounded-2xl focus:ring-4 focus:ring-var(--gold-pale) outline-none transition-all flex justify-between items-center text-left" style="border-color: var(--gold-pale);">
                                    <span x-text="addressData.kecamatan_nama" :class="addressData.kecamatan_id ? 'text-var(--text-dark) font-bold' : 'text-var(--text-light) font-bold'"></span>
                                    <span class="material-symbols-outlined text-var(--text-light) transition-transform" :class="open ? 'rotate-180' : ''">keyboard_arrow_down</span>
                                </button>

                                <div x-show="open" @click.away="open = false" 
                                     class="absolute z-[210] w-full mt-2 bg-white border rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200" style="border-color: var(--gold-pale);">
                                    <div class="p-3 border-b" style="border-color: var(--gold-pale);">
                                        <input type="text" x-model="search" placeholder="Cari..." 
                                               class="w-full px-4 py-2 bg-var(--cream) border-none rounded-xl text-sm focus:ring-1 focus:ring-var(--gold) outline-none">
                                    </div>
                                    <div class="max-h-48 overflow-y-auto">
                                        <template x-for="kec in filteredKecamatans" :key="kec.id">
                                            <div @click="select(kec)" 
                                                 class="px-6 py-4 hover:bg-var(--gold-pale)/30 cursor-pointer transition-colors text-sm font-bold"
                                                 :style="addressData.kecamatan_id == kec.id ? 'color: var(--gold); background: var(--cream);' : 'color: var(--text-dark);'">
                                                <span x-text="kec.nama"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[0.65rem] font-bold uppercase tracking-[0.15em] ml-2" style="color: var(--text-light);">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" x-model="addressData.alamat_lengkap" rows="3" placeholder="Jl. Mangga No..." class="w-full px-8 py-6 bg-var(--cream) border rounded-[2rem] focus:ring-4 focus:ring-var(--gold-pale) outline-none transition-all font-bold resize-none" style="border-color: var(--gold-pale); color: var(--text-dark);" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[0.65rem] font-bold uppercase tracking-[0.15em] ml-2" style="color: var(--text-light);">Kota/Kabupaten</label>
                            <input type="text" name="kota" x-model="addressData.kota" class="w-full px-6 py-4 bg-var(--cream) border rounded-2xl focus:ring-4 focus:ring-var(--gold-pale) outline-none transition-all font-bold" style="border-color: var(--gold-pale); color: var(--text-dark);" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[0.65rem] font-bold uppercase tracking-[0.15em] ml-2" style="color: var(--text-light);">Kode Pos</label>
                            <input type="text" name="kode_pos" x-model="addressData.kode_pos" placeholder="452..." class="w-full px-6 py-4 bg-var(--cream) border rounded-2xl focus:ring-4 focus:ring-var(--gold-pale) outline-none transition-all font-bold" style="border-color: var(--gold-pale); color: var(--text-dark);" required>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-5 rounded-2xl border" style="background: var(--cream); border-color: var(--gold-pale);">
                        <input type="checkbox" name="utama" id="form-utama" value="1" x-model="addressData.utama" class="w-6 h-6 rounded border-gray-300 text-var(--gold) focus:ring-var(--gold)">
                        <label for="form-utama" class="text-[0.65rem] font-black uppercase tracking-widest" style="color: var(--text-dark);">Jadikan Alamat Utama</label>
                    </div>

                    <div class="flex gap-4 pt-6">
                        <button type="button" @click="modalOpen = false" class="flex-1 py-5 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest transition-all" style="background: var(--cream); color: var(--text-light);">Batal</button>
                        <button type="submit" class="flex-[2] py-5 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest transition-all shadow-xl" style="background: var(--text-dark); color: white;">Simpan Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
