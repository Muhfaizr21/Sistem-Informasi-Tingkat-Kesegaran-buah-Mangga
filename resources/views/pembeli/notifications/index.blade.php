@extends('layouts.pembeli')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1b1b18] mb-1">Pusat Notifikasi</h1>
            <p class="text-[#706f6c]">Informasi terbaru seputar pesanan dan petani favorit Anda.</p>
        </div>
        @if($notifications->where('sudah_dibaca', false)->count() > 0)
        <form action="{{ route('pembeli.notifications.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm font-bold text-[#FFB800] hover:underline">Tandai semua dibaca</button>
        </form>
        @endif
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notif)
        <div class="glass-card rounded-3xl p-6 transition-all {{ $notif->sudah_dibaca ? 'opacity-70' : 'border-l-4 border-l-[#FFB800] shadow-md' }}">
            <div class="flex gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 {{ $notif->sudah_dibaca ? 'bg-gray-100 text-gray-400' : 'bg-orange-50 text-[#FFB800]' }}">
                    @if($notif->tipe === 'pesanan_selesai')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    @elseif($notif->tipe === 'stok_baru')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    @endif
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold {{ $notif->sudah_dibaca ? 'text-[#706f6c]' : 'text-[#1b1b18]' }}">{{ $notif->judul }}</h3>
                        <span class="text-[10px] text-[#706f6c]">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-[#706f6c] leading-relaxed mb-3">{{ $notif->pesan }}</p>
                    
                    @if($notif->referensi_tipe === 'pesanan')
                        <a href="{{ route('pembeli.pesanan.show', $notif->referensi_id) }}" class="text-xs font-bold text-[#FFB800] hover:underline">Lihat Detail Pesanan →</a>
                    @elseif($notif->referensi_tipe === 'listing')
                        <a href="{{ route('pembeli.marketplace.detail', $notif->referensi_id) }}" class="text-xs font-bold text-[#FFB800] hover:underline">Lihat Produk →</a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center glass-card rounded-[2rem]">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <h3 class="text-xl font-bold">Belum Ada Notifikasi</h3>
            <p class="text-[#706f6c]">Semua pemberitahuan akan muncul di sini.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
