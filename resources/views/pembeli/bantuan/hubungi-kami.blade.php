@extends('layouts.pembeli')

@section('title', 'Hubungi Kami - SI-Mangga')

@section('content')
<div class="max-w-4xl mx-auto py-12">
    <div class="bg-white rounded-[3rem] p-10 md:p-16 border border-gray-100 shadow-[0_20px_60px_-20px_rgba(0,0,0,0.05)]">
        <h1 class="text-4xl font-black text-[#1b1b18] mb-8 tracking-tight">Hubungi <span class="text-[#FFB800]">Kami</span></h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <p class="text-gray-600 font-medium leading-relaxed mb-8">
                    Punya pertanyaan, keluhan, atau sekadar ingin memberikan saran? Tim bantuan kami siap membantu Anda kapan saja.
                </p>

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined fill-1">mail</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Email</p>
                            <p class="text-lg font-black text-[#1b1b18]">support@si-mangga.id</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined fill-1">call</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Telepon / WhatsApp</p>
                            <p class="text-lg font-black text-[#1b1b18]">+62 811 2345 6789</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-50 text-[#FFB800] rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined fill-1">location_on</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Kantor Pusat</p>
                            <p class="font-bold text-[#1b1b18]">Jl. Raya Lohbener No. 112,<br>Indramayu, Jawa Barat</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <form class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                        <input type="text" class="w-full bg-gray-50 border border-gray-200 text-[#1b1b18] text-sm rounded-2xl focus:ring-[#FFB800] focus:border-[#FFB800] block p-4 font-medium" placeholder="Nama Anda">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Pesan Anda</label>
                        <textarea rows="4" class="w-full bg-gray-50 border border-gray-200 text-[#1b1b18] text-sm rounded-2xl focus:ring-[#FFB800] focus:border-[#FFB800] block p-4 font-medium" placeholder="Tuliskan pesan Anda..."></textarea>
                    </div>
                    <button type="button" onclick="alert('Pesan berhasil dikirim! Tim kami akan segera menghubungi Anda.')" class="w-full py-4 bg-[#1b1b18] text-white rounded-2xl text-[10px] font-black text-center uppercase tracking-widest hover:bg-[#FFB800] transition-all">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
