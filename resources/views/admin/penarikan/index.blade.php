<x-admin-layout>
    <x-slot name="title">Verifikasi Pencairan Dana Petani</x-slot>

    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <h2 class="text-4xl font-black text-on-surface tracking-tight mb-2">Penarikan <span class="text-primary-500">Dana</span></h2>
            <p class="text-on-surface-variant font-medium">Manajemen dan verifikasi pengajuan pencairan pendapatan petani.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl border border-emerald-100 flex items-center gap-3 animate-in fade-in duration-300">
            <span class="material-symbols-outlined">check_circle</span>
            <p class="text-sm font-bold">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-2xl border border-red-100 flex items-center gap-3 animate-in fade-in duration-300">
            <span class="material-symbols-outlined">error</span>
            <p class="text-sm font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Pending Requests Section -->
    @if($pendingRequests->count() > 0)
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                <h3 class="text-xl font-black text-on-surface">Menunggu Verifikasi</h3>
                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-black">{{ $pendingRequests->count() }} Ajuan</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($pendingRequests as $request)
                    <div class="bg-white rounded-[2.5rem] p-8 border border-outline-variant shadow-sm hover:shadow-xl transition-all group">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <p class="text-[10px] font-black text-primary-600 uppercase tracking-widest mb-1">{{ \Carbon\Carbon::parse($request->created_at)->translatedFormat('d M Y, H:i') }}</p>
                                <h4 class="text-lg font-black text-on-surface leading-tight">{{ $request->petani->user->name }}</h4>
                            </div>
                            <div class="w-12 h-12 bg-surface-container-low rounded-2xl flex items-center justify-center text-on-surface-variant overflow-hidden">
                                @if($request->petani->user->avatar)
                                    <img src="{{ asset('storage/' . $request->petani->user->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined">person</span>
                                @endif
                            </div>
                        </div>

                        <div class="bg-surface-container-low rounded-2xl p-5 border border-outline-variant mb-6 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-primary-500 rounded-full mix-blend-multiply filter blur-[30px] opacity-10 translate-x-1/2 -translate-y-1/2"></div>
                            <p class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1 relative z-10">Nominal Ajuan</p>
                            <p class="text-2xl font-black text-on-surface relative z-10">Rp {{ number_format($request->nominal, 0, ',', '.') }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-slate-50 rounded-2xl">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Bank</p>
                                <p class="text-xs font-bold text-slate-900">{{ $request->nama_bank }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">No Rekening</p>
                                <p class="text-xs font-bold text-slate-900">{{ $request->no_rekening }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Atas Nama</p>
                                <p class="text-xs font-bold text-slate-900">{{ $request->nama_rekening }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">No KTP (NIK)</p>
                                <p class="text-xs font-bold text-slate-900">{{ $request->no_ktp }}</p>
                            </div>
                            @if($request->foto_ktp)
                            <div class="col-span-2 mt-2">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Foto KTP</p>
                                <div class="w-full h-32 bg-slate-200 rounded-xl overflow-hidden border border-slate-300">
                                    <a href="{{ asset('storage/' . $request->foto_ktp) }}" target="_blank" class="block w-full h-full">
                                        <img src="{{ asset('storage/' . $request->foto_ktp) }}" class="w-full h-full object-cover hover:scale-105 transition-transform cursor-pointer" alt="Foto KTP">
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="flex gap-3">
                            <button onclick="document.getElementById('rejectModal_{{ $request->id }}').classList.remove('hidden')" class="w-full py-3.5 bg-surface-container-high hover:bg-red-50 hover:text-red-600 text-on-surface-variant rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Tolak</button>
                            <form action="{{ route('admin.penarikan.action', ['id' => $request->id, 'action' => 'terima']) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-emerald-600/20 active:scale-95">Setujui</button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Tolak -->
                    <div id="rejectModal_{{ $request->id }}" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-on-surface/80 backdrop-blur-md p-4">
                        <div class="bg-white rounded-[3rem] p-10 max-w-md w-full shadow-2xl border border-outline-variant animate-in zoom-in duration-300">
                            <div class="w-16 h-16 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center mb-6">
                                <span class="material-symbols-outlined text-3xl">block</span>
                            </div>
                            <h3 class="text-2xl font-black text-on-surface mb-2">Tolak Pencairan</h3>
                            <p class="text-on-surface-variant font-medium mb-8">Berikan alasan penolakan agar petani dapat memperbaikinya (misal: nama rekening tidak sesuai KTP).</p>
                            
                            <form action="{{ route('admin.penarikan.action', ['id' => $request->id, 'action' => 'tolak']) }}" method="POST" class="space-y-6">
                                @csrf
                                <div>
                                    <label class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest mb-3 block">Alasan Penolakan</label>
                                    <textarea name="catatan" required rows="3" class="w-full bg-surface-container-low border border-outline-variant text-on-surface rounded-2xl p-5 focus:ring-primary-500 focus:border-primary-500 font-medium text-sm placeholder-on-surface-variant/40" placeholder="Alasan penolakan..."></textarea>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button" onclick="document.getElementById('rejectModal_{{ $request->id }}').classList.add('hidden')" class="py-4 bg-surface-container-high text-on-surface-variant rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-surface-container-highest transition-all">Batal</button>
                                    <button type="submit" class="py-4 bg-red-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl shadow-red-600/20">Tolak Ajuan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Daftar Petani -->
    <div class="bg-white rounded-[3.5rem] border border-outline-variant shadow-sm overflow-hidden">
        <div class="p-10 border-b border-surface-container flex justify-between items-center bg-surface-container-low/20">
            <div>
                <h3 class="text-xl font-black text-on-surface uppercase tracking-tight">Daftar Akun Petani</h3>
                <p class="text-xs text-on-surface-variant font-bold uppercase tracking-widest mt-1">Ringkasan Pendapatan & Saldo</p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/50">
                        <th class="px-10 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Petani</th>
                        <th class="px-6 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest text-right">Total Pendapatan</th>
                        <th class="px-6 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest text-right">Telah Ditarik</th>
                        <th class="px-6 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest text-right">Saldo Tersedia</th>
                        <th class="px-10 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    @forelse($petanis as $petani)
                    <tr class="hover:bg-surface-container-low/50 transition-colors group">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-surface-container-high rounded-full overflow-hidden shrink-0">
                                    @if($petani->user->avatar)
                                        <img src="{{ asset('storage/' . $petani->user->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-on-surface-variant">
                                            <span class="material-symbols-outlined">person</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black text-on-surface">{{ $petani->user->name }}</p>
                                    <p class="text-[10px] text-on-surface-variant font-medium mt-0.5">{{ $petani->user->email }}</p>
                                    @if($petani->pending_requests > 0)
                                        <span class="inline-block mt-2 px-2 py-1 bg-amber-100 text-amber-700 rounded-md text-[8px] font-black uppercase tracking-widest">{{ $petani->pending_requests }} Ajuan Menunggu</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-right">
                            <p class="text-xs font-bold text-slate-600">Rp {{ number_format($petani->total_pendapatan, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-6 text-right">
                            <p class="text-xs font-bold text-emerald-600">Rp {{ number_format($petani->total_ditarik, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-6 text-right">
                            <p class="text-sm font-black text-primary-600">Rp {{ number_format($petani->saldo_tersedia, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <a href="{{ route('admin.penarikan.show', $petani->id) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-surface-container-high text-on-surface-variant hover:bg-primary-500 hover:text-white transition-all shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-surface-container-low rounded-full flex items-center justify-center text-on-surface-variant/30 mb-4">
                                    <span class="material-symbols-outlined text-5xl">group_off</span>
                                </div>
                                <p class="text-xs font-black text-on-surface-variant uppercase tracking-widest">Belum ada data petani terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
