@extends('layouts.pembeli')

@section('title', 'Cara Pemesanan - SI-Mangga')

@section('content')
<div class="max-w-4xl mx-auto py-12">
    <div class="bg-white rounded-[3rem] p-10 md:p-16 border border-gray-100 shadow-[0_20px_60px_-20px_rgba(0,0,0,0.05)]">
        <h1 class="text-4xl font-black text-[#1b1b18] mb-8 tracking-tight">Cara <span class="text-[#FFB800]">Pemesanan</span></h1>
        
        <div class="space-y-8 text-gray-600 font-medium leading-relaxed">
            <div class="flex gap-6">
                <div class="w-12 h-12 shrink-0 bg-orange-50 text-[#FFB800] rounded-2xl flex items-center justify-center font-black text-xl">1</div>
                <div>
                    <h3 class="text-xl font-black text-[#1b1b18] mb-2">Pilih Mangga</h3>
                    <p>Jelajahi halaman Marketplace untuk menemukan berbagai jenis mangga berkualitas dari petani terpercaya di Indramayu. Anda dapat melihat detail, ulasan, dan skor kesegaran AI untuk setiap produk.</p>
                </div>
            </div>

            <div class="flex gap-6">
                <div class="w-12 h-12 shrink-0 bg-orange-50 text-[#FFB800] rounded-2xl flex items-center justify-center font-black text-xl">2</div>
                <div>
                    <h3 class="text-xl font-black text-[#1b1b18] mb-2">Masukkan ke Keranjang</h3>
                    <p>Tentukan jumlah (dalam kg) yang ingin Anda beli, lalu klik "Beli Sekarang" atau masukkan ke keranjang belanja Anda.</p>
                </div>
            </div>

            <div class="flex gap-6">
                <div class="w-12 h-12 shrink-0 bg-orange-50 text-[#FFB800] rounded-2xl flex items-center justify-center font-black text-xl">3</div>
                <div>
                    <h3 class="text-xl font-black text-[#1b1b18] mb-2">Checkout & Pengiriman</h3>
                    <p>Pilih alamat pengiriman Anda atau tambahkan alamat baru. Pastikan nomor telepon dan detail lokasi sudah benar agar kurir dapat mengantar dengan tepat waktu.</p>
                </div>
            </div>

            <div class="flex gap-6">
                <div class="w-12 h-12 shrink-0 bg-orange-50 text-[#FFB800] rounded-2xl flex items-center justify-center font-black text-xl">4</div>
                <div>
                    <h3 class="text-xl font-black text-[#1b1b18] mb-2">Pembayaran & Verifikasi</h3>
                    <p>Selesaikan pembayaran melalui metode pembayaran yang tersedia. Setelah itu, sistem akan memverifikasi pesanan Anda dan meneruskannya langsung ke petani untuk segera dikemas.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
