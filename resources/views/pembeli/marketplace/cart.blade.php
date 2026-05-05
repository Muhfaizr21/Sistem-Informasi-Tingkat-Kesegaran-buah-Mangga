@extends('layouts.pembeli')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="relative min-h-screen pb-20">
    <!-- Header -->
    <div class="mb-12 animate-in fade-in slide-in-from-left duration-700">
        <h1 class="text-4xl md:text-5xl font-black text-[#1b1b18] tracking-tight mb-2">Keranjang <span class="text-[#F53003]">Belanja</span></h1>
        <p class="text-lg text-[#706f6c] font-medium">Tinjau kembali pilihan mangga terbaik Anda sebelum dikirim.</p>
    </div>

    @if(session('success'))
    <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-[2rem] flex items-center gap-4 animate-in zoom-in duration-500 shadow-sm">
        <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Cart Items Column -->
        <div class="lg:col-span-8 space-y-10 animate-in fade-in duration-1000">
            @forelse($groupedCart as $petaniId => $group)
            <div class="bg-white rounded-[3rem] border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] overflow-hidden">
                <div class="px-10 py-6 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-[#F53003] text-white rounded-2xl flex items-center justify-center font-black text-sm">
                            {{ substr($group['petani_nama'], 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Penjual</p>
                            <span class="font-black text-[#1b1b18]">{{ $group['petani_nama'] }}</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-black px-3 py-1 bg-white border border-gray-100 rounded-lg text-emerald-600 uppercase tracking-widest shadow-sm">Verified Farmer</span>
                </div>
                
                <div class="p-10 space-y-10">
                    @foreach($group['items'] as $id => $item)
                    <div class="flex flex-col sm:flex-row items-center gap-8 group">
                        <div class="w-32 h-32 bg-gray-100 rounded-[2rem] overflow-hidden shrink-0 shadow-lg border border-white">
                            @if($item['foto'])
                                <img src="{{ asset('storage/' . $item['foto']) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-xl font-black text-[#1b1b18] mb-1 group-hover:text-[#F53003] transition-colors">{{ $item['nama'] }}</h3>
                            <p class="text-sm text-gray-400 font-bold uppercase tracking-widest mb-3">Rp{{ number_format($item['harga'], 0, ',', '.') }} <span class="text-[10px] opacity-60">/kg</span></p>
                            <div class="flex items-center justify-center sm:justify-start gap-4">
                                <span class="px-4 py-1.5 bg-gray-50 text-[#1b1b18] border border-gray-100 rounded-xl text-xs font-black">{{ $item['jumlah'] }} KG</span>
                                <span class="text-[10px] text-gray-300 font-black uppercase tracking-widest">Minimal Order: {{ $item['minimal_order'] }}kg</span>
                            </div>
                        </div>
                        
                        <div class="text-center sm:text-right min-w-[150px]">
                            <p class="text-xs font-black text-gray-300 uppercase tracking-widest mb-1">Subtotal</p>
                            <p class="text-2xl font-black text-[#1b1b18]">Rp{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</p>
                        </div>
                        
                        <form action="{{ route('pembeli.cart.remove') }}" method="POST" class="shrink-0">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="w-12 h-12 bg-gray-50 text-gray-300 hover:bg-red-50 hover:text-red-500 rounded-2xl flex items-center justify-center transition-all border border-transparent hover:border-red-100 shadow-sm active:scale-90">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    @if(!$loop->last) <hr class="border-gray-50"> @endif
                    @endforeach
                </div>
            </div>
            @empty
            <div class="py-32 bg-gray-50 rounded-[4rem] border border-dashed border-gray-200 text-center">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-8 shadow-xl shadow-gray-200/50">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-[#1b1b18] mb-4 tracking-tight">Keranjang Anda Kosong</h3>
                <p class="text-lg text-[#706f6c] max-w-sm mx-auto mb-10 leading-relaxed font-medium">Sepertinya Anda belum menemukan mangga idaman hari ini.</p>
                <a href="{{ route('pembeli.marketplace.katalog') }}" class="inline-flex items-center px-10 py-5 bg-[#1b1b18] text-white rounded-[2rem] font-black text-sm tracking-widest uppercase hover:bg-black transition-all shadow-xl shadow-black/20">
                    MULAI BELANJA
                </a>
            </div>
            @endforelse
        </div>

        <!-- Summary Column -->
        @if(count($groupedCart) > 0)
        <div class="lg:col-span-4 space-y-8 animate-in fade-in slide-in-from-right duration-1000">
            <div class="bg-white rounded-[3.5rem] p-10 border border-gray-100 shadow-[0_40px_80px_-40px_rgba(0,0,0,0.1)] sticky top-24">
                <h3 class="text-2xl font-black text-[#1b1b18] tracking-tight mb-10 text-center">Ringkasan Belanja</h3>
                
                <div class="space-y-6 mb-10">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-black text-gray-400 uppercase tracking-widest">Subtotal Produk</span>
                        <span class="text-lg font-black text-[#1b1b18]">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-black text-gray-400 uppercase tracking-widest">Biaya Admin</span>
                        <span class="text-lg font-black text-[#1b1b18]">Rp2.500</span>
                    </div>
                    <div class="flex justify-between items-center text-emerald-600">
                        <span class="text-sm font-black uppercase tracking-widest">Diskon Member</span>
                        <span class="text-lg font-black">- Rp0</span>
                    </div>
                    
                    <div class="pt-8 border-t border-gray-100 space-y-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] text-center">Total Pembayaran</p>
                        <p class="text-4xl font-black text-[#F53003] text-center">Rp{{ number_format($totalPrice + 2500, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <a href="{{ route('pembeli.checkout.index') }}" class="w-full py-6 bg-[#F53003] text-white rounded-[2.2rem] font-black text-sm tracking-[0.2em] uppercase shadow-2xl shadow-orange-900/30 hover:bg-[#FF4433] transition-all transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-3">
                    LANJUT CHECKOUT
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                
                <div class="mt-8 flex items-center justify-center gap-2 text-gray-300">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-[8px] font-black uppercase tracking-widest">Pembayaran Aman & Terenkripsi</span>
                </div>
            </div>

            <!-- Promotion Card -->
            <div class="bg-[#1b1b18] rounded-[3rem] p-8 text-white relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-[#F53003] rounded-full blur-3xl opacity-20 group-hover:scale-150 transition-transform"></div>
                <div class="relative z-10">
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] mb-2 text-[#F53003]">Promo Spesial</h4>
                    <p class="text-lg font-bold leading-tight">Gunakan poin Anda untuk potongan pengiriman!</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
