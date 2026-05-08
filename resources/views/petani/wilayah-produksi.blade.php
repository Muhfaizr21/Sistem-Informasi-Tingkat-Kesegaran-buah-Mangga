<x-petani-layout>
    <x-slot name="title">Wilayah Produksi & Geo-Analytics</x-slot>

    <!-- Leaflet & Heatmap JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>

    <!-- Header Section -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-3 py-1 bg-primary-500/10 text-primary-500 text-[10px] font-black rounded-full uppercase tracking-widest">GIS Mapping</span>
                <span class="px-3 py-1 bg-blue-500/10 text-blue-500 text-[10px] font-black rounded-full uppercase tracking-widest">Spatial Analytics</span>
            </div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Geo-Analytics Produksi 🌐</h1>
            <p class="text-slate-500 font-medium mt-1">Pemetaan GIS dan analisis produktivitas lahan secara spasial.</p>
        </div>
        <div class="flex gap-3">
            <button class="px-6 py-3 bg-white border border-slate-100 rounded-2xl text-xs font-black text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2 uppercase tracking-widest shadow-sm">
                <span class="material-symbols-outlined text-lg">download</span> Export GIS Data
            </button>
        </div>
    </div>

    <!-- Analytics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 p-10 rounded-[3rem] text-white shadow-2xl shadow-slate-900/20 relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-white/50 text-[10px] font-black uppercase tracking-widest mb-3">Produksi Kumulatif</p>
                <h3 class="text-4xl font-extrabold mb-2 tracking-tighter">{{ number_format($totalProduksi, 1) }} <span class="text-lg font-medium opacity-50">Kg</span></h3>
                <p class="text-xs font-bold text-primary-500">Berasal dari {{ $lahanData->count() }} titik lahan.</p>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] text-white/5 rotate-12 group-hover:scale-110 transition-transform duration-500">database</span>
        </div>

        <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Rasio Produktivitas</p>
            <h3 class="text-4xl font-extrabold text-slate-900 mb-2 tracking-tighter">{{ number_format($avgProductivity, 1) }} <span class="text-lg font-medium text-slate-400 opacity-50 uppercase">Kg/Ha</span></h3>
            <div class="flex items-center gap-2 text-xs font-black text-primary-500 uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm">trending_up</span>
                Status: Efisien
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] text-slate-50 rotate-12 group-hover:scale-110 transition-transform duration-500">insights</span>
        </div>

        <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Total Area Terpetakan</p>
            <h3 class="text-4xl font-extrabold text-slate-900 mb-2 tracking-tighter">{{ number_format($totalLuas, 2) }} <span class="text-lg font-medium text-slate-400 opacity-50 uppercase">Ha</span></h3>
            <p class="text-xs font-bold text-secondary uppercase tracking-widest">Zona: {{ $lahanData->pluck('kecamatan_id')->unique()->count() }} Kecamatan</p>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] text-slate-50 rotate-12 group-hover:scale-110 transition-transform duration-500">public</span>
        </div>
    </div>

    <!-- Map & List Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-10">
        
        <!-- Interactive Map -->
        <div class="xl:col-span-8">
            <div class="bg-white p-6 rounded-[3.5rem] border border-slate-100 shadow-sm h-[650px] relative overflow-hidden group">
                <div id="map" class="w-full h-full rounded-[2.5rem] z-10 border border-slate-50"></div>
                
                <!-- Map Legend Overlay -->
                <div class="absolute bottom-12 left-12 z-[1000] bg-white/80 backdrop-blur-xl p-6 rounded-3xl border border-white shadow-2xl space-y-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Heatmap Legend</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-primary-500 shadow-[0_0_10px_#10B981]"></div>
                            <span class="text-[11px] font-extrabold text-slate-700">High Yield (> 1000 Kg)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary shadow-[0_0_10px_#FBBF24]"></div>
                            <span class="text-[11px] font-extrabold text-slate-700">Moderate (500-1000 Kg)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-red-500 shadow-[0_0_10px_#EF4444]"></div>
                            <span class="text-[11px] font-extrabold text-slate-700">Low Yield (< 500 Kg)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar List / Details -->
        <div class="xl:col-span-4 space-y-8">
            <div class="bg-white p-10 rounded-[3.5rem] border border-slate-100 shadow-sm h-[650px] flex flex-col">
                <div class="mb-8">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-2">Performa Spasial</h2>
                    <p class="text-xs text-slate-400 font-medium">Klik pada titik lokasi di peta untuk melihat detail spesifik lahan.</p>
                </div>

                <div class="flex-1 overflow-y-auto space-y-5 pr-2 custom-scrollbar">
                    @foreach($lahanData as $item)
                    <div class="p-6 bg-slate-50/50 rounded-3xl border border-transparent hover:border-primary-500 hover:bg-white transition-all duration-300 cursor-pointer group shadow-sm hover:shadow-xl">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-extrabold text-slate-900 group-hover:text-primary-500 transition-colors">{{ $item->nama_lahan }}</h4>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $item->kecamatan->nama_kecamatan ?? 'N/A' }}</p>
                            </div>
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-primary-500">location_on</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="p-3 bg-white rounded-2xl border border-slate-100">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Satellite NDVI</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-extrabold {{ $item->ndvi > 0.7 ? 'text-primary-500' : 'text-amber-500' }}">{{ $item->ndvi }}</span>
                                    <div class="w-1.5 h-1.5 rounded-full {{ $item->ndvi > 0.7 ? 'bg-primary-500 animate-pulse' : 'bg-amber-500' }}"></div>
                                </div>
                            </div>
                            <div class="p-3 bg-white rounded-2xl border border-slate-100">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Soil Moisture</p>
                                <p class="text-xs font-extrabold text-slate-900">{{ round($item->soil_moisture) }}%</p>
                            </div>
                            <div class="col-span-2 p-3 bg-white rounded-2xl border border-slate-100 flex justify-between items-center">
                                <div>
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Productivity</p>
                                    <p class="text-sm font-extrabold text-slate-900">{{ number_format($item->productivity, 1) }} <span class="text-[10px] text-slate-400 uppercase">Kg</span></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Area</p>
                                    <p class="text-sm font-extrabold text-slate-900">{{ $item->luas_hektar }} <span class="text-[10px] text-slate-400 uppercase">Ha</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden shadow-inner">
                            @php $percent = min(($item->productivity / 2000) * 100, 100); @endphp
                            <div class="h-full {{ $percent > 70 ? 'bg-primary-500' : ($percent > 30 ? 'bg-secondary' : 'bg-red-500') }} transition-all duration-1000" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-8 border-t border-slate-50">
                    <div class="flex items-center gap-4 p-5 bg-primary-500/5 rounded-3xl border border-primary-500/10">
                        <div class="w-10 h-10 bg-primary-500 rounded-2xl flex items-center justify-center text-white shrink-0">
                            <span class="material-symbols-outlined text-xl">psychology</span>
                        </div>
                        <p class="text-[10px] leading-relaxed font-extrabold text-primary-600 uppercase tracking-tight italic">
                            AI Insight: Lahan <span class="text-primary-700 underline">{{ $lahanData->sortByDesc('productivity')->first()->nama_lahan ?? '-' }}</span> menunjukkan efisiensi tertinggi musim ini.
                        </p>
                    </div>
                </div>
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
                                <span class="${lahan.productivity > 1000 ? 'text-primary-500' : (lahan.productivity > 500 ? 'text-secondary' : 'text-red-500')}">
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
                                    <span class="${l.productivity > 1000 ? 'text-primary-500' : (l.productivity > 500 ? 'text-secondary' : 'text-red-500')}">
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
            background: rgba(255, 255, 255, 0.9);
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
            border-radius: 2.5rem;
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
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 9999px;
        }
    </style>
</x-petani-layout>
