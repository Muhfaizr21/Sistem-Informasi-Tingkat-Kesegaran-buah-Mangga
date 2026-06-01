<x-admin-layout>
    <x-slot name="title">Profil Admin</x-slot>

    <!-- Header / Cover Section -->
    <div class="relative mb-8">
        <div class="h-48 md:h-64 bg-gradient-to-br from-slate-900 via-slate-800 to-primary-600 rounded-[3rem] shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary-500/20 rounded-full blur-[100px]"></div>
        </div>
        
        <!-- Profile Info Card -->
        <div class="relative -mt-24 mx-4 md:mx-10 p-6 md:p-8 bg-white/95 backdrop-blur-md rounded-[2.5rem] border border-slate-100 shadow-xl flex flex-col lg:flex-row items-center justify-between gap-6">
            <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                <!-- Avatar -->
                <div class="relative group shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-[2.5rem] border-[6px] border-white shadow-xl overflow-hidden bg-slate-100">
                        <img src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama) . '&background=10B981&color=fff&size=512' }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" id="avatar-display" alt="Profile">
                    </div>
                    <label class="absolute inset-[6px] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm opacity-0 group-hover:opacity-100 rounded-[2rem] transition-all duration-300 cursor-pointer border border-white/20">
                        <span class="material-symbols-outlined text-white text-3xl">photo_camera</span>
                        <input type="file" form="form-profile" name="foto_profil" onchange="previewAvatar(this)" class="hidden">
                    </label>
                </div>
                
                <!-- Details -->
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-2 flex-wrap">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ auth()->user()->nama }}</h1>
                        <span class="material-symbols-outlined text-primary-500 fill-1 text-xl md:text-2xl">verified</span>
                    </div>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                        <span class="px-4 py-1.5 bg-primary-500/10 text-primary-500 text-[10px] font-black rounded-full uppercase tracking-[0.2em] border border-primary-500/20 shadow-sm">Super Admin</span>
                        <span class="text-slate-400 font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">mail</span>
                            {{ auth()->user()->email }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Quick System Stats -->
            <div class="flex gap-4 shrink-0">
                <div class="bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 text-center min-w-[120px] hover:scale-105 transition-transform duration-300">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">System Health</p>
                    <div class="flex items-center justify-center gap-1">
                        <p class="text-xl font-black text-emerald-500 tracking-tighter">100%</p>
                    </div>
                </div>
                <div class="bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 text-center min-w-[120px] hover:scale-105 transition-transform duration-300">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Security</p>
                    <p class="text-xl font-black text-slate-900 tracking-tighter">Active</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-12 p-6 bg-primary-50 text-primary-600 rounded-3xl border border-primary-100 flex items-center gap-4 animate-in slide-in-from-top duration-500">
            <span class="material-symbols-outlined text-2xl">check_circle</span>
            <span class="font-bold text-sm uppercase tracking-widest">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Sidebar Navigation Tabs -->
        <div class="lg:col-span-4 bg-white p-5 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-3 h-fit">
            <button onclick="switchTab('info')" id="btn-info" class="tab-btn w-full flex items-center justify-between px-5 py-4 rounded-2xl bg-primary-500 text-white font-black shadow-2xl shadow-primary-500/20 transition-all duration-300 group">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-lg shrink-0">account_circle</span>
                    <span class="text-xs uppercase tracking-[0.15em] whitespace-nowrap">Data Personal</span>
                </div>
                <span class="chevron-icon material-symbols-outlined text-sm opacity-50 group-hover:translate-x-1 transition-transform shrink-0">chevron_right</span>
            </button>
            <button onclick="switchTab('security')" id="btn-security" class="tab-btn w-full flex items-center justify-between px-5 py-4 rounded-2xl text-slate-500 hover:bg-slate-50 font-bold transition-all duration-300 group">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-lg shrink-0">security</span>
                    <span class="text-xs uppercase tracking-[0.15em] whitespace-nowrap">Kredensial Keamanan</span>
                </div>
                <span class="chevron-icon material-symbols-outlined text-sm opacity-0 group-hover:opacity-50 group-hover:translate-x-1 transition-all shrink-0">chevron_right</span>
            </button>
        </div>

        <!-- Tab Content -->
        <div class="lg:col-span-8">
            <!-- Information Tab -->
            <div id="tab-info" class="tab-content">
                <div class="bg-white p-10 md:p-14 rounded-[4rem] border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-10 opacity-5">
                        <span class="material-symbols-outlined text-[120px]">assignment_ind</span>
                    </div>
                    
                    @if ($errors->any())
                        <div class="mb-8 p-6 bg-red-50 text-red-600 rounded-3xl border border-red-100 space-y-2 animate-in slide-in-from-top duration-500">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-2xl">error</span>
                                <span class="font-bold text-sm uppercase tracking-widest">Terjadi Kesalahan Validasi</span>
                            </div>
                            <ul class="list-disc list-inside text-xs font-bold text-red-500 pl-7 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form id="form-profile" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-12 relative z-10">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-8">
                            <h3 class="text-xl font-extrabold text-slate-900 border-b border-slate-50 pb-6 tracking-tight">Identitas Personal Admin</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ auth()->user()->nama }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
                                </div>
                                <div class="group">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Alamat Email</label>
                                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
                                </div>
                                <div class="group">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Nomor Telepon</label>
                                    <input type="text" name="no_telepon" value="{{ auth()->user()->no_telepon }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner">
                                </div>
                                <div class="group">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Hak Akses Sistem</label>
                                    <div class="relative">
                                        <input type="text" value="Super Administrator" disabled class="w-full bg-slate-100 border border-slate-100 rounded-2xl px-6 py-5 text-slate-400 font-bold cursor-not-allowed italic">
                                        <span class="material-symbols-outlined absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 text-sm">lock</span>
                                    </div>
                                </div>
                                <div class="group md:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Alamat Domisili</label>
                                    <textarea name="alamat" rows="3" class="w-full bg-slate-50 border border-slate-100 rounded-3xl px-8 py-6 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner resize-none">{{ auth()->user()->alamat }}</textarea>
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

            <!-- Security Tab -->
            <div id="tab-security" class="tab-content hidden">
                <div class="bg-white p-10 md:p-14 rounded-[4rem] border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-10 opacity-5">
                        <span class="material-symbols-outlined text-[120px]">security</span>
                    </div>

                    <h3 class="text-2xl font-extrabold text-slate-900 border-b border-slate-50 pb-8 mb-10 tracking-tight">Proteksi Kredensial</h3>
                    <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-8 relative z-10">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-red-500 transition-colors">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-5 focus:ring-4 focus:ring-red-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
                            </div>
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Kata Sandi Baru</label>
                                <input type="password" name="password" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
                            </div>
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 group-focus-within:text-primary-500 transition-colors">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 shadow-inner" required>
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
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-primary-500', 'text-white', 'shadow-2xl', 'shadow-primary-500/20', 'font-black');
                btn.classList.add('text-slate-500', 'hover:bg-slate-50', 'font-bold');
                
                const chevron = btn.querySelector('.chevron-icon');
                if(chevron) {
                    chevron.classList.add('opacity-0');
                    chevron.classList.remove('opacity-50');
                }
            });

            document.getElementById('tab-' + tabId).classList.remove('hidden');
            const activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.remove('text-slate-500', 'hover:bg-slate-50', 'font-bold');
            activeBtn.classList.add('bg-primary-500', 'text-white', 'shadow-2xl', 'shadow-primary-500/20', 'font-black');
            
            const activeChevron = activeBtn.querySelector('.chevron-icon');
            if(activeChevron) {
                activeChevron.classList.remove('opacity-0');
                activeChevron.classList.add('opacity-50');
            }
        }

        function previewAvatar(input) {
            const preview = document.getElementById('avatar-display');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-admin-layout>
