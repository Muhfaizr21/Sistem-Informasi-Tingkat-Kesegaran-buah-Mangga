@extends('layouts.pembeli')

@section('title', 'Detail Pesanan ' . $pesanan->kode_pesanan)

@section('content')
<div class="relative animate-in fade-in duration-700">
    <div class="mb-8">
        <a href="{{ route('pembeli.pesanan.index') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all no-underline" style="background: white; border: 1px solid var(--gold-pale); color: var(--text-mid);">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            KEMBALI KE RIWAYAT
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left: Tracking & Items -->
        <div class="lg:col-span-8 space-y-10">
            <!-- Tracking Timeline -->
            <div class="bg-white rounded-[3rem] p-10 lg:p-14 border shadow-sm relative overflow-hidden group" style="border-color: var(--gold-pale);">
                <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full blur-3xl opacity-5 group-hover:opacity-10 transition-opacity" style="background: var(--gold);"></div>
                
                <h2 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);" class="mb-12 relative z-10 flex items-center gap-4">
                    Status <span style="color: var(--gold);">Pengiriman</span>
                    <div class="px-3 py-1 bg-var(--gold-pale) rounded-lg text-[9px] font-black uppercase tracking-widest" style="color: var(--gold);">Live Track</div>
                </h2>
                
                <div class="relative z-10 space-y-10">
                    @php
                        $steps = [
                            'menunggu_bayar' => ['label' => 'Pembayaran', 'desc' => 'Selesaikan pembayaran pesanan.', 'icon' => 'payments'],
                            'menunggu_verifikasi' => ['label' => 'Verifikasi', 'desc' => 'Admin sedang memverifikasi pembayaran.', 'icon' => 'verified'],
                            'dikonfirmasi' => ['label' => 'Dikonfirmasi', 'desc' => 'Pesanan Anda telah dikonfirmasi.', 'icon' => 'check_circle'],
                            'dikemas' => ['label' => 'Dikemas', 'desc' => 'Petani sedang menyiapkan mangga Anda.', 'icon' => 'inventory_2'],
                            'dikirim' => ['label' => 'Dikirim', 'desc' => 'Pesanan dalam perjalanan ke lokasi.', 'icon' => 'local_shipping'],
                            'menunggu_verifikasi_selesai' => ['label' => 'Diterima', 'desc' => 'Pesanan sampai. Menunggu verifikasi admin.', 'icon' => 'assignment_turned_in'],
                            'selesai' => ['label' => 'Selesai', 'desc' => 'Pesanan telah selesai dengan baik.', 'icon' => 'task_alt'],
                        ];
                        $currentStatusIdx = array_search($pesanan->status, array_keys($steps));
                        if($currentStatusIdx === false) $currentStatusIdx = -1;
                        $idx = 0;
                    @endphp

                    @foreach($steps as $status => $data)
                    @php 
                        $isReached = $idx <= $currentStatusIdx;
                        $isCurrent = $status === $pesanan->status;
                    @endphp
                    <div class="flex gap-8 relative">
                        @if(!$loop->last)
                        <div class="absolute left-[27px] top-[56px] w-[2px] h-[calc(100%-16px)] transition-colors duration-500" style="background: {{ $idx < $currentStatusIdx ? 'var(--gold)' : 'var(--gold-pale)' }};"></div>
                        @endif
                        
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 z-10 transition-all duration-500 {{ $isReached ? 'shadow-lg' : '' }}" 
                             style="background: {{ $isReached ? 'var(--gold)' : 'var(--cream)' }}; color: {{ $isReached ? 'white' : 'var(--gold)' }}; border: {{ $isReached ? 'none' : '1px solid var(--gold-pale)' }};">
                            <span class="material-symbols-outlined text-[24px] {{ $isCurrent ? 'animate-pulse' : '' }}">{{ $data['icon'] }}</span>
                        </div>
                        
                        <div class="flex-1 pt-3">
                            <p class="text-lg font-black tracking-tight mb-1" style="color: {{ $isReached ? 'var(--text-dark)' : 'var(--text-light)' }}">{{ $data['label'] }}</p>
                            
                            @if($status === 'selesai' && $pesanan->selesai_pada)
                                <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color: var(--text-light);">{{ \Carbon\Carbon::parse($pesanan->selesai_pada)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') }}</p>
                            @endif
                            
                            @if($isCurrent)
                                <span class="inline-block mt-2 px-3 py-1 bg-emerald-50 text-emerald-600 text-[8px] font-black uppercase tracking-widest rounded-lg border border-emerald-100 animate-pulse">Status Saat Ini</span>
                            @else
                                <p class="text-sm font-medium" style="color: var(--text-mid);">{{ $data['desc'] }}</p>
                            @endif
                        </div>
                    </div>
                    @php $idx++; @endphp
                    @endforeach
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-[3rem] p-10 lg:p-14 border shadow-sm" style="border-color: var(--gold-pale);">
                <h2 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--leaf-dark);" class="mb-8">Rincian <span style="color: var(--gold);">Produk</span></h2>
                <div class="space-y-6">
                    @foreach($pesanan->items as $item)
                    <div class="flex items-center gap-6 p-6 rounded-3xl transition-colors hover:bg-var(--gold-pale)/20 border border-transparent hover:border-var(--gold-pale)">
                        <div class="w-24 h-24 bg-var(--gold-pale) rounded-2xl overflow-hidden shrink-0 border" style="border-color: var(--gold-pale);">
                            @if($item->listing && is_array($item->listing->foto_batch) && count($item->listing->foto_batch) > 0)
                                <img src="{{ asset('storage/' . $item->listing->foto_batch[0]) }}" class="w-full h-full object-cover">
                            @elseif($item->listing?->foto_batch)
                                <img src="{{ asset('storage/' . $item->listing->foto_batch) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-var(--gold) opacity-20">
                                    <span class="material-symbols-outlined text-4xl">image</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 style="font-family: 'Lora', serif; font-size: 1.25rem; font-weight: 600; color: var(--leaf-dark);" class="mb-1">{{ $item->listing?->jenis_mangga ?? 'Mangga Premium' }}</h3>
                            <p class="text-[0.65rem] font-bold uppercase tracking-widest" style="color: var(--text-light);">{{ $item->jumlah_kg }} KG × Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-black" style="color: var(--gold);">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Review Section -->
            @if($pesanan->status === 'selesai' && !$pesanan->review)
            <div class="bg-white rounded-[3.5rem] p-10 lg:p-14 border shadow-xl" style="border-color: var(--gold-pale); background: linear-gradient(to bottom right, white, var(--cream));">
                <div class="mb-10 text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm" style="color: var(--gold);">
                        <span class="material-symbols-outlined text-4xl fill-1">stars</span>
                    </div>
                    <h2 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--leaf-dark);">Berikan <span style="color: var(--gold);">Ulasan</span></h2>
                    <p class="text-sm font-medium" style="color: var(--text-mid);">Bantu petani kami dan pembeli lain dengan ulasan jujur Anda.</p>
                </div>

                <form action="{{ route('pembeli.pesanan.review', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    <div class="text-center">
                        <label class="block text-[0.65rem] font-black uppercase tracking-[0.2em] mb-4" style="color: var(--text-light);">Rating Kualitas</label>
                        <div class="flex gap-4 justify-center" x-data="{ rating: 0 }">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required @click="rating = {{ $i }}">
                                <div class="w-14 h-14 rounded-2xl bg-white border-2 flex items-center justify-center transition-all transform hover:scale-110 shadow-sm peer-checked:bg-var(--gold) peer-checked:border-var(--gold) peer-checked:text-white"
                                     style="border-color: var(--gold-pale); color: var(--gold-pale);"
                                     :style="rating >= {{ $i }} ? 'color: var(--gold); border-color: var(--gold);' : ''"
                                     :class="rating >= {{ $i }} ? 'text-var(--gold)' : ''">
                                    <span class="material-symbols-outlined text-3xl" :class="rating >= {{ $i }} ? 'fill-1' : ''">star</span>
                                </div>
                            </label>
                            @endfor
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-[0.65rem] font-black uppercase tracking-[0.2em] ml-2" style="color: var(--text-light);">Ceritakan Pengalaman Anda</label>
                        <textarea name="komentar" rows="4" class="w-full px-8 py-6 bg-white border rounded-[2rem] focus:ring-4 focus:ring-var(--gold-pale) outline-none transition-all font-medium resize-none" style="border-color: var(--gold-pale); color: var(--text-dark);" placeholder="Bagaimana rasa mangganya?"></textarea>
                    </div>

                    <div x-data="{ 
                        previews: [],
                        files: new DataTransfer(),
                        handleFiles(e) {
                            const newFiles = Array.from(e.target.files);
                            if ((this.previews.length + newFiles.length) > 5) {
                                alert('Maksimal 5 foto!');
                                return;
                            }
                            newFiles.forEach(file => {
                                this.files.items.add(file);
                                const reader = new FileReader();
                                reader.onload = (ev) => {
                                    this.previews.push({ id: Date.now() + Math.random(), url: ev.target.result, fileName: file.name });
                                };
                                reader.readAsDataURL(file);
                            });
                            this.$refs.initFileInput.files = this.files.files;
                        },
                        removePreview(id, fileName) {
                            this.previews = this.previews.filter(p => p.id !== id);
                            const newDt = new DataTransfer();
                            Array.from(this.files.files).filter(f => f.name !== fileName).forEach(f => newDt.items.add(f));
                            this.files = newDt;
                            this.$refs.initFileInput.files = this.files.files;
                        }
                    }">
                        <label class="block text-[0.65rem] font-black uppercase tracking-[0.2em] mb-4 ml-2" style="color: var(--text-light);">Upload Foto (Maks 5)</label>
                        <div x-show="previews.length > 0" class="grid grid-cols-5 gap-4 mb-6">
                            <template x-for="preview in previews" :key="preview.id">
                                <div class="relative aspect-square rounded-2xl overflow-hidden border-2 border-white shadow-sm">
                                    <img :src="preview.url" class="w-full h-full object-cover">
                                    <button type="button" @click="removePreview(preview.id, preview.fileName)" class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[14px]">close</span>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <div class="relative w-full bg-white border-2 border-dashed rounded-[2rem] p-10 text-center hover:bg-var(--gold-pale)/20 transition-all group" style="border-color: var(--gold-pale);">
                            <input type="file" x-ref="initFileInput" name="foto_review[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFiles">
                            <span class="material-symbols-outlined text-4xl mb-3 opacity-20" style="color: var(--gold);">add_a_photo</span>
                            <p class="text-xs font-bold uppercase tracking-widest" style="color: var(--text-light);" x-text="previews.length > 0 ? previews.length + ' Foto dipilih' : 'Klik untuk upload foto'"></p>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 rounded-2xl font-black text-[0.75rem] tracking-[0.2em] uppercase transition-all shadow-xl active:scale-95"
                            style="background: var(--text-dark); color: white; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                        Kirim Ulasan Sekarang
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- Right: Summary & Info (Sticky) -->
        <div class="lg:col-span-4 space-y-8">
            <div class="sticky top-24 space-y-8">
                <!-- Address Box -->
                <div class="bg-white rounded-[3rem] p-10 border shadow-sm" style="border-color: var(--gold-pale);">
                    <h3 class="text-[0.65rem] font-black uppercase tracking-[0.2em] mb-6" style="color: var(--text-light);">Alamat Tujuan</h3>
                    <div class="space-y-4">
                        <p class="font-black text-xl leading-tight" style="color: var(--text-dark);">{{ $pesanan->alamat?->nama_penerima ?? '-' }}</p>
                        <p class="text-[0.65rem] font-bold uppercase tracking-widest" style="color: var(--text-light);">{{ $pesanan->alamat?->no_telepon ?? '-' }}</p>
                        <div class="pt-4 border-t" style="border-color: var(--gold-pale);">
                            <p class="text-sm font-medium leading-relaxed" style="color: var(--text-mid);">
                                {{ $pesanan->alamat?->alamat_lengkap ?? '-' }}<br>
                                {{ $pesanan->alamat?->kecamatan?->nama ?? 'Lokasi tidak diketahui' }}, {{ $pesanan->alamat?->kota ?? 'Indramayu' }} {{ $pesanan->alamat?->kode_pos ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden" style="background: #1a2e16;">
                    <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full blur-3xl opacity-10" style="background: var(--gold);"></div>
                    <h3 class="text-[0.65rem] font-black uppercase tracking-[0.2em] mb-8 relative z-10 text-white/40">Ringkasan Pembayaran</h3>
                    
                    <div class="space-y-4 relative z-10">
                        <div class="flex justify-between items-center text-[0.7rem] uppercase tracking-widest text-white/40">
                            <span>Subtotal</span>
                            <span class="text-white font-bold">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-[0.7rem] uppercase tracking-widest text-white/40">
                            <span>Ongkir</span>
                            <span class="text-white font-bold">Rp{{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-[0.7rem] uppercase tracking-widest text-white/40">
                            <span>Admin</span>
                            <span class="text-white font-bold">Rp{{ number_format($pesanan->biaya_layanan, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="pt-8 mt-8 border-t border-white/10">
                            <div class="flex justify-between items-end">
                                <span class="text-[0.6rem] font-black uppercase tracking-widest text-white/40">Total Tagihan</span>
                                <span class="text-3xl font-black" style="color: var(--gold);">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-8 border-t border-white/10 relative z-10 text-center">
                        <p class="text-[0.6rem] font-black uppercase tracking-widest text-white/40 mb-3">Metode Pembayaran</p>
                        <div class="inline-block px-5 py-2 rounded-xl border border-white/10 bg-white/5">
                            <p class="text-[0.7rem] font-black tracking-[0.1em] uppercase">{{ str_replace('_', ' ', $pesanan->metode_pembayaran) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                @if($pesanan->status === 'menunggu_bayar' && $pesanan->metode_pembayaran === 'midtrans' && $pesanan->snap_token)
                <button type="button" id="pay-button" class="w-full py-5 rounded-2xl font-black text-[0.75rem] tracking-[0.2em] uppercase transition-all shadow-xl active:scale-[0.98] flex items-center justify-center gap-3"
                        style="background: var(--gold); color: white; box-shadow: 0 10px 30px rgba(212,160,23,0.3);">
                    <span class="material-symbols-outlined text-[20px]">payments</span>
                    BAYAR SEKARANG
                </button>
                @endif

                @if($pesanan->status === 'dikirim')
                <div class="bg-white rounded-[3rem] p-10 border shadow-sm" style="border-color: var(--gold-pale);">
                    <h3 class="text-[0.65rem] font-black uppercase tracking-[0.2em] mb-6" style="color: var(--text-light);">Konfirmasi Penerimaan</h3>
                    <form action="{{ route('pembeli.pesanan.konfirmasi-selesai', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="space-y-3">
                            <label class="text-[9px] font-black uppercase tracking-widest text-on-surface-variant ml-1">Upload Bukti Terima</label>
                            <div class="relative w-full bg-var(--cream) border-2 border-dashed rounded-2xl p-6 text-center hover:bg-var(--gold-pale)/20 transition-all group" style="border-color: var(--gold-pale);">
                                <input type="file" name="foto_selesai" required accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewSelesai(this)">
                                <div id="preview-container" class="hidden mb-3">
                                    <img id="image-preview" src="" class="w-20 h-20 object-cover rounded-xl mx-auto border-2 border-white shadow-sm">
                                </div>
                                <span class="material-symbols-outlined text-3xl mb-1 opacity-20" style="color: var(--gold);">add_a_photo</span>
                                <p class="text-[8px] font-bold uppercase tracking-widest" style="color: var(--text-light);" id="upload-text">Klik untuk Foto Bukti</p>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-4 bg-emerald-500 text-white rounded-2xl font-black text-[10px] tracking-widest uppercase hover:scale-105 transition-all shadow-lg shadow-emerald-500/20">
                            PESANAN DITERIMA
                        </button>
                    </form>
                </div>
                @endif

                @if($pesanan->status === 'menunggu_verifikasi_selesai')
                <div class="bg-white rounded-[3rem] p-10 border shadow-sm text-center space-y-6" style="border-color: var(--gold-pale);">
                    <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto text-emerald-500">
                        <span class="material-symbols-outlined text-4xl">hourglass_top</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-on-surface tracking-tight">Menunggu Verifikasi</h3>
                        <p class="text-[10px] font-medium text-on-surface-variant mt-1 leading-relaxed">Admin sedang mengecek bukti penerimaan Anda sebelum mencairkan dana ke petani.</p>
                    </div>
                    @if($pesanan->foto_selesai)
                    <div class="aspect-video rounded-2xl overflow-hidden border-2 border-white shadow-md bg-surface-container-low">
                        <img src="{{ asset('storage/' . $pesanan->foto_selesai) }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                </div>
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
        payButton.addEventListener('click', function() {
            window.snap.pay('{{ $pesanan->snap_token }}', {
                onSuccess: function(result) { window.location.reload(); },
                onPending: function(result) { window.location.reload(); },
                onError: function(result) { alert("Pembayaran gagal!"); }
            });
        });
    }
    function previewSelesai(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('preview-container').classList.remove('hidden');
                document.getElementById('upload-text').innerText = 'Foto dipilih: ' + input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
