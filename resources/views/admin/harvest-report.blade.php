<x-admin-layout>
    <x-slot name="title">Manajemen Laporan & Penjualan</x-slot>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-on-surface tracking-tight">Manajemen Laporan</h1>
            <p class="text-base text-on-surface-variant mt-1">Audit produksi, monitoring tanam, dan analisis omset transaksi.</p>
        </div>
        <div class="flex items-center gap-3">
            @if($tab === 'automatic')
            <div class="relative group">
                <button class="px-4 py-2 bg-primary-600 text-white rounded-xl text-sm font-bold flex items-center gap-2 premium-shadow hover:bg-primary-700 transition-all">
                    <span class="material-symbols-outlined text-[18px]">export_notes</span>
                    Export Report
                </button>
            </div>
            @endif
            <button onclick="location.reload()" class="p-2.5 bg-surface-container-low border border-outline-variant text-on-surface-variant rounded-xl hover:bg-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">refresh</span>
            </button>
        </div>
    </div>

    <!-- Stats Summary (Only for Sales tab) -->
    @if($tab === 'sales')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-primary-600 rounded-[32px] p-8 text-white relative overflow-hidden premium-shadow">
            <div class="relative z-10">
                <p class="text-primary-100 text-sm font-bold uppercase tracking-wider mb-2">Total Omset Keseluruhan</p>
                <h2 class="text-4xl font-black mb-4">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h2>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 rounded-full text-xs font-bold">
                    <span class="material-symbols-outlined text-sm">trending_up</span>
                    +12.5% from last month
                </div>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[160px] opacity-10 rotate-12">payments</span>
        </div>
        <div class="bg-secondary-600 rounded-[32px] p-8 text-white relative overflow-hidden premium-shadow">
            <div class="relative z-10">
                <p class="text-secondary-100 text-sm font-bold uppercase tracking-wider mb-2">Omset Bulan Ini</p>
                <h2 class="text-4xl font-black mb-4">Rp {{ number_format($thisMonthOmset, 0, ',', '.') }}</h2>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 rounded-full text-xs font-bold">
                    <span class="material-symbols-outlined text-sm">target</span>
                    Target: Rp 50.000.000
                </div>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[160px] opacity-10 rotate-12">monitoring</span>
        </div>
    </div>
    @endif

    <!-- Tab Navigation -->
    <div class="flex items-center gap-1 bg-surface-container-low p-1.5 rounded-2xl mb-8 w-fit border border-outline-variant overflow-x-auto max-w-full">
        <a href="{{ route('admin.harvest-report', ['tab' => 'harvest']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'harvest' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">inventory_2</span>
            Laporan Panen
        </a>
        <a href="{{ route('admin.harvest-report', ['tab' => 'planting']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'planting' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">potted_plant</span>
            Laporan Tanam
        </a>
        <a href="{{ route('admin.harvest-report', ['tab' => 'sales']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'sales' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">shopping_cart</span>
            Laporan Penjualan
        </a>
        <a href="{{ route('admin.harvest-report', ['tab' => 'automatic']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'automatic' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">auto_awesome</span>
            Otomasi Report
        </a>
        <a href="{{ route('admin.harvest-report', ['tab' => 'dataset_kuartal']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'dataset_kuartal' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">analytics</span>
            Dataset Kuartal BPS
        </a>
        <a href="{{ route('admin.harvest-report', ['tab' => 'dataset_prediksi']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'dataset_prediksi' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">trending_up</span>
            Dataset Tahunan (Prediksi)
        </a>
    </div>

    @if($tab === 'harvest')
    <!-- HARVEST TAB -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-[32px] overflow-hidden premium-shadow mb-8">
        <div class="p-6 border-b border-outline-variant bg-surface-container-lowest flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="font-bold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary-600">inventory_2</span>
                Daftar Laporan Panen Petani
            </h3>
            <form action="{{ route('admin.harvest-report') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <input type="hidden" name="tab" value="harvest">
                <select name="petani" class="bg-surface border-outline-variant rounded-xl text-xs font-bold px-4 py-2 focus:ring-primary-500">
                    <option value="">Semua Petani</option>
                    @foreach($petanis as $p)
                        <option value="{{ $p->id }}" {{ request('petani') == $p->id ? 'selected' : '' }}>{{ $p->user->nama }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-surface border-outline-variant rounded-xl text-xs font-bold px-4 py-2">
                <button type="submit" class="p-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-all">
                    <span class="material-symbols-outlined text-[20px]">filter_list</span>
                </button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[11px] font-black tracking-widest border-b border-outline-variant">
                        <th class="px-6 py-4">Petani & Lahan</th>
                        <th class="px-6 py-4">Tanggal Panen</th>
                        <th class="px-6 py-4 text-center">Produksi</th>
                        <th class="px-6 py-4">Jenis Mangga</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($reports as $report)
                    <tr class="hover:bg-primary-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 font-bold border border-primary-100">
                                    {{ substr($report->petani->user->nama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-on-surface group-hover:text-primary-600 transition-colors">{{ $report->petani->user->nama }}</div>
                                    <div class="text-[10px] text-on-surface-variant font-bold uppercase">{{ $report->lahan->nama ?? 'Lahan Utama' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">{{ $report->tanggal_panen->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-full text-xs font-bold border border-primary-100">
                                {{ number_format($report->jumlah_kg, 1) }} Kg
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-on-surface-variant">{{ $report->jenis_mangga }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusStyles = [
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'rejected' => 'bg-red-50 text-red-700 border-red-200'
                                ];
                                $style = $statusStyles[$report->status] ?? $statusStyles['pending'];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $style }}">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openVerifyModal('harvest', {{ $report->id }}, '{{ $report->petani->user->nama }}', '{{ $report->jumlah_kg }} Kg')" 
                                    class="p-2 hover:bg-primary-100 rounded-lg text-primary-600 transition-all">
                                <span class="material-symbols-outlined text-[20px]">assignment_turned_in</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant text-sm">Belum ada laporan panen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
        <div class="p-6 border-t border-outline-variant">
            {{ $reports->links() }}
        </div>
        @endif
    </div>

    @elseif($tab === 'planting')
    <!-- PLANTING TAB -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-[32px] overflow-hidden premium-shadow mb-8">
        <div class="p-6 border-b border-outline-variant bg-surface-container-lowest">
            <h3 class="font-bold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">nature_people</span>
                Monitor Laporan Tanam Petani
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[11px] font-black tracking-widest border-b border-outline-variant">
                        <th class="px-6 py-4">Petani & Lahan</th>
                        <th class="px-6 py-4 text-center">Tgl Tanam</th>
                        <th class="px-6 py-4 text-center">Bibit (Pohon)</th>
                        <th class="px-6 py-4">Konsistensi Lahan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($reports as $report)
                    <tr class="hover:bg-emerald-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 font-bold border border-emerald-100">
                                    {{ substr($report->petani->user->nama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-on-surface group-hover:text-emerald-600 transition-colors">{{ $report->petani->user->nama }}</div>
                                    <div class="text-[10px] text-on-surface-variant font-bold uppercase">{{ $report->lahan->nama }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-medium">{{ $report->tanggal_tanam->format('d/m/y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-on-surface">{{ $report->jumlah_bibit }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $isConsistent = $report->jumlah_bibit <= ($report->lahan->luas_lahan * 0.05); // Simple logic
                            @endphp
                            @if($isConsistent)
                                <div class="flex items-center gap-1.5 text-emerald-600">
                                    <span class="material-symbols-outlined text-[16px] font-bold">check_circle</span>
                                    <span class="text-[10px] font-black uppercase">Sesuai Kapasitas</span>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5 text-amber-600">
                                    <span class="material-symbols-outlined text-[16px] font-bold">error</span>
                                    <span class="text-[10px] font-black uppercase">Potensi Overload</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                             <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $report->status === 'approved' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                             <button onclick="openVerifyModal('planting', {{ $report->id }}, '{{ $report->petani->user->nama }}', '{{ $report->jumlah_bibit }} Pohon')" 
                                    class="p-2 hover:bg-emerald-100 rounded-lg text-emerald-600 transition-all">
                                <span class="material-symbols-outlined text-[20px]">fact_check</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant text-sm">Belum ada laporan tanam.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @elseif($tab === 'sales')
    <!-- SALES TAB -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-[32px] overflow-hidden premium-shadow mb-8">
        <div class="p-6 border-b border-outline-variant bg-surface-container-lowest flex items-center justify-between">
            <h3 class="font-bold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">receipt_long</span>
                Log Transaksi Penjualan
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[11px] font-black tracking-widest border-b border-outline-variant">
                        <th class="px-6 py-4">Invoice & Pembeli</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-right">Total Transaksi</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-black text-primary-600 text-sm">#{{ $trx->kode_pesanan }}</div>
                            <div class="text-xs font-bold text-on-surface-variant">{{ $trx->pembeli->user->nama ?? 'Guest' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">{{ $trx->created_at->format('d M, H:i') }}</td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-black text-on-surface">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $sClass = [
                                    'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'dikirim' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'diproses' => 'bg-sky-50 text-sky-700 border-sky-200',
                                    'menunggu_pembayaran' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'dibatalkan' => 'bg-red-50 text-red-700 border-red-200'
                                ][$trx->status] ?? 'bg-surface-container-low text-on-surface-variant';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $sClass }}">
                                {{ str_replace('_', ' ', $trx->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="w-8 h-8 rounded-xl bg-surface-container-low text-on-surface-variant flex items-center justify-center hover:bg-white hover:text-primary-600 transition-all shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant text-sm">Belum ada data penjualan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @elseif($tab === 'automatic')
    <!-- AUTOMATIC REPORT TAB -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow relative overflow-hidden">
            <div class="w-16 h-16 rounded-[24px] bg-primary-50 text-primary-600 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-[32px]">schedule_send</span>
            </div>
            <h3 class="text-2xl font-black text-on-surface mb-2">Penjadwalan Report</h3>
            <p class="text-on-surface-variant text-sm mb-8 leading-relaxed">Aktifkan pengiriman laporan otomatis ke stakeholder untuk transparansi data berkala.</p>
            
            <div class="space-y-4">
                <div class="p-4 bg-surface rounded-3xl border border-outline-variant flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600">
                            <span class="material-symbols-outlined text-[20px]">today</span>
                        </div>
                        <span class="text-sm font-bold">Daily Production Summary</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-surface-container-high rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                </div>
                <div class="p-4 bg-surface rounded-3xl border border-outline-variant flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600">
                            <span class="material-symbols-outlined text-[20px]">calendar_view_week</span>
                        </div>
                        <span class="text-sm font-bold">Weekly Sales Analysis</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-surface-container-high rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
            <div class="w-16 h-16 rounded-[24px] bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-[32px]">group_add</span>
            </div>
            <h3 class="text-2xl font-black text-on-surface mb-2">Stakeholders</h3>
            <p class="text-on-surface-variant text-sm mb-8 leading-relaxed">Kelola daftar penerima laporan otomatis (Manager, Investor, Mitra).</p>
            
            <div class="flex gap-2 mb-6">
                <input type="email" placeholder="email@stakeholder.com" class="flex-1 bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500">
                <button class="px-6 py-3 bg-on-surface text-white rounded-2xl text-sm font-bold hover:opacity-90 transition-all">Add</button>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <span class="px-4 py-2 bg-surface-container-low border border-outline-variant rounded-xl text-xs font-bold flex items-center gap-2">
                    ceo@mangofresh.com
                    <span class="material-symbols-outlined text-[14px] cursor-pointer hover:text-red-600">close</span>
                </span>
                <span class="px-4 py-2 bg-surface-container-low border border-outline-variant rounded-xl text-xs font-bold flex items-center gap-2">
                    investor@venture.com
                    <span class="material-symbols-outlined text-[14px] cursor-pointer hover:text-red-600">close</span>
                </span>
            </div>
        </div>
    </div>
    @elseif($tab === 'dataset_kuartal')
    <!-- DATASET KUARTAL BPS TAB -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-[32px] overflow-hidden premium-shadow mb-8">
        <div class="p-6 border-b border-outline-variant bg-surface-container-lowest flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-600">analytics</span>
                    Dataset Kuartal BPS Indramayu
                </h3>
                <p class="text-xs text-on-surface-variant mt-1">Data historis triwulanan BPS per kecamatan.</p>
            </div>
            <form action="{{ route('admin.harvest-report') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <input type="hidden" name="tab" value="dataset_kuartal">
                
                <!-- Custom Kecamatan Dropdown -->
                <div class="relative custom-select-container w-full md:w-auto text-left" id="select-kecamatan-container">
                    <input type="hidden" name="kecamatan" id="input-kecamatan" value="{{ request('kecamatan') }}">
                    <button type="button" id="btn-kecamatan" class="w-full md:w-56 bg-surface border border-outline-variant rounded-xl text-xs font-bold px-4 py-2.5 focus:ring-2 focus:ring-primary-500 text-on-surface flex items-center justify-between gap-2 shadow-sm min-w-[180px]">
                        <span id="label-kecamatan">
                            @if(request('kecamatan') && $kecamatans->firstWhere('id', request('kecamatan')))
                                {{ $kecamatans->firstWhere('id', request('kecamatan'))->nama }}
                            @else
                                Semua Kecamatan
                            @endif
                        </span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-200">keyboard_arrow_down</span>
                    </button>
                    <!-- Dropdown Panel -->
                    <div id="panel-kecamatan" class="hidden absolute left-0 right-0 md:left-auto md:right-0 mt-1.5 bg-surface border border-outline-variant rounded-xl shadow-xl z-50 overflow-hidden min-w-[220px]">
                        <div class="p-1.5 bg-surface border-b border-outline-variant">
                            <input type="text" id="search-kecamatan" placeholder="Cari kecamatan..." class="w-full bg-surface-container-low border border-outline-variant rounded-lg text-xs px-2.5 py-1.5 focus:outline-none focus:border-primary-500 text-on-surface">
                        </div>
                        <div class="options-list max-h-48 overflow-y-auto py-1 bg-surface divide-y divide-outline-variant/30">
                            <div class="option-item px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-primary-50 hover:text-primary-700 cursor-pointer transition-colors" data-value="">
                                Semua Kecamatan
                            </div>
                            @foreach($kecamatans as $k)
                                <div class="option-item px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-primary-50 hover:text-primary-700 cursor-pointer transition-colors" data-value="{{ $k->id }}">
                                    {{ $k->nama }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Custom Tahun Dropdown -->
                <div class="relative custom-select-container w-full md:w-auto text-left" id="select-tahun-container">
                    <input type="hidden" name="tahun" id="input-tahun" value="{{ request('tahun') }}">
                    <button type="button" id="btn-tahun" class="w-full md:w-40 bg-surface border border-outline-variant rounded-xl text-xs font-bold px-4 py-2.5 focus:ring-2 focus:ring-primary-500 text-on-surface flex items-center justify-between gap-2 shadow-sm min-w-[130px]">
                        <span id="label-tahun">
                            @if(request('tahun'))
                                {{ request('tahun') }}
                            @else
                                Semua Tahun
                            @endif
                        </span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-200">keyboard_arrow_down</span>
                    </button>
                    <!-- Dropdown Panel -->
                    <div id="panel-tahun" class="hidden absolute left-0 right-0 md:left-auto md:right-0 mt-1.5 bg-surface border border-outline-variant rounded-xl shadow-xl z-50 overflow-hidden min-w-[150px]">
                        <div class="options-list max-h-48 overflow-y-auto py-1 bg-surface divide-y divide-outline-variant/30">
                            <div class="option-item px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-primary-50 hover:text-primary-700 cursor-pointer transition-colors" data-value="">
                                Semua Tahun
                            </div>
                            @for($y = 2025; $y >= 2011; $y--)
                                <div class="option-item px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-primary-50 hover:text-primary-700 cursor-pointer transition-colors" data-value="{{ $y }}">
                                    {{ $y }}
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <button type="submit" class="p-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">filter_list</span>
                </button>
                <a href="{{ route('admin.harvest-report', ['tab' => 'dataset_kuartal']) }}" class="p-2.5 bg-surface-container-low border border-outline-variant text-on-surface-variant rounded-xl hover:bg-white transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">restart_alt</span>
                </a>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[11px] font-black tracking-widest border-b border-outline-variant">
                        <th class="px-6 py-4">Kecamatan</th>
                        <th class="px-6 py-4 text-center">Tahun</th>
                        <th class="px-6 py-4 text-center">Kuartal</th>
                        <th class="px-6 py-4 text-right">Produksi (Ton)</th>
                        <th class="px-6 py-4 text-right">Produksi (Kuintal)</th>
                        <th class="px-6 py-4">Mangga</th>
                        <th class="px-6 py-4">Cuaca</th>
                        <th class="px-6 py-4 text-center">Keberhasilan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($reports as $item)
                    <tr class="hover:bg-primary-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-500 text-[20px]">map</span>
                                <div class="font-bold text-on-surface">Kecamatan {{ $item->kecamatan->nama }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-semibold text-on-surface-variant">{{ $item->tahun }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2.5 py-1 bg-secondary-50 text-secondary-800 rounded-lg text-xs font-black border border-secondary-200">
                                {{ $item->kuartal }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-bold text-on-surface">{{ number_format($item->produksi_kuintal / 10, 2, ',', '.') }} Ton</span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-semibold text-on-surface-variant">{{ number_format($item->produksi_kuintal, 1, ',', '.') }} Kw</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-amber-50 text-amber-800 rounded-full text-xs font-bold border border-amber-200">
                                {{ $item->jenis_mangga ?? 'Harum Manis' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-blue-500">partly_cloudy_day</span>
                                {{ $item->cuaca ?? 'Cerah Berawan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusMap = [
                                    'Berhasil' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Berhasil Panen' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Kurang Panen' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'Tidak Berhasil' => 'bg-red-50 text-red-700 border-red-200',
                                    'Tidak Berhasil Panen' => 'bg-red-50 text-red-700 border-red-200'
                                ];
                                $badgeStyle = $statusMap[$item->keberhasilan_panen] ?? 'bg-surface-container-low text-on-surface-variant';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $badgeStyle }}">
                                {{ $item->keberhasilan_panen ?? 'N/A' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-on-surface-variant text-sm">Tidak ada data kuartal BPS yang cocok dengan filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
        <div class="p-6 border-t border-outline-variant bg-surface-container-lowest">
            {{ $reports->links() }}
        </div>
        @endif
    </div>

    @elseif($tab === 'dataset_prediksi')
    <!-- DATASET TAHUNAN (PREDIKSI) TAB -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-[32px] overflow-hidden premium-shadow mb-8">
        <div class="p-6 border-b border-outline-variant bg-surface-container-lowest flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-600">trending_up</span>
                    Dataset Tahunan & Prediksi BPS
                </h3>
                <p class="text-xs text-on-surface-variant mt-1">Data produksi tahunan historis (2011-2025) terintegrasi.</p>
            </div>
            <form action="{{ route('admin.harvest-report') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <input type="hidden" name="tab" value="dataset_prediksi">
                
                <!-- Custom Kecamatan Dropdown -->
                <div class="relative custom-select-container w-full md:w-auto text-left" id="select-kecamatan-container">
                    <input type="hidden" name="kecamatan" id="input-kecamatan" value="{{ request('kecamatan') }}">
                    <button type="button" id="btn-kecamatan" class="w-full md:w-56 bg-surface border border-outline-variant rounded-xl text-xs font-bold px-4 py-2.5 focus:ring-2 focus:ring-primary-500 text-on-surface flex items-center justify-between gap-2 shadow-sm min-w-[180px]">
                        <span id="label-kecamatan">
                            @if(request('kecamatan') && $kecamatans->firstWhere('id', request('kecamatan')))
                                {{ $kecamatans->firstWhere('id', request('kecamatan'))->nama }}
                            @else
                                Semua Kecamatan
                            @endif
                        </span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-200">keyboard_arrow_down</span>
                    </button>
                    <!-- Dropdown Panel -->
                    <div id="panel-kecamatan" class="hidden absolute left-0 right-0 md:left-auto md:right-0 mt-1.5 bg-surface border border-outline-variant rounded-xl shadow-xl z-50 overflow-hidden min-w-[220px]">
                        <div class="p-1.5 bg-surface border-b border-outline-variant">
                            <input type="text" id="search-kecamatan" placeholder="Cari kecamatan..." class="w-full bg-surface-container-low border border-outline-variant rounded-lg text-xs px-2.5 py-1.5 focus:outline-none focus:border-primary-500 text-on-surface">
                        </div>
                        <div class="options-list max-h-48 overflow-y-auto py-1 bg-surface divide-y divide-outline-variant/30">
                            <div class="option-item px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-primary-50 hover:text-primary-700 cursor-pointer transition-colors" data-value="">
                                Semua Kecamatan
                            </div>
                            @foreach($kecamatans as $k)
                                <div class="option-item px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-primary-50 hover:text-primary-700 cursor-pointer transition-colors" data-value="{{ $k->id }}">
                                    {{ $k->nama }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Custom Tahun Dropdown -->
                <div class="relative custom-select-container w-full md:w-auto text-left" id="select-tahun-container">
                    <input type="hidden" name="tahun" id="input-tahun" value="{{ request('tahun') }}">
                    <button type="button" id="btn-tahun" class="w-full md:w-40 bg-surface border border-outline-variant rounded-xl text-xs font-bold px-4 py-2.5 focus:ring-2 focus:ring-primary-500 text-on-surface flex items-center justify-between gap-2 shadow-sm min-w-[130px]">
                        <span id="label-tahun">
                            @if(request('tahun'))
                                {{ request('tahun') }}
                            @else
                                Semua Tahun
                            @endif
                        </span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-200">keyboard_arrow_down</span>
                    </button>
                    <!-- Dropdown Panel -->
                    <div id="panel-tahun" class="hidden absolute left-0 right-0 md:left-auto md:right-0 mt-1.5 bg-surface border border-outline-variant rounded-xl shadow-xl z-50 overflow-hidden min-w-[150px]">
                        <div class="options-list max-h-48 overflow-y-auto py-1 bg-surface divide-y divide-outline-variant/30">
                            <div class="option-item px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-primary-50 hover:text-primary-700 cursor-pointer transition-colors" data-value="">
                                Semua Tahun
                            </div>
                            @for($y = 2025; $y >= 2011; $y--)
                                <div class="option-item px-4 py-2 text-xs font-bold text-on-surface-variant hover:bg-primary-50 hover:text-primary-700 cursor-pointer transition-colors" data-value="{{ $y }}">
                                    {{ $y }}
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <button type="submit" class="p-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">filter_list</span>
                </button>
                <a href="{{ route('admin.harvest-report', ['tab' => 'dataset_prediksi']) }}" class="p-2.5 bg-surface-container-low border border-outline-variant text-on-surface-variant rounded-xl hover:bg-white transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">restart_alt</span>
                </a>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[11px] font-black tracking-widest border-b border-outline-variant">
                        <th class="px-6 py-4">Kecamatan</th>
                        <th class="px-6 py-4 text-center">Tahun</th>
                        <th class="px-6 py-4 text-right">Total Produksi (Ton)</th>
                        <th class="px-6 py-4 text-right">Luas Lahan BPS (Ha)</th>
                        <th class="px-6 py-4">Mangga Dominan</th>
                        <th class="px-6 py-4">Cuaca Dominan</th>
                        <th class="px-6 py-4 text-center">Hasil Panen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($reports as $item)
                    <tr class="hover:bg-primary-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-500 text-[20px]">location_on</span>
                                <div class="font-bold text-on-surface">Kecamatan {{ $item->kecamatan->nama }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-semibold text-on-surface-variant">
                            @if($item->tahun >= 2024)
                                <span class="px-2 py-0.5 bg-primary-100 text-primary-800 rounded font-black text-[10px] uppercase align-middle mr-1.5 border border-primary-200">PREDIKSI</span>
                            @endif
                            {{ $item->tahun }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-black text-primary-700">{{ number_format($item->produksi_kuintal / 10, 2, ',', '.') }} Ton</span>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-on-surface">
                            {{ number_format($item->luas_hektar, 2, ',', '.') }} Ha
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-800 rounded-full text-xs font-bold border border-emerald-200">
                                {{ $item->jenis_mangga ?? 'Harum Manis' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-amber-500">sunny</span>
                                {{ $item->cuaca ?? 'Cerah Berawan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusMap = [
                                    'Berhasil' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Berhasil Panen' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Kurang Panen' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'Tidak Berhasil' => 'bg-red-50 text-red-700 border-red-200',
                                    'Tidak Berhasil Panen' => 'bg-red-50 text-red-700 border-red-200'
                                ];
                                $badgeStyle = $statusMap[$item->keberhasilan_panen] ?? 'bg-surface-container-low text-on-surface-variant';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $badgeStyle }}">
                                {{ $item->keberhasilan_panen ?? 'N/A' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant text-sm">Tidak ada data tahunan/prediksi yang cocok dengan filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
        <div class="p-6 border-t border-outline-variant bg-surface-container-lowest">
            {{ $reports->links() }}
        </div>
        @endif
    </div>
    @endif

    <!-- VERIFICATION MODAL -->
    <div id="verifyModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-on-surface/40 backdrop-blur-sm"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-4">
            <div class="bg-surface-container-lowest rounded-[40px] shadow-2xl overflow-hidden border border-outline-variant">
                <div class="p-8 border-b border-outline-variant">
                    <h3 class="text-2xl font-black text-on-surface mb-1">Verifikasi Laporan</h3>
                    <p class="text-on-surface-variant text-sm" id="modalSubTitle">Audit data inputan petani.</p>
                </div>
                <form id="verifyForm" method="POST" class="p-8">
                    @csrf
                    <div class="p-4 bg-surface-container-low rounded-[24px] border border-outline-variant mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest mb-1">Objek</p>
                                <p class="font-bold text-on-surface" id="modalPetaniName">-</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest mb-1">Value</p>
                                <p class="font-bold text-on-surface" id="modalValue">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-8">
                        <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Catatan Audit</label>
                        <textarea name="catatan" class="w-full bg-surface border-outline-variant rounded-[24px] p-4 text-sm font-medium focus:ring-primary-500 min-h-[100px]" placeholder="Berikan alasan approve/reject..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" name="status" value="rejected" class="py-4 bg-red-50 text-red-600 rounded-[24px] font-bold hover:bg-red-600 hover:text-white transition-all">Reject</button>
                        <button type="submit" name="status" value="approved" class="py-4 bg-primary-600 text-white rounded-[24px] font-bold hover:bg-primary-700 transition-all premium-shadow">Approve</button>
                    </div>
                </form>
                <button onclick="closeVerifyModal()" class="absolute top-6 right-6 text-on-surface-variant hover:text-on-surface">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function openVerifyModal(type, id, petani, value) {
            const modal = document.getElementById('verifyModal');
            const form = document.getElementById('verifyForm');
            const title = document.getElementById('modalSubTitle');
            const pName = document.getElementById('modalPetaniName');
            const pValue = document.getElementById('modalValue');

            if(type === 'harvest') {
                form.action = `/admin/harvest-report/${id}/verify-harvest`;
                title.innerText = 'Audit laporan hasil panen petani.';
            } else {
                form.action = `/admin/harvest-report/${id}/verify-planting`;
                title.innerText = 'Audit laporan penanaman bibit.';
            }

            pName.innerText = petani;
            pValue.innerText = value;
            modal.classList.remove('hidden');
        }

        function closeVerifyModal() {
            document.getElementById('verifyModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Setup Custom Select Dropdowns
            setupCustomSelect('select-kecamatan-container', 'btn-kecamatan', 'panel-kecamatan', 'input-kecamatan', 'label-kecamatan', 'search-kecamatan');
            setupCustomSelect('select-tahun-container', 'btn-tahun', 'panel-tahun', 'input-tahun', 'label-tahun');

            function setupCustomSelect(containerId, btnId, panelId, inputId, labelId, searchId = null) {
                const container = document.getElementById(containerId);
                if (!container) return;

                const btn = document.getElementById(btnId);
                const panel = document.getElementById(panelId);
                const input = document.getElementById(inputId);
                const label = document.getElementById(labelId);
                const arrow = btn.querySelector('.material-symbols-outlined');
                const searchInput = searchId ? document.getElementById(searchId) : null;
                const options = panel.querySelectorAll('.option-item');

                // Toggle open/close
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    // Close all other dropdown panels
                    document.querySelectorAll('.custom-select-container div[id^="panel-"]').forEach(p => {
                        if (p.id !== panelId) p.classList.add('hidden');
                    });
                    document.querySelectorAll('.custom-select-container button').forEach(b => {
                        const arr = b.querySelector('.material-symbols-outlined');
                        if (b.id !== btnId && arr) arr.style.transform = 'rotate(0deg)';
                    });

                    const isOpen = !panel.classList.contains('hidden');
                    if (isOpen) {
                        panel.classList.add('hidden');
                        arrow.style.transform = 'rotate(0deg)';
                    } else {
                        panel.classList.remove('hidden');
                        arrow.style.transform = 'rotate(180deg)';
                        if (searchInput) {
                            searchInput.value = '';
                            filterOptions('');
                            setTimeout(() => searchInput.focus(), 50);
                        }
                    }
                });

                // Search options if enabled
                if (searchInput) {
                    searchInput.addEventListener('input', function (e) {
                        filterOptions(e.target.value);
                    });
                    searchInput.addEventListener('click', function (e) {
                        e.stopPropagation(); // keep open when interacting with search input
                    });
                }

                function filterOptions(query) {
                    const cleanQuery = query.toLowerCase().trim();
                    options.forEach(opt => {
                        const text = opt.innerText.toLowerCase();
                        if (text.includes(cleanQuery)) {
                            opt.style.display = 'block';
                        } else {
                            opt.style.display = 'none';
                        }
                    });
                }

                // Option selection
                options.forEach(opt => {
                    opt.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const val = this.getAttribute('data-value');
                        const text = this.innerText;
                        
                        input.value = val;
                        label.innerText = text;
                        panel.classList.add('hidden');
                        arrow.style.transform = 'rotate(0deg)';
                    });
                });
            }

            // Close dropdowns on clicking outside
            document.addEventListener('click', function () {
                document.querySelectorAll('.custom-select-container div[id^="panel-"]').forEach(p => {
                    p.classList.add('hidden');
                });
                document.querySelectorAll('.custom-select-container button .material-symbols-outlined').forEach(arrow => {
                    arrow.style.transform = 'rotate(0deg)';
                });
            });
        });
    </script>

    <style>
        .premium-shadow {
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
        }
    </style>
</x-admin-layout>
