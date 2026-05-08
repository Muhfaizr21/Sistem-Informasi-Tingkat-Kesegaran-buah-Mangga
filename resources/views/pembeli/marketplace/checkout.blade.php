@extends('layouts.pembeli')

@section('title', 'Checkout')

@section('content')
<div class="relative animate-in fade-in duration-700">
    <!-- Header -->
    <div class="mb-12 animate-in fade-in slide-in-from-left duration-700">
        <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
            <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
            Final Step
        </div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3.2rem); line-height: 1.1; color: var(--leaf-dark);">
            Selesaikan <span style="color: var(--gold);">Pesanan</span>
        </h1>
        <p class="text-sm mt-2" style="color: var(--text-light);">Satu langkah lagi untuk mendapatkan mangga terbaik dari tanah Indramayu.</p>
    </div>

    @if(session('error'))
    <div class="mb-8 p-6 rounded-[2rem] flex items-center gap-4 shadow-sm animate-in zoom-in duration-500" style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.1);">
        <div class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined">warning</span>
        </div>
        <span class="font-bold text-red-700">{{ session('error') }}</span>
    </div>
    @endif

    <form action="{{ route('pembeli.checkout.process') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Form Sections -->
            <div class="lg:col-span-8 space-y-10">
                <!-- Alamat Pengiriman -->
                <div class="bg-white rounded-[3rem] p-10 border shadow-sm relative overflow-hidden" style="border-color: var(--gold-pale);">
                    <div class="absolute top-0 right-0 p-12 opacity-[0.03]">
                        <span class="material-symbols-outlined text-[180px]" style="color: var(--gold);">location_on</span>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-8">
                            <h2 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);">Alamat <span style="color: var(--gold);">Tujuan</span></h2>
                            <a href="{{ route('pembeli.alamat.index') }}" class="px-4 py-2 rounded-xl text-[10px] font-black tracking-widest uppercase transition-all border no-underline" style="background: var(--cream); border-color: var(--gold-pale); color: var(--text-dark);">
                                + ALAMAT BARU
                            </a>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($alamats as $alamat)
                            <label class="block relative cursor-pointer group">
                                <input type="radio" name="alamat_id" value="{{ $alamat->id }}" class="peer absolute opacity-0" {{ $alamat->utama ? 'checked' : '' }}>
                                <div class="p-8 bg-white border-2 rounded-[2.5rem] peer-checked:!border-[#bef264] peer-checked:border-4 peer-checked:bg-[#bef264]/10 peer-checked:shadow-2xl peer-checked:scale-[1.02] transition-all duration-300 relative overflow-hidden" style="border-color: var(--gold-pale);">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-white border flex items-center justify-center transition-all group-hover:rotate-6" style="border-color: var(--gold-pale);">
                                                <span class="material-symbols-outlined text-var(--text-light) peer-checked:!text-[#bef264] transition-colors">home</span>
                                            </div>
                                            <span class="font-black text-[0.65rem] uppercase tracking-widest transition-colors peer-checked:!text-[#bef264]" style="color: var(--text-mid);">{{ $alamat->label }}</span>
                                        </div>
                                        @if($alamat->utama)
                                        <span class="px-3 py-1 bg-var(--text-dark) text-white text-[8px] font-black uppercase tracking-widest rounded-lg shadow-sm">Utama</span>
                                        @endif
                                    </div>
                                    <div class="pl-14">
                                        <p class="font-black text-xl mb-1 transition-colors peer-checked:text-[#1E3A1A]" style="color: var(--text-dark);">{{ $alamat->nama_penerima ?? 'Penerima' }}</p>
                                        <p class="text-[0.65rem] font-bold uppercase tracking-widest mb-4" style="color: var(--text-light);">{{ $alamat->no_telepon ?? '-' }}</p>
                                        <div class="pt-4 border-t transition-colors peer-checked:!border-[#bef264]/30" style="border-color: var(--gold-pale);">
                                            <p class="text-sm font-medium leading-relaxed" style="color: var(--text-mid);">
                                                {{ $alamat->alamat_lengkap ?? '-' }}<br>
                                                {{ $alamat->kecamatan?->nama ?? 'Indramayu' }}, {{ $alamat->kota ?? 'Indramayu' }} {{ $alamat->kode_pos ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="absolute top-8 right-8 scale-0 peer-checked:scale-125 transition-transform duration-500">
                                        <div class="w-12 h-12 bg-[#bef264] rounded-full flex items-center justify-center shadow-lg shadow-[#bef264]/30 border-4 border-white">
                                            <span class="material-symbols-outlined text-white text-2xl font-bold">check</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            @empty
                            <div class="p-12 border-2 border-dashed rounded-[3rem] text-center" style="border-color: var(--gold-pale); background: var(--cream);">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border" style="border-color: var(--gold-pale);">
                                    <span class="material-symbols-outlined text-4xl opacity-20" style="color: var(--gold);">location_off</span>
                                </div>
                                <p class="text-lg font-bold mb-2" style="color: var(--text-dark);">Belum Ada Alamat</p>
                                <p class="text-sm mb-6" style="color: var(--text-light);">Silakan tambahkan alamat pengiriman terlebih dahulu.</p>
                                <a href="{{ route('pembeli.alamat.index') }}" class="px-8 py-4 rounded-xl font-black text-[0.7rem] uppercase tracking-widest transition-all shadow-lg no-underline" style="background: var(--text-dark); color: white;">TAMBAH ALAMAT BARU</a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Metode Pengiriman -->
                <div class="bg-white rounded-[3rem] p-10 border shadow-sm" style="border-color: var(--gold-pale);">
                    <h2 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);" class="mb-8">Pilih <span style="color: var(--gold);">Layanan</span></h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php $ships = [
                            ['val'=>'same_day', 'icon'=>'bolt', 'name'=>'Instan', 'desc'=>'Tiba Hari Ini', 'price'=>25000],
                            ['val'=>'next_day', 'icon'=>'local_shipping', 'name'=>'Next Day', 'desc'=>'Tiba Besok', 'price'=>15000],
                            ['val'=>'reguler', 'icon'=>'package', 'name'=>'Reguler', 'desc'=>'2-3 Hari', 'price'=>10000]
                        ]; @endphp
                        @foreach($ships as $s)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="metode_pengiriman" value="{{ $s['val'] }}" class="peer absolute opacity-0" {{ $loop->first ? 'checked' : '' }}>
                            <div class="p-6 border-2 rounded-[2rem] peer-checked:!border-[#bef264] peer-checked:border-4 peer-checked:bg-[#bef264]/10 peer-checked:shadow-xl peer-checked:scale-[1.05] transition-all duration-300 text-center h-full flex flex-col justify-between group-hover:border-[#bef264]" style="background: var(--cream); border-color: var(--gold-pale);">
                                <div>
                                    <div class="w-12 h-12 rounded-full mx-auto flex items-center justify-center mb-4 transition-all bg-white peer-checked:!border-[#bef264] border">
                                        <span class="material-symbols-outlined text-var(--text-dark) peer-checked:!text-[#bef264] transition-colors">{{ $s['icon'] }}</span>
                                    </div>
                                    <p class="font-black text-lg mb-1 peer-checked:!text-[#bef264] transition-colors">{{ $s['name'] }}</p>
                                    <p class="text-[0.6rem] font-bold uppercase tracking-widest opacity-60 mb-4 transition-colors">{{ $s['desc'] }}</p>
                                </div>
                                <div class="py-2 rounded-xl bg-white/50 peer-checked:bg-[#bef264]/10 transition-all">
                                    <p class="font-black text-[#D4A017] peer-checked:!text-[#bef264] transition-colors">Rp{{ number_format($s['price'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="bg-white rounded-[3rem] p-10 border shadow-sm" style="border-color: var(--gold-pale);">
                    <h2 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);" class="mb-8">Metode <span style="color: var(--gold);">Pembayaran</span></h2>
                    <div class="space-y-4">
                        @php $pays = [
                            ['val'=>'midtrans', 'icon'=>'account_balance_wallet', 'name'=>'Pembayaran Instan', 'desc'=>'QRIS, GOPAY, OVO, Virtual Account (Otomatis)'],
                            ['val'=>'transfer', 'icon'=>'account_balance', 'name'=>'Transfer Bank Manual', 'desc'=>'Transfer ke rekening admin (Verifikasi 5-10 menit)'],
                            ['val'=>'cod', 'icon'=>'payments', 'name'=>'Bayar di Tempat (COD)', 'desc'=>'Bayar langsung ke kurir saat barang sampai']
                        ]; @endphp
                        @foreach($pays as $p)
                        <label class="block relative cursor-pointer group">
                            <input type="radio" name="metode_pembayaran" value="{{ $p['val'] }}" class="peer absolute opacity-0" {{ $loop->first ? 'checked' : '' }}>
                            <div class="p-8 border-2 rounded-[2.5rem] peer-checked:!border-[#bef264] peer-checked:border-4 peer-checked:bg-[#bef264]/10 peer-checked:shadow-xl peer-checked:scale-[1.02] transition-all duration-300 flex items-center gap-6 relative overflow-hidden" style="border-color: var(--gold-pale); background: var(--cream);">
                                <div class="w-14 h-14 rounded-2xl bg-white border flex items-center justify-center shrink-0 shadow-sm group-hover:rotate-6 transition-all peer-checked:!border-[#bef264]/30" style="border-color: var(--gold-pale); color: var(--gold);">
                                    <span class="material-symbols-outlined text-3xl transition-transform peer-checked:scale-125 peer-checked:!text-[#bef264]">{{ $p['icon'] }}</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-black leading-tight transition-colors peer-checked:text-[#1E3A1A]" style="color: var(--text-dark);">{{ $p['name'] }}</h4>
                                    <p class="text-[0.65rem] font-medium" style="color: var(--text-light);">{{ $p['desc'] }}</p>
                                </div>
                                <div class="scale-0 peer-checked:scale-125 transition-transform duration-500">
                                    <div class="w-12 h-12 bg-[#bef264] rounded-full flex items-center justify-center shadow-lg shadow-[#bef264]/30 border-4 border-white">
                                        <span class="material-symbols-outlined text-white text-2xl font-bold">check</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Ringkasan Sticky Column -->
            <div class="lg:col-span-4">
                <div class="bg-var(--text-dark) rounded-[3rem] p-10 shadow-2xl relative overflow-hidden sticky top-24 text-white" style="background: #1a2e16;">
                    <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full blur-3xl opacity-10" style="background: var(--gold);"></div>
                    
                    <div class="relative z-10">
                        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem;" class="mb-8">Ringkasan</h3>
                        
                        <div class="max-h-64 overflow-y-auto mb-8 pr-2 space-y-6 custom-scrollbar">
                            @foreach($cart as $item)
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden shrink-0 border border-white/10">
                                    @if(!empty($item['foto']))
                                        <img src="{{ asset('storage/' . $item['foto']) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-white/5 text-white/20">
                                            <span class="material-symbols-outlined">image</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-bold truncate">{{ $item['nama'] ?? 'Mangga Premium' }}</h4>
                                    <p class="text-[9px] font-medium uppercase tracking-widest text-white/40">{{ $item['jumlah'] ?? 0 }} KG × Rp{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black" style="color: var(--gold);">Rp{{ number_format(($item['harga'] ?? 0) * ($item['jumlah'] ?? 0), 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="space-y-4 mb-8 pt-6 border-t border-white/10">
                            <div class="flex justify-between items-center">
                                <span class="text-[0.65rem] font-bold uppercase tracking-widest text-white/40">Subtotal</span>
                                <span class="font-bold text-sm">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[0.65rem] font-bold uppercase tracking-widest text-white/40">Ongkir</span>
                                <span class="font-bold text-sm" id="display-shipping">Rp25.000</span>
                                <input type="hidden" name="biaya_pengiriman" id="input-shipping" value="25000">
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[0.65rem] font-bold uppercase tracking-widest text-white/40">Admin</span>
                                <span class="font-bold text-sm">Rp2.500</span>
                            </div>
                            
                            <div class="pt-6 mt-6 border-t border-white/20">
                                <p class="text-[0.65rem] font-black uppercase tracking-widest text-white/40 mb-1">Total Bayar</p>
                                <p class="text-4xl font-black" id="display-total" style="color: var(--gold);">Rp0</p>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full py-5 rounded-2xl font-black text-[0.75rem] tracking-[0.2em] uppercase transition-all shadow-xl active:scale-[0.98] flex justify-center items-center gap-3"
                                style="background: var(--gold); color: white; box-shadow: 0 10px 30px rgba(212,160,23,0.3);">
                            BUAT PESANAN
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                        
                        <div class="mt-6 flex justify-center items-center gap-2 opacity-20">
                            <span class="material-symbols-outlined text-sm">verified_user</span>
                            <span class="text-[8px] font-black uppercase tracking-widest">Secured Transaction</span>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($cart as $id => $item)
                <input type="hidden" name="items[]" value="{{ $id }}">
            @endforeach
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingInputs = document.querySelectorAll('input[name="metode_pengiriman"]');
        const subtotal = {{ $totalPrice }};
        const serviceFee = 2500;
        
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
            let selectedMethod = selectedInput ? selectedInput.value : 'same_day';
            let shippingCost = shippingRates[selectedMethod] || 0;
            let total = subtotal + shippingCost + serviceFee;

            if(shippingLabel) shippingLabel.innerText = 'Rp' + shippingCost.toLocaleString('id-ID');
            if(shippingInput) shippingInput.value = shippingCost;
            if(totalLabel) totalLabel.innerText = 'Rp' + total.toLocaleString('id-ID');
        }

        shippingInputs.forEach(input => {
            input.addEventListener('change', updateTotals);
        });

        updateTotals();
    });
</script>
@endsection
