@extends('layouts.pembeli')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="relative animate-in fade-in duration-700">
    <!-- Header -->
    <div class="mb-10 animate-in fade-in slide-in-from-left duration-700">
        <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
            <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
            Purchase History
        </div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3rem); line-height: 1.1; color: var(--leaf-dark);">
            Pesanan <span style="color: var(--gold);">Saya</span>
        </h1>
        <p class="text-sm mt-2" style="color: var(--text-light);">Pantau status pengiriman dan riwayat belanja Anda dengan mudah.</p>
    </div>

    <!-- Filters -->
    <div class="mb-12 space-y-6">
        <div class="flex flex-wrap gap-2">
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
                   class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all no-underline"
                   style="{{ $currentStatus == $value ? 'background: var(--gold); color: white; box-shadow: 0 4px 12px rgba(212,160,23,0.3);' : 'background: white; color: var(--text-mid); border: 1px solid var(--gold-pale);' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="flex flex-wrap gap-2">
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
                   class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all no-underline"
                   style="{{ $currentMetode == $value ? 'background: var(--text-dark); color: white;' : 'background: white; color: var(--text-light); border: 1px solid var(--gold-pale);' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    @if(session('success'))
    <div class="mb-8 p-6 rounded-[2rem] flex items-center gap-4 shadow-sm animate-in zoom-in duration-500" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1);">
        <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined">check</span>
        </div>
        <span class="font-bold text-emerald-700">{{ session('success') }}</span>
    </div>
    @endif

    <div class="space-y-6">
        @forelse($pesanans as $pesanan)
        <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-var(--gold-pale) shadow-sm hover:shadow-md transition-all group">
            <div class="flex flex-col md:flex-row justify-between gap-8">
                <!-- Kiri: Info Produk -->
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span class="px-3 py-1 bg-var(--gold-pale) rounded-lg text-[9px] font-black uppercase tracking-widest" style="color: var(--text-light);">
                            {{ \Carbon\Carbon::parse($pesanan->created_at)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') }}
                        </span>
                        <span class="text-[10px] font-black" style="color: var(--gold);">{{ $pesanan->kode_pesanan }}</span>
                        
                        @php
                            $statusConfig = [
                                'menunggu_bayar' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'Menunggu Bayar'],
                                'menunggu_verifikasi' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'label' => 'Verifikasi'],
                                'dikonfirmasi' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Dikonfirmasi'],
                                'dikemas' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Dikemas'],
                                'dikirim' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'label' => 'Dikirim'],
                                'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Selesai'],
                                'dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Batal'],
                            ];
                            $status = $statusConfig[$pesanan->status] ?? $statusConfig['menunggu_bayar'];
                        @endphp
                        <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest {{ $status['bg'] }} {{ $status['text'] }}">
                            {{ $status['label'] }}
                        </span>
                        <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest" style="background: var(--text-dark); color: white;">
                            {{ strtoupper(str_replace('_', ' ', $pesanan->metode_pembayaran)) }}
                        </span>
                    </div>

                    <div class="flex gap-6 items-center">
                        <div class="w-20 h-20 bg-var(--gold-pale) rounded-2xl overflow-hidden shrink-0 border border-var(--gold-pale) group-hover:scale-105 transition-transform">
                            @if($pesanan->items->first() && is_array($pesanan->items->first()->listing?->foto_batch) && count($pesanan->items->first()->listing->foto_batch) > 0)
                                <img src="{{ asset('storage/' . $pesanan->items->first()->listing->foto_batch[0]) }}" class="w-full h-full object-cover">
                            @elseif($pesanan->items->first() && !is_array($pesanan->items->first()->listing?->foto_batch) && $pesanan->items->first()->listing?->foto_batch)
                                <img src="{{ asset('storage/' . $pesanan->items->first()->listing->foto_batch) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-var(--gold) opacity-20">
                                    <span class="material-symbols-outlined text-4xl">image</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 style="font-family: 'Lora', serif; font-size: 1.25rem; font-weight: 600; color: var(--leaf-dark);" class="mb-1 group-hover:text-var(--gold) transition-colors">
                                {{ $pesanan->items->first()?->listing?->jenis_mangga ?? 'Mangga Premium' }}
                            </h3>
                            <p class="text-[0.65rem] font-bold uppercase tracking-widest" style="color: var(--text-light);">
                                {{ $pesanan->items->count() }} Produk • Total {{ number_format($pesanan->items->sum('jumlah_kg'), 1) }} kg
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Aksi -->
                <div class="flex flex-col justify-between items-start md:items-end gap-6 pt-6 md:pt-0 border-t md:border-t-0" style="border-color: var(--gold-pale);">
                    <div class="text-left md:text-right w-full">
                        <p class="text-[0.6rem] font-bold uppercase tracking-widest mb-1" style="color: var(--text-light);">Total Bayar</p>
                        <p class="text-2xl font-black" style="color: var(--text-dark);">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
                        <a href="{{ route('pembeli.pesanan.show', $pesanan->id) }}" class="flex-1 md:flex-none px-6 py-3 rounded-xl text-[10px] font-black text-center uppercase tracking-widest transition-all no-underline"
                           style="background: var(--gold-pale); color: var(--text-dark);">
                            DETAIL
                        </a>
                        
                        @if($pesanan->status === 'dikirim')
                        <form action="{{ route('pembeli.pesanan.selesai', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 md:flex-none flex items-center gap-2">
                            @csrf
                            <input type="file" name="foto_selesai" id="foto_selesai_{{ $pesanan->id }}" class="hidden" onchange="this.form.submit()" accept="image/*">
                            <button type="button" onclick="document.getElementById('foto_selesai_{{ $pesanan->id }}').click()" class="w-full px-6 py-3 bg-emerald-500 text-white rounded-xl text-[10px] font-black text-center uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                SELESAI
                            </button>
                        </form>
                        @endif

                        @if($pesanan->status === 'selesai' && !$pesanan->review)
                        <a href="{{ route('pembeli.pesanan.show', $pesanan->id) }}#review-section" class="flex-1 md:flex-none px-6 py-3 bg-amber-500 text-white rounded-xl text-[10px] font-black text-center uppercase tracking-widest hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/30 flex items-center gap-2 no-underline">
                            <span class="material-symbols-outlined text-[18px] fill-1">star</span>
                            ULASAN
                        </a>
                        @endif

                        @if($pesanan->status === 'menunggu_bayar')
                            @if($pesanan->metode_pembayaran === 'midtrans' && $pesanan->snap_token)
                            <button type="button" onclick="triggerSnap('{{ $pesanan->snap_token }}')" class="flex-1 md:flex-none px-6 py-3 rounded-xl text-[10px] font-black text-center uppercase tracking-widest transition-all shadow-lg flex items-center gap-2"
                                    style="background: var(--gold); color: white; box-shadow: 0 10px 20px rgba(212,160,23,0.3);">
                                <span class="material-symbols-outlined text-[18px]">payments</span>
                                BAYAR
                            </button>
                            @elseif($pesanan->metode_pembayaran === 'transfer')
                            <form action="{{ route('pembeli.pesanan.bayar', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 md:flex-none flex items-center gap-2">
                                @csrf
                                <input type="file" name="bukti_pembayaran" id="bukti_{{ $pesanan->id }}" class="hidden" onchange="this.form.submit()" accept="image/*">
                                <button type="button" onclick="document.getElementById('bukti_{{ $pesanan->id }}').click()" class="w-full px-6 py-3 rounded-xl text-[10px] font-black text-center uppercase tracking-widest transition-all shadow-lg flex items-center gap-2"
                                        style="background: var(--gold); color: white; box-shadow: 0 10px 20px rgba(212,160,23,0.3);">
                                    <span class="material-symbols-outlined text-[18px]">upload_file</span>
                                    BUKTI
                                </button>
                            </form>
                            @endif

                            <form action="{{ route('pembeli.pesanan.batal', $pesanan->id) }}" method="POST" class="flex-1 md:flex-none" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                <button type="submit" class="w-full px-6 py-3 bg-red-50 text-red-500 border border-red-100 rounded-xl text-[10px] font-black text-center uppercase tracking-widest hover:bg-red-100 transition-all">
                                    BATAL
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="py-32 text-center bg-white rounded-[3.5rem] border border-var(--gold-pale) shadow-sm">
            <div class="w-24 h-24 bg-var(--gold-pale) rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-5xl opacity-20" style="color: var(--gold);">shopping_bag</span>
            </div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);" class="mb-2">Belum Ada Pesanan</h3>
            <p class="font-medium mb-10 max-w-md mx-auto text-sm" style="color: var(--text-light);">Anda belum pernah melakukan pemesanan. Ayo mulai belanja mangga premium sekarang!</p>
            <a href="{{ route('pembeli.marketplace.katalog') }}" class="inline-flex items-center gap-3 px-8 py-4 rounded-xl font-black text-[0.7rem] uppercase tracking-widest transition-all shadow-lg no-underline"
               style="background: var(--gold); color: white; box-shadow: 0 10px 20px rgba(212,160,23,0.3);">
                BUKA MARKETPLACE
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
        @endforelse

        <div class="mt-12 flex justify-center">
            @if($pesanans->hasPages())
                <nav class="flex items-center gap-2 bg-white p-2 rounded-2xl border border-var(--gold-pale) shadow-sm">
                    @if ($pesanans->onFirstPage())
                        <span class="w-10 h-10 flex items-center justify-center opacity-20">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </span>
                    @else
                        <a href="{{ $pesanans->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center hover:bg-var(--gold-pale) rounded-xl transition-all">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </a>
                    @endif

                    @foreach ($pesanans->getUrlRange(1, $pesanans->lastPage()) as $page => $url)
                        @if ($page == $pesanans->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center text-white font-black text-[10px] rounded-xl shadow-lg" style="background: var(--gold); box-shadow: 0 4px 10px rgba(212,160,23,0.3);">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center font-bold text-[10px] rounded-xl transition-all" style="color: var(--text-light);">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($pesanans->hasMorePages())
                        <a href="{{ $pesanans->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center hover:bg-var(--gold-pale) rounded-xl transition-all">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </a>
                    @else
                        <span class="w-10 h-10 flex items-center justify-center opacity-20">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </span>
                    @endif
                </nav>
            @endif
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
