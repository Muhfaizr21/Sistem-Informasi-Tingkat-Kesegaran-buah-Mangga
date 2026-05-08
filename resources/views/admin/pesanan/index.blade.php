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
                        'menunggu_bayar' => 'Bayar',
                        'menunggu_verifikasi' => 'Verifikasi',
                        'dikonfirmasi' => 'Diproses',
                        'dikemas' => 'Dikemas',
                        'dikirim' => 'Dikirim',
                        'menunggu_verifikasi_selesai' => 'Diterima',
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
                                            'dikonfirmasi' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'check_circle', 'label' => 'Diproses'],
                                            'dikemas' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'icon' => 'package_2', 'label' => 'Dikemas'],
                                            'dikirim' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'icon' => 'local_shipping', 'label' => 'Dikirim'],
                                            'menunggu_verifikasi_selesai' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-700', 'icon' => 'assignment_turned_in', 'label' => 'Diterima'],
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
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    @if($pesanan->status === 'menunggu_verifikasi')
                                    <button onclick="showPaymentModal('{{ $pesanan->id }}', '{{ $pesanan->kode_pesanan }}', '{{ asset('storage/'.$pesanan->bukti_pembayaran) }}', '{{ number_format($pesanan->total_bayar, 0, ',', '.') }}', '{{ $pesanan->pembeli->user->name ?? 'Pembeli' }}')" 
                                            class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-500 hover:text-white transition-all shadow-sm border border-indigo-100 group"
                                            title="Verifikasi Pembayaran">
                                        <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">payments</span>
                                    </button>
                                    @endif

                                    @if($pesanan->status === 'menunggu_verifikasi_selesai')
                                    <div class="flex gap-2">
                                        <button onclick="showFinishModal('{{ $pesanan->id }}', '{{ $pesanan->kode_pesanan }}', '{{ asset('storage/'.$pesanan->foto_selesai) }}')" 
                                                class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all shadow-sm border border-emerald-100 group"
                                                title="Lihat Bukti & Selesaikan">
                                            <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">visibility</span>
                                        </button>
                                        <button onclick="showFinishModal('{{ $pesanan->id }}', '{{ $pesanan->kode_pesanan }}', '{{ asset('storage/'.$pesanan->foto_selesai) }}')" 
                                                class="p-2.5 rounded-xl bg-emerald-500 text-white hover:bg-emerald-600 transition-all shadow-sm group"
                                                title="Konfirmasi Cepat">
                                            <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">check_circle</span>
                                        </button>
                                    </div>
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
                                    <div class="text-on-surface-variant font-black uppercase tracking-widest text-[10px]">Data Pesanan Kosong</div>
                                    <p class="text-xs text-on-surface-variant/60 max-w-[200px] mx-auto leading-relaxed">Belum ada transaksi yang sesuai dengan kriteria filter ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-8 py-6 border-t border-outline-variant bg-surface-container-low/30">
                {{ $pesanans->appends(['status' => $status])->links() }}
            </div>
        </div>
    </div>
                
    <!-- Modal Verifikasi Pembayaran -->
    <div id="paymentModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-on-surface/80 backdrop-blur-md p-4">
        <div class="bg-white rounded-[3rem] max-w-4xl w-full shadow-2xl border border-outline-variant overflow-hidden animate-in zoom-in duration-300">
            <div class="flex flex-col md:flex-row h-[80vh] md:h-auto relative">
                <!-- Proof Image -->
                <div class="w-full md:w-1/2 bg-surface-container-low relative group overflow-hidden border-b md:border-b-0 md:border-r border-outline-variant">
                    <img id="paymentProofImg" src="" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute bottom-6 left-6 right-6">
                        <a id="paymentProofLink" href="#" target="_blank" class="block w-full py-3 bg-white/20 backdrop-blur-xl border border-white/30 text-white text-[10px] font-black uppercase tracking-widest text-center rounded-xl hover:bg-white/40 transition-all">Perbesar Gambar</a>
                    </div>
                </div>
                <!-- Action Content -->
                <div class="w-full md:w-1/2 p-10 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h3 class="text-[10px] font-black text-primary-600 uppercase tracking-[0.2em] mb-1" id="paymentCode">ORD-XXXX</h3>
                                <h2 class="text-2xl font-black text-on-surface tracking-tighter" id="paymentUser">Nama Pembeli</h2>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1">Tagihan</p>
                                <p class="text-2xl font-black text-primary-600">Rp<span id="paymentAmount">0</span></p>
                            </div>
                        </div>
                        
                        <div class="bg-surface-container-low rounded-3xl p-6 border border-outline-variant mb-8">
                            <p class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest mb-4">Instruksi Verifikasi</p>
                            <ul class="space-y-3 text-xs font-medium text-on-surface-variant">
                                <li class="flex gap-3">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-500">check_circle</span>
                                    Pastikan nama pengirim sesuai atau valid.
                                </li>
                                <li class="flex gap-3">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-500">check_circle</span>
                                    Periksa nominal transfer harus tepat.
                                </li>
                            </ul>
                        </div>

                        <form id="paymentForm" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-3 block px-1">Catatan Internal (Opsional)</label>
                                <textarea name="catatan" rows="2" class="w-full bg-surface-container-low border border-outline-variant rounded-2xl p-4 focus:ring-primary-500 focus:border-primary-500 text-xs font-medium" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                            </div>
                        </form>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <button type="button" onclick="rejectPayment()" class="py-4 border border-red-200 text-red-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-50 transition-all active:scale-95">TOLAK BUKTI</button>
                        <button type="button" onclick="submitPayment()" class="py-4 bg-on-surface text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary-600 transition-all shadow-xl active:scale-95 shadow-on-surface/10">KONFIRMASI</button>
                    </div>
                </div>
                <button onclick="hidePaymentModal()" class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center bg-white/20 backdrop-blur-xl rounded-full text-white hover:bg-red-500 transition-all border border-white/20 z-10">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Verifikasi Penerimaan -->
    <div id="finishModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-on-surface/80 backdrop-blur-md p-4">
        <div class="bg-white rounded-[2rem] max-w-2xl w-full shadow-2xl border border-outline-variant overflow-hidden animate-in zoom-in duration-300">
            <div class="flex flex-col md:flex-row h-auto relative">
                <!-- Proof Image -->
                <div class="w-full md:w-4/12 bg-surface-container-low relative group overflow-hidden border-b md:border-b-0 md:border-r border-outline-variant">
                    <img id="finishProofImg" src="" class="w-full h-full object-contain p-3 group-hover:scale-105 transition-transform duration-700">
                </div>
                <!-- Action Content -->
                <div class="w-full md:w-8/12 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-[8px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-1" id="finishCode">ORD-XXXX</h3>
                                <h2 class="text-lg font-black text-on-surface tracking-tighter">Konfirmasi <span class="text-emerald-500">Penerimaan</span></h2>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 border border-emerald-100 shrink-0">
                                <span class="material-symbols-outlined text-lg">local_shipping</span>
                            </div>
                        </div>
                        
                        <div class="bg-surface-container-low rounded-xl p-4 border border-outline-variant mb-4">
                            <p class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest mb-1">Status</p>
                            <p class="text-[10px] font-medium text-on-surface-variant leading-relaxed">
                                Barang diterima pembeli. Dana akan segera diteruskan ke petani.
                            </p>
                        </div>

                        <form id="finishForm" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label class="text-[8px] font-black text-on-surface-variant uppercase tracking-widest mb-1.5 block px-1">Catatan Admin</label>
                                <textarea name="catatan" rows="2" class="w-full bg-surface-container-low border border-outline-variant rounded-lg p-3 focus:ring-emerald-500 focus:border-emerald-500 text-[11px] font-medium" placeholder="Opsional..."></textarea>
                            </div>
                        </form>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <button type="button" onclick="hideFinishModal()" class="py-3 bg-surface-container-high text-on-surface-variant rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-surface-container-highest transition-all">BATAL</button>
                        <button type="button" onclick="submitFinish()" class="py-3 bg-emerald-600 text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 active:scale-95">KONFIRMASI</button>
                    </div>
                </div>
                <button onclick="hideFinishModal()" class="absolute top-3 right-3 w-7 h-7 flex items-center justify-center bg-white/20 backdrop-blur-xl rounded-full text-white hover:bg-red-500 transition-all border border-white/20 z-10">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showPaymentModal(id, code, imgSrc, amount, user) {
            const modal = document.getElementById('paymentModal');
            document.getElementById('paymentProofImg').src = imgSrc;
            document.getElementById('paymentProofLink').href = imgSrc;
            document.getElementById('paymentCode').innerText = code;
            document.getElementById('paymentUser').innerText = user;
            document.getElementById('paymentAmount').innerText = amount;
            document.getElementById('paymentForm').action = `/admin/pesanan/${id}/konfirmasi`;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hidePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function submitPayment() {
            document.getElementById('paymentForm').submit();
        }

        function rejectPayment() {
            const form = document.getElementById('paymentForm');
            const action = form.action;
            const newAction = action.replace('/konfirmasi', '/tolak');
            form.action = newAction;
            form.submit();
        }

        function showFinishModal(id, code, imgSrc) {
            const modal = document.getElementById('finishModal');
            document.getElementById('finishProofImg').src = imgSrc;
            document.getElementById('finishCode').innerText = code;
            document.getElementById('finishForm').action = `/admin/pesanan/${id}/konfirmasi-selesai`;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideFinishModal() {
            document.getElementById('finishModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function submitFinish() {
            document.getElementById('finishForm').submit();
        }
    </script>
    @endpush
</x-admin-layout>
