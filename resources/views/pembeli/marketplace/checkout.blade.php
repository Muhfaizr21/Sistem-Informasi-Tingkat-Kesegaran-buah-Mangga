@extends('layouts.pembeli')

@section('title', 'Checkout')

@section('content')
<div class="relative min-h-screen pb-20">
    <!-- Header -->
    <div class="mb-12 animate-in fade-in slide-in-from-left duration-700">
        <h1 class="text-4xl md:text-5xl font-black text-[#1b1b18] tracking-tight mb-2">Selesaikan <span class="text-[#FFB800]">Pesanan</span></h1>
        <p class="text-lg text-[#706f6c] font-medium">Satu langkah lagi untuk mendapatkan mangga terbaik dari tanah Indramayu.</p>
    </div>

    @if(session('error'))
    <div class="mb-8 p-6 bg-red-50 border border-red-100 text-red-700 rounded-[2rem] flex items-center gap-4 shadow-sm animate-in zoom-in duration-500">
        <div class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <span class="font-bold">{{ session('error') }}</span>
    </div>
    @endif

    <form action="{{ route('pembeli.checkout.process') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Form Sections -->
            <div class="lg:col-span-8 space-y-10 animate-in fade-in duration-1000">
                <!-- Alamat Pengiriman -->
                <div class="bg-white rounded-[3.5rem] p-10 border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <svg class="w-40 h-40 text-[#1b1b18]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-8">
                            <h2 class="text-2xl font-black text-[#1b1b18] tracking-tight">Alamat Tujuan</h2>
                            <a href="{{ route('pembeli.alamat.index') }}" class="px-4 py-2 bg-gray-50 text-[#1b1b18] rounded-xl font-black text-[10px] tracking-widest uppercase hover:bg-gray-100 transition-all border border-gray-100">
                                + ALAMAT BARU
                            </a>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($alamats as $alamat)
                            <label class="block relative cursor-pointer group">
                                <input type="radio" name="alamat_id" value="{{ $alamat->id }}" class="peer absolute opacity-0" {{ $alamat->utama ? 'checked' : '' }}>
                                <div class="p-8 bg-gray-50 border border-gray-100 rounded-[2rem] peer-checked:border-[#FFB800] peer-checked:bg-orange-50/50 transition-all group-hover:border-gray-200 shadow-sm relative overflow-hidden">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center border border-gray-100 text-gray-400 peer-checked:text-[#FFB800] transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                            </span>
                                            <span class="font-black text-[#1b1b18] uppercase tracking-widest text-xs">{{ $alamat->label }}</span>
                                        </div>
                                        @if($alamat->utama)
                                        <span class="px-3 py-1 bg-[#1b1b18] text-white text-[9px] font-black uppercase tracking-widest rounded-lg">Utama</span>
                                        @endif
                                    </div>
                                    <div class="pl-11">
                                        <p class="font-black text-lg text-[#1b1b18] leading-tight">{{ $alamat->nama_penerima ?? 'Penerima' }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $alamat->no_telepon ?? '-' }}</p>
                                        <div class="pt-4 mt-4 border-t border-gray-100">
                                            <p class="text-sm font-medium text-[#706f6c] leading-relaxed">
                                                {{ $alamat->alamat_lengkap ?? '-' }}<br>
                                                {{ $alamat->kecamatan?->nama ?? 'Kecamatan tidak diketahui' }}, {{ $alamat->kota ?? 'Indramayu' }}<br>
                                                {{ $alamat->kode_pos ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-8 right-8 hidden peer-checked:block text-[#FFB800]">
                                    <svg class="w-6 h-6 animate-in zoom-in duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </label>
                            @empty
                            <div class="p-12 border-2 border-dashed border-gray-200 rounded-[2.5rem] text-center bg-gray-50/50">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                </div>
                                <p class="text-lg font-bold text-[#1b1b18] mb-2">Belum Ada Alamat</p>
                                <p class="text-gray-500 font-medium mb-6">Silakan tambahkan alamat pengiriman terlebih dahulu.</p>
                                <a href="{{ route('pembeli.alamat.index') }}" class="px-8 py-4 bg-[#1b1b18] text-white rounded-[1.5rem] font-black text-xs tracking-widest uppercase hover:bg-black transition-all shadow-xl shadow-black/10 inline-block">TAMBAH ALAMAT BARU</a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Metode Pengiriman -->
                <div class="bg-white rounded-[3.5rem] p-10 border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden mb-10">
                    <h2 class="text-2xl font-black text-[#1b1b18] tracking-tight mb-8">Pilih Pengiriman</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="metode_pengiriman" value="same_day" class="peer absolute opacity-0" checked>
                            <div class="p-6 bg-gray-50 border border-gray-100 rounded-[2rem] peer-checked:border-[#FFB800] peer-checked:bg-[#FFB800] peer-checked:text-white transition-all text-center h-full flex flex-col justify-between group-hover:border-gray-300 shadow-sm">
                                <div>
                                    <div class="w-12 h-12 rounded-full bg-white/80 peer-checked:bg-white/20 text-[#1b1b18] peer-checked:text-white mx-auto flex items-center justify-center mb-4 transition-colors backdrop-blur">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <p class="font-black text-lg mb-1">Instan</p>
                                    <p class="text-[10px] font-bold uppercase tracking-widest opacity-70 mb-4">Tiba Hari Ini</p>
                                </div>
                                <div class="py-2 bg-white peer-checked:bg-white/20 rounded-xl">
                                    <p class="font-black text-[#FFB800] peer-checked:text-white">Rp25.000</p>
                                </div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="metode_pengiriman" value="next_day" class="peer absolute opacity-0">
                            <div class="p-6 bg-gray-50 border border-gray-100 rounded-[2rem] peer-checked:border-[#FFB800] peer-checked:bg-[#FFB800] peer-checked:text-white transition-all text-center h-full flex flex-col justify-between group-hover:border-gray-300 shadow-sm">
                                <div>
                                    <div class="w-12 h-12 rounded-full bg-white/80 peer-checked:bg-white/20 text-[#1b1b18] peer-checked:text-white mx-auto flex items-center justify-center mb-4 transition-colors backdrop-blur">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="font-black text-lg mb-1">Next Day</p>
                                    <p class="text-[10px] font-bold uppercase tracking-widest opacity-70 mb-4">Tiba Besok</p>
                                </div>
                                <div class="py-2 bg-white peer-checked:bg-white/20 rounded-xl">
                                    <p class="font-black text-[#FFB800] peer-checked:text-white">Rp15.000</p>
                                </div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="metode_pengiriman" value="reguler" class="peer absolute opacity-0">
                            <div class="p-6 bg-gray-50 border border-gray-100 rounded-[2rem] peer-checked:border-[#FFB800] peer-checked:bg-[#FFB800] peer-checked:text-white transition-all text-center h-full flex flex-col justify-between group-hover:border-gray-300 shadow-sm">
                                <div>
                                    <div class="w-12 h-12 rounded-full bg-white/80 peer-checked:bg-white/20 text-[#1b1b18] peer-checked:text-white mx-auto flex items-center justify-center mb-4 transition-colors backdrop-blur">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="font-black text-lg mb-1">Reguler</p>
                                    <p class="text-[10px] font-bold uppercase tracking-widest opacity-70 mb-4">2-3 Hari Kerja</p>
                                </div>
                                <div class="py-2 bg-white peer-checked:bg-white/20 rounded-xl">
                                    <p class="font-black text-[#FFB800] peer-checked:text-white">Rp10.000</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="bg-white rounded-[3.5rem] p-10 border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <h2 class="text-2xl font-black text-[#1b1b18] tracking-tight mb-8">Pilih Pembayaran</h2>
                    <div class="space-y-4">
                        <label class="block relative cursor-pointer group">
                            <input type="radio" name="metode_pembayaran" value="midtrans" class="peer absolute opacity-0" checked>
                            <div class="p-8 bg-gray-50 border border-gray-100 rounded-[2.5rem] peer-checked:border-[#FFB800] peer-checked:bg-orange-50/50 transition-all group-hover:border-gray-200 shadow-sm flex items-center gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-white border border-gray-100 flex items-center justify-center text-[#FFB800] shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-black text-[#1b1b18] leading-tight">Pembayaran Instan</h4>
                                    <p class="text-xs font-medium text-[#706f6c]">QRIS, GOPAY, OVO, Virtual Account (Verifikasi Otomatis)</p>
                                </div>
                                <div class="hidden peer-checked:block text-[#FFB800]">
                                    <svg class="w-6 h-6 animate-in zoom-in duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </label>

                        <label class="block relative cursor-pointer group">
                            <input type="radio" name="metode_pembayaran" value="transfer" class="peer absolute opacity-0">
                            <div class="p-8 bg-gray-50 border border-gray-100 rounded-[2.5rem] peer-checked:border-[#FFB800] peer-checked:bg-orange-50/50 transition-all group-hover:border-gray-200 shadow-sm flex items-center gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-white border border-gray-100 flex items-center justify-center text-[#FFB800] shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-black text-[#1b1b18] leading-tight">Transfer Bank Manual</h4>
                                    <p class="text-xs font-medium text-[#706f6c]">Transfer ke rekening admin (Verifikasi 5-10 menit)</p>
                                </div>
                                <div class="hidden peer-checked:block text-[#FFB800]">
                                    <svg class="w-6 h-6 animate-in zoom-in duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </label>

                        <label class="block relative cursor-pointer group">
                            <input type="radio" name="metode_pembayaran" value="cod" class="peer absolute opacity-0">
                            <div class="p-8 bg-gray-50 border border-gray-100 rounded-[2.5rem] peer-checked:border-[#FFB800] peer-checked:bg-orange-50/50 transition-all group-hover:border-gray-200 shadow-sm flex items-center gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-white border border-gray-100 flex items-center justify-center text-[#FFB800] shrink-0 shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-black text-[#1b1b18] leading-tight">Bayar di Tempat (COD)</h4>
                                    <p class="text-xs font-medium text-[#706f6c]">Bayar langsung ke kurir saat barang sampai</p>
                                </div>
                                <div class="hidden peer-checked:block text-[#FFB800]">
                                    <svg class="w-6 h-6 animate-in zoom-in duration-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>


            </div>

            <!-- Ringkasan Sticky Column -->
            <div class="lg:col-span-4 space-y-8 animate-in fade-in slide-in-from-right duration-1000">
                <div class="bg-[#1b1b18] rounded-[3.5rem] p-10 shadow-2xl relative overflow-hidden sticky top-24 text-white">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-[#FFB800] rounded-full blur-3xl opacity-20"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-2xl font-black tracking-tight mb-8">Ringkasan</h3>
                        
                        <div class="max-h-64 overflow-y-auto mb-8 pr-4 space-y-6 scrollbar-thin scrollbar-thumb-white/10">
                            @foreach($cart as $item)
                            <div class="flex items-center gap-6 p-4 rounded-[2rem] hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                                <div class="w-24 h-24 bg-gray-100 rounded-[1.5rem] overflow-hidden shrink-0 shadow-sm">
                                    @if(!empty($item['foto']))
                                        <img src="{{ asset('storage/' . $item['foto']) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-black text-[#1b1b18] mb-1">{{ $item['nama'] ?? 'Mangga Premium' }}</h4>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $item['jumlah'] ?? 0 }} KG × Rp{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-black text-[#FFB800]">Rp{{ number_format(($item['harga'] ?? 0) * ($item['jumlah'] ?? 0), 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @php
                            // Asumsi ongkos kirim disesuaikan via JS nanti, untuk demo kita set 15000 fixed default
                            $ongkir = 15000;
                            $biayaLayanan = 2500;
                        @endphp
                        
                        <div class="space-y-4 mb-8 pt-6 border-t border-white/10">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Subtotal</span>
                                <span class="font-black">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ongkos Kirim</span>
                                <span class="font-black" id="display-shipping">Rp{{ number_format($ongkir, 0, ',', '.') }}</span>
                                <input type="hidden" name="biaya_pengiriman" id="input-shipping" value="{{ $ongkir }}">
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Biaya Layanan</span>
                                <span class="font-black">Rp{{ number_format($biayaLayanan, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="pt-6 mt-6 border-t border-white/10">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Pembayaran</p>
                                <p class="text-4xl font-black text-white" id="display-total">Rp{{ number_format($totalPrice + $ongkir + $biayaLayanan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full py-6 bg-[#FFB800] text-white rounded-[2rem] font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-orange-900/40 hover:bg-[#10B981] transition-all transform hover:scale-[1.02] active:scale-[0.98] flex justify-center items-center gap-3">
                            BUAT PESANAN
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                        
                        <div class="mt-6 flex justify-center items-center gap-2 text-gray-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-[8px] font-black uppercase tracking-widest">Transaksi 100% Aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingInputs = document.querySelectorAll('input[name="metode_pengiriman"]');
        const subtotal = {{ $totalPrice }};
        const serviceFee = 2500;
        
        // Midtrans config (if needed by Snap.js elsewhere, but here we just need the IDs)
        const shippingRates = {
            'same_day': 25000,
            'next_day': 15000,
            'reguler': 10000
        };

        const shippingLabel = document.getElementById('display-shipping');
        const shippingInput = document.getElementById('input-shipping');
        const totalLabel = document.getElementById('display-total');

        function updateTotals() {
            let selectedInput = document.querySelector('input[name="metode_pengiriman"]:checked');
            let selectedMethod = selectedInput ? selectedInput.value : 'reguler';
            let shippingCost = shippingRates[selectedMethod] || 15000;
            let total = subtotal + shippingCost + serviceFee;

            if(shippingLabel) shippingLabel.innerText = 'Rp' + shippingCost.toLocaleString('id-ID');
            if(shippingInput) shippingInput.value = shippingCost;
            if(totalLabel) totalLabel.innerText = 'Rp' + total.toLocaleString('id-ID');
        }

        shippingInputs.forEach(input => {
            input.addEventListener('change', updateTotals);
        });

        // Initialize
        updateTotals();
    });
</script>
@endpush
