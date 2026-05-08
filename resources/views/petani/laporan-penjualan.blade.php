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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
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
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pendapatan (Periode)</p>
                    <p class="text-2xl font-black text-slate-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="h-1.5 bg-slate-50 rounded-full overflow-hidden">
                <div class="h-full bg-amber-500 w-full animate-progress"></div>
            </div>
        </div>
    </div>

    <!-- Saldo & Penarikan -->
    <div class="bg-slate-900 rounded-[3.5rem] p-10 mb-12 relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500 rounded-full mix-blend-multiply filter blur-[100px] opacity-20 translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-amber-500 rounded-full mix-blend-multiply filter blur-[100px] opacity-20 -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex-1 w-full">
                <h3 class="text-primary-400 font-black tracking-widest uppercase text-xs mb-2">Saldo Tersedia</h3>
                <div class="text-5xl md:text-6xl font-black text-white tracking-tighter mb-4">
                    <span class="text-3xl text-slate-400 align-top mr-1">Rp</span>{{ number_format($saldoTersedia, 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-4 text-sm font-medium text-slate-400">
                    <span>Total Keseluruhan: <strong class="text-white">Rp {{ number_format($pendapatanKeseluruhan, 0, ',', '.') }}</strong></span>
                    <span class="w-1 h-1 rounded-full bg-slate-600"></span>
                    <span>Telah Ditarik: <strong class="text-white">Rp {{ number_format($totalDitarik, 0, ',', '.') }}</strong></span>
                </div>
            </div>
            <div class="w-full md:w-auto flex flex-col gap-3">
                <button onclick="document.getElementById('tarikModal').classList.remove('hidden')" class="w-full md:w-auto px-8 py-4 bg-primary-500 hover:bg-primary-600 text-white rounded-2xl font-black uppercase tracking-widest transition-all shadow-lg shadow-primary-500/30 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">account_balance_wallet</span> Tarik Dana
                </button>
                <button onclick="document.getElementById('riwayatModal').classList.remove('hidden')" class="w-full md:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white rounded-2xl font-black uppercase tracking-widest transition-all backdrop-blur-md flex items-center justify-center gap-2 border border-white/10">
                    <span class="material-symbols-outlined">history</span> Riwayat Penarikan
                </button>
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

    <!-- Modal Tarik Dana -->
    <div id="tarikModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/80 backdrop-blur-md p-4 overflow-y-auto">
        <div class="bg-white rounded-[3rem] p-10 max-w-lg w-full shadow-2xl border border-slate-100 animate-in zoom-in duration-300 my-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-black text-slate-900">Tarik <span class="text-primary-500">Dana</span></h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Cairkan Pendapatan Anda</p>
                </div>
                <div class="w-12 h-12 bg-primary-50 text-primary-500 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">account_balance</span>
                </div>
            </div>

            @if($saldoTersedia < 10000)
                <div class="p-6 bg-red-50 text-red-600 rounded-2xl mb-6 border border-red-100 flex items-start gap-4">
                    <span class="material-symbols-outlined mt-1">error</span>
                    <div>
                        <p class="text-sm font-black mb-1">Saldo Tidak Cukup</p>
                        <p class="text-xs font-medium">Minimal penarikan dana adalah Rp 10.000.</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('tarikModal').classList.add('hidden')" class="w-full py-4 bg-slate-100 text-slate-500 hover:text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">TUTUP</button>
            @else
                <form action="{{ route('petani.penghasilan.tarik') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Nominal Penarikan (Rp)</label>
                        <input type="number" name="nominal" min="10000" max="{{ $saldoTersedia }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl p-5 focus:ring-primary-500 focus:border-primary-500 font-black text-xl placeholder-slate-300" placeholder="Contoh: 100000" value="{{ old('nominal') }}">
                        <p class="text-[10px] text-slate-400 font-medium mt-2">Maksimal: Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">No. KTP</label>
                            <input type="text" name="no_ktp" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl p-4 focus:ring-primary-500 focus:border-primary-500 font-bold text-sm placeholder-slate-300" placeholder="16 digit NIK" value="{{ old('no_ktp', $petani->nik) }}">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Foto KTP</label>
                            <input type="file" name="foto_ktp" required accept="image/*" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl p-3 focus:ring-primary-500 focus:border-primary-500 font-bold text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Bank Tujuan</label>
                            <input type="text" name="nama_bank" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl p-4 focus:ring-primary-500 focus:border-primary-500 font-bold text-sm placeholder-slate-300" placeholder="BCA, BRI, Mandiri..." value="{{ old('nama_bank', $petani->nama_bank) }}">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Nomor Rekening</label>
                            <input type="text" name="no_rekening" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl p-4 focus:ring-primary-500 focus:border-primary-500 font-bold text-sm placeholder-slate-300" placeholder="Nomor rekening" value="{{ old('no_rekening', $petani->rekening_bank) }}">
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Nama Pemilik Rekening</label>
                            <input type="text" name="nama_rekening" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl p-4 focus:ring-primary-500 focus:border-primary-500 font-bold text-sm placeholder-slate-300" placeholder="Sesuai buku tabungan" value="{{ old('nama_rekening', $petani->user->name) }}">
                        </div>
                    </div>

                    <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100 mt-6">
                        <div class="flex gap-3">
                            <span class="material-symbols-outlined text-blue-500 text-xl">info</span>
                            <p class="text-xs font-medium text-blue-700 leading-relaxed">
                                Pastikan data bank yang Anda masukkan sudah benar. Kesalahan input dapat menyebabkan penundaan atau kegagalan transfer.
                            </p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                        <button type="button" onclick="document.getElementById('tarikModal').classList.add('hidden')" class="py-4 bg-slate-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">BATAL</button>
                        <button type="submit" class="py-4 bg-primary-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary-600 transition-all shadow-xl shadow-primary-500/20 active:scale-95">AJUKAN</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <!-- Modal Riwayat Penarikan -->
    <div id="riwayatModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/80 backdrop-blur-md p-4 overflow-y-auto">
        <div class="bg-white rounded-[3rem] p-10 max-w-3xl w-full shadow-2xl border border-slate-100 animate-in zoom-in duration-300 my-8">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-2xl font-black text-slate-900">Riwayat <span class="text-primary-500">Penarikan</span></h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Daftar pencairan dana Anda</p>
                </div>
                <button onclick="document.getElementById('riwayatModal').classList.add('hidden')" class="w-10 h-10 bg-slate-100 hover:bg-red-50 hover:text-red-500 rounded-full flex items-center justify-center transition-all text-slate-400">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>

            <div class="max-h-[60vh] overflow-y-auto pr-2">
                @forelse($riwayatPenarikan as $riwayat)
                    <div class="p-6 border border-slate-100 rounded-3xl mb-4 hover:border-primary-100 hover:shadow-md transition-all group">
                        <div class="flex flex-col md:flex-row justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0
                                    @if($riwayat->status == 'pending') bg-amber-50 text-amber-500
                                    @elseif($riwayat->status == 'disetujui') bg-emerald-50 text-emerald-500
                                    @else bg-red-50 text-red-500 @endif
                                ">
                                    <span class="material-symbols-outlined">
                                        @if($riwayat->status == 'pending') pending_actions
                                        @elseif($riwayat->status == 'disetujui') check_circle
                                        @else cancel @endif
                                    </span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="text-lg font-black text-slate-900">Rp {{ number_format($riwayat->nominal, 0, ',', '.') }}</p>
                                        <span class="px-2 py-1 text-[8px] font-black uppercase tracking-widest rounded-lg 
                                            @if($riwayat->status == 'pending') bg-amber-100 text-amber-700
                                            @elseif($riwayat->status == 'disetujui') bg-emerald-100 text-emerald-700
                                            @else bg-red-100 text-red-700 @endif
                                        ">
                                            {{ $riwayat->status }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 font-medium">{{ \Carbon\Carbon::parse($riwayat->created_at)->translatedFormat('d M Y, H:i') }}</p>
                                    
                                    <div class="mt-4 grid grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl">
                                        <div>
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Bank</p>
                                            <p class="text-xs font-bold text-slate-900">{{ $riwayat->nama_bank }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">No. Rekening</p>
                                            <p class="text-xs font-bold text-slate-900">{{ $riwayat->no_rekening }}</p>
                                        </div>
                                    </div>

                                    @if($riwayat->catatan_admin)
                                        <div class="mt-4 p-4 rounded-2xl @if($riwayat->status == 'ditolak') bg-red-50 border border-red-100 @else bg-slate-50 border border-slate-100 @endif">
                                            <p class="text-[9px] font-black @if($riwayat->status == 'ditolak') text-red-400 @else text-slate-400 @endif uppercase tracking-widest mb-1">Catatan Admin</p>
                                            <p class="text-xs font-medium @if($riwayat->status == 'ditolak') text-red-700 @else text-slate-700 @endif">{{ $riwayat->catatan_admin }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-300 mx-auto mb-4 shadow-sm">
                            <span class="material-symbols-outlined text-3xl">history</span>
                        </div>
                        <p class="text-sm font-bold text-slate-900 mb-1">Belum Ada Riwayat</p>
                        <p class="text-xs text-slate-500">Anda belum pernah melakukan penarikan dana.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-petani-layout>

