<x-admin-layout>
    <x-slot name="title">Pemetaan Lahan</x-slot>

    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-4xl font-black text-on-surface tracking-tighter">Geospasial <span class="text-primary-500">Lahan</span></h1>
            <p class="text-on-surface-variant mt-2 flex items-center gap-2 font-medium">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                Visualisasi distribusi geografis aset komoditas mangga.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="glass px-4 py-2 rounded-2xl flex items-center gap-2 text-sm font-medium text-on-surface-variant premium-shadow">
                <span class="material-symbols-outlined text-[18px]">location_on</span>
                {{ $lahan->count() }} Titik Lahan Terdaftar
            </div>
        </div>
    </div>

    <!-- Map & List Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-[calc(100vh-250px)] min-h-[600px]">
        
        <!-- Left: Map Visualization -->
        <div class="lg:col-span-8 bg-white/50 backdrop-blur-xl border border-white/20 rounded-[2.5rem] overflow-hidden premium-shadow relative flex flex-col">
            <!-- Map Controls / Filters Overlay -->
            <div class="absolute top-6 left-6 right-6 z-[10] flex flex-wrap gap-3">
                <div class="bg-white/90 backdrop-blur-md border border-outline-variant px-4 py-2.5 rounded-xl text-xs font-bold shadow-lg flex items-center gap-4">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-primary-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></span>
                        <span>Aktif</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                        <span>Persiapan</span>
                    </div>
                </div>
            </div>

            <!-- Leaflet Map Container -->
            <div id="map" class="flex-1 w-full h-full z-[1]"></div>
        </div>

        <!-- Right: Land List Sidebar -->
        <div class="lg:col-span-4 flex flex-col gap-4 overflow-hidden">
            <div class="bg-white/80 backdrop-blur-xl border border-white/20 rounded-[2.5rem] p-6 premium-shadow flex flex-col h-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-on-surface tracking-tight">Daftar Lahan</h3>
                    <span class="text-xs font-bold text-primary-600 bg-primary-50 px-2.5 py-1 rounded-lg">Terdekat</span>
                </div>

                <div class="flex-1 overflow-y-auto pr-2 space-y-4 custom-scrollbar">
                    @forelse($lahan as $item)
                    <div class="group p-4 bg-white border border-outline-variant rounded-2xl hover:border-primary-500 transition-all cursor-pointer hover:shadow-md" 
                         onclick="focusMap({{ $item->latitude }}, {{ $item->longitude }}, '{{ $item->nama_lahan }}')">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-on-surface group-hover:text-primary-600 transition-colors">{{ $item->nama_lahan }}</h4>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase {{ $item->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $item->status }}
                            </span>
                        </div>
                        <div class="space-y-1.5">
                            <p class="text-xs text-on-surface-variant flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px]">person</span>
                                {{ $item->petani->user->nama }}
                            </p>
                            <p class="text-xs text-on-surface-variant flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px]">location_on</span>
                                {{ $item->desa }}, Kec. {{ $item->kecamatan->nama_kecamatan }}
                            </p>
                            <div class="flex items-center gap-3 mt-3 pt-3 border-t border-dashed border-outline-variant">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-primary-500">square_foot</span>
                                    <span class="text-[11px] font-bold">{{ $item->luas_hektar }} Ha</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-mango-500">park</span>
                                    <span class="text-[11px] font-bold">{{ $item->jumlah_pohon }} Pohon</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 opacity-50">
                        <span class="material-symbols-outlined text-4xl">map</span>
                        <p class="text-sm mt-2">Tidak ada data lahan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map { background: #f8fafc; border-radius: 2.5rem; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
        .leaflet-popup-content-wrapper { border-radius: 1.5rem; padding: 0.5rem; }
        .leaflet-container { font-family: 'Outfit', sans-serif !important; }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        var map = L.map('map').setView([-6.33, 108.32], 11); // Default focus on Indramayu area

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        var markers = [];
        var dataLahan = @json($lahan);

        dataLahan.forEach(function(item) {
            if (item.latitude && item.longitude) {
                var markerColor = item.status === 'aktif' ? '#22c55e' : '#eab308';
                
                var marker = L.circleMarker([item.latitude, item.longitude], {
                    radius: 10,
                    fillColor: markerColor,
                    color: "#fff",
                    weight: 3,
                    opacity: 1,
                    fillOpacity: 0.8
                }).addTo(map);

                marker.bindPopup(`
                    <div class="p-2 min-w-[200px]">
                        <h5 class="font-bold text-lg mb-1">${item.nama_lahan}</h5>
                        <p class="text-sm text-gray-600 mb-3">${item.petani.user.nama}</p>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="bg-gray-100 p-2 rounded-lg">
                                <p class="text-gray-400">Luas</p>
                                <p class="font-bold">${item.luas_hektar} Ha</p>
                            </div>
                            <div class="bg-gray-100 p-2 rounded-lg">
                                <p class="text-gray-400">Pohon</p>
                                <p class="font-bold">${item.jumlah_pohon}</p>
                            </div>
                        </div>
                    </div>
                `);

                markers.push({
                    id: item.id,
                    lat: item.latitude,
                    lng: item.longitude,
                    marker: marker
                });
            }
        });

        if (markers.length > 0) {
            var group = new L.featureGroup(markers.map(m => m.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }

        function focusMap(lat, lng, name) {
            map.flyTo([lat, lng], 15, {
                duration: 1.5
            });
            
            // Find and open popup
            markers.forEach(function(m) {
                if (m.lat == lat && m.lng == lng) {
                    m.marker.openPopup();
                }
            });
        }
    </script>
    @endpush
</x-admin-layout>
