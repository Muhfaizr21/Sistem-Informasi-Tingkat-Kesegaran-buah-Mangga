<x-petani-layout>
    <x-slot name="title">Profil Petani</x-slot>

    <!-- Header / Cover Section -->
    <div class="relative mb-40">
        <div class="h-56 md:h-72 bg-gradient-to-br from-slate-900 via-slate-800 to-primary-600 rounded-[4rem] shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary-500/20 rounded-full blur-[100px]"></div>
        </div>
        <div class="absolute -bottom-24 left-10 flex flex-col md:flex-row items-end gap-8">
            <div class="relative group">
                <div class="w-40 h-40 md:w-48 md:h-48 rounded-[3.5rem] border-[10px] border-white shadow-2xl overflow-hidden bg-slate-100">
                    <img src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama) . '&background=10B981&color=fff&size=512' }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Profile">
                </div>
                <label class="absolute inset-[10px] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm opacity-0 group-hover:opacity-100 rounded-[3rem] transition-all duration-300 cursor-pointer border-2 border-white/20">
                    <span class="material-symbols-outlined text-white text-4xl">photo_camera</span>
                    <input type="file" form="form-profile" name="foto_profil" class="hidden">
                </label>
            </div>
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ auth()->user()->nama }}</h1>
                    <span class="material-symbols-outlined text-primary-500 fill-1 text-2xl">verified</span>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <span class="px-4 py-1.5 bg-primary-500/10 text-primary-500 text-[10px] font-black rounded-full uppercase tracking-[0.2em] border border-primary-500/20 shadow-sm">Verified Farmer</span>
                    <span class="text-slate-400 font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">groups</span>
                        {{ $petani->kelompok_tani ?? 'Independent Producer' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-16 right-10 hidden lg:flex gap-6">
            <div class="bg-white p-6 rounded-[2.5rem] shadow-xl border border-slate-50 text-center min-w-[140px] hover:scale-105 transition-transform duration-300">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Trust Score</p>
                <div class="flex items-center justify-center gap-1">
                    <p class="text-2xl font-black text-slate-900 tracking-tighter">4.9</p>
                    <span class="material-symbols-outlined text-secondary fill-1 text-lg">star</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2.5rem] shadow-xl border border-slate-50 text-center min-w-[140px] hover:scale-105 transition-transform duration-300">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Annual Yield</p>
                <p class="text-2xl font-black text-slate-900 tracking-tighter">1.2K <span class="text-xs text-slate-400 font-medium">Kg</span></p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-12 p-6 bg-primary-50 text-primary-600 rounded-3xl border border-primary-100 flex items-center gap-4 animate-in slide-in-from-top duration-500">
            <span class="material-symbols-outlined text-2xl">check_circle</span>
            <span class="font-bold text-sm uppercase tracking-widest">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Sidebar Navigation Tabs -->
        <div class="lg:col-span-3 space-y-3">
            <button onclick="switchTab('info')" id="btn-info" class="tab-btn w-full flex items-center justify-between px-8 py-5 rounded-3xl bg-primary-500 text-white font-black shadow-2xl shadow-primary-500/20 transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-xl">account_circle</span>
                    <span class="text-xs uppercase tracking-[0.2em]">Personal Data</span>
                </div>
                <span class="material-symbols-outlined text-sm opacity-50 group-hover:translate-x-1 transition-transform">chevron_right</span>
            </button>
            <button onclick="switchTab('verification')" id="btn-verification" class="tab-btn w-full flex items-center justify-between px-8 py-5 rounded-3xl text-slate-500 hover:bg-slate-50 font-bold transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-xl">verified_user</span>
                    <span class="text-xs uppercase tracking-[0.2em]">Verification</span>
                </div>
                <span class="material-symbols-outlined text-sm opacity-0 group-hover:opacity-50 group-hover:translate-x-1 transition-all">chevron_right</span>
            </button>
            <button onclick="switchTab('security')" id="btn-security" class="tab-btn w-full flex items-center justify-between px-8 py-5 rounded-3xl text-slate-500 hover:bg-slate-50 font-bold transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-xl">security</span>
                    <span class="text-xs uppercase tracking-[0.2em]">Credentials</span>
                </div>
                <span class="material-symbols-outlined text-sm opacity-0 group-hover:opacity-50 group-hover:translate-x-1 transition-all">chevron_right</span>
            </button>
        </div>

        <!-- Tab Content -->
        <div class="lg:col-span-9">
            <!-- Information Tab -->
            <div id="tab-info" class="tab-content">
                <div class="bg-white p-10 md:p-14 rounded-[4rem] border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-10 opacity-5">
                        <span class="material-symbols-outlined text-[120px]">assignment_ind</span>
                    </div>
                    
                    <form id="form-profile" action="{{ route('petani.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-12 relative z-10">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-8">
                                <h3 class="text-xl font-extrabold text-slate-900 border-b border-slate-50 pb-6 tracking-tight">Identitas Personal</h3>
                                <div class="space-y-6">
                                    <div class="group">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Nama Lengkap Sesuai KTP</label>
                                        <input type="text" name="nama" value="{{ auth()->user()->nama }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
                                    </div>
                                    <div class="group opacity-70">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Nomor Induk Kependudukan (NIK)</label>
                                        <div class="relative">
                                            <input type="text" value="{{ $petani->nik }}" disabled class="w-full bg-slate-100 border-none rounded-2xl px-6 py-5 text-slate-400 font-bold cursor-not-allowed italic">
                                            <span class="material-symbols-outlined absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 text-sm">lock</span>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Nomor WhatsApp Aktif</label>
                                        <input type="text" name="no_hp" value="{{ auth()->user()->no_hp }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner">
                                    </div>
                                    <div class="group">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Alamat Domisili Lengkap</label>
                                        <textarea name="alamat" rows="4" class="w-full bg-slate-50 border-none rounded-3xl px-8 py-6 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner resize-none">{{ auth()->user()->alamat }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-8">
                                <h3 class="text-xl font-extrabold text-slate-900 border-b border-slate-50 pb-6 tracking-tight">Kredensial Usaha & Perbankan</h3>
                                <div class="space-y-6">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="group">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Pengalaman (Thn)</label>
                                            <input type="number" name="pengalaman_tahun" value="{{ $petani->pengalaman_tahun }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner">
                                        </div>
                                        <div class="group">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Grup Tani</label>
                                            <input type="text" name="kelompok_tani" value="{{ $petani->kelompok_tani }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner">
                                        </div>
                                    </div>
                                    <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 space-y-6">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Pengaturan Pembayaran</p>
                                        <div class="group">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Nama Instansi Perbankan</label>
                                            <input type="text" name="nama_bank" value="{{ $petani->nama_bank }}" placeholder="Contoh: BANK CENTRAL ASIA (BCA)" class="w-full bg-white border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-sm">
                                        </div>
                                        <div class="group">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Nomor Rekening Tujuan</label>
                                            <input type="text" name="rekening_bank" value="{{ $petani->rekening_bank }}" placeholder="000-000-0000" class="w-full bg-white border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-10 border-t border-slate-50 flex justify-end">
                            <button type="submit" class="px-12 py-6 bg-primary-500 text-white font-black rounded-[2rem] shadow-2xl shadow-primary-500/30 hover:scale-105 transition-all active:scale-95 uppercase tracking-[0.2em] text-xs">
                                Update Data Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Verification Tab -->
            <div id="tab-verification" class="tab-content hidden">
                <div class="bg-white p-10 md:p-14 rounded-[4rem] border border-slate-100 shadow-sm space-y-12">
                    <div class="flex items-center gap-6 p-8 bg-primary-500/5 rounded-[3rem] border border-primary-500/10 relative overflow-hidden group">
                        <div class="w-16 h-16 bg-primary-500 rounded-[1.5rem] flex items-center justify-center text-white shrink-0 shadow-lg shadow-primary-500/20">
                            <span class="material-symbols-outlined text-3xl">verified_user</span>
                        </div>
                        <div class="relative z-10">
                            <h4 class="text-xl font-extrabold text-primary-600 mb-1 tracking-tight">Status Validasi: {{ strtoupper($petani->status_verifikasi) }}</h4>
                            <p class="text-xs text-primary-500/70 font-medium uppercase tracking-widest leading-relaxed">Pastikan seluruh dokumen identitas legal telah diunggah untuk akses fitur eksklusif.</p>
                        </div>
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-primary-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                    </div>

                    <form action="{{ route('petani.profil.documents') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        @csrf
                        <div class="group relative p-10 border-4 border-dashed border-slate-100 rounded-[3.5rem] text-center space-y-6 hover:border-primary-500 hover:bg-primary-50/30 transition-all duration-500">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto group-hover:bg-primary-500 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-3xl">badge</span>
                            </div>
                            <div>
                                <h5 class="text-lg font-extrabold text-slate-900 mb-1 tracking-tight">Foto E-KTP Asli</h5>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Minimal Resolusi 1080p</p>
                            </div>
                            @if($petani->dokumen_ktp)
                                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-500/10 text-primary-500 rounded-full text-[10px] font-black uppercase tracking-widest border border-primary-500/20">
                                    <span class="material-symbols-outlined text-[14px] fill-1">check_circle</span> Terunggah
                                </div>
                            @endif
                            <input type="file" name="dokumen_ktp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="pt-4">
                                <p class="text-[9px] text-slate-400 italic">Klik atau seret file ke area ini</p>
                            </div>
                        </div>

                        <div class="group relative p-10 border-4 border-dashed border-slate-100 rounded-[3.5rem] text-center space-y-6 hover:border-secondary hover:bg-secondary/5 transition-all duration-500">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto group-hover:bg-secondary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-3xl">landscape</span>
                            </div>
                            <div>
                                <h5 class="text-lg font-extrabold text-slate-900 mb-1 tracking-tight">Sertifikat / Bukti Lahan</h5>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Surat Keterangan Pengelolaan</p>
                            </div>
                            @if($petani->dokumen_lahan)
                                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-secondary/10 text-secondary rounded-full text-[10px] font-black uppercase tracking-widest border border-secondary/20">
                                    <span class="material-symbols-outlined text-[14px] fill-1">check_circle</span> Terunggah
                                </div>
                            @endif
                            <input type="file" name="dokumen_lahan" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="pt-4">
                                <p class="text-[9px] text-slate-400 italic">Klik atau seret file ke area ini</p>
                            </div>
                        </div>

                        <div class="md:col-span-2 flex justify-center pt-8">
                            <button type="submit" class="px-12 py-6 bg-slate-900 text-white font-black rounded-[2rem] hover:bg-black transition-all active:scale-95 uppercase tracking-[0.2em] text-xs shadow-2xl shadow-slate-900/20">
                                Submit Dokumen Verifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="tab-security" class="tab-content hidden">
                <div class="bg-white p-10 md:p-14 rounded-[4rem] border border-slate-100 shadow-sm max-w-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-10 opacity-5">
                        <span class="material-symbols-outlined text-[120px]">security</span>
                    </div>

                    <h3 class="text-2xl font-extrabold text-slate-900 border-b border-slate-50 pb-8 mb-10 tracking-tight">Proteksi Kredensial</h3>
                    <form action="{{ route('petani.profil.password') }}" method="POST" class="space-y-8 relative z-10">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-red-500 transition-colors">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-red-500/10 outline-none font-bold text-slate-700 shadow-inner">
                            </div>
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Kata Sandi Baru</label>
                                <input type="password" name="password" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner">
                            </div>
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner">
                            </div>
                        </div>
                        <div class="pt-6">
                            <button type="submit" class="w-full py-6 bg-slate-900 text-white font-black rounded-[2rem] hover:bg-black transition-all shadow-2xl shadow-slate-900/30 uppercase tracking-[0.2em] text-xs">
                                Perbarui Kredensial Keamanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabId) {
            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            // Remove active styles from buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-primary-500', 'text-white', 'shadow-2xl', 'shadow-primary-500/20');
                btn.classList.add('text-slate-500', 'hover:bg-slate-50', 'font-bold');
                
                // Hide chevron icon for inactive
                const chevron = btn.querySelector('span:last-child');
                if(chevron) chevron.classList.add('opacity-0');
            });

            // Show target content
            document.getElementById('tab-' + tabId).classList.remove('hidden');
            // Add active styles to clicked button
            const activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.remove('text-slate-500', 'hover:bg-slate-50', 'font-bold');
            activeBtn.classList.add('bg-primary-500', 'text-white', 'shadow-2xl', 'shadow-primary-500/20');
            
            // Show chevron icon for active
            const activeChevron = activeBtn.querySelector('span:last-child');
            if(activeChevron) activeChevron.classList.remove('opacity-0');
        }
    </script>
</x-petani-layout>
