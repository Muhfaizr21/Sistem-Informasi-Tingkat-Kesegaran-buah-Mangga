@extends('layouts.pembeli')

@section('title', 'Dashboard Pembeli')

@section('content')
<div class="relative min-h-screen pb-20">
    <!-- Welcome Section -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6 animate-in fade-in slide-in-from-left duration-700">
        <div>
            <h1 class="text-4xl md:text-5xl font-black text-[#1b1b18] tracking-tight mb-2">
                Halo, <span class="text-[#F53003]">{{ explode(' ', $user->nama)[0] }}</span>! 👋
            </h1>
            <p class="text-lg text-[#706f6c] font-medium">Temukan mangga terbaik dari tanah Indramayu hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-2xl border border-emerald-100 flex items-center gap-2 shadow-sm">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-black uppercase tracking-widest">Sistem AI Aktif</span>
            </div>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-16 animate-in fade-in slide-in-from-bottom duration-700 delay-100">
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] transition-all group">
            <div class="w-12 h-12 bg-orange-50 text-[#F53003] rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-1">Total Scan</p>
            <p class="text-3xl font-black text-[#1b1b18]">{{ number_format($stats['total_scan'] ?? 0) }}</p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] transition-all group">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-1">Pesanan</p>
            <p class="text-3xl font-black text-[#1b1b18]">{{ number_format($stats['total_pesanan'] ?? 0) }}</p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] transition-all group">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-1">Mango Poin</p>
            <p class="text-3xl font-black text-[#1b1b18]">{{ number_format($stats['poin_loyalitas'] ?? 0) }}</p>
        </div>

        <div class="bg-[#F53003] p-8 rounded-[2.5rem] shadow-[0_20px_40px_-15px_rgba(245,48,3,0.3)] hover:shadow-[0_30px_60px_-15px_rgba(245,48,3,0.4)] transition-all group relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-bold text-white/60 uppercase tracking-[0.2em] mb-1">Membership</p>
                <p class="text-3xl font-black text-white">{{ $stats['tier'] ?? 'Bronze' }}</p>
                <div class="mt-4 flex items-center gap-2">
                    <div class="flex-1 h-1 bg-white/20 rounded-full overflow-hidden">
                        <div class="h-full bg-white w-2/3"></div>
                    </div>
                    <span class="text-[8px] font-black text-white/80 uppercase">Elite Tier</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left: Action & Feed -->
        <div class="lg:col-span-8 space-y-12">
            <!-- AI Scanner CTA -->
            <div class="relative bg-[#1b1b18] rounded-[3.5rem] p-10 lg:p-16 overflow-hidden group shadow-2xl">
                <div class="absolute top-0 right-0 p-12 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12a5 5 0 110-10 5 5 0 010 10zm0-2a3 3 0 100-6 3 3 0 000 6zm9 11a1 1 0 01-2 0v-2a3 3 0 00-3-3H8a3 3 0 00-3 3v2a1 1 0 01-2 0v-2a5 5 0 015-5h8a5 5 0 015 5v2z"></path></svg>
                </div>
                
                <div class="relative z-10 max-w-md">
                    <h2 class="text-4xl font-black text-white tracking-tight mb-6">Diagnosa Kualitas <br><span class="text-[#F53003]">Tanpa Ragu.</span></h2>
                    <p class="text-lg text-gray-400 mb-10 leading-relaxed font-medium">Gunakan teknologi Deep Neural Network kami untuk memverifikasi tingkat kematangan mangga Anda secara instan.</p>
                    <a href="{{ route('pembeli.scan') }}" class="inline-flex items-center px-10 py-5 bg-[#F53003] text-white rounded-[2rem] font-black text-sm tracking-widest uppercase hover:bg-[#FF4433] hover:scale-105 transition-all shadow-xl shadow-orange-900/40 group">
                        MULAI SCAN AI
                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Marketplace Preview -->
            <div class="space-y-8">
                <div class="flex items-end justify-between px-4">
                    <div>
                        <h3 class="text-2xl font-black text-[#1b1b18] tracking-tight">Panen Unggulan</h3>
                        <p class="text-sm text-gray-400 font-medium mt-1">Hasil kurasi terbaik hari ini</p>
                    </div>
                    <a href="{{ route('pembeli.marketplace.katalog') }}" class="text-xs font-black text-[#F53003] uppercase tracking-widest hover:underline">Lihat Katalog</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($recent_listings ?? [] as $listing)
                    @php 
                        /** @var \App\Models\ListingMangga $listing */
                        $foto = isset($listing->foto_batch) && is_array($listing->foto_batch) ? ($listing->foto_batch[0] ?? null) : null;
                    @endphp
                    <div class="bg-white rounded-[2.5rem] border border-gray-100 p-4 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_50px_-15px_rgba(0,0,0,0.1)] transition-all group">
                        <div class="aspect-[16/10] bg-gray-50 rounded-[2rem] overflow-hidden mb-6 relative">
                            @if($foto)
                                <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4">
                                <div class="px-2 py-1 bg-white/90 backdrop-blur rounded-lg text-[9px] font-black text-emerald-600 shadow-sm border border-emerald-50 tracking-tighter">AI: {{ number_format(optional($listing)->skor_kesegaran ?? 0, 0) }}% FRESH</div>
                            </div>
                        </div>
                        
                        <div class="px-4 pb-4">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-lg font-black text-[#1b1b18] group-hover:text-[#F53003] transition-colors truncate pr-2">{{ optional($listing)->jenis_mangga ?? 'Mangga Premium' }}</h4>
                                <span class="text-lg font-black text-[#1b1b18]">Rp{{ number_format(optional($listing)->harga_per_kg ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-400 font-medium flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ optional(optional(optional($listing)->lahan)->kecamatan)->nama ?? 'Indramayu' }}
                                </p>
                                @if(isset($listing->id))
                                <a href="{{ route('pembeli.marketplace.detail', $listing->id) }}" class="text-[9px] font-black text-gray-400 uppercase tracking-widest hover:text-[#F53003] transition-colors">Beli Sekarang</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-gray-50 rounded-[2rem] border border-dashed border-gray-200 text-gray-400 font-medium italic">
                        Belum ada rekomendasi panen hari ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Actions Sidebar -->
        <div class="lg:col-span-4 space-y-8 animate-in fade-in slide-in-from-right duration-1000">
            <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-[0_20px_60px_-20px_rgba(0,0,0,0.05)]">
                <h3 class="text-xl font-black text-[#1b1b18] tracking-tight mb-8">Pintasan Elite</h3>
                
                <div class="space-y-4">
                    <a href="{{ route('pembeli.pesanan.index') }}" class="flex items-center p-4 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50 transition-all group">
                        <div class="w-14 h-14 bg-orange-50 text-[#F53003] rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-black text-[#1b1b18] uppercase tracking-widest">Riwayat Order</p>
                            <p class="text-[10px] text-gray-400 font-bold mt-1">Lacak status kiriman</p>
                        </div>
                    </a>

                    <a href="{{ route('pembeli.alamat.index') }}" class="flex items-center p-4 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50 transition-all group">
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-black text-[#1b1b18] uppercase tracking-widest">Alamat Saya</p>
                            <p class="text-[10px] text-gray-400 font-bold mt-1">Atur lokasi pengiriman</p>
                        </div>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex items-center p-4 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50 transition-all group">
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-black text-[#1b1b18] uppercase tracking-widest">Profil Saya</p>
                            <p class="text-[10px] text-gray-400 font-bold mt-1">Ubah info dan keamanan</p>
                        </div>
                    </a>

                    <a href="{{ route('pembeli.notifications.index') }}" class="flex items-center p-4 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50 transition-all group">
                        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-black text-[#1b1b18] uppercase tracking-widest">Notifikasi</p>
                            <p class="text-[10px] text-gray-400 font-bold mt-1">Cek info stok terbaru</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Loyalty Box -->
            <div class="bg-gradient-to-br from-[#F53003] to-orange-600 rounded-[3rem] p-10 text-white shadow-2xl shadow-orange-900/20 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform"></div>
                <div class="relative z-10">
                    <h4 class="text-lg font-black uppercase tracking-widest mb-4 flex items-center gap-2">
                        Poin Loyalitas
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </h4>
                    <p class="text-5xl font-black mb-6">{{ number_format($stats['poin_loyalitas'] ?? 0) }}</p>
                    <p class="text-xs font-bold text-white/70 leading-relaxed uppercase tracking-tighter">Gunakan poin Anda untuk mendapatkan diskon eksklusif di pembelian berikutnya.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
