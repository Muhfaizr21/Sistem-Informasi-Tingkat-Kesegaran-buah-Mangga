@extends('layouts.pembeli')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="relative min-h-screen pb-20">
    <!-- Header -->
    <div class="mb-12 animate-in fade-in slide-in-from-left duration-700">
        <h1 class="text-4xl md:text-5xl font-black text-[#1b1b18] tracking-tight mb-2">Pesanan <span class="text-[#FFB800]">Saya</span></h1>
        <p class="text-lg text-[#706f6c] font-medium">Pantau status pengiriman dan riwayat belanja Anda dengan mudah.</p>
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
                    
                    <div class="flex gap-3 w-full md:w-auto">
                        <a href="{{ route('pembeli.pesanan.show', $pesanan->id) }}" class="flex-1 md:flex-none px-6 py-3 bg-gray-50 border border-gray-200 rounded-[1.2rem] text-[10px] font-black text-[#1b1b18] text-center uppercase tracking-widest hover:bg-gray-100 transition-colors">
                            DETAIL PESANAN
                        </a>
                        
                        @if($pesanan->status === 'dikirim')
                        <form action="{{ route('pembeli.pesanan.selesai', $pesanan->id) }}" method="POST" class="flex-1 md:flex-none">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-emerald-500 text-white rounded-[1.2rem] text-[10px] font-black text-center uppercase tracking-widest hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-500/30">
                                PESANAN DITERIMA
                            </button>
                        </form>
                        @endif

                        @if($pesanan->status === 'menunggu_bayar')
                        <a href="{{ route('pembeli.pesanan.show', $pesanan->id) }}" class="flex-1 md:flex-none px-6 py-3 bg-[#FFB800] text-white rounded-[1.2rem] text-[10px] font-black text-center uppercase tracking-widest hover:bg-[#10B981] transition-colors shadow-lg shadow-orange-900/20">
                            BAYAR SEKARANG
                        </a>
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
            {{ $pesanans->links() }}
        </div>
    </div>
</div>
@endsection
