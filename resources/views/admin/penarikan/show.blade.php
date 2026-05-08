<x-admin-layout>
    <x-slot name="title">Detail Riwayat Penarikan</x-slot>

    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('admin.penarikan.index') }}" class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:bg-primary-50 hover:text-primary-600 transition-all">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                </a>
                <h2 class="text-4xl font-black text-on-surface tracking-tight">Detail <span class="text-primary-500">Petani</span></h2>
            </div>
            <p class="text-on-surface-variant font-medium">Riwayat lengkap pencairan dana untuk {{ $petani->user->name }}.</p>
        </div>
    </div>

    <!-- Farmer Profile Card -->
    <div class="bg-white rounded-[3.5rem] border border-outline-variant shadow-sm overflow-hidden mb-12">
        <div class="p-10 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-50 rounded-full mix-blend-multiply filter blur-[100px] opacity-50 translate-x-1/3 -translate-y-1/3"></div>
            
            <div class="w-32 h-32 bg-surface-container-high rounded-full overflow-hidden shrink-0 border-4 border-white shadow-xl relative z-10">
                @if($petani->user->avatar)
                    <img src="{{ asset('storage/' . $petani->user->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl">person</span>
                    </div>
                @endif
            </div>

            <div class="flex-1 text-center md:text-left relative z-10">
                <h3 class="text-3xl font-black text-on-surface mb-1">{{ $petani->user->name }}</h3>
                <p class="text-sm font-bold text-on-surface-variant mb-6">{{ $petani->user->email }}</p>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-surface-container-low rounded-2xl border border-outline-variant">
                        <p class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1">Total Pendapatan</p>
                        <p class="text-base font-black text-slate-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-surface-container-low rounded-2xl border border-outline-variant">
                        <p class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1">Total Ditarik</p>
                        <p class="text-base font-black text-emerald-600">Rp {{ number_format($riwayat->where('status', 'disetujui')->sum('nominal'), 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-surface-container-low rounded-2xl border border-outline-variant">
                        <p class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1">Saldo Tersedia</p>
                        <p class="text-base font-black text-primary-600">Rp {{ number_format($totalPendapatan - $riwayat->where('status', 'disetujui')->sum('nominal'), 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-surface-container-low rounded-2xl border border-outline-variant">
                        <p class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1">Bank Default</p>
                        <p class="text-xs font-bold text-slate-900 uppercase">{{ $petani->nama_bank ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="bg-white rounded-[3.5rem] border border-outline-variant shadow-sm overflow-hidden">
        <div class="p-10 border-b border-surface-container flex justify-between items-center bg-surface-container-low/20">
            <div>
                <h3 class="text-xl font-black text-on-surface uppercase tracking-tight">Riwayat Pengajuan</h3>
                <p class="text-xs text-on-surface-variant font-bold uppercase tracking-widest mt-1">Semua transaksi penarikan dana</p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/50">
                        <th class="px-10 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Waktu Transaksi</th>
                        <th class="px-6 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest text-center">Nominal</th>
                        <th class="px-6 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Detail Bank Tujuan</th>
                        <th class="px-10 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Catatan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    @forelse($riwayat as $item)
                    <tr class="hover:bg-surface-container-low/50 transition-colors group">
                        <td class="px-10 py-6">
                            <p class="text-xs font-bold text-slate-900">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</p>
                            <p class="text-[10px] text-on-surface-variant font-medium">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <p class="text-sm font-black text-slate-900">Rp {{ number_format($item->nominal, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <span class="px-3 py-1.5 text-[9px] font-black uppercase tracking-widest rounded-lg 
                                @if($item->status == 'pending') bg-amber-100 text-amber-700
                                @elseif($item->status == 'disetujui') bg-emerald-100 text-emerald-700
                                @else bg-red-100 text-red-700 @endif
                            ">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <p class="text-xs font-bold text-slate-900 uppercase">{{ $item->nama_bank }}</p>
                                <p class="text-[10px] text-on-surface-variant font-medium font-mono">{{ $item->no_rekening }}</p>
                                <p class="text-[9px] text-on-surface-variant uppercase tracking-widest mt-1">A.N: {{ $item->nama_rekening }}</p>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            @if($item->catatan_admin)
                                <div class="p-3 rounded-xl @if($item->status == 'ditolak') bg-red-50 text-red-700 @else bg-surface-container-low text-on-surface-variant @endif">
                                    <p class="text-[10px] font-medium leading-relaxed">{{ $item->catatan_admin }}</p>
                                </div>
                            @else
                                <p class="text-xs font-bold text-on-surface-variant/40 italic">-</p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-surface-container-low rounded-full flex items-center justify-center text-on-surface-variant/30 mb-4">
                                    <span class="material-symbols-outlined text-5xl">history</span>
                                </div>
                                <p class="text-xs font-black text-on-surface-variant uppercase tracking-widest">Belum ada riwayat penarikan dana</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
