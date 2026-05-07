<x-admin-layout>
<div class="p-6">
    <div class="mb-10">
        <h1 class="text-3xl font-black text-white tracking-tight mb-2">Verifikasi <span class="text-indigo-400">Pembayaran</span></h1>
        <p class="text-slate-400 font-medium">Tinjau bukti pembayaran dari pembeli untuk memproses pesanan.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 rounded-2xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        @forelse($pesanans as $pesanan)
        <div class="bg-white/5 rounded-3xl border border-white/10 shadow-sm overflow-hidden backdrop-blur-sm flex flex-col">
            <!-- Bukti Pembayaran -->
            <div class="aspect-[4/3] bg-black/20 relative group">
                @if($pesanan->bukti_pembayaran)
                    <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" class="w-full h-full object-contain cursor-zoom-in hover:opacity-90 transition-opacity" onclick="window.open(this.src, '_blank')">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                        <span class="text-white text-[10px] font-black uppercase tracking-widest">Klik untuk perbesar</span>
                    </div>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-500 italic">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-xs">Tidak ada bukti</span>
                    </div>
                @endif
            </div>

            <!-- Info & Actions -->
            <div class="p-8 flex flex-col justify-between flex-1">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">{{ $pesanan->kode_pesanan }}</p>
                            <h3 class="text-lg font-black text-white leading-tight">{{ $pesanan->pembeli->user->name ?? 'Pembeli' }}</h3>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Bayar</p>
                            <p class="text-lg font-black text-emerald-400">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">Waktu Upload Bukti</p>
                                <p class="text-xs font-bold text-slate-300">{{ $pesanan->dibayar_pada ? $pesanan->dibayar_pada->format('d M Y, H:i') : '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">Metode Bayar</p>
                                <p class="text-xs font-bold text-slate-300">{{ ucfirst($pesanan->metode_pembayaran ?? 'Transfer') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <form action="{{ route('admin.pesanan.konfirmasi', $pesanan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-emerald-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                            KONFIRMASI PEMBAYARAN
                        </button>
                    </form>
                    
                    <button onclick="document.getElementById('reject_modal_{{ $pesanan->id }}').classList.remove('hidden')" class="w-full py-4 bg-red-500/10 text-red-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500/20 transition-all border border-red-500/20">
                        TOLAK / REJECT
                    </button>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div id="reject_modal_{{ $pesanan->id }}" class="hidden fixed inset-0 z-[200] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
            <div class="bg-[#001F3F] rounded-[2.5rem] p-10 max-w-md w-full shadow-2xl border border-white/10">
                <h3 class="text-2xl font-black text-white mb-2">Tolak Pembayaran</h3>
                <p class="text-slate-400 font-medium mb-8">Berikan alasan penolakan agar pembeli dapat mengunggah ulang bukti pembayaran.</p>
                
                <form action="{{ route('admin.pesanan.tolak', $pesanan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 block">Alasan Penolakan</label>
                        <textarea name="catatan" required rows="3" class="w-full bg-white/5 border-white/10 text-white rounded-2xl p-5 focus:ring-indigo-500 focus:border-indigo-500 font-medium text-sm placeholder-slate-600" placeholder="Contoh: Bukti transfer tidak terbaca atau nominal tidak sesuai."></textarea>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" onclick="document.getElementById('reject_modal_{{ $pesanan->id }}').classList.add('hidden')" class="flex-1 py-4 bg-white/5 text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-white/10 transition-all">BATAL</button>
                        <button type="submit" class="flex-1 py-4 bg-red-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-600 transition-all shadow-lg shadow-red-500/20">KIRIM</button>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-24 text-center bg-white/5 rounded-[3rem] border border-dashed border-white/10">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-slate-500 font-bold uppercase tracking-[0.2em] text-xs">Semua Beres! Tidak ada antrean verifikasi.</p>
        </div>
        @endforelse
    </div>
</div>
</x-admin-layout>
