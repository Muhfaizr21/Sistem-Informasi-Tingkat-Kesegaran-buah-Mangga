<x-admin-layout>
<div class="p-6">
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight mb-2">Monitor <span class="text-emerald-400">Transaksi</span></h1>
            <p class="text-slate-400 font-medium">Pantau semua pesanan yang masuk di sistem Mango Marketplace.</p>
        </div>
        <a href="{{ route('admin.verifikasi-pembayaran') }}" class="px-6 py-3 bg-indigo-500/20 text-indigo-300 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-500/30 transition-all flex items-center gap-2 border border-indigo-500/30">
            <span class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse"></span>
            Verifikasi Pembayaran
        </a>
    </div>

    <div class="bg-white/5 rounded-[2.5rem] border border-white/10 shadow-sm overflow-hidden backdrop-blur-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pesanan</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pembeli</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($pesanans as $pesanan)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-8 py-6">
                            <p class="text-sm font-black text-white mb-1">{{ $pesanan->kode_pesanan }}</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $pesanan->created_at->format('d M Y, H:i') }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-slate-300 font-black text-xs">
                                    {{ substr($pesanan->pembeli->user->name ?? 'P', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">{{ $pesanan->pembeli->user->name ?? '-' }}</p>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $pesanan->pembeli->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-black text-white">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $pesanan->items->count() }} Item</p>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusConfig = [
                                    'menunggu_bayar' => ['bg' => 'bg-amber-500/20', 'text' => 'text-amber-300', 'label' => 'Menunggu Bayar'],
                                    'menunggu_verifikasi' => ['bg' => 'bg-indigo-500/20', 'text' => 'text-indigo-300', 'label' => 'Verifikasi'],
                                    'dikonfirmasi' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-300', 'label' => 'Dikonfirmasi'],
                                    'dikemas' => ['bg' => 'bg-purple-500/20', 'text' => 'text-purple-300', 'label' => 'Dikemas'],
                                    'dikirim' => ['bg' => 'bg-orange-500/20', 'text' => 'text-orange-300', 'label' => 'Dikirim'],
                                    'selesai' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-300', 'label' => 'Selesai'],
                                    'dibatalkan' => ['bg' => 'bg-red-500/20', 'text' => 'text-red-300', 'label' => 'Batal'],
                                ];
                                $status = $statusConfig[$pesanan->status] ?? ['bg' => 'bg-slate-500/20', 'text' => 'text-slate-300', 'label' => $pesanan->status];
                            @endphp
                            <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $status['bg'] }} {{ $status['text'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <p class="text-slate-500 font-medium italic">Belum ada data pesanan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-admin-layout>
