<x-admin-layout>
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="relative overflow-hidden bg-on-surface rounded-[2.5rem] p-8 md:p-12 text-white premium-shadow">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-primary-500/10 to-transparent"></div>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <nav class="flex items-center gap-2 text-white/50 text-xs font-bold uppercase tracking-widest mb-4">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-400 transition-colors">Dashboard</a>
                        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                        <a href="{{ route('admin.pesanan.index') }}" class="hover:text-primary-400 transition-colors tracking-widest">Pesanan</a>
                        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                        <span class="text-white">Verifikasi Pembayaran</span>
                    </nav>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tighter mb-2">
                        Verifikasi <span class="text-primary-400">Pembayaran</span>
                    </h1>
                    <p class="text-white/60 font-medium max-w-xl">
                        Tinjau bukti transaksi dari pembeli dengan teliti untuk memastikan validitas pembayaran sebelum pesanan diproses.
                    </p>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center backdrop-blur-xl border border-white/10">
                    <span class="material-symbols-outlined text-3xl text-primary-400">fact_check</span>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-[2rem] flex items-center gap-4 animate-in fade-in slide-in-from-top duration-500">
            <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                <span class="material-symbols-outlined text-[20px]">check</span>
            </div>
            <p class="text-emerald-700 font-bold tracking-tight">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Verification Cards Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            @forelse($pesanans as $pesanan)
            <div class="bg-white rounded-[2.5rem] border border-outline-variant shadow-sm overflow-hidden flex flex-col md:flex-row group transition-all hover:shadow-xl hover:border-primary-200">
                <!-- Payment Proof Preview -->
                <div class="w-full md:w-2/5 aspect-square md:aspect-auto bg-surface-container-low relative overflow-hidden cursor-pointer" onclick="window.open('{{ asset('storage/' . $pesanan->bukti_pembayaran) }}', '_blank')">
                    @if($pesanan->bukti_pembayaran)
                        <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="px-4 py-2 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-widest border border-white/20">Perbesar Bukti</span>
                        </div>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-on-surface-variant/30">
                            <span class="material-symbols-outlined text-6xl mb-2">no_photography</span>
                            <span class="text-xs font-black uppercase tracking-widest">Tanpa Bukti</span>
                        </div>
                    @endif
                </div>

                <!-- Details & Actions -->
                <div class="flex-1 p-8 flex flex-col justify-between gap-6">
                    <div>
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <p class="text-[10px] font-black text-primary-600 uppercase tracking-widest mb-1">{{ $pesanan->kode_pesanan }}</p>
                                <h3 class="text-xl font-black text-on-surface leading-tight">{{ $pesanan->pembeli->user->name ?? 'Pembeli' }}</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest mb-1">Nominal</p>
                                <p class="text-xl font-black text-primary-600">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-surface-container-low border border-outline-variant">
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-primary-600 shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest leading-none">Waktu Unggah</span>
                                    <span class="text-xs font-bold text-on-surface mt-0.5">{{ $pesanan->dibayar_pada ? $pesanan->dibayar_pada->translatedFormat('d M Y, H:i') : '-' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-surface-container-low border border-outline-variant">
                                <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-mango-600 shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">account_balance_wallet</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-on-surface-variant uppercase tracking-widest leading-none">Metode Pembayaran</span>
                                    <span class="text-xs font-bold text-on-surface mt-0.5 uppercase tracking-tighter">{{ str_replace('_', ' ', $pesanan->metode_pembayaran ?? 'Transfer') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <form action="{{ route('admin.pesanan.konfirmasi', $pesanan->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-on-surface text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-primary-600 transition-all shadow-xl active:scale-95">
                                Konfirmasi Berhasil
                            </button>
                        </form>
                        
                        <button onclick="document.getElementById('reject_modal_{{ $pesanan->id }}').classList.remove('hidden')" class="w-full py-4 bg-surface-container-high text-on-surface-variant rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-red-500 hover:text-white transition-all active:scale-95">
                            Tolak Bukti
                        </button>
                    </div>
                </div>
            </div>

            <!-- Rejection Modal -->
            <div id="reject_modal_{{ $pesanan->id }}" class="hidden fixed inset-0 z-[200] flex items-center justify-center bg-on-surface/80 backdrop-blur-md p-4">
                <div class="bg-white rounded-[3rem] p-10 max-w-md w-full shadow-2xl border border-outline-variant animate-in zoom-in duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-3xl">error</span>
                    </div>
                    <h3 class="text-2xl font-black text-on-surface mb-2">Tolak Pembayaran</h3>
                    <p class="text-on-surface-variant font-medium mb-8">Informasikan alasan penolakan kepada pembeli agar mereka dapat memperbaiki kesalahan pembayaran.</p>
                    
                    <form action="{{ route('admin.pesanan.tolak', $pesanan->id) }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest mb-3 block">Alasan Penolakan</label>
                            <textarea name="catatan" required rows="3" class="w-full bg-surface-container-low border border-outline-variant text-on-surface rounded-2xl p-5 focus:ring-primary-500 focus:border-primary-500 font-medium text-sm placeholder-on-surface-variant/40" placeholder="Contoh: Nominal transfer kurang, atau bukti tidak terbaca."></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" onclick="document.getElementById('reject_modal_{{ $pesanan->id }}').classList.add('hidden')" class="py-4 bg-surface-container-high text-on-surface-variant rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-surface-container-highest transition-all">BATAL</button>
                            <button type="submit" class="py-4 bg-red-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl shadow-red-600/20">KIRIM ALASAN</button>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border border-dashed border-outline-variant">
                <div class="w-24 h-24 bg-surface-container-low rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-5xl text-on-surface-variant opacity-20">verified_user</span>
                </div>
                <h3 class="text-xl font-black text-on-surface tracking-tight uppercase">Antrean Kosong</h3>
                <p class="text-on-surface-variant text-sm mt-1">Seluruh bukti pembayaran telah diverifikasi dengan sukses.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-admin-layout>
