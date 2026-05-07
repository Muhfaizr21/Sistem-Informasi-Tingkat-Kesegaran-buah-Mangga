@extends('layouts.pembeli')

@section('title', 'Dashboard Pembeli')

@section('content')
<div class="relative min-h-screen pb-20">
    <!-- Welcome Section -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6 animate-in fade-in slide-in-from-left duration-700">
        <div>
            <h1 class="text-4xl md:text-5xl font-black text-[#1b1b18] tracking-tight mb-2">
                Halo, <span class="text-[#FFB800]">{{ explode(' ', $user->nama)[0] }}</span>! 👋
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
    <div class="grid grid-cols-2 gap-6 mb-16 animate-in fade-in slide-in-from-bottom duration-700 delay-100">
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] transition-all group">
            <div class="w-12 h-12 bg-orange-50 text-[#FFB800] rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
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
                    <h2 class="text-4xl font-black text-white tracking-tight mb-6">Diagnosa Kualitas <br><span class="text-[#FFB800]">Tanpa Ragu.</span></h2>
                    <p class="text-lg text-gray-400 mb-10 leading-relaxed font-medium">Gunakan teknologi Deep Neural Network kami untuk memverifikasi tingkat kematangan mangga Anda secara instan.</p>
                    <a href="{{ route('pembeli.scan') }}" class="inline-flex items-center px-10 py-5 bg-[#FFB800] text-white rounded-[2rem] font-black text-sm tracking-widest uppercase hover:bg-[#10B981] hover:scale-105 transition-all shadow-xl shadow-orange-900/40 group">
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
                    <a href="{{ route('pembeli.marketplace.katalog') }}" class="text-xs font-black text-[#FFB800] uppercase tracking-widest hover:underline">Lihat Katalog</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($recent_listings ?? [] as $listing)
                    <div class="bg-white rounded-[2.5rem] border border-gray-100 p-4 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_50px_-15px_rgba(0,0,0,0.1)] transition-all group">
                        <div class="relative h-48 rounded-[2rem] overflow-hidden group/img">
                            @php $foto = is_array($listing->foto_batch) ? ($listing->foto_batch[0] ?? null) : $listing->foto_batch; @endphp
                            @if($foto)
                                <img src="{{ str_starts_with($foto, 'http') ? $foto : asset('storage/' . $foto) }}" class="w-full h-full object-cover group-hover/img:scale-110 transition-transform duration-500 {{ $listing->stok_tersedia_kg <= 0 ? 'grayscale' : '' }}">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300 italic text-xs">No Photo</div>
                            @endif
                            <div class="absolute top-4 left-4 z-10 flex flex-col gap-1.5">
                                <div class="px-2.5 py-1 bg-white/90 backdrop-blur rounded-full text-[8px] font-black tracking-tighter uppercase shadow-sm border border-white">AI {{ number_format($listing->skor_kesegaran ?? 0, 0) }}% FRESH</div>
                                @if($listing->stok_tersedia_kg <= 0)
                                <div class="px-2.5 py-1 bg-red-500 text-white rounded-full text-[8px] font-black tracking-tighter uppercase shadow-lg">Habis</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="px-4 pb-4 mt-6">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-lg font-black text-[#1b1b18] group-hover:text-[#FFB800] transition-colors truncate pr-2">{{ $listing->jenis_mangga ?? 'Mangga Premium' }}</h4>
                                <span class="text-lg font-black text-[#1b1b18]">Rp{{ number_format($listing->harga_per_kg ?? 0, 0, ',', '.') }}</span>
                            </div>
                            
                            <p class="text-xs text-gray-400 font-medium flex items-center mb-6">
                                <svg class="w-3 h-3 mr-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                {{ $listing->lahan?->kecamatan?->nama ?? 'Indramayu' }}
                            </p>

                            @if(($listing->stok_tersedia_kg ?? 0) > 0)
                                <a href="{{ route('pembeli.marketplace.detail', $listing->id) }}" class="w-full py-4 bg-[#1b1b18] text-white rounded-2xl text-[10px] font-black text-center uppercase tracking-widest hover:bg-[#FFB800] transition-all shadow-xl shadow-black/10 flex items-center justify-center gap-2 group/btn">
                                    <span>BELI SEKARANG</span>
                                    <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            @else
                                <button disabled class="w-full py-4 bg-gray-100 text-gray-400 rounded-2xl text-[10px] font-black text-center uppercase tracking-widest cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    <span>HABIS TERJUAL</span>
                                </button>
                            @endif
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
                        <div class="w-14 h-14 bg-orange-50 text-[#FFB800] rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
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

        </div>
    </div>
</div>
@endsection
