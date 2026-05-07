<x-admin-layout>
    <div class="space-y-8">
        <!-- Header Section with Glassmorphism -->
        <div class="relative overflow-hidden bg-on-surface rounded-[2.5rem] p-8 md:p-12 text-white premium-shadow">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-primary-500/10 to-transparent"></div>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <nav class="flex items-center gap-2 text-white/50 text-xs font-bold uppercase tracking-widest mb-4">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-400 transition-colors">Dashboard</a>
                        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                        <span class="text-white">Manajemen Pesanan</span>
                    </nav>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tighter mb-2">
                        Monitor <span class="text-primary-400">Transaksi</span>
                    </h1>
                    <p class="text-white/60 font-medium max-w-xl">
                        Kelola alur distribusi mangga Indramayu dari hulu ke hilir dengan sistem pelacakan pesanan real-time.
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.verifikasi-pembayaran') }}" class="px-6 py-4 bg-primary-500 text-on-surface rounded-2xl font-black text-sm hover:scale-105 active:scale-95 transition-all flex items-center gap-3 shadow-lg shadow-primary-500/20">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                        Verifikasi Pembayaran
                    </a>
                </div>
            </div>

            <!-- Mini Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 border-t border-white/10 pt-8">
                <div class="bg-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/10">
                    <p class="text-white/50 text-[10px] font-black uppercase tracking-widest mb-1">Total Pesanan</p>
                    <p class="text-2xl font-black">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/10">
                    <p class="text-white/50 text-[10px] font-black uppercase tracking-widest mb-1">Butuh Tindakan</p>
                    <p class="text-2xl font-black text-amber-400">{{ number_format($stats['pending']) }}</p>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/10">
                    <p class="text-white/50 text-[10px] font-black uppercase tracking-widest mb-1">Dalam Proses</p>
                    <p class="text-2xl font-black text-blue-400">{{ number_format($stats['processed']) }}</p>
                </div>
                <div class="bg-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/10">
                    <p class="text-white/50 text-[10px] font-black uppercase tracking-widest mb-1">Total Omset</p>
                    <p class="text-2xl font-black text-primary-400">Rp{{ number_format($stats['revenue']/1000000, 1) }}M</p>
                </div>
            </div>
        </div>

        <!-- Filter & Table Section -->
        <div class="bg-white rounded-[2.5rem] premium-shadow-sm border border-outline-variant overflow-hidden">
            <!-- Tab Filters -->
            <div class="flex items-center gap-2 p-4 md:p-6 border-b border-outline-variant overflow-x-auto no-scrollbar">
                @php
                    $tabs = [
                        'semua' => 'Semua',
                        'menunggu_bayar' => 'Menunggu Bayar',
                        'menunggu_verifikasi' => 'Verifikasi',
                        'dikonfirmasi' => 'Diproses',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Batal'
                    ];
                    $currentStatus = $status ?? 'semua';
                @endphp

                @foreach($tabs as $key => $label)
                <a href="{{ route('admin.pesanan.index', ['status' => $key]) }}" 
                   class="px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all whitespace-nowrap
                   {{ $currentStatus === $key ? 'bg-on-surface text-white shadow-xl' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-8 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-[0.2em]">ID Pesanan</th>
                            <th class="px-8 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-[0.2em]">Mitra & Produk</th>
                            <th class="px-8 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-[0.2em]">Total Pembayaran</th>
                            <th class="px-8 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-[0.2em]">Metode & Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-on-surface-variant uppercase tracking-[0.2em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse($pesanans as $pesanan)
                        <tr class="hover:bg-primary-50/30 transition-colors group">
                            <!-- Order ID -->
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-on-surface tracking-tight">{{ $pesanan->kode_pesanan }}</span>
                                    <span class="text-[10px] font-bold text-on-surface-variant mt-1">{{ $pesanan->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                            </td>

                            <!-- Mitra & Product Info -->
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-surface-container-high flex items-center justify-center text-on-surface font-black text-xs">
                                        {{ substr($pesanan->pembeli->user->name ?? 'P', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-on-surface">{{ $pesanan->pembeli->user->name ?? 'Pembeli' }}</span>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                                            <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider italic">
                                                {{ $pesanan->items->first()->listing->petani->user->name ?? 'Petani' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Amount -->
                            <td class="px-8 py-6 text-right md:text-left">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-on-surface">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                                    <span class="text-[10px] font-bold text-on-surface-variant mt-1 uppercase">{{ $pesanan->items->sum('kuantitas_kg') }} Kg • {{ $pesanan->items->count() }} Varietas</span>
                                </div>
                            </td>

                            <!-- Status & Payment -->
                            <td class="px-8 py-6">
                                <div class="flex flex-col gap-2">
                                    @php
                                        $statusConfig = [
                                            'menunggu_bayar' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'schedule', 'label' => 'Menunggu'],
                                            'menunggu_verifikasi' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'icon' => 'fact_check', 'label' => 'Verifikasi'],
                                            'dikonfirmasi' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'check_circle', 'label' => 'Diterima'],
                                            'dikemas' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'icon' => 'package_2', 'label' => 'Dikemas'],
                                            'dikirim' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'icon' => 'local_shipping', 'label' => 'Dikirim'],
                                            'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'verified', 'label' => 'Selesai'],
                                            'dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'cancel', 'label' => 'Batal'],
                                        ];
                                        $config = $statusConfig[$pesanan->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'icon' => 'help', 'label' => $pesanan->status];
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest flex items-center gap-1.5 {{ $config['bg'] }} {{ $config['text'] }}">
                                            <span class="material-symbols-outlined text-[14px]">{{ $config['icon'] }}</span>
                                            {{ $config['label'] }}
                                        </span>
                                    </div>
                                    <span class="text-[9px] font-bold text-on-surface-variant uppercase tracking-widest px-1">
                                        {{ str_replace('_', ' ', $pesanan->metode_pembayaran) }} • {{ str_replace('_', ' ', $pesanan->metode_pengiriman) }}
                                    </span>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <button class="p-2 rounded-xl bg-surface-container-high text-on-surface hover:bg-on-surface hover:text-white transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </button>
                                    @if($pesanan->status === 'menunggu_verifikasi')
                                    <form action="{{ route('admin.pesanan.konfirmasi', $pesanan->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="p-2 rounded-xl bg-primary-100 text-primary-700 hover:bg-primary-500 hover:text-white transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-[18px]">check</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 rounded-full bg-surface-container-low flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[40px] text-on-surface-variant opacity-20">inventory_2</span>
                                    </div>
                                    <div>
                                        <p class="text-on-surface font-black text-lg tracking-tight">Data Pesanan Kosong</p>
                                        <p class="text-on-surface-variant text-sm mt-1">Belum ada transaksi yang sesuai dengan kriteria filter ini.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-outline-variant bg-surface-container-lowest/50">
                {{ $pesanans->appends(['status' => $status])->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
