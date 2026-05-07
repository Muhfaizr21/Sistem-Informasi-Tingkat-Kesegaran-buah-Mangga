@extends('layouts.pembeli')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="relative min-h-screen pb-20">
    <!-- Header -->
    <div class="mb-10 animate-in fade-in slide-in-from-left duration-700">
        <h1 class="text-4xl md:text-5xl font-black text-[#1b1b18] tracking-tight mb-2">Pesanan <span class="text-[#FFB800]">Saya</span></h1>
        <p class="text-lg text-[#706f6c] font-medium">Pantau status pengiriman dan riwayat belanja Anda dengan mudah.</p>
    </div>

    <!-- Filters -->
    <div class="mb-12 space-y-6 animate-in fade-in slide-in-from-top duration-1000">
        <div class="flex flex-wrap gap-3">
            @php
                $statusFilters = [
                    '' => 'Semua Status',
                    'menunggu_bayar' => 'Belum Bayar',
                    'menunggu_verifikasi' => 'Verifikasi',
                    'dikonfirmasi' => 'Dikonfirmasi',
                    'dikemas' => 'Dikemas',
                    'dikirim' => 'Dikirim',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Batal',
                ];
                $currentStatus = request('status', '');
            @endphp
            @foreach($statusFilters as $value => $label)
                <a href="{{ route('pembeli.pesanan.index', ['status' => $value, 'metode' => request('metode')]) }}" 
                   class="px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $currentStatus == $value ? 'bg-[#FFB800] text-white shadow-lg shadow-orange-900/20' : 'bg-white text-gray-500 border border-gray-100 hover:border-orange-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="flex flex-wrap gap-3">
            @php
                $metodeFilters = [
                    '' => 'Semua Metode',
                    'midtrans' => 'Midtrans',
                    'transfer' => 'Transfer Bank',
                    'cod' => 'COD',
                ];
                $currentMetode = request('metode', '');
            @endphp
            @foreach($metodeFilters as $value => $label)
                <a href="{{ route('pembeli.pesanan.index', ['metode' => $value, 'status' => request('status')]) }}" 
                   class="px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $currentMetode == $value ? 'bg-[#1b1b18] text-white shadow-lg shadow-black/20' : 'bg-white text-gray-400 border border-gray-100 hover:border-gray-300' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    @if(session('success'))
    <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-[2rem] flex items-center gap-4 shadow-sm animate-in zoom-in duration-500">
        <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <div class="space-y-6 animate-in fade-in slide-in-from-bottom duration-1000 delay-100">
        @forelse($pesanans as $pesanan)
        <div class="bg-white rounded-[3rem] p-8 md:p-10 border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_50px_-15px_rgba(0,0,0,0.1)] transition-all group">
            <div class="flex flex-col md:flex-row justify-between gap-8">
                <!-- Kiri: Info Produk -->
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span class="px-4 py-1.5 bg-gray-50 border border-gray-100 rounded-xl text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
                        <span class="text-[10px] font-black text-gray-300">|</span>
                        <span class="text-[10px] font-black text-[#FFB800] tracking-widest">{{ $pesanan->kode_pesanan }}</span>
                        
                        @php
                            $statusConfig = [
                                'menunggu_bayar' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'Menunggu Pembayaran'],
                                'menunggu_verifikasi' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'label' => 'Verifikasi'],
                                'dikonfirmasi' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Dikonfirmasi'],
                                'dikemas' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Sedang Dikemas'],
                                'dikirim' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'label' => 'Dalam Pengiriman'],
                                'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Selesai'],
                                'dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Dibatalkan'],
                            ];
                            $status = $statusConfig[$pesanan->status] ?? $statusConfig['menunggu_bayar'];
                        @endphp
                        <span class="px-3 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $status['bg'] }} {{ $status['text'] }}">
                            {{ $status['label'] }}
                        </span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-xl text-[9px] font-black uppercase tracking-widest">
                            {{ strtoupper(str_replace('_', ' ', $pesanan->metode_pembayaran)) }}
                        </span>
                    </div>

                    <div class="flex gap-6 items-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-[1.5rem] overflow-hidden shrink-0 border border-gray-100 group-hover:scale-105 transition-transform">
                            @if($pesanan->items->first() && is_array($pesanan->items->first()->listing?->foto_batch) && count($pesanan->items->first()->listing->foto_batch) > 0)
                                <img src="{{ asset('storage/' . $pesanan->items->first()->listing->foto_batch[0]) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-[#1b1b18] mb-1 group-hover:text-[#FFB800] transition-colors">{{ $pesanan->items->first()?->listing?->jenis_mangga ?? 'Mangga Premium' }}</h3>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $pesanan->items->count() }} Produk • Total {{ number_format($pesanan->items->sum('jumlah_kg'), 1) }} kg</p>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Aksi -->
                <div class="flex flex-col justify-between items-start md:items-end gap-6 pt-6 md:pt-0 border-t md:border-t-0 border-gray-100">
                    <div class="text-left md:text-right w-full">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Belanja</p>
                        <p class="text-2xl font-black text-[#1b1b18]">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
                        <a href="{{ route('pembeli.pesanan.show', $pesanan->id) }}" class="flex-1 md:flex-none px-6 py-3 bg-gray-50 border border-gray-200 rounded-[1.2rem] text-[10px] font-black text-[#1b1b18] text-center uppercase tracking-widest hover:bg-gray-100 transition-colors">
                            DETAIL
                        </a>
                        
                        @if($pesanan->status === 'dikirim')
                        <form action="{{ route('pembeli.pesanan.selesai', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 md:flex-none flex items-center gap-2">
                            @csrf
                            <input type="file" name="foto_selesai" id="foto_selesai_{{ $pesanan->id }}" class="hidden" onchange="this.form.submit()" accept="image/*">
                            <button type="button" onclick="document.getElementById('foto_selesai_{{ $pesanan->id }}').click()" class="w-full px-6 py-3 bg-emerald-500 text-white rounded-[1.2rem] text-[10px] font-black text-center uppercase tracking-widest hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                SELESAI
                            </button>
                        </form>
                        @endif

                        @if($pesanan->status === 'menunggu_bayar')
                            @if($pesanan->metode_pembayaran === 'midtrans' && $pesanan->snap_token)
                            <button type="button" onclick="triggerSnap('{{ $pesanan->snap_token }}')" class="flex-1 md:flex-none px-6 py-3 bg-[#FFB800] text-white rounded-[1.2rem] text-[10px] font-black text-center uppercase tracking-widest hover:bg-amber-500 transition-colors shadow-lg shadow-orange-900/20 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                BAYAR SEKARANG
                            </button>
                            @elseif($pesanan->metode_pembayaran === 'transfer')
                            <form action="{{ route('pembeli.pesanan.bayar', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 md:flex-none flex items-center gap-2">
                                @csrf
                                <input type="file" name="bukti_pembayaran" id="bukti_{{ $pesanan->id }}" class="hidden" onchange="this.form.submit()" accept="image/*">
                                <button type="button" onclick="document.getElementById('bukti_{{ $pesanan->id }}').click()" class="w-full px-6 py-3 bg-[#FFB800] text-white rounded-[1.2rem] text-[10px] font-black text-center uppercase tracking-widest hover:bg-amber-500 transition-colors shadow-lg shadow-orange-900/20 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    UPLOAD BUKTI
                                </button>
                            </form>
                            @endif

                            <form action="{{ route('pembeli.pesanan.batal', $pesanan->id) }}" method="POST" class="flex-1 md:flex-none" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                <button type="submit" class="w-full px-6 py-3 bg-red-50 text-red-500 border border-red-100 rounded-[1.2rem] text-[10px] font-black text-center uppercase tracking-widest hover:bg-red-100 transition-colors">
                                    BATAL
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="py-32 text-center bg-white rounded-[3.5rem] border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)]">
            <div class="w-24 h-24 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-[#1b1b18] mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-400 font-medium mb-10 max-w-md mx-auto">Anda belum pernah melakukan pemesanan. Ayo mulai belanja mangga premium sekarang!</p>
            <a href="{{ route('pembeli.marketplace.katalog') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-[#FFB800] text-white rounded-[2rem] font-black text-xs tracking-widest uppercase shadow-xl shadow-orange-900/20 hover:bg-[#10B981] hover:scale-105 transition-all">
                BUKA MARKETPLACE
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
        @endforelse

        <div class="mt-12">
            {{ $pesanans->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    function triggerSnap(token) {
        window.snap.pay(token, {
            onSuccess: function (result) { window.location.reload(); },
            onPending: function (result) { window.location.reload(); },
            onError: function (result) { alert("Pembayaran gagal!"); },
            onClose: function () { console.log('User closed the popup'); }
        });
    }
</script>
@endpush
