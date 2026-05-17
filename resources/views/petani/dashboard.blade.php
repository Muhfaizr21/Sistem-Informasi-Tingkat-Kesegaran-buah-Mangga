<x-petani-layout>
    <x-slot name="title">Dashboard Petani</x-slot>
    
    <!-- Leaflet GIS Local -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" />
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>

    <!-- Header & Quick Actions -->
    <div class="mb-12 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight mb-2">Semangat Pagi, {{ Auth::user()->nama }}! 🧑‍🌾</h1>
            <p class="text-sm text-slate-500 font-medium">Berikut ringkasan kondisi bisnis mangga Anda hari ini.</p>
        </div>
        <div class="flex flex-wrap gap-3 w-full sm:w-auto">
            <a href="{{ route('petani.cek-kesegaran') }}" 
               class="flex-1 sm:flex-initial flex items-center justify-center gap-2 px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-lg shadow-emerald-600/10 hover:shadow-emerald-600/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-xs uppercase tracking-widest">
                <span class="material-symbols-outlined text-lg">center_focus_strong</span> Scan Baru
            </a>
            <a href="{{ route('petani.laporan-panen') }}" 
               class="flex-1 sm:flex-initial flex items-center justify-center gap-2 px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-black rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all text-xs uppercase tracking-widest">
                <span class="material-symbols-outlined text-lg">add_task</span> Buat Laporan
            </a>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column (Stats & Charts) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Statistik Panen & Penjualan (Bento Grid) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Panen Card -->
                <div class="bg-[#064E3B] bg-gradient-to-br from-[#064E3B] to-[#022C22] p-8 rounded-[2.5rem] text-white shadow-xl relative overflow-hidden group">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <p class="text-emerald-300/80 text-[10px] font-black uppercase tracking-widest mb-3">Panen Bulan Ini</p>
                        <h3 class="text-3xl md:text-4xl font-extrabold mb-3 tracking-tight">{{ number_format($totalPanenBulanIni, 1) }} <span class="text-lg font-medium text-emerald-300">Kg</span></h3>
                        <div class="flex items-center gap-1.5 text-[10px] font-black text-emerald-200 bg-white/10 w-fit px-3 py-1.5 rounded-full uppercase tracking-wider">
                            <span class="material-symbols-outlined text-sm">trending_up</span>
                            <span>+12% vs bln lalu</span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[110px] text-white/5 rotate-12 group-hover:rotate-45 transition-transform duration-700 pointer-events-none">eco</span>
                </div>

                <!-- Penjualan Card -->
                <div class="bg-slate-50/60 p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-slate-200/20 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Mangga Terjual</p>
                        <h3 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-3 tracking-tight">{{ number_format($manggaTerjual, 0) }} <span class="text-lg font-medium text-slate-400">Kg</span></h3>
                        <div class="flex items-center gap-1.5 text-[10px] font-black text-amber-600 bg-amber-500/10 w-fit px-3 py-1.5 rounded-full uppercase tracking-wider">
                            <span class="material-symbols-outlined text-sm">inventory_2</span>
                            <span>Stok: {{ number_format($manggaTersedia, 0) }} Kg</span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[110px] text-slate-200/50 rotate-12 group-hover:rotate-45 transition-transform duration-700 pointer-events-none">shopping_basket</span>
                </div>

                <!-- Pendapatan Card -->
                <div class="bg-slate-50/60 p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-slate-200/20 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Estimasi Pendapatan</p>
                        <h3 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-3 tracking-tight">Rp {{ number_format($pendapatanBulanIni/1000, 0) }}<span class="text-lg font-medium text-slate-400">k</span></h3>
                        <div class="flex items-center gap-2 mt-4">
                            <div class="flex-1 bg-slate-200/60 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-600 h-full w-[85%]"></div>
                            </div>
                            <span class="text-[10px] font-black text-slate-500 whitespace-nowrap">85% Target</span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[110px] text-slate-200/50 rotate-12 group-hover:rotate-45 transition-transform duration-700 pointer-events-none">payments</span>
                </div>
            </div>

            <!-- Ringkasan Lahan Section -->
            <div class="bg-white p-6 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-850">Visualisasi & Ringkasan Lahan</h2>
                        <p class="text-xs text-slate-400 font-medium">Pengelolaan {{ $lahan->count() }} lokasi produksi aktif.</p>
                    </div>
                    <a href="{{ route('petani.data-lahan') }}" 
                       class="px-5 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 rounded-xl text-[10px] font-black text-slate-600 transition-all uppercase tracking-widest">
                        Detail Lahan
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Mini Map Card -->
                    <div class="w-full">
                        <div class="bg-slate-50/50 p-3 rounded-[2.5rem] border border-slate-100 shadow-sm group">
                            <div class="aspect-video bg-slate-100 rounded-[2rem] overflow-hidden relative border border-slate-200/60 shadow-inner group-hover:shadow-md transition-all duration-500">
                                <div id="dashboard-mini-map" class="absolute inset-0 z-10"></div>
                                <div class="absolute inset-0 flex items-center justify-center flex-col text-center p-8 bg-white/70 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300 z-20 pointer-events-none">
                                    <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg mb-3">
                                        <span class="material-symbols-outlined text-3xl">map</span>
                                    </div>
                                    <p class="text-xs font-black text-slate-800 uppercase tracking-wider">Peta Wilayah Produksi</p>
                                </div>
                            </div>
                            <a href="{{ route('petani.wilayah-produksi') }}" 
                               class="w-full mt-3 py-3.5 flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-black rounded-2xl transition-all active:scale-[0.98] text-[10px] uppercase tracking-widest">
                                Buka Peta Interaktif
                            </a>
                        </div>
                    </div>

                    <!-- Lahan Details List -->
                    <div class="flex flex-col justify-center space-y-6">
                        <div class="flex items-center gap-4 p-4 bg-slate-50/50 rounded-2xl border border-slate-100">
                            <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 shrink-0">
                                <span class="material-symbols-outlined text-2xl">straighten</span>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Luas Kelolaan</p>
                                <p class="text-lg font-black text-slate-800">{{ $totalHektar }} <span class="text-xs font-medium text-slate-550">Hektar</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50/50 rounded-2xl border border-slate-100">
                            <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600 shrink-0">
                                <span class="material-symbols-outlined text-2xl">category</span>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Varietas Produksi</p>
                                <p class="text-sm font-bold text-slate-700 leading-snug">{{ implode(', ', $varietas) ?: 'Belum ada data' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50/50 rounded-2xl border border-slate-100">
                            <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-600 shrink-0">
                                <span class="material-symbols-outlined text-2xl">verified</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Lahan</p>
                                <div class="flex flex-wrap gap-1.5 mt-1">
                                    @foreach($statusLahan as $status => $count)
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[9px] font-black uppercase tracking-wider">{{ $status }}: {{ $count }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Remote Monitoring Section (Satellite Hub) -->
            <div class="bg-white p-6 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 relative z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="w-2 h-2 bg-rose-500 rounded-full animate-ping"></span>
                            <p class="text-[9px] font-black text-rose-500 uppercase tracking-[0.2em]">Live Satellite Feed</p>
                        </div>
                        <h2 class="text-2xl font-extrabold text-slate-850 tracking-tight">Global Remote Monitoring 🛰️</h2>
                    </div>
                    <div class="px-4 py-2 bg-slate-800 text-white rounded-xl flex items-center gap-2 shrink-0">
                        <span class="material-symbols-outlined text-sm animate-spin">sync</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">Scanning Fields...</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                    <!-- NDVI Health Card -->
                    <div class="p-6 bg-slate-50/50 rounded-[2rem] border border-slate-100 group/item hover:bg-white hover:shadow-md transition-all duration-500">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-600">
                                <span class="material-symbols-outlined text-xl">potted_plant</span>
                            </div>
                            <span class="text-[9px] font-black text-emerald-600 bg-emerald-500/10 px-2.5 py-1 rounded-full uppercase tracking-wider">{{ number_format(($agroData['ndvi']['ndvi'] ?? 0) * 100, 1) }}% HEALTH</span>
                        </div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Crop Health (NDVI)</p>
                        <p class="text-sm font-bold text-slate-700 mb-4 leading-snug">
                            @php
                                $ndvi = $agroData['ndvi']['ndvi'] ?? 0;
                                if($ndvi > 0.7) echo "Optimal Photosynthesis";
                                elseif($ndvi > 0.4) echo "Normal Growth";
                                else echo "Vegetation Stress";
                            @endphp
                        </p>
                        <div class="w-full bg-slate-200/60 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full w-[{{ ($agroData['ndvi']['ndvi'] ?? 0) * 100 }}%]"></div>
                        </div>
                    </div>

                    <!-- Soil Moisture Remote -->
                    <div class="p-6 bg-slate-50/50 rounded-[2rem] border border-slate-100 group/item hover:bg-white hover:shadow-md transition-all duration-500">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined text-xl">water_drop</span>
                            </div>
                            <span class="text-[9px] font-black text-blue-600 bg-blue-500/10 px-2.5 py-1 rounded-full uppercase tracking-wider">{{ number_format(($agroData['soil']['moisture'] ?? 0) * 100, 1) }}% MOISTURE</span>
                        </div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Soil Condition</p>
                        <p class="text-sm font-bold text-slate-700 mb-4 leading-snug">
                            @php
                                $moisture = $agroData['soil']['moisture'] ?? 0;
                                if($moisture > 0.3) echo "Adequate Irrigation";
                                elseif($moisture > 0.15) echo "Mild Dryness";
                                else echo "Critical Water Need";
                            @endphp
                        </p>
                        <div class="w-full bg-slate-200/60 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full w-[{{ ($agroData['soil']['moisture'] ?? 0) * 100 }}%]"></div>
                        </div>
                    </div>

                    <!-- Pest Risk Index -->
                    <div class="p-6 bg-slate-50/50 rounded-[2rem] border border-slate-100 group/item hover:bg-white hover:shadow-md transition-all duration-500">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-600">
                                <span class="material-symbols-outlined text-xl">bug_report</span>
                            </div>
                            <span class="text-[9px] font-black text-amber-600 bg-amber-500/10 px-2.5 py-1 rounded-full uppercase tracking-wider">12% LOW RISK</span>
                        </div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Pest Activity</p>
                        <p class="text-sm font-bold text-slate-700 mb-4 leading-snug">No Outbreak Detected</p>
                        <div class="w-full bg-slate-200/60 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-[#FFB800] h-full w-[12%]"></div>
                        </div>
                    </div>
                </div>

                <!-- Decorative Radar Animation Background -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 pointer-events-none opacity-[0.02] group-hover:opacity-[0.05] transition-opacity duration-1000">
                    <div class="absolute inset-0 border-4 border-slate-900 rounded-full animate-ping"></div>
                    <div class="absolute inset-10 border-4 border-slate-900 rounded-full animate-pulse"></div>
                    <div class="absolute inset-20 border-4 border-slate-900 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Right Column (Alerts & Lists) -->
        <div class="lg:col-span-4 space-y-8">
            
            <!-- AI Advisor Floating Card -->
            <div class="bg-[#064E3B] bg-gradient-to-br from-[#064E3B] to-[#022C22] rounded-[3rem] p-8 md:p-10 text-white shadow-xl relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-emerald-600/80 rounded-xl flex items-center justify-center text-white shadow-lg">
                                <span class="material-symbols-outlined text-lg">psychology</span>
                            </div>
                            <h2 class="text-lg font-black tracking-tight text-white uppercase tracking-wider">AI Advisor</h2>
                        </div>
                        <div class="text-right">
                            <p class="text-[8px] font-black text-emerald-300/40 uppercase tracking-widest">Target Lahan:</p>
                            <p class="text-[9px] font-bold text-[#FFB800] uppercase truncate max-w-[120px]">{{ $lahan->first()->nama_lahan ?? 'Default' }}</p>
                        </div>
                    </div>

                    @if($cuaca)
                    <div class="space-y-6">
                        <div class="p-5 bg-white/5 rounded-2xl border border-white/5 backdrop-blur-md">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-[9px] font-black text-emerald-300/60 uppercase tracking-widest">Rekomendasi Panen</span>
                                @if($cuaca->optimal_panen)
                                <span class="px-2.5 py-0.5 bg-emerald-600 text-white rounded-full text-[8px] font-black uppercase tracking-wider">Optimal</span>
                                @else
                                <span class="px-2.5 py-0.5 bg-[#FFB800] text-emerald-950 rounded-full text-[8px] font-black uppercase tracking-wider">Warning</span>
                                @endif
                            </div>
                            <p class="text-xs font-bold leading-relaxed text-emerald-100">
                                {{ $cuaca->optimal_panen ? 'Hari ini cuaca sangat ideal! Segera lakukan pemanenan untuk kualitas terbaik.' : 'Curah hujan cukup tinggi. Disarankan menunda panen 1-2 hari ke depan.' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white/5 rounded-xl border border-white/5">
                                <p class="text-[8px] font-black text-emerald-300/40 uppercase tracking-widest mb-1.5">Suhu Maksimal</p>
                                <div class="flex items-center gap-2 text-white">
                                    <span class="material-symbols-outlined text-[#FFB800] text-lg">wb_sunny</span>
                                    <span class="text-base font-extrabold">{{ $cuaca->suhu_max }}°C</span>
                                </div>
                            </div>
                            <div class="p-4 bg-white/5 rounded-xl border border-white/5">
                                <p class="text-[8px] font-black text-emerald-300/40 uppercase tracking-widest mb-1.5">Kelembaban</p>
                                <div class="flex items-center gap-2 text-white">
                                    <span class="material-symbols-outlined text-blue-400 text-lg">water_drop</span>
                                    <span class="text-base font-extrabold">{{ $cuaca->kelembaban }}%</span>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('petani.rekomendasi') }}" 
                           class="w-full flex items-center justify-center gap-2 py-3.5 bg-white text-slate-900 hover:bg-slate-50 font-black rounded-xl transition-all text-[10px] uppercase tracking-widest active:scale-[0.98]">
                            Buka Analisis Lengkap
                        </a>
                    </div>
                    @endif
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500/10 blur-[80px] rounded-full"></div>
            </div>

            <!-- User Presence Card -->
            <div id="user-location-card" class="hidden bg-white p-6 md:p-8 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden group animate-in slide-in-from-right duration-700">
                <div class="relative z-10 flex items-center gap-5">
                    <div class="w-16 h-16 bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-600 shrink-0">
                        <span class="material-symbols-outlined text-3xl animate-bounce">person_pin_circle</span>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-blue-600 uppercase tracking-[0.2em] mb-0.5">Keberadaan Anda</p>
                        <h3 id="current-city" class="text-xl font-black text-slate-800 tracking-tight leading-tight">Mendeteksi...</h3>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            <p class="text-[9px] font-bold text-slate-450 uppercase tracking-widest">GPS Aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Buyers List -->
            <div class="bg-white p-6 md:p-8 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex justify-between items-center mb-6 px-2">
                    <h2 class="text-lg font-black text-slate-800">Pembeli Aktif</h2>
                    <span class="px-2.5 py-0.5 bg-slate-50 border border-slate-200 rounded-full text-[8px] font-black text-slate-450 uppercase tracking-wider">Live Monitor</span>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3.5 bg-slate-50/50 hover:bg-slate-50 rounded-2xl transition-all cursor-pointer border border-transparent hover:border-slate-100 group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm overflow-hidden border border-slate-100">
                                <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=random&color=fff" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-extrabold text-slate-800">Siti Aminah</p>
                                <p class="text-[10px] text-slate-450 font-medium">Reseller • Indramayu</p>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-slate-300 group-hover:text-emerald-600 transition-colors">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3.5 bg-slate-50/50 hover:bg-slate-50 rounded-2xl transition-all cursor-pointer border border-transparent hover:border-slate-100 group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm overflow-hidden border border-slate-100">
                                <img src="https://ui-avatars.com/api/?name=Resto+Sunda&background=random&color=fff" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-extrabold text-slate-800">Resto Saung Sunda</p>
                                <p class="text-[10px] text-slate-450 font-medium">Restoran • Losarang</p>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-slate-300 group-hover:text-emerald-600 transition-colors">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </div>
                    </div>
                </div>
                <button class="w-full mt-6 py-3.5 border border-dashed border-slate-200 hover:border-emerald-600/50 rounded-2xl text-[9px] font-black text-slate-400 hover:text-emerald-600 transition-all uppercase tracking-widest active:scale-[0.98]">
                    Lihat Semua Mitra Niaga
                </button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if ("geolocation" in navigator) {
                const locationCard = document.getElementById('user-location-card');
                const cityTitle = document.getElementById('current-city');
                
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    
                    locationCard.classList.remove('hidden');
 
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            const addr = data.address;
                            const suburb = addr.suburb || addr.village || addr.neighbourhood || '';
                            const district = addr.city_district || addr.district || '';
                            const city = addr.city || addr.town || addr.county || '';
                            
                            let locationString = '';
                            if (suburb || district) {
                                locationString = `${suburb || district}, ${city}`;
                            } else {
                                locationString = city;
                            }
                            
                            cityTitle.innerText = locationString.toUpperCase();
                        })
                        .catch(err => {
                            cityTitle.innerText = `${lat.toFixed(2)}, ${lon.toFixed(2)}`;
                        });
                });
            }
 
            // Initialize Dashboard Mini Map
            const dashMap = L.map('dashboard-mini-map', {
                zoomControl: false,
                attributionControl: false
            }).setView([-6.3276, 108.3249], 12);
 
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(dashMap);
 
            const lahanData = @json($lahan);
            const bounds = [];
 
            lahanData.forEach(l => {
                if (l.koordinat_polygon && l.koordinat_polygon.length > 0) {
                    const polygon = L.polygon(l.koordinat_polygon, {
                        color: "#10B981",
                        fillColor: "#10B981",
                        fillOpacity: 0.4,
                        weight: 2
                    }).addTo(dashMap);
                    bounds.push(polygon.getBounds());
                } else if (l.latitude && l.longitude) {
                    const marker = L.circleMarker([l.latitude, l.longitude], {
                        radius: 5,
                        fillColor: "#10B981",
                        color: "#fff",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(dashMap);
                    bounds.push(marker.getLatLng());
                }
            });
 
            if (bounds.length > 0) {
                const group = new L.featureGroup(dashMap._layers);
                dashMap.fitBounds(group.getBounds().pad(0.3));
            }
        });
    </script>
</x-petani-layout>
