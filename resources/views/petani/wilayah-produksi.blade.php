<x-petani-layout>
    <x-slot name="title">Wilayah Produksi & Geo-Analytics</x-slot>

    <!-- Leaflet & Heatmap Local -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" />
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/vendor/leaflet/leaflet-heat.js') }}"></script>

    <!-- Header Section -->
    <div class="mb-12 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 text-[10px] font-black rounded-full uppercase tracking-widest border border-emerald-500/20">GIS Mapping</span>
                <span class="px-3 py-1 bg-blue-500/10 text-blue-700 text-[10px] font-black rounded-full uppercase tracking-widest border border-blue-500/20">Spatial Analytics</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight">Geo-Analytics Produksi 🌐</h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Pemetaan GIS dan analisis produktivitas lahan secara spasial.</p>
        </div>
        <div class="w-full sm:w-auto">
            <button class="w-full sm:w-auto px-6 py-3.5 bg-white border border-slate-200 hover:bg-slate-50 active:scale-[0.98] rounded-2xl text-xs font-black text-slate-700 transition-all flex items-center justify-center gap-2 uppercase tracking-widest shadow-sm">
                <span class="material-symbols-outlined text-lg">download</span> Export GIS Data
            </button>
        </div>
    </div>

    <!-- Analytics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Produksi Card -->
        <div class="bg-[#064E3B] bg-gradient-to-br from-[#064E3B] to-[#022C22] p-8 rounded-[2.5rem] text-white shadow-xl relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-emerald-300/80 text-[10px] font-black uppercase tracking-widest mb-3">Produksi ({{ $historicalStats->first()->tahun ?? '2024' }})</p>
                <h3 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">{{ number_format($totalProduksi, 1) }} <span class="text-lg font-medium text-emerald-300">Kuintal</span></h3>
                <p class="text-xs font-bold text-emerald-400">Data bersumber dari CSV.</p>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[110px] text-white/5 rotate-12 group-hover:scale-110 transition-transform duration-500 pointer-events-none">database</span>
        </div>

        <!-- Luas Lahan Card -->
        <div class="bg-slate-50/60 p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Luas Lahan (CSV)</p>
            <h3 class="text-3xl md:text-4xl font-extrabold text-slate-850 mb-2 tracking-tight">{{ number_format($totalLuas, 2) }} <span class="text-lg font-medium text-slate-400 uppercase">Ha</span></h3>
            <div class="flex items-center gap-1.5 text-[10px] font-black text-emerald-600 bg-emerald-500/10 w-fit px-3 py-1 rounded-full uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm">map</span>
                <span>Terpetakan: {{ $lahanData->count() }} Titik</span>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[110px] text-slate-200/50 rotate-12 group-hover:scale-110 transition-transform duration-500 pointer-events-none">public</span>
        </div>

        <!-- Cuaca Card -->
        <div class="bg-slate-50/60 p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Cuaca Saat Ini</p>
            <h3 class="text-3xl md:text-4xl font-extrabold text-slate-850 mb-2 tracking-tight">{{ $currentWeather->suhu_max ?? '32' }}<span class="text-lg font-medium text-slate-400">°C</span></h3>
            <div class="flex items-center gap-1.5 text-[10px] font-black text-amber-700 bg-amber-500/10 w-fit px-3 py-1 rounded-full uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm">wb_sunny</span>
                <span>{{ $currentWeather->kondisi ?? 'Cerah' }}</span>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[110px] text-slate-200/50 rotate-12 group-hover:scale-110 transition-transform duration-500 pointer-events-none">sunny</span>
        </div>

        <!-- Keberhasilan Card -->
        <div class="bg-slate-50/60 p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Keberhasilan Panen</p>
            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-850 mb-2 tracking-tight">BERHASIL</h3>
            <div class="flex items-center gap-1.5 text-[10px] font-black text-emerald-600 bg-emerald-500/10 w-fit px-3 py-1 rounded-full uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm">verified</span>
                <span>Tren Historis Optimal</span>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[110px] text-slate-200/50 rotate-12 group-hover:scale-110 transition-transform duration-500 pointer-events-none">verified</span>
        </div>
    </div>

    <!-- Map & List Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Interactive Map -->
        <div class="lg:col-span-8">
            <div class="bg-white p-5 rounded-[3rem] border border-slate-100 shadow-sm h-[400px] md:h-[650px] relative overflow-hidden group">
                <div id="map" class="w-full h-full rounded-[2rem] z-10 border border-slate-100"></div>
                
                <!-- Map Legend Overlay -->
                <div class="absolute bottom-10 left-10 z-[1000] bg-white/95 backdrop-blur-md p-5 rounded-2xl border border-slate-200/80 shadow-xl space-y-3 max-w-[240px] hidden sm:block">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Legenda Yield</p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2.5">
                            <div class="w-3.5 h-3.5 rounded-full bg-emerald-500 shadow-sm"></div>
                            <span class="text-[10px] font-extrabold text-slate-700">Tinggi (> 1000 Kg)</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-3.5 h-3.5 rounded-full bg-amber-500 shadow-sm"></div>
                            <span class="text-[10px] font-extrabold text-slate-700">Sedang (500-1000 Kg)</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-3.5 h-3.5 rounded-full bg-rose-500 shadow-sm"></div>
                            <span class="text-[10px] font-extrabold text-slate-700">Rendah (< 500 Kg)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar List / Details -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white p-8 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm h-auto lg:h-[650px] flex flex-col">
                <div class="mb-6">
                    <h2 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight mb-2">Performa Spasial</h2>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Klik pada titik lokasi di peta untuk melihat detail spesifik lahan.</p>
                </div>

                <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar max-h-[360px] lg:max-h-none">
                    @foreach($lahanData as $item)
                    <div class="p-5 bg-slate-50/50 rounded-2xl border border-slate-100/50 hover:border-emerald-500/30 hover:bg-white transition-all duration-300 cursor-pointer group shadow-sm hover:shadow-md">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-extrabold text-slate-800 group-hover:text-emerald-650 transition-colors text-sm">{{ $item->nama_lahan }}</h4>
                                <p class="text-[9px] font-black text-slate-450 uppercase tracking-widest mt-0.5">{{ $item->kecamatan->nama_kecamatan ?? 'N/A' }}</p>
                            </div>
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-emerald-500 text-lg">location_on</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="p-2.5 bg-white rounded-xl border border-slate-100">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Satellite NDVI</p>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-black {{ $item->ndvi > 0.7 ? 'text-emerald-650' : 'text-amber-600' }}">{{ $item->ndvi }}</span>
                                    <div class="w-1.5 h-1.5 rounded-full {{ $item->ndvi > 0.7 ? 'bg-emerald-500' : 'bg-amber-500' }}"></div>
                                </div>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-slate-100">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Soil Moisture</p>
                                <p class="text-xs font-black text-slate-800">{{ round($item->soil_moisture) }}%</p>
                            </div>
                            <div class="col-span-2 p-2.5 bg-white rounded-xl border border-slate-100 flex justify-between items-center">
                                <div>
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Productivity</p>
                                    <p class="text-xs font-black text-slate-800">{{ number_format($item->productivity, 1) }} <span class="text-[8px] text-slate-400 uppercase font-medium">Kg</span></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Area</p>
                                    <p class="text-xs font-black text-slate-800">{{ $item->luas_hektar }} <span class="text-[8px] text-slate-400 uppercase font-medium">Ha</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                            @php $percent = min(($item->productivity / 2000) * 100, 100); @endphp
                            <div class="h-full {{ $percent > 70 ? 'bg-emerald-500' : ($percent > 30 ? 'bg-amber-500' : 'bg-rose-500') }}" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100 shrink-0">
                    <div class="flex items-center gap-3 p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100/50">
                        <div class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center text-white shrink-0">
                            <span class="material-symbols-outlined text-lg">psychology</span>
                        </div>
                        <p class="text-[10px] leading-relaxed font-black text-emerald-700 uppercase tracking-tight italic">
                            AI Insight: Lahan <span class="text-emerald-800 underline font-extrabold">{{ $lahanData->sortByDesc('productivity')->first()->nama_lahan ?? '-' }}</span> menunjukkan efisiensi tertinggi musim ini.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historical Data Table (from CSV) -->
    <div class="mt-12 bg-white p-6 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">Data Historis Kecamatan 📈</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Rekam jejak produksi dan luas lahan berdasarkan dataset BPS (CSV).</p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                <form action="{{ route('petani.wilayah-produksi') }}" method="GET" class="flex items-center gap-3 bg-slate-50 p-2 rounded-2xl border border-slate-200/60 w-full sm:w-auto">
                    <input type="number" name="search_tahun" value="{{ request('search_tahun') }}" placeholder="Cari Tahun..." class="bg-transparent border-none outline-none px-4 py-2 font-black text-sm w-full sm:w-28 text-slate-700">
                    <button type="submit" class="p-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl transition-all shrink-0">
                        <span class="material-symbols-outlined text-sm">search</span>
                    </button>
                    @if(request('search_tahun'))
                    <a href="{{ route('petani.wilayah-produksi') }}" class="p-2 bg-rose-100 text-rose-600 rounded-xl hover:bg-rose-200 transition-all shrink-0">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </a>
                    @endif
                </form>
                <div class="w-full sm:w-auto px-6 py-4 bg-slate-800 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-center">
                    Dataset: 2011 - 2025
                </div>
            </div>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-100 shadow-inner">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="py-5 px-6 text-[10px] font-black text-slate-450 uppercase tracking-widest">Tahun</th>
                        <th class="py-5 px-6 text-[10px] font-black text-slate-450 uppercase tracking-widest">Kecamatan</th>
                        <th class="py-5 px-6 text-[10px] font-black text-slate-450 uppercase tracking-widest">Total Produksi</th>
                        <th class="py-5 px-6 text-[10px] font-black text-slate-450 uppercase tracking-widest">Luas Lahan</th>
                        <th class="py-5 px-6 text-[10px] font-black text-slate-450 uppercase tracking-widest">Jenis Mangga</th>
                        <th class="py-5 px-6 text-[10px] font-black text-slate-450 uppercase tracking-widest">Cuaca</th>
                        <th class="py-5 px-6 text-[10px] font-black text-slate-450 uppercase tracking-widest">Keberhasilan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($historicalStats as $stat)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="py-5 px-6">
                            <span class="px-4 py-1.5 bg-slate-100 text-slate-800 text-[10px] font-black rounded-full uppercase tracking-widest">{{ $stat->tahun }}</span>
                        </td>
                        <td class="py-5 px-6">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-black rounded-full uppercase tracking-widest">{{ $stat->kecamatan->nama ?? 'N/A' }}</span>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-extrabold text-slate-800">{{ number_format($stat->produksi_kuintal / 10, 2) }}</span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest font-bold">Ton</span>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-extrabold text-slate-700">{{ number_format($stat->luas_hektar, 2) }}</span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest font-bold">Ha</span>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-100 text-[10px] font-black rounded-full uppercase tracking-widest">{{ $stat->jenis_mangga }}</span>
                        </td>
                        <td class="py-5 px-6">
                            <span class="flex items-center gap-1.5 text-xs font-bold text-slate-700">
                                <span class="material-symbols-outlined text-sm text-slate-400">
                                    @if(str_contains(strtolower($stat->cuaca), 'cerah'))
                                        wb_sunny
                                    @elseif(str_contains(strtolower($stat->cuaca), 'hujan'))
                                        rainy
                                    @elseif(str_contains(strtolower($stat->cuaca), 'awan') || str_contains(strtolower($stat->cuaca), 'mendung'))
                                        cloud
                                    @elseif(str_contains(strtolower($stat->cuaca), 'angin'))
                                        wind_power
                                    @else
                                        device_thermostat
                                    @endif
                                </span>
                                {{ $stat->cuaca }}
                            </span>
                        </td>
                        <td class="py-5 px-6">
                            @if(str_contains(strtolower($stat->keberhasilan_panen), 'berhasil'))
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 text-[10px] font-black rounded-full uppercase tracking-widest">Berhasil</span>
                            @elseif(str_contains(strtolower($stat->keberhasilan_panen), 'kurang'))
                                <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-100 text-[10px] font-black rounded-full uppercase tracking-widest">Kurang</span>
                            @else
                                <span class="px-3 py-1 bg-rose-50 text-rose-700 border border-rose-100 text-[10px] font-black rounded-full uppercase tracking-widest">Gagal</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center">
                            <p class="text-slate-400 font-medium">Belum ada data historis yang tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-center">
            <div class="bg-slate-50 px-6 py-3 rounded-2xl border border-slate-100">
                {{ $historicalStats->links() }}
            </div>
        </div>
    </div>

    <!-- Leaflet & Heatmap Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const agroApiKey = '{{ env("AGRO_API_KEY") }}';
            
            // Define Tile Layers
            const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Esri Satellite'
            });

            const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                attribution: 'OpenTopoMap'
            });

            // Agromonitoring NDVI Layer (Hanya muncul jika API Key ada)
            const ndviLayer = L.tileLayer(`http://api.agromonitoring.com/agro/1.0/tile/v1/NDVI/{z}/{x}/{y}?appid=${agroApiKey}`, {
                attribution: 'Agromonitoring NDVI',
                opacity: 0.7
            });

            // Initialize Map
            const map = L.map('map', {
                zoomControl: false,
                layers: [satellite]
            }).setView([-6.3276, 108.3249], 13);

            // Layer Switcher
            const baseMaps = {
                "Satelit (High Res)": satellite,
                "Topografi (Medan)": terrain
            };
            
            const overlayMaps = {};
            if (agroApiKey) {
                overlayMaps["Live Satellite NDVI (Agro)"] = ndviLayer;
            }

            L.control.layers(baseMaps, overlayMaps, { position: 'topleft', collapsed: false }).addTo(map);
            L.control.zoom({ position: 'topright' }).addTo(map);

            const lahanData = @json($lahanData);
            
            // --- IMPLEMENTASI HEATMAP ---
            const heatPoints = [];
            lahanData.forEach(lahan => {
                if (lahan.latitude && lahan.longitude) {
                    // Normalize productivity (0 to 1) for heatmap intensity
                    let intensity = Math.min(lahan.productivity / 1500, 1.0);
                    if (intensity < 0.1) intensity = 0.2; // Min visibility
                    
                    heatPoints.push([lahan.latitude, lahan.longitude, intensity]);

                    // Add Custom Marker for Details
                    let color = '#EF4444'; // Red (Low)
                    if (lahan.productivity > 1000) color = '#10B981'; // Green (High)
                    else if (lahan.productivity > 500) color = '#FBBF24'; // Yellow (Mod)

                    const marker = L.circleMarker([lahan.latitude, lahan.longitude], {
                        radius: 8,
                        fillColor: color,
                        color: "#fff",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 1
                    }).addTo(map);

                    marker.bindPopup(`
                        <div class="p-4 font-sans w-56">
                            <p class="font-extrabold text-slate-900 mb-1">${lahan.nama_lahan}</p>
                            <div class="flex justify-between items-center text-xs font-black">
                                <span class="text-slate-400">STATUS YIELD:</span>
                                <span class="${lahan.productivity > 1000 ? 'text-[#059669]' : (lahan.productivity > 500 ? 'text-[#D97706]' : 'text-red-500')}">
                                    ${lahan.productivity > 1000 ? 'HIGH' : (lahan.productivity > 500 ? 'MODERATE' : 'LOW')}
                                </span>
                            </div>
                        </div>
                    `);
                }
            });

            // Initialize Heat Layer
            if (heatPoints.length > 0) {
                L.heatLayer(heatPoints, {
                    radius: 45,
                    blur: 25,
                    maxZoom: 15,
                    gradient: {
                        0.2: '#EF4444', // Red (Low)
                        0.5: '#FBBF24', // Yellow (Moderate)
                        0.8: '#10B981', // Green (High)
                        1.0: '#34D399'  // Bright Green (Max)
                    }
                }).addTo(map);

                const boundsGroup = [];
                lahanData.forEach(l => {
                    let coords = l.koordinat_polygon;
                    
                    // Jika tidak ada polygon, buat kotak (square) berdasarkan luas_hektar
                    if (!coords || coords.length === 0) {
                        if (l.latitude && l.longitude && l.luas_hektar > 0) {
                            const lat = parseFloat(l.latitude);
                            const lng = parseFloat(l.longitude);
                            const areaM2 = l.luas_hektar * 10000;
                            const sideM = Math.sqrt(areaM2);
                            
                            // Konversi meter ke derajat (pendekatan)
                            const deltaLat = (sideM / 111320) / 2;
                            const deltaLng = (sideM / (111320 * Math.cos(lat * Math.PI / 180))) / 2;
                            
                            coords = [
                                [lat + deltaLat, lng - deltaLng],
                                [lat + deltaLat, lng + deltaLng],
                                [lat - deltaLat, lng + deltaLng],
                                [lat - deltaLat, lng - deltaLng]
                            ];
                        }
                    }

                    if (coords && coords.length > 0) {
                        const poly = L.polygon(coords, {
                            color: '#ff0000', // Red border like the example
                            fillColor: '#6366f1', // Indigo/Purple fill
                            fillOpacity: 0.3,
                            weight: 3,
                            dashArray: '5, 5' 
                        }).addTo(map);

                        // Permanent label showing Name and Hectares
                        poly.bindTooltip(`<div class="text-center"><b class="text-xs">${l.nama_lahan}</b><br><span class="text-[10px] font-black">${l.luas_hektar} HA</span></div>`, {
                            permanent: true,
                            direction: 'center',
                            className: 'polygon-label'
                        }).openTooltip();

                        poly.bindPopup(`
                            <div class="p-4 font-sans w-56">
                                <p class="font-extrabold text-slate-900 mb-1">${l.nama_lahan}</p>
                                <div class="flex justify-between items-center text-xs font-black">
                                    <span class="text-slate-400">YIELD:</span>
                                    <span class="${l.productivity > 1000 ? 'text-[#059669]' : (l.productivity > 500 ? 'text-[#D97706]' : 'text-red-500')}">
                                        ${numberFormat(l.productivity)} Kg
                                    </span>
                                </div>
                            </div>
                        `);
                        boundsGroup.push(poly.getBounds());
                    } else if (l.latitude && l.longitude) {
                        boundsGroup.push([l.latitude, l.longitude]);
                    }
                });

                if (boundsGroup.length > 0) {
                    map.fitBounds(L.latLngBounds(boundsGroup).pad(0.3));
                }
            }

            function numberFormat(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });
    </script>

    <style>
        .polygon-label {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #ff0000;
            border-radius: 8px;
            padding: 4px 8px;
            color: #1b1b18;
            font-weight: 900;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        .polygon-label::before {
            display: none;
        }
        .custom-popup .leaflet-popup-content-wrapper {
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            border: 1px solid #f1f5f9;
            padding: 0;
            overflow: hidden;
            backdrop-filter: blur(24px);
            background-color: rgba(255, 255, 255, 0.9);
        }
        .custom-popup .leaflet-popup-content {
            margin: 0;
        }
        .custom-popup .leaflet-popup-tip {
            box-shadow: none;
            background-color: rgba(255, 255, 255, 0.9);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
    </style>
</x-petani-layout>
