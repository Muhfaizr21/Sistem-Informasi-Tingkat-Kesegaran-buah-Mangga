<x-admin-layout>
    <x-slot name="title">Dashboard Admin</x-slot>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-bold text-on-surface tracking-tight">Ikhtisar <span class="gradient-text">Sistem</span></h1>
            <p class="text-on-surface-variant mt-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                Pemantauan operasional dan kualitas komoditas terpusat.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="glass px-4 py-2 rounded-2xl flex items-center gap-2 text-sm font-medium text-on-surface-variant premium-shadow">
                <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                {{ now()->translatedFormat('F Y') }}
            </div>
            <button class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-2xl text-sm font-bold flex items-center gap-2 transition-all hover:scale-105 active:scale-95 premium-shadow">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Laporan PDF
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        <!-- Card 1: Total Petani -->
        <div class="relative group overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl md:rounded-3xl p-4 md:p-6 text-white premium-shadow transition-all hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 w-16 h-16 md:w-24 md:h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="flex justify-between items-start relative z-10">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md">
                    <span class="material-symbols-outlined text-[20px] md:text-[24px]">agriculture</span>
                </div>
                <div class="bg-white/20 px-2 py-0.5 rounded-lg text-[9px] md:text-[10px] font-bold uppercase tracking-wider backdrop-blur-md">
                    +{{ $growth['petani'] }}%
                </div>
            </div>
            <div class="mt-6 md:mt-8 relative z-10">
                <p class="text-white/70 text-[10px] md:text-sm font-medium">Mitra Petani</p>
                <h3 class="text-xl md:text-3xl font-bold mt-1">{{ number_format($totalPetani) }}</h3>
            </div>
        </div>

        <!-- Card 2: Total Pembeli -->
        <div class="relative group overflow-hidden bg-gradient-to-br from-mango-500 to-mango-600 rounded-2xl md:rounded-3xl p-4 md:p-6 text-white premium-shadow transition-all hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 w-16 h-16 md:w-24 md:h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="flex justify-between items-start relative z-10">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md">
                    <span class="material-symbols-outlined text-[20px] md:text-[24px]">storefront</span>
                </div>
                <div class="bg-white/20 px-2 py-0.5 rounded-lg text-[9px] md:text-[10px] font-bold uppercase tracking-wider backdrop-blur-md">
                    +{{ $growth['pembeli'] }}%
                </div>
            </div>
            <div class="mt-6 md:mt-8 relative z-10">
                <p class="text-white/70 text-[10px] md:text-sm font-medium">Pembeli Aktif</p>
                <h3 class="text-xl md:text-3xl font-bold mt-1">{{ number_format($totalPembeli) }}</h3>
            </div>
        </div>

        <!-- Card 3: Total Panen -->
        <div class="relative group overflow-hidden bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl md:rounded-3xl p-4 md:p-6 text-white premium-shadow transition-all hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 w-16 h-16 md:w-24 md:h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="flex justify-between items-start relative z-10">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md">
                    <span class="material-symbols-outlined text-[20px] md:text-[24px]">compost</span>
                </div>
                <div class="bg-white/20 px-2 py-0.5 rounded-lg text-[9px] md:text-[10px] font-bold uppercase tracking-wider backdrop-blur-md uppercase">
                    Ton
                </div>
            </div>
            <div class="mt-6 md:mt-8 relative z-10">
                <p class="text-white/70 text-[10px] md:text-sm font-medium">Total Panen</p>
                <h3 class="text-xl md:text-3xl font-bold mt-1">{{ number_format($totalPanenTon, 1) }}</h3>
            </div>
        </div>

        <!-- Card 4: Kualitas -->
        <div class="relative group overflow-hidden bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl md:rounded-3xl p-4 md:p-6 text-white premium-shadow transition-all hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 w-16 h-16 md:w-24 md:h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="flex justify-between items-start relative z-10">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md">
                    <span class="material-symbols-outlined text-[20px] md:text-[24px]">verified</span>
                </div>
                <div class="bg-white/20 px-2 py-0.5 rounded-lg text-[9px] md:text-[10px] font-bold uppercase tracking-wider backdrop-blur-md">
                    AI
                </div>
            </div>
            <div class="mt-6 md:mt-8 relative z-10">
                <p class="text-white/70 text-[10px] md:text-sm font-medium">Avg. Kualitas</p>
                <h3 class="text-xl md:text-3xl font-bold mt-1">{{ $qualityGrade }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Chart -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-[2rem] p-8 border border-outline-variant premium-shadow">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-xl font-bold text-on-surface">Tren Produksi Mangga</h3>
                        <p class="text-sm text-on-surface-variant">Data panen terverifikasi dalam 6 bulan terakhir</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="flex items-center gap-1.5 text-xs font-medium text-on-surface-variant bg-surface px-3 py-1.5 rounded-xl border border-outline-variant">
                            <span class="w-2 h-2 rounded-full bg-primary-500"></span> Ton
                        </span>
                    </div>
                </div>

                <div class="h-[350px] flex items-end justify-between gap-4 relative">
                    <!-- Grid Lines -->
                    <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-8">
                        @for($i=0; $i<6; $i++)
                            <div class="w-full h-px bg-slate-100"></div>
                        @endfor
                    </div>

                    @foreach($harvestData as $data)
                        @php $height = $data > 0 ? min(($data / (max($harvestData) ?: 1)) * 100, 100) : 0; @endphp
                        <div class="flex-1 flex flex-col items-center gap-4 z-10 group">
                            <div class="w-full max-w-[48px] relative flex flex-col justify-end h-full">
                                <!-- Tooltip -->
                                <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-on-surface text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                    {{ number_format($data, 1) }} Ton
                                </div>
                                <!-- Bar -->
                                <div class="w-full rounded-t-2xl transition-all duration-700 ease-out {{ $loop->last ? 'bg-gradient-to-t from-primary-600 to-mango-400' : 'bg-gradient-to-t from-slate-200 to-slate-300 group-hover:from-primary-200 group-hover:to-primary-300' }}" 
                                     style="height: {{ $height }}%;">
                                </div>
                            </div>
                            <span class="text-xs font-bold text-on-surface-variant uppercase tracking-tighter">{{ $months[$loop->index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Orders / Activity -->
            <div class="bg-white rounded-[2rem] p-8 border border-outline-variant premium-shadow">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-on-surface">Aktivitas Pasar Terbaru</h3>
                    <a href="#" class="text-primary-600 text-sm font-bold hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @php
                        $orders = \App\Models\Pesanan::with('pembeli.user')->latest()->limit(4)->get();
                    @endphp
                    @forelse($orders as $order)
                    <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-surface transition-colors border border-transparent hover:border-outline-variant">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-mango-100 flex items-center justify-center text-mango-700">
                                <span class="material-symbols-outlined">shopping_basket</span>
                            </div>
                            <div>
                                <p class="font-bold text-on-surface">{{ $order->pembeli->user->nama ?? 'Pembeli' }}</p>
                                <p class="text-xs text-on-surface-variant">Pesanan #{{ $order->id }} • {{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-on-surface">Rp {{ number_format($order->total_harga) }}</p>
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-green-100 text-green-700">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-on-surface-variant italic text-sm">
                        Belum ada transaksi terbaru.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Verification & Alerts -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Verification Queue -->
            <div class="bg-white rounded-[2rem] p-8 border border-outline-variant premium-shadow relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-on-surface">Antrean Verifikasi</h3>
                        <span class="bg-error text-white text-[10px] font-bold px-2.5 py-1 rounded-full">
                            {{ $pendingPetani->count() + $pendingPanen->count() }} Baru
                        </span>
                    </div>
                    <div class="space-y-4">
                        @foreach($pendingPetani as $petani)
                        <div class="group cursor-pointer">
                            <div class="flex items-center gap-4 p-3 rounded-2xl transition-all hover:bg-surface active:scale-95 border border-transparent hover:border-outline-variant">
                                <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[20px]">person_check</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-on-surface line-clamp-1">Verifikasi Petani</p>
                                    <p class="text-xs text-on-surface-variant">{{ $petani->user->nama }}</p>
                                </div>
                                <span class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                            </div>
                        </div>
                        @endforeach

                        @foreach($pendingPanen as $panen)
                        <div class="group cursor-pointer">
                            <div class="flex items-center gap-4 p-3 rounded-2xl transition-all hover:bg-surface active:scale-95 border border-transparent hover:border-outline-variant">
                                <div class="w-10 h-10 rounded-xl bg-mango-100 text-mango-700 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-on-surface line-clamp-1">Laporan Panen: {{ $panen->jumlah_kg }}Kg</p>
                                    <p class="text-xs text-on-surface-variant">{{ $panen->petani->user->nama }}</p>
                                </div>
                                <span class="material-symbols-outlined text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                            </div>
                        </div>
                        @endforeach

                        @if($pendingPetani->isEmpty() && $pendingPanen->isEmpty())
                        <div class="py-10 text-center text-on-surface-variant italic text-sm">
                            Semua verifikasi telah selesai.
                        </div>
                        @endif
                    </div>
                    <button class="w-full mt-6 py-3 rounded-2xl border-2 border-primary-600 text-primary-600 font-bold text-sm hover:bg-primary-600 hover:text-white transition-all active:scale-95">
                        Lihat Semua Antrean
                    </button>
                </div>
            </div>

            <!-- System Alert -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-[2rem] p-8 text-white premium-shadow relative overflow-hidden">
                <span class="material-symbols-outlined absolute -right-6 -bottom-6 text-[120px] text-white/10 rotate-12 pointer-events-none">warning</span>
                <div class="relative z-10">
                    <h3 class="text-xl font-bold flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined">security</span>
                        Security Audit
                    </h3>
                    <p class="text-white/80 text-sm leading-relaxed mb-6">
                        Sistem mendeteksi 12 upaya akses tidak sah dari IP eksternal dalam 24 jam terakhir. Seluruh upaya telah diblokir secara otomatis oleh firewall.
                    </p>
                    <div class="flex gap-2">
                        <div class="flex-1 bg-white/20 backdrop-blur-md rounded-xl p-3 text-center">
                            <p class="text-[10px] uppercase font-bold text-white/60">Status</p>
                            <p class="text-sm font-bold">Secure</p>
                        </div>
                        <div class="flex-1 bg-white/20 backdrop-blur-md rounded-xl p-3 text-center">
                            <p class="text-[10px] uppercase font-bold text-white/60">Firewall</p>
                            <p class="text-sm font-bold">Active</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-on-surface rounded-[2rem] p-8 text-white premium-shadow">
                <h3 class="text-xl font-bold mb-6">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex flex-col items-center gap-3 p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition-colors border border-white/10">
                        <span class="material-symbols-outlined text-mango-400">add_moderator</span>
                        <span class="text-xs font-bold">Verifikasi</span>
                    </button>
                    <button class="flex flex-col items-center gap-3 p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition-colors border border-white/10">
                        <span class="material-symbols-outlined text-primary-400">mail</span>
                        <span class="text-xs font-bold">Broadcast</span>
                    </button>
                    <button class="flex flex-col items-center gap-3 p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition-colors border border-white/10">
                        <span class="material-symbols-outlined text-blue-400">map</span>
                        <span class="text-xs font-bold">GIS Map</span>
                    </button>
                    <button class="flex flex-col items-center gap-3 p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition-colors border border-white/10">
                        <span class="material-symbols-outlined text-purple-400">settings</span>
                        <span class="text-xs font-bold">Config</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
