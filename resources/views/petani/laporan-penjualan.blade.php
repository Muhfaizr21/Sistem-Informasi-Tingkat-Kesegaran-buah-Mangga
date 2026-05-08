<x-petani-layout>
    <x-slot name="title">Laporan Penjualan</x-slot>

    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Laporan Penjualan</h2>
            <p class="text-slate-500 font-medium">Analisis performa penjualan buah mangga Anda.</p>
        </div>
        
        <div class="flex items-center gap-3 bg-white p-2 rounded-3xl shadow-sm border border-slate-100">
            <a href="?range=hari_ini" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $range == 'hari_ini' ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/30' : 'text-slate-400 hover:text-slate-600' }}">Hari Ini</a>
            <a href="?range=minggu_ini" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $range == 'minggu_ini' ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/30' : 'text-slate-400 hover:text-slate-600' }}">Minggu Ini</a>
            <a href="?range=bulan_ini" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $range == 'bulan_ini' ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/30' : 'text-slate-400 hover:text-slate-600' }}">Bulan Ini</a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm group hover:shadow-xl transition-all duration-500">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-3xl">shopping_cart</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Pesanan</p>
                    <p class="text-2xl font-black text-slate-900">{{ $totalPesanan }}</p>
                </div>
            </div>
            <div class="h-1.5 bg-slate-50 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 w-full animate-progress"></div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm group hover:shadow-xl transition-all duration-500">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-primary-50 rounded-2xl flex items-center justify-center text-primary-500 group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-3xl">scale</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Volume Terjual</p>
                    <p class="text-2xl font-black text-slate-900">{{ number_format($totalKg, 1) }} <span class="text-xs text-slate-400">Kg</span></p>
                </div>
            </div>
            <div class="h-1.5 bg-slate-50 rounded-full overflow-hidden">
                <div class="h-full bg-primary-500 w-full animate-progress"></div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm group hover:shadow-xl transition-all duration-500">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-3xl">payments</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Pendapatan</p>
                    <p class="text-2xl font-black text-slate-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="h-1.5 bg-slate-50 rounded-full overflow-hidden">
                <div class="h-full bg-amber-500 w-full animate-progress"></div>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/20">
            <div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Rincian Penjualan</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Data Transaksi Real-Time</p>
            </div>
            <button class="px-6 py-3 bg-slate-900 text-white text-[10px] font-black rounded-2xl hover:bg-black transition-all active:scale-95 uppercase tracking-widest flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">download</span> Export PDF
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Transaksi</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kode Pesanan</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Produk / Varietas</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Volume</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Harga Satuan</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($penjualan as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-10 py-6">
                            <p class="text-xs font-bold text-slate-900">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase tracking-wider group-hover:bg-white group-hover:shadow-sm transition-all">
                                #{{ $item->kode_pesanan }}
                            </span>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center text-primary-500 font-black text-[10px]">
                                    {{ substr($item->jenis_mangga, 0, 1) }}
                                </div>
                                <p class="text-xs font-black text-slate-900">Mangga {{ $item->jenis_mangga }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <p class="text-xs font-black text-slate-900">{{ number_format($item->jumlah_kg, 1) }} <span class="text-[9px] text-slate-400">Kg</span></p>
                        </td>
                        <td class="px-6 py-6 text-right">
                            <p class="text-xs font-bold text-slate-600">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <p class="text-sm font-black text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4">
                                    <span class="material-symbols-outlined text-5xl">receipt_long</span>
                                </div>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Belum ada transaksi pada periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-petani-layout>
