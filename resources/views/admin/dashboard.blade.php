<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <!-- Page Header -->
    <div class="flex items-end justify-between mb-2">
        <div>
            <h1 class="text-3xl font-bold text-on-surface">Ikhtisar Sistem</h1>
            <p class="text-base text-on-surface-variant mt-1">Pemantauan operasional dan kualitas komoditas terpusat.</p>
        </div>
        <div class="flex gap-3">
            <button
                class="h-10 px-4 flex items-center gap-2 rounded bg-surface-container-lowest border border-outline-variant text-sm text-on-surface hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                Bulan Ini
            </button>
            <button
                class="h-10 px-4 flex items-center gap-2 rounded bg-primary-container text-on-primary text-sm hover:bg-primary transition-colors">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Unduh Laporan
            </button>
        </div>
    </div>

    <!-- Bento Grid: Key Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-stack-lg">
        <!-- Stat 1 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-5 flex flex-col gap-3">
            <div class="flex justify-between items-start">
                <span class="text-[12px] font-bold text-on-surface-variant uppercase tracking-wider">Total Petani</span>
                <span class="material-symbols-outlined text-on-surface-variant opacity-50">agriculture</span>
            </div>
            <div>
                <div class="text-2xl font-semibold text-on-surface">1,248</div>
                <div class="text-[14px] text-on-tertiary-container mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    +12% bulan ini
                </div>
            </div>
        </div>
        <!-- Stat 2 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-5 flex flex-col gap-3">
            <div class="flex justify-between items-start">
                <span class="text-[12px] font-bold text-on-surface-variant uppercase tracking-wider">Total Pembeli</span>
                <span class="material-symbols-outlined text-on-surface-variant opacity-50">storefront</span>
            </div>
            <div>
                <div class="text-2xl font-semibold text-on-surface">892</div>
                <div class="text-[14px] text-on-tertiary-container mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    +5% bulan ini
                </div>
            </div>
        </div>
        <!-- Stat 3 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-5 flex flex-col gap-3">
            <div class="flex justify-between items-start">
                <span class="text-[12px] font-bold text-on-surface-variant uppercase tracking-wider">Total Panen</span>
                <span class="material-symbols-outlined text-on-surface-variant opacity-50">compost</span>
            </div>
            <div>
                <div class="text-2xl font-semibold text-on-surface flex items-baseline gap-1">45.2 <span
                        class="text-sm text-on-surface-variant font-normal">Ton</span></div>
                <div class="text-[14px] text-on-tertiary-container mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    +18% target tercapai
                </div>
            </div>
        </div>
        <!-- Stat 4 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-5 flex flex-col gap-3">
            <div class="flex justify-between items-start">
                <span class="text-[12px] font-bold text-on-surface-variant uppercase tracking-wider">Transaksi</span>
                <span class="material-symbols-outlined text-on-surface-variant opacity-50">receipt_long</span>
            </div>
            <div>
                <div class="text-2xl font-semibold text-on-surface">Rp 3.4M</div>
                <div class="text-[14px] text-on-surface-variant mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">horizontal_rule</span>
                    Stabil
                </div>
            </div>
        </div>
        <!-- Stat 5 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-5 flex flex-col gap-3">
            <div class="flex justify-between items-start">
                <span class="text-[12px] font-bold text-on-surface-variant uppercase tracking-wider">Rata-rata Kualitas</span>
                <span class="material-symbols-outlined text-on-surface-variant opacity-50">verified</span>
            </div>
            <div>
                <div class="text-2xl font-semibold text-secondary">Grade A-</div>
                <div class="text-[14px] text-error mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">trending_down</span>
                    Turun dari Grade A
                </div>
            </div>
        </div>
    </div>

    <!-- Bento Grid: Charts & Complex Data -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-stack-lg">
        <!-- Main Chart: Production Trend -->
        <div
            class="lg:col-span-8 bg-surface-container-lowest border border-outline-variant rounded-lg p-6 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-on-surface">Tren Produksi &amp; Distribusi</h3>
                <button class="text-on-surface-variant hover:text-on-surface">
                    <span class="material-symbols-outlined">more_horiz</span>
                </button>
            </div>
            <!-- Chart Canvas Area (Simulated) -->
            <div
                class="flex-1 w-full min-h-[300px] relative border-b border-l border-surface-container-high flex items-end pt-4 pb-0 pl-0">
                <!-- Y Axis Labels -->
                <div
                    class="absolute left-[-30px] h-full flex flex-col justify-between text-[10px] text-on-surface-variant py-2">
                    <span>50t</span><span>40t</span><span>30t</span><span>20t</span><span>10t</span><span>0</span>
                </div>
                <!-- Grid Lines -->
                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                    <div class="w-full h-px bg-surface-container-high"></div>
                    <div class="w-full h-px bg-surface-container-high"></div>
                    <div class="w-full h-px bg-surface-container-high"></div>
                    <div class="w-full h-px bg-surface-container-high"></div>
                    <div class="w-full h-px bg-surface-container-high"></div>
                </div>
                <!-- Bars -->
                <div class="w-full h-full flex justify-around items-end px-4 gap-2 z-10">
                    <div class="w-full max-w-[40px] bg-secondary-container rounded-t-sm" style="height: 45%;"></div>
                    <div class="w-full max-w-[40px] bg-secondary-container rounded-t-sm" style="height: 60%;"></div>
                    <div class="w-full max-w-[40px] bg-secondary-container rounded-t-sm" style="height: 55%;"></div>
                    <div class="w-full max-w-[40px] bg-primary-container rounded-t-sm" style="height: 80%;"></div>
                    <div class="w-full max-w-[40px] bg-secondary-container rounded-t-sm" style="height: 70%;"></div>
                    <div class="w-full max-w-[40px] bg-secondary-container rounded-t-sm" style="height: 90%;"></div>
                </div>
            </div>
            <!-- X Axis Labels -->
            <div class="w-full flex justify-around mt-3 text-[12px] text-on-surface-variant pl-4">
                <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span>
            </div>
        </div>
        <!-- Secondary Area: Alerts & Pending Actions -->
        <div class="lg:col-span-4 flex flex-col gap-stack-lg">
            <!-- Pending Verification -->
            <div
                class="bg-surface-container-lowest border border-outline-variant rounded-lg p-6 flex flex-col flex-1">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-on-surface">Verifikasi Tertunda</h3>
                    <span class="bg-error text-on-error text-[10px] font-bold px-2 py-0.5 rounded-full">3
                        Baru</span>
                </div>
                <div class="flex flex-col gap-0 border-t border-outline-variant pt-2">
                    <!-- List Item -->
                    <div
                        class="py-3 flex items-center justify-between border-b border-surface-container-high last:border-0 group cursor-pointer hover:bg-surface-container-low -mx-4 px-4 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[16px]">badge</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-on-surface mb-1">Registrasi Lahan A-12</div>
                                <div class="text-[12px] text-on-surface-variant">Oleh: Bpk. Supardi</div>
                            </div>
                        </div>
                        <button class="text-secondary opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                    <!-- List Item -->
                    <div
                        class="py-3 flex items-center justify-between border-b border-surface-container-high last:border-0 group cursor-pointer hover:bg-surface-container-low -mx-4 px-4 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[16px]">science</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-on-surface mb-1">Hasil Lab Batch #882</div>
                                <div class="text-[12px] text-on-surface-variant">Menunggu approval QA</div>
                            </div>
                        </div>
                        <button class="text-secondary opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                    <!-- List Item -->
                    <div
                        class="py-3 flex items-center justify-between border-b border-surface-container-high last:border-0 group cursor-pointer hover:bg-surface-container-low -mx-4 px-4 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-on-surface mb-1">Manifest Distribusi JKT</div>
                                <div class="text-[12px] text-on-surface-variant">Truk B 9921 XX</div>
                            </div>
                        </div>
                        <button class="text-secondary opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Anomaly Alerts Card -->
            <div class="bg-error-container border border-error/20 rounded-lg p-5 relative overflow-hidden">
                <!-- Decorative Icon Background -->
                <span
                    class="material-symbols-outlined absolute -right-4 -bottom-4 text-[100px] text-error/5 rotate-12 pointer-events-none">warning</span>
                <h3 class="text-lg font-semibold text-on-error-container flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined">error</span>
                    Anomali Sistem
                </h3>
                <ul class="space-y-3">
                    <li class="flex gap-3 items-start">
                        <div class="w-1.5 h-1.5 rounded-full bg-error mt-1.5 shrink-0"></div>
                        <div>
                            <div class="text-[13px] text-on-error-container font-semibold">Penurunan Kualitas Mendadak</div>
                            <div class="text-[12px] text-on-error-container/80 mt-0.5">Blok C-3 melaporkan 40% Grade C dalam 2 hari terakhir.</div>
                        </div>
                    </li>
                    <li class="flex gap-3 items-start">
                        <div class="w-1.5 h-1.5 rounded-full bg-error mt-1.5 shrink-0"></div>
                        <div>
                            <div class="text-[13px] text-on-error-container font-semibold">Sensor Cuaca Offline</div>
                            <div class="text-[12px] text-on-error-container/80 mt-0.5">Stasiun Area Utara tidak mengirim data sejak 04:00 AM.</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-admin-layout>
