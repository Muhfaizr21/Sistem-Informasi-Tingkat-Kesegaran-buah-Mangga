@extends('layouts.pembeli')

@section('title', 'Kebijakan Privasi - SI-Mangga')

@section('content')
<div class="max-w-4xl mx-auto py-12">
    <div class="bg-white rounded-[3rem] p-10 md:p-16 border border-gray-100 shadow-[0_20px_60px_-20px_rgba(0,0,0,0.05)]">
        <h1 class="text-4xl font-black text-[#1b1b18] mb-8 tracking-tight">Kebijakan <span class="text-[#FFB800]">Privasi</span></h1>
        
        <div class="prose prose-lg text-gray-600 font-medium leading-relaxed">
            <p class="mb-6">
                Privasi Anda sangat penting bagi kami. Kebijakan ini menjelaskan bagaimana SI-Mangga mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat Anda menggunakan layanan kami.
            </p>
            
            <h3 class="text-xl font-black text-[#1b1b18] mt-8 mb-4">1. Pengumpulan Informasi</h3>
            <p class="mb-6">
                Kami mengumpulkan informasi yang Anda berikan secara langsung saat mendaftar akun, seperti nama, alamat email, nomor telepon, dan alamat pengiriman. Kami juga mengumpulkan gambar yang Anda unggah saat menggunakan fitur Scan AI.
            </p>

            <h3 class="text-xl font-black text-[#1b1b18] mt-8 mb-4">2. Penggunaan Informasi</h3>
            <p class="mb-6">
                Informasi Anda digunakan untuk memproses pesanan, menyediakan layanan pelanggan, dan meningkatkan akurasi sistem Scan AI kami. Gambar scan yang Anda kirim mungkin digunakan secara anonim untuk melatih model kecerdasan buatan kami.
            </p>

            <h3 class="text-xl font-black text-[#1b1b18] mt-8 mb-4">3. Keamanan Data</h3>
            <p class="mb-6">
                Kami menerapkan standar keamanan industri untuk melindungi informasi Anda dari akses yang tidak sah, modifikasi, atau penghancuran. Detail pembayaran diproses melalui gateway aman dan tidak pernah disimpan dalam server kami.
            </p>

            <h3 class="text-xl font-black text-[#1b1b18] mt-8 mb-4">4. Hak Anda</h3>
            <p class="mb-6">
                Anda memiliki hak untuk mengakses, memperbarui, atau menghapus informasi pribadi Anda dari sistem kami. Anda dapat melakukannya melalui menu profil Anda.
            </p>
        </div>
    </div>
</div>
@endsection
