<x-petani-layout>
    <x-slot name="title">Dashboard Petani</x-slot>

    <!-- Header & Quick Actions -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Semangat Pagi, {{ Auth::user()->nama }}! 🧑‍🌾</h1>
            <p class="text-slate-500 font-medium">Berikut ringkasan kondisi bisnis mangga Anda hari ini.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('petani.cek-kesegaran') }}" class="flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-bold rounded-2xl shadow-xl shadow-primary-500/20 hover:scale-105 transition-all active:scale-95 text-sm">
                <span class="material-symbols-outlined text-lg">center_focus_strong</span> Scan Baru
            </a>
            <a href="{{ route('petani.laporan-panen') }}" class="flex items-center gap-2 px-6 py-3 bg-white text-slate-900 font-bold rounded-2xl shadow-sm border border-slate-100 hover:bg-slate-50 transition-all active:scale-95 text-sm">
                <span class="material-symbols-outlined text-lg">add_task</span> Buat Laporan
            </a>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column (Stats & Charts) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Statistik Panen & Penjualan (Bento Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Panen Card -->
                <div class="bg-gradient-to-br from-primary-600 to-primary-700 p-8 rounded-5xl text-white shadow-2xl shadow-primary-500/20 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-white/70 text-[10px] font-black uppercase tracking-widest mb-2">Panen Bulan Ini</p>
                        <h3 class="text-4xl font-extrabold mb-2">{{ number_format($totalPanenBulanIni, 1) }} <span class="text-lg font-medium opacity-70">Kg</span></h3>
                        <div class="flex items-center gap-2 text-xs font-bold text-white/90 bg-white/20 w-fit px-3 py-1.5 rounded-full backdrop-blur-md">
                            <span class="material-symbols-outlined text-[14px]">trending_up</span>
                            <span>+12% vs bln lalu</span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] text-white/10 rotate-12 group-hover:scale-110 transition-transform duration-500">eco</span>
                </div>

                <!-- Penjualan Card -->
                <div class="bg-white p-8 rounded-5xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Mangga Terjual</p>
                        <h3 class="text-4xl font-extrabold text-slate-900 mb-2">{{ number_format($manggaTerjual, 0) }} <span class="text-lg font-medium text-slate-400">Kg</span></h3>
                        <p class="text-xs font-bold text-secondary">Stok Tersedia: {{ number_format($manggaTersedia, 0) }} Kg</p>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] text-slate-50 rotate-12 group-hover:scale-110 transition-transform duration-500">shopping_basket</span>
                </div>

                <!-- Pendapatan Card -->
                <div class="bg-white p-8 rounded-5xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Estimasi Pendapatan</p>
                        <h3 class="text-4xl font-extrabold text-slate-900 mb-2">Rp {{ number_format($pendapatanBulanIni/1000, 0) }}<span class="text-lg font-medium text-slate-400">k</span></h3>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex-1 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full w-[85%]"></div>
                            </div>
                            <span class="text-[10px] font-black text-slate-400">85% Target</span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] text-slate-50 rotate-12 group-hover:scale-110 transition-transform duration-500">payments</span>
                </div>
            </div>

            <!-- Ringkasan Lahan Section -->
            <div class="bg-white p-10 rounded-[3.5rem] border border-slate-100 shadow-sm">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900">Visualisasi & Ringkasan Lahan</h2>
                        <p class="text-sm text-slate-400 font-medium">Pengelolaan {{ $lahan->count() }} lokasi produksi aktif.</p>
                    </div>
                    <a href="{{ route('petani.data-lahan') }}" class="px-6 py-3 bg-slate-50 rounded-2xl text-xs font-black text-slate-600 hover:bg-slate-100 transition-all uppercase tracking-widest">Detail Lahan</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Mini Map Card -->
                    <a href="{{ route('petani.wilayah-produksi') }}" class="group relative aspect-video bg-slate-100 rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-inner">
                        <div class="absolute inset-0 opacity-60 scale-110 group-hover:scale-100 transition-transform duration-1000" style="background-image: url('https://api.mapbox.com/styles/v1/mapbox/light-v10/static/108.3249,-6.3276,13,0/600x400?access_token=YOUR_TOKEN'); background-size: cover;"></div>
                        <div class="absolute inset-0 flex items-center justify-center flex-col text-center p-8 bg-white/60 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <div class="w-16 h-16 bg-primary-500 rounded-3xl flex items-center justify-center text-white shadow-2xl mb-4">
                                <span class="material-symbols-outlined text-4xl">map</span>
                            </div>
                            <p class="text-sm font-extrabold text-slate-900">Buka Peta Wilayah Produksi</p>
                            <p class="text-xs text-slate-600 font-medium mt-1">Lihat distribusi lahan secara real-time</p>
                        </div>
                    </a>

                    <!-- Lahan Details List -->
                    <div class="space-y-8 py-2">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 bg-primary-500/10 rounded-3xl flex items-center justify-center text-primary-500">
                                <span class="material-symbols-outlined text-3xl">straighten</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Luas Kelolaan</p>
                                <p class="text-xl font-extrabold text-slate-900">{{ $totalHektar }} <span class="text-sm font-medium text-slate-400">Hektar</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 bg-secondary/10 rounded-3xl flex items-center justify-center text-secondary">
                                <span class="material-symbols-outlined text-3xl">category</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Varietas Produksi</p>
                                <p class="text-xl font-extrabold text-slate-900">{{ implode(', ', $varietas) ?: 'Belum ada data' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 bg-blue-50 rounded-3xl flex items-center justify-center text-blue-500">
                                <span class="material-symbols-outlined text-3xl">verified</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Penyebaran Status</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($statusLahan as $status => $count)
                                    <span class="px-3 py-1 bg-slate-50 border border-slate-100 rounded-xl text-[9px] font-black text-slate-600 uppercase tracking-tight">{{ $status }}: {{ $count }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Remote Monitoring Section (Satellite Hub) -->
            <div class="bg-white p-10 rounded-[4rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="flex justify-between items-center mb-10 relative z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                            <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em]">Live Satellite Feed</p>
                        </div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Global Remote Monitoring 🛰️</h2>
                    </div>
                    <div class="px-4 py-2 bg-slate-900 text-white rounded-2xl flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm animate-spin">sync</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">Scanning Fields...</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                    <!-- NDVI Health Card -->
                    <div class="p-6 bg-slate-50 rounded-[2.5rem] border border-slate-100 group/item hover:bg-white hover:shadow-xl transition-all duration-500">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-primary-500/10 rounded-2xl flex items-center justify-center text-primary-500">
                                <span class="material-symbols-outlined text-2xl">potted_plant</span>
                            </div>
                            <span class="text-[9px] font-black text-primary-500 bg-primary-500/10 px-3 py-1 rounded-full">{{ number_format(($agroData['ndvi']['ndvi'] ?? 0) * 100, 1) }}% HEALTH</span>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Crop Health (NDVI)</p>
                        <p class="text-lg font-black text-slate-900 mb-4 tracking-tight">
                            @php
                                $ndvi = $agroData['ndvi']['ndvi'] ?? 0;
                                if($ndvi > 0.7) echo "Optimal Photosynthesis";
                                elseif($ndvi > 0.4) echo "Normal Growth";
                                else echo "Vegetation Stress";
                            @endphp
                        </p>
                        <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-primary-500 h-full w-[{{ ($agroData['ndvi']['ndvi'] ?? 0) * 100 }}%] animate-pulse"></div>
                        </div>
                    </div>

                    <!-- Soil Moisture Remote -->
                    <div class="p-6 bg-slate-50 rounded-[2.5rem] border border-slate-100 group/item hover:bg-white hover:shadow-xl transition-all duration-500">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500">
                                <span class="material-symbols-outlined text-2xl">water_drop</span>
                            </div>
                            <span class="text-[9px] font-black text-blue-500 bg-blue-500/10 px-3 py-1 rounded-full">{{ number_format(($agroData['soil']['moisture'] ?? 0) * 100, 1) }}% MOISTURE</span>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Soil Condition</p>
                        <p class="text-lg font-black text-slate-900 mb-4 tracking-tight">
                            @php
                                $moisture = $agroData['soil']['moisture'] ?? 0;
                                if($moisture > 0.3) echo "Adequate Irrigation";
                                elseif($moisture > 0.15) echo "Mild Dryness";
                                else echo "Critical Water Need";
                            @endphp
                        </p>
                        <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full w-[{{ ($agroData['soil']['moisture'] ?? 0) * 100 }}%]"></div>
                        </div>
                    </div>

                    <!-- Pest Risk Index -->
                    <div class="p-6 bg-slate-50 rounded-[2.5rem] border border-slate-100 group/item hover:bg-white hover:shadow-xl transition-all duration-500">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-yellow-500/10 rounded-2xl flex items-center justify-center text-yellow-500">
                                <span class="material-symbols-outlined text-2xl">bug_report</span>
                            </div>
                            <span class="text-[9px] font-black text-yellow-600 bg-yellow-500/10 px-3 py-1 rounded-full">12% LOW RISK</span>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pest Activity</p>
                        <p class="text-lg font-black text-slate-900 mb-4 tracking-tight">No Outbreak Detected</p>
                        <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-yellow-500 h-full w-[12%]"></div>
                        </div>
                    </div>
                </div>

                <!-- Decorative Radar Animation Background -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 pointer-events-none opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-1000">
                    <div class="absolute inset-0 border-4 border-slate-900 rounded-full animate-ping"></div>
                    <div class="absolute inset-10 border-4 border-slate-900 rounded-full animate-pulse"></div>
                    <div class="absolute inset-20 border-4 border-slate-900 rounded-full"></div>
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-900 origin-center animate-[spin_4s_linear_infinite]"></div>
                </div>
            </div>
        </div>

        <!-- Right Column (Alerts & Lists) -->
        <div class="lg:col-span-4 space-y-8">
            
            <!-- AI Advisor Floating Card -->
            <div class="bg-slate-900 rounded-[3.5rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-10">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary-500/20">
                                <span class="material-symbols-outlined text-xl">psychology</span>
                            </div>
                            <h2 class="text-xl font-extrabold tracking-tight">AI Smart Advisor</h2>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-white/40 uppercase tracking-widest">Target Lahan:</p>
                            <p class="text-[10px] font-bold text-primary-500">{{ $lahan->first()->nama_lahan ?? 'Indramayu (Default)' }}</p>
                        </div>
                    </div>

                    @if($cuaca)
                    <div class="space-y-8">
                        <div class="p-6 bg-white/10 rounded-3xl border border-white/10 backdrop-blur-md">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-[10px] font-black text-white/50 uppercase tracking-widest">Rekomendasi Panen</span>
                                @if($cuaca->optimal_panen)
                                <span class="px-3 py-1 bg-primary-500 rounded-full text-[9px] font-black uppercase tracking-widest">Optimal</span>
                                @else
                                <span class="px-3 py-1 bg-secondary rounded-full text-[9px] font-black uppercase tracking-widest text-dark">Warning</span>
                                @endif
                            </div>
                            <p class="text-sm font-bold leading-relaxed">{{ $cuaca->optimal_panen ? 'Hari ini cuaca sangat ideal! Segera lakukan pemanenan untuk kualitas terbaik.' : 'Curah hujan cukup tinggi. Disarankan menunda panen 1-2 hari ke depan.' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                                <p class="text-[9px] font-black text-white/30 uppercase tracking-widest mb-2">Temperatur</p>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-lg">wb_sunny</span>
                                    <span class="text-xl font-extrabold">{{ $cuaca->suhu_max }}°C</span>
                                </div>
                            </div>
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                                <p class="text-[9px] font-black text-white/30 uppercase tracking-widest mb-2">Humidity</p>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-blue-400 text-lg">water_drop</span>
                                    <span class="text-xl font-extrabold">{{ $cuaca->kelembaban }}%</span>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('petani.rekomendasi') }}" class="w-full flex items-center justify-center gap-2 py-4 bg-white text-slate-900 font-black rounded-2xl hover:bg-slate-50 transition-all text-[11px] uppercase tracking-widest">
                            Buka Analisis Lengkap
                        </a>
                    </div>
                    @endif
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-500/20 blur-[80px] rounded-full"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-500/10 blur-[80px] rounded-full"></div>
            </div>

            <!-- User Presence Card -->
            <div id="user-location-card" class="hidden bg-white p-8 rounded-[3.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 relative overflow-hidden group animate-in slide-in-from-right duration-700">
                <div class="relative z-10 flex items-center gap-6">
                    <div class="w-20 h-20 bg-blue-600 rounded-[2rem] flex items-center justify-center text-white shadow-2xl shadow-blue-500/30 shrink-0">
                        <span class="material-symbols-outlined text-4xl animate-bounce">person_pin_circle</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-1">Your Presence</p>
                        <h3 id="current-city" class="text-2xl font-extrabold text-slate-900 tracking-tight leading-tight">Detecting...</h3>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">GPS Active</p>
                        </div>
                    </div>
                </div>
                <!-- Mini Map Pattern Background -->
                <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
            </div>

            <!-- Active Buyers List -->
            <div class="bg-white p-8 rounded-[3.5rem] border border-slate-100 shadow-sm">
                <div class="flex justify-between items-center mb-8 px-2">
                    <h2 class="text-xl font-extrabold text-slate-900">Pembeli Aktif</h2>
                    <span class="px-3 py-1 bg-slate-50 rounded-full text-[10px] font-black text-slate-400 uppercase tracking-tighter">Live Monitor</span>
                </div>
                <div class="space-y-5">
                    <div class="flex items-center justify-between p-4 bg-slate-50/50 hover:bg-slate-50 rounded-3xl transition-all cursor-pointer border border-transparent hover:border-slate-100 group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm overflow-hidden border border-slate-100">
                                <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=random&color=fff" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-extrabold text-slate-900">Siti Aminah</p>
                                <p class="text-[10px] text-slate-400 font-medium">Reseller • Indramayu</p>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-slate-300 group-hover:text-primary-500 transition-colors">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50/50 hover:bg-slate-50 rounded-3xl transition-all cursor-pointer border border-transparent hover:border-slate-100 group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm overflow-hidden border border-slate-100">
                                <img src="https://ui-avatars.com/api/?name=Resto+Sunda&background=random&color=fff" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-extrabold text-slate-900">Resto Saung Sunda</p>
                                <p class="text-[10px] text-slate-400 font-medium">Restoran • Losarang</p>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-slate-300 group-hover:text-primary-500 transition-colors">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </div>
                    </div>
                </div>
                <button class="w-full mt-8 py-4 border-2 border-dashed border-slate-200 rounded-3xl text-[11px] font-black text-slate-400 hover:border-primary-500 hover:text-primary-500 transition-all uppercase tracking-widest">
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
        });
    </script>
</x-petani-layout>
