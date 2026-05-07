@extends('layouts.pembeli')

@section('title', 'Detail Pesanan ' . $pesanan->kode_pesanan)

@section('content')
<div class="relative min-h-screen pb-20">
    <div class="mb-8 animate-in fade-in slide-in-from-top duration-500">
        <a href="{{ route('pembeli.pesanan.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-100 rounded-xl text-xs font-black text-gray-500 uppercase tracking-widest hover:bg-gray-50 hover:text-[#1b1b18] transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            KEMBALI KE DAFTAR PESANAN
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left: Tracking & Items -->
        <div class="lg:col-span-8 space-y-10 animate-in fade-in slide-in-from-left duration-1000">
            <!-- Tracking Timeline -->
            <div class="bg-white rounded-[3.5rem] p-10 lg:p-14 border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden group">
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#FFB800] rounded-full blur-3xl opacity-5 group-hover:opacity-10 transition-opacity"></div>
                
                <h2 class="text-2xl font-black text-[#1b1b18] tracking-tight mb-12 relative z-10 flex items-center gap-4">
                    Status Pengiriman
                    <span class="px-3 py-1 bg-orange-50 text-[#FFB800] text-[10px] uppercase tracking-widest rounded-lg border border-orange-100">Live Track</span>
                </h2>
                
                <div class="relative z-10 space-y-10">
                    @php
                        $steps = [
                            'menunggu_bayar' => ['label' => 'Menunggu Pembayaran', 'desc' => 'Menunggu upload bukti pembayaran.', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                            'menunggu_verifikasi' => ['label' => 'Verifikasi Admin', 'desc' => 'Bukti pembayaran sedang diverifikasi oleh admin.', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                            'dikonfirmasi' => ['label' => 'Dikonfirmasi', 'desc' => 'Pembayaran berhasil diverifikasi admin.', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'dikemas' => ['label' => 'Sedang Dikemas', 'desc' => 'Pesanan sedang disiapkan oleh petani.', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                            'dikirim' => ['label' => 'Dalam Pengiriman', 'desc' => 'Pesanan sedang dalam perjalanan ke alamat Anda.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            'selesai' => ['label' => 'Pesanan Selesai', 'desc' => 'Pesanan telah diterima dengan baik.', 'icon' => 'M5 13l4 4L19 7'],
                        ];
                        $currentStatus = $pesanan->status;
                        $reached = true;
                    @endphp

                    @foreach($steps as $status => $data)
                    <div class="flex gap-8 relative group/step">
                        @if(!$loop->last)
                        <div class="absolute left-[27px] top-[56px] w-[2px] h-[calc(100%-16px)] {{ $reached ? 'bg-[#FFB800]' : 'bg-gray-100' }} transition-colors duration-500"></div>
                        @endif
                        
                        <div class="w-14 h-14 rounded-[1.2rem] flex items-center justify-center shrink-0 z-10 transition-all duration-500 {{ $reached ? 'bg-[#FFB800] text-white shadow-xl shadow-orange-900/30 scale-110' : 'bg-gray-50 border border-gray-100 text-gray-400' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['icon'] }}"></path></svg>
                        </div>
                        
                        <div class="flex-1 pt-3">
                            <p class="text-lg font-black {{ $reached ? 'text-[#1b1b18]' : 'text-gray-400' }} tracking-tight mb-1">{{ $data['label'] }}</p>
                            
                            @if($status === 'selesai' && $pesanan->selesai_pada)
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">{{ $pesanan->selesai_pada->format('d M Y, H:i') }} WIB</p>
                                <p class="text-sm font-medium text-[#706f6c]">{{ $data['desc'] }}</p>
                            @elseif($status === $pesanan->status)
                                <span class="inline-block mt-2 px-3 py-1 bg-green-50 text-green-600 text-[9px] font-black uppercase tracking-widest rounded-lg border border-green-100 animate-pulse">Status Saat Ini</span>
                            @elseif($reached)
                                <p class="text-sm font-medium text-gray-500">{{ $data['desc'] }}</p>
                            @endif
                        </div>
                    </div>
                    @php if($status === $pesanan->status) $reached = false; @endphp
                    @endforeach
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-[3.5rem] p-10 lg:p-14 border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)]">
                <h2 class="text-2xl font-black text-[#1b1b18] tracking-tight mb-8">Rincian Produk</h2>
                <div class="space-y-6">
                    @foreach($pesanan->items as $item)
                    <div class="flex items-center gap-6 p-4 rounded-[2rem] hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                        <div class="w-24 h-24 bg-gray-100 rounded-[1.5rem] overflow-hidden shrink-0 shadow-sm">
                            @if($item->listing && is_array($item->listing->foto_batch) && count($item->listing->foto_batch) > 0)
                                <img src="{{ asset('storage/' . $item->listing->foto_batch[0]) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-black text-[#1b1b18] mb-1">{{ $item->listing?->jenis_mangga ?? 'Mangga Premium' }}</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $item->jumlah_kg }} KG × Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-black text-[#FFB800]">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Review Section -->
            @if($pesanan->status === 'selesai' && !$pesanan->review)
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-[3.5rem] p-10 lg:p-14 border border-orange-100 shadow-xl shadow-orange-100/50">
                <div class="mb-10 text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-amber-500">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-black text-[#1b1b18] tracking-tight mb-2">Berikan Ulasan Anda</h2>
                    <p class="text-sm font-medium text-orange-800/60">Bantu petani kami dan pembeli lain dengan ulasan jujur Anda.</p>
                </div>

                <form action="{{ route('pembeli.pesanan.review', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-orange-800/50 uppercase tracking-[0.2em] mb-4 text-center">Rating Kualitas</label>
                        <div class="flex gap-4 justify-center">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                <div class="w-14 h-14 rounded-2xl bg-white border-2 border-transparent flex items-center justify-center peer-checked:bg-[#FFB800] peer-checked:border-[#FFB800] peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-orange-900/20 text-[#1b1b18] transition-all transform group-hover:scale-110 shadow-sm">
                                    <span class="text-xl font-black">{{ $i }}</span>
                                </div>
                            </label>
                            @endfor
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-orange-800/50 uppercase tracking-[0.2em] mb-3 ml-2">Ceritakan Pengalaman Anda</label>
                        <textarea name="komentar" rows="4" class="w-full px-6 py-5 bg-white border border-transparent rounded-[1.5rem] focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all shadow-sm font-medium text-[#1b1b18] resize-none" placeholder="Bagaimana rasa mangganya? Pengirimannya aman?"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-orange-800/50 uppercase tracking-[0.2em] mb-3 ml-2">Upload Foto (Opsional)</label>
                        <div class="relative w-full bg-white border-2 border-dashed border-orange-200 rounded-[1.5rem] p-8 text-center hover:bg-orange-50 transition-colors">
                            <input type="file" name="foto_review[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <svg class="w-8 h-8 text-orange-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-bold text-orange-800">Klik atau Drag foto ke sini</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#1b1b18] text-white rounded-[1.5rem] font-black text-xs tracking-widest uppercase hover:bg-black transition-all shadow-xl shadow-black/10 active:scale-95">
                        Kirim Ulasan Sekarang
                    </button>
                </form>
            </div>
            @elseif($pesanan->review)
            <div class="bg-emerald-50 border border-emerald-100 rounded-[3.5rem] p-10 lg:p-14 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-32 h-32 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
                
                <h2 class="text-2xl font-black text-emerald-900 tracking-tight mb-6">Ulasan Anda</h2>
                <div class="flex items-center gap-2 mb-6 bg-white w-fit px-4 py-2 rounded-2xl shadow-sm">
                    @for($i=1; $i<=5; $i++)
                        <svg class="w-6 h-6 {{ $i <= $pesanan->review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    @endfor
                </div>
                <p class="text-emerald-800/80 font-medium leading-relaxed mb-6 bg-white/50 p-6 rounded-2xl border border-white">"{{ $pesanan->review->komentar }}"</p>
                
                @if($pesanan->review->foto_review)
                <div class="flex gap-4">
                    @foreach($pesanan->review->foto_review as $foto)
                    <div class="w-24 h-24 rounded-2xl overflow-hidden shadow-sm border border-white">
                        <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Right: Summary & Address (Sticky) -->
        <div class="lg:col-span-4 space-y-8 animate-in fade-in slide-in-from-right duration-1000">
            <div class="sticky top-24 space-y-8">
                <!-- Address Box -->
                <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)]">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Alamat Tujuan</h2>
                    <div class="space-y-3 mb-8">
                        <p class="font-black text-lg text-[#1b1b18] leading-tight">{{ $pesanan->alamat?->nama_penerima ?? '-' }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $pesanan->alamat?->no_telepon ?? '-' }}</p>
                        <div class="pt-4 mt-4 border-t border-gray-100">
                            <p class="text-sm font-medium text-[#706f6c] leading-relaxed">
                                {{ $pesanan->alamat?->alamat_lengkap ?? '-' }}<br>
                                {{ $pesanan->alamat?->kecamatan?->nama ?? 'Lokasi tidak diketahui' }}, {{ $pesanan->alamat?->kota ?? 'Indramayu' }}<br>
                                {{ $pesanan->alamat?->kode_pos ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-gray-100">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Metode Pengiriman</h2>
                        @php
                            $shippingMap = [
                                'same_day' => ['label' => 'Instan', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                                'next_day' => ['label' => 'Next Day', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                'reguler' => ['label' => 'Reguler', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ];
                            $sInfo = $shippingMap[$pesanan->metode_pengiriman] ?? ['label' => $pesanan->metode_pengiriman, 'icon' => 'M5 13l4 4L19 7'];
                            
                            $baseDate = $pesanan->created_at;
                            if ($pesanan->metode_pengiriman === 'same_day') {
                                $eta = 'Hari Ini (' . $baseDate->translatedFormat('d M Y') . ')';
                            } elseif ($pesanan->metode_pengiriman === 'next_day') {
                                $eta = 'Besok (' . $baseDate->copy()->addDay()->translatedFormat('d M Y') . ')';
                            } else {
                                $eta = $baseDate->copy()->addDays(2)->translatedFormat('d M') . ' - ' . $baseDate->copy()->addDays(3)->translatedFormat('d M Y');
                            }
                        @endphp
                        <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#FFB800] shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sInfo['icon'] }}"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-[#1b1b18]">{{ $sInfo['label'] }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Estimasi Tiba: {{ $eta }}</p>
                            </div>
                    </div>
                </div>

                <!-- Manage Order Box -->
                @if($pesanan->status === 'menunggu_bayar' || ($pesanan->status === 'menunggu_verifikasi' && $pesanan->metode_pembayaran === 'cod'))
                <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)]">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Kelola Pesanan</h2>
                    
                    <div class="space-y-6">
                        <!-- Change Payment Method -->
                        <form action="{{ route('pembeli.pesanan.update-payment-method', $pesanan->id) }}" method="POST">
                            @csrf
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Ganti Metode Pembayaran</label>
                            <div class="flex gap-2">
                                <select name="metode_pembayaran" class="flex-1 bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-[#FFB800] outline-none">
                                    <option value="midtrans" {{ $pesanan->metode_pembayaran == 'midtrans' ? 'selected' : '' }}>Midtrans (Otomatis)</option>
                                    <option value="transfer" {{ $pesanan->metode_pembayaran == 'transfer' ? 'selected' : '' }}>Transfer Bank (Manual)</option>
                                    <option value="cod" {{ $pesanan->metode_pembayaran == 'cod' ? 'selected' : '' }}>Bayar di Tempat (COD)</option>
                                </select>
                                <button type="submit" class="px-6 py-3 bg-[#1b1b18] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-colors shadow-lg shadow-black/10">
                                    SIMPAN
                                </button>
                            </div>
                        </form>

                        @if($pesanan->status === 'menunggu_bayar')
                        <!-- Cancel Order -->
                        <div class="pt-6 border-t border-gray-100">
                            <form action="{{ route('pembeli.pesanan.batal', $pesanan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-red-50 text-red-500 border border-red-100 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    BATALKAN PESANAN
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Payment Summary Box -->
                <div class="bg-[#1b1b18] rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                    
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-8 relative z-10">Ringkasan Pembayaran</h2>
                    
                    <div class="space-y-4 relative z-10">
                        <div class="flex justify-between items-center text-sm text-gray-400">
                            <span class="font-medium">Subtotal Produk</span>
                            <span class="font-bold text-white">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm text-gray-400">
                            <span class="font-medium">Biaya Pengiriman</span>
                            <span class="font-bold text-white">Rp{{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm text-gray-400">
                            <span class="font-medium">Biaya Layanan</span>
                            <span class="font-bold text-white">Rp{{ number_format($pesanan->biaya_layanan, 0, ',', '.') }}</span>
                        </div>
                        
                        
                        <div class="pt-6 mt-6 border-t border-white/10 flex justify-between items-end">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Bayar</span>
                            <span class="text-3xl font-black text-[#FFB800]">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-8 border-t border-white/10 relative z-10 text-center">
                        <p class="text-[9px] text-gray-500 uppercase font-black tracking-[0.2em] mb-3">Metode Pembayaran</p>
                        <div class="inline-block px-4 py-2 bg-white/10 rounded-xl">
                            <p class="text-sm font-black tracking-widest">{{ strtoupper(str_replace('_', ' ', $pesanan->metode_pembayaran)) }}</p>
                        </div>
                    </div>
                </div>

                @if($pesanan->status === 'menunggu_bayar')
                    @if($pesanan->metode_pembayaran === 'midtrans')
                        @if($pesanan->snap_token)
                        <button type="button" id="pay-button" class="w-full py-5 bg-[#FFB800] text-white rounded-[2rem] font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-orange-900/30 hover:bg-amber-500 transition-all transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            BAYAR SEKARANG (MIDTRANS)
                        </button>
                        @endif
                    @elseif($pesanan->metode_pembayaran === 'transfer')
                        <!-- Info Rekening -->
                        <div class="bg-gray-50 border border-gray-100 rounded-[2.5rem] p-8 mb-6">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Informasi Pembayaran</h3>
                            <div class="space-y-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-8 bg-white border border-gray-100 rounded-lg flex items-center justify-center font-black text-[#1b1b18] text-[10px]">BCA</div>
                                    <div>
                                        <p class="text-xs font-black text-[#1b1b18]">8832109823</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">A.N SI MANGGA ADMIN</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-8 bg-white border border-gray-100 rounded-lg flex items-center justify-center font-black text-[#1b1b18] text-[10px]">MANDIRI</div>
                                    <div>
                                        <p class="text-xs font-black text-[#1b1b18]">132009823122</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">A.N SI MANGGA ADMIN</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 pt-6 border-t border-gray-100 text-[10px] font-medium text-gray-500 leading-relaxed italic">
                                * Silakan transfer sesuai total tagihan dan upload bukti bayar di bawah ini.
                            </div>
                        </div>

                        <form action="{{ route('pembeli.pesanan.bayar', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="bukti_pembayaran" id="bukti_detail" class="hidden" onchange="this.form.submit()" accept="image/*">
                            <button type="button" onclick="document.getElementById('bukti_detail').click()" class="w-full py-5 bg-[#1b1b18] text-white rounded-[2rem] font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-black/20 hover:bg-black transition-all transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                UPLOAD BUKTI PEMBAYARAN
                            </button>
                        </form>
                    @elseif($pesanan->metode_pembayaran === 'cod')
                        <div class="bg-blue-50 border border-blue-100 rounded-[2.5rem] p-8 text-center">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-blue-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-black text-blue-900 mb-1">Bayar di Tempat (COD)</h3>
                            <p class="text-xs font-medium text-blue-700/60 leading-relaxed">Silakan siapkan uang tunai sebesar <strong>Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</strong> saat kurir tiba.</p>
                        </div>
                    @endif
                @endif

                @if($pesanan->status === 'dikirim')
                <form action="{{ route('pembeli.pesanan.selesai', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="foto_selesai" id="foto_selesai_detail" class="hidden" onchange="this.form.submit()" accept="image/*">
                    <button type="button" onclick="document.getElementById('foto_selesai_detail').click()" class="w-full py-5 bg-emerald-500 text-white rounded-[2rem] font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-emerald-900/30 hover:bg-emerald-600 transition-all transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        UPLOAD FOTO & KONFIRMASI DITERIMA
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    const payButton = document.getElementById('pay-button');
    if (payButton) {
        const triggerPay = () => {
            window.snap.pay('{{ $pesanan->snap_token }}', {
                onSuccess: function (result) {
                    window.location.reload();
                },
                onPending: function (result) {
                    window.location.reload();
                },
                onError: function (result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function () {
                    console.log('Customer closed the popup without finishing the payment');
                }
            });
        };

        payButton.addEventListener('click', triggerPay);

        @if(session('success'))
            // Auto trigger pay on first load after checkout
            setTimeout(triggerPay, 1000);
        @endif
    }
</script>
@endpush
