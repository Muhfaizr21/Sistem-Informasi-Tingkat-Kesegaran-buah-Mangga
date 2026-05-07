<x-petani-layout>
<div class="relative min-h-screen pb-20">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-[#1b1b18] tracking-tight mb-2">Pesanan <span class="text-[#FFB800]">Masuk</span></h1>
        <p class="text-lg text-[#706f6c] font-medium">Kelola proses pengemasan dan pengiriman produk Anda.</p>
    </div>

    @if(session('success'))
    <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-[2rem] flex items-center gap-4 shadow-sm">
        <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-8 p-6 bg-red-50 border border-red-100 text-red-700 rounded-[2rem] flex items-center gap-4 shadow-sm">
        <div class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </div>
        <span class="font-bold text-sm">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Status Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        @php
            $countDikonfirmasi = $pesanans->where('status', 'dikonfirmasi')->count();
            $countDikemas = $pesanans->where('status', 'dikemas')->count();
            $countDikirim = $pesanans->where('status', 'dikirim')->count();
            $countSelesai = $pesanans->where('status', 'selesai')->count();
        @endphp
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <p class="text-3xl font-black text-blue-600">{{ $countDikonfirmasi }}</p>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Siap Kemas</p>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <p class="text-3xl font-black text-purple-600">{{ $countDikemas }}</p>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Dikemas</p>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <p class="text-3xl font-black text-orange-600">{{ $countDikirim }}</p>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Dikirim</p>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <p class="text-3xl font-black text-emerald-600">{{ $countSelesai }}</p>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Selesai</p>
        </div>
    </div>

    <!-- Order List -->
    <div class="space-y-6">
        @forelse($pesanans as $pesanan)
        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex flex-col md:flex-row justify-between gap-6">
                <!-- Left: Order Info -->
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span class="px-4 py-1.5 bg-gray-50 border border-gray-100 rounded-xl text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
                        <span class="text-[10px] font-black text-gray-300">|</span>
                        <span class="text-[10px] font-black text-[#FFB800] tracking-widest">{{ $pesanan->kode_pesanan }}</span>
                        @php
                            $statusConfig = [
                                'menunggu_verifikasi' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'label' => 'Menunggu Verifikasi'],
                                'dikonfirmasi' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Siap Dikemas'],
                                'dikemas' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Sedang Dikemas'],
                                'dikirim' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'label' => 'Dalam Pengiriman'],
                                'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Selesai'],
                                'dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Dibatalkan'],
                            ];
                            $status = $statusConfig[$pesanan->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-500', 'label' => ucfirst(str_replace('_', ' ', $pesanan->status))];
                        @endphp
                        <span class="px-3 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $status['bg'] }} {{ $status['text'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        @foreach($pesanan->items as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 shrink-0">
                                @if($item->listing && is_array($item->listing->foto_batch) && count($item->listing->foto_batch) > 0)
                                    <img src="{{ asset('storage/' . $item->listing->foto_batch[0]) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1b1b18] text-sm">{{ $item->listing->jenis_mangga ?? 'Mangga' }}</h4>
                                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">{{ number_format($item->jumlah_kg, 1) }} KG × Rp{{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right: Buyer Info & Actions -->
                <div class="flex flex-col justify-between items-start md:items-end gap-6 pt-6 md:pt-0 border-t md:border-t-0 border-gray-100">
                    <div class="text-left md:text-right">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pembeli</p>
                        <p class="font-bold text-[#1b1b18]">{{ $pesanan->pembeli->user->name ?? 'Pembeli' }}</p>
                        <p class="text-2xl font-black text-[#1b1b18] mt-2">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
                    </div>

                    <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
                        @if($pesanan->status === 'dikonfirmasi')
                        <form action="{{ route('petani.pesanan.status', $pesanan->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="dikemas">
                            <button type="submit" class="px-6 py-3 bg-purple-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-purple-600 transition-all shadow-lg shadow-purple-500/20 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                MULAI KEMAS
                            </button>
                        </form>
                        @endif

                        @if($pesanan->status === 'dikemas')
                        <form action="{{ route('petani.pesanan.status', $pesanan->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="dikirim">
                            <button type="submit" class="px-6 py-3 bg-orange-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                                KIRIM PESANAN
                            </button>
                        </form>
                        @endif

                        @if($pesanan->status === 'selesai')
                        <span class="px-6 py-3 bg-emerald-50 text-emerald-600 rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            SELESAI
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="py-24 text-center bg-white rounded-[3rem] border border-dashed border-gray-200">
            <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-[#1b1b18] mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-400 font-medium max-w-sm mx-auto">Pesanan masuk untuk produk Anda akan tampil di sini. Pastikan produk Anda aktif di marketplace.</p>
        </div>
        @endforelse
    </div>
</div>
</x-petani-layout>
