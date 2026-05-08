@extends(Auth::user()->role === 'pembeli' ? 'layouts.pembeli' : 'layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="relative min-h-screen pb-20">
    <!-- Header -->
    <div class="mb-12 animate-in fade-in slide-in-from-left duration-700">
        <h1 class="text-4xl md:text-5xl font-black text-[#1b1b18] tracking-tight mb-2">Pengaturan <span class="text-[#FFB800]">Profil</span></h1>
        <p class="text-lg text-[#706f6c] font-medium">Kelola informasi akun dan keamanan Anda di sini.</p>
    </div>

    @if (session('status'))
    <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-[2rem] flex items-center gap-4 animate-in zoom-in duration-500 shadow-sm">
        <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <span class="font-bold">{{ session('status') === 'profile-updated' ? 'Profil berhasil diperbarui!' : (session('status') === 'password-updated' ? 'Kata sandi berhasil diubah!' : session('status')) }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left Sidebar: Info Profile -->
        <div class="lg:col-span-4 space-y-8 animate-in fade-in slide-in-from-left duration-1000">
            <div class="bg-white rounded-[3.5rem] p-10 border-2 border-gray-200 shadow-xl shadow-gray-200/50 text-center relative overflow-hidden group">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-orange-50 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform"></div>
                
                <div class="relative z-10">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-[2.5rem] bg-gradient-to-br from-[#FFB800] to-orange-500 p-1">
                        <div class="w-full h-full bg-white rounded-[2.3rem] flex items-center justify-center overflow-hidden">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-black text-[#FFB800]">{{ substr(Auth::user()->nama, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-[#1b1b18] mb-1">{{ Auth::user()->nama }}</h3>
                    <p class="text-sm text-gray-400 font-bold mb-6 tracking-wide">{{ Auth::user()->email }}</p>
                    
                    <div class="inline-flex px-4 py-2 bg-gray-50 border border-gray-100 rounded-2xl text-[10px] font-black text-gray-500 uppercase tracking-widest">
                        Member Since {{ Auth::user()->created_at->format('M Y') }}
                    </div>
                </div>
            </div>

            <!-- Stats or Info Box -->
            <div class="bg-[#1b1b18] rounded-[3rem] p-10 text-white relative overflow-hidden group shadow-2xl">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#FFB800] rounded-full blur-3xl opacity-20 group-hover:scale-150 transition-transform"></div>
                <div class="relative z-10">
                    <h4 class="text-xs font-black uppercase tracking-[0.3em] mb-4 text-[#FFB800]">Keamanan Akun</h4>
                    <p class="text-sm text-gray-400 leading-relaxed font-medium">Pastikan kata sandi Anda kuat dan ganti secara berkala untuk menjaga keamanan data Anda.</p>
                </div>
            </div>

            @if(Auth::user()->role === 'pembeli')
            <!-- Address Box -->
            <div class="bg-white rounded-[3.5rem] p-10 border-2 border-gray-200 shadow-xl shadow-gray-200/50 relative overflow-hidden group">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-[#1b1b18]">Lokasi & Alamat</h4>
                    <a href="{{ route('pembeli.alamat.index') }}" class="text-[#FFB800] hover:text-[#10B981] transition-colors p-3 bg-orange-50 rounded-[1rem] group-hover:bg-orange-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </a>
                </div>
                
                @php
                    $alamatUtama = Auth::user()->pembeli ? Auth::user()->pembeli->alamat()->where('utama', true)->first() : null;
                @endphp

                @if($alamatUtama)
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-[#1b1b18] text-white text-[9px] font-black uppercase tracking-widest rounded-lg">{{ $alamatUtama->label }}</span>
                            <span class="text-[9px] font-black text-[#FFB800] uppercase tracking-widest">Utama</span>
                        </div>
                        <p class="font-black text-[#1b1b18] text-lg">{{ $alamatUtama->nama_penerima }}</p>
                        <p class="text-xs font-bold text-gray-400">{{ $alamatUtama->no_telepon }}</p>
                        <p class="text-[11px] font-medium text-[#706f6c] leading-relaxed mt-2 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            {{ $alamatUtama->alamat_lengkap }}, {{ $alamatUtama->kecamatan->nama }}, {{ $alamatUtama->kota }}, {{ $alamatUtama->kode_pos }}
                        </p>
                    </div>
                @else
                    <div class="text-center py-6 border-2 border-dashed border-gray-200 rounded-[2rem] bg-gray-50/50">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-[#1b1b18] mb-1">Belum ada alamat</p>
                        <p class="text-[10px] font-medium text-gray-400 mb-6 px-4">Tambahkan alamat pengiriman untuk mulai belanja</p>
                        <a href="{{ route('pembeli.alamat.index') }}" class="inline-block px-6 py-3 bg-[#1b1b18] text-white rounded-[1.2rem] text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-black/10">
                            + Tambah Alamat
                        </a>
                    </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Right Column: Forms -->
        <div class="lg:col-span-8 space-y-12 animate-in fade-in slide-in-from-right duration-1000">
            <!-- Profile Info Form -->
            <div class="bg-white rounded-[3.5rem] p-10 lg:p-14 border-2 border-gray-200 shadow-xl shadow-gray-200/50">
                <div class="mb-10">
                    <h2 class="text-2xl font-black text-[#1b1b18] tracking-tight mb-2">Informasi Profil</h2>
                    <p class="text-sm text-gray-400 font-medium">Perbarui nama dan alamat email akun Anda.</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama', Auth::user()->nama) }}" placeholder="Masukkan nama lengkap Anda" class="w-full bg-gray-50 border border-gray-100 rounded-[1.5rem] p-5 text-[#1b1b18] font-bold focus:border-[#FFB800]/50 outline-none transition-all" required>
                            @error('nama') <p class="text-[10px] text-red-500 font-bold ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="Masukkan email yang valid" class="w-full bg-gray-50 border border-gray-100 rounded-[1.5rem] p-5 text-[#1b1b18] font-bold focus:border-[#FFB800]/50 outline-none transition-all" required>
                            @error('email') <p class="text-[10px] text-red-500 font-bold ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-10 py-5 bg-[#1b1b18] text-white rounded-[1.8rem] font-black text-xs tracking-widest uppercase hover:bg-black transition-all shadow-xl shadow-black/10 active:scale-95">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Form -->
            <div class="bg-white rounded-[3.5rem] p-10 lg:p-14 border-2 border-gray-200 shadow-xl shadow-gray-200/50">
                <div class="mb-10">
                    <h2 class="text-2xl font-black text-[#1b1b18] tracking-tight mb-2">Ubah Kata Sandi</h2>
                    <p class="text-sm text-gray-400 font-medium">Gunakan kata sandi yang panjang dan acak untuk keamanan ekstra.</p>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-8">
                    @csrf
                    @method('put')

                    <div class="space-y-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" placeholder="Masukkan kata sandi lama" class="w-full bg-gray-50 border border-gray-100 rounded-[1.5rem] p-5 text-[#1b1b18] font-bold focus:border-[#FFB800]/50 outline-none transition-all">
                            @error('current_password', 'updatePassword') <p class="text-[10px] text-red-500 font-bold ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Kata Sandi Baru</label>
                                <input type="password" name="password" placeholder="Masukkan kata sandi baru" class="w-full bg-gray-50 border border-gray-100 rounded-[1.5rem] p-5 text-[#1b1b18] font-bold focus:border-[#FFB800]/50 outline-none transition-all">
                                @error('password', 'updatePassword') <p class="text-[10px] text-red-500 font-bold ml-1 uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi sandi baru" class="w-full bg-gray-50 border border-gray-100 rounded-[1.5rem] p-5 text-[#1b1b18] font-bold focus:border-[#FFB800]/50 outline-none transition-all">
                                @error('password_confirmation', 'updatePassword') <p class="text-[10px] text-red-500 font-bold ml-1 uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-10 py-5 bg-[#FFB800] text-white rounded-[1.8rem] font-black text-xs tracking-widest uppercase hover:bg-[#10B981] transition-all shadow-xl shadow-orange-900/20 active:scale-95">
                            UPDATE KATA SANDI
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 rounded-[3.5rem] p-10 lg:p-14 border-2 border-red-200 shadow-xl shadow-red-100/50 overflow-hidden relative">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-red-100 rounded-full blur-3xl opacity-50"></div>
                
                <div class="relative z-10">
                    <h2 class="text-2xl font-black text-red-900 tracking-tight mb-2">Danger Zone</h2>
                    <p class="text-sm text-red-600/70 font-medium mb-10">Hapus akun secara permanen. Tindakan ini tidak dapat dibatalkan.</p>

                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="px-10 py-5 bg-red-600 text-white rounded-[1.8rem] font-black text-xs tracking-widest uppercase hover:bg-red-700 transition-all shadow-xl shadow-red-900/20 active:scale-95">
                        HAPUS AKUN SAYA
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Simple Modal for Deletion (Breeze Style adjusted) -->
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-10">
        @csrf
        @method('delete')

        <h2 class="text-2xl font-black text-[#1b1b18] tracking-tight mb-4">
            Apakah Anda yakin ingin menghapus akun?
        </h2>

        <p class="text-sm text-gray-500 mb-8 leading-relaxed">
            Setelah akun dihapus, semua data dan riwayat scan Anda akan hilang permanen. Masukkan kata sandi untuk konfirmasi.
        </p>

        <div class="mb-8">
            <input type="password" name="password" placeholder="Kata Sandi Konfirmasi" class="w-full bg-gray-50 border border-gray-100 rounded-[1.5rem] p-5 text-[#1b1b18] font-bold focus:border-red-500/50 outline-none transition-all">
            @error('password', 'userDeletion') <p class="text-[10px] text-red-500 font-bold mt-2 uppercase ml-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-4">
            <button type="button" x-on:click="$dispatch('close')" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-[1.5rem] font-black text-[10px] tracking-widest uppercase hover:bg-gray-200 transition-all">
                BATAL
            </button>
            <button type="submit" class="px-8 py-4 bg-red-600 text-white rounded-[1.5rem] font-black text-[10px] tracking-widest uppercase hover:bg-red-700 transition-all shadow-lg shadow-red-900/20">
                HAPUS PERMANEN
            </button>
        </div>
    </form>
</x-modal>
@endsection
