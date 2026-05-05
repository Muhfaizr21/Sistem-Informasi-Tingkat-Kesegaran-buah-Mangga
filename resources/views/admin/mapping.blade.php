<x-admin-layout>
    <x-slot name="title">Pemetaan Lahan</x-slot>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <div class="flex flex-col gap-6 h-[calc(100vh-140px)]">
        <!-- Header -->
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-on-surface">Pemetaan Lahan GIS</h1>
                <p class="text-base text-on-surface-variant mt-1">Pantau sebaran kebun dan status kesuburan lahan secara geografis.</p>
            </div>
            <div class="flex gap-2">
                <div class="bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg flex items-center gap-4 shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        <span class="text-xs font-bold text-on-surface">Subur</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                        <span class="text-xs font-bold text-on-surface">Sedang</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="text-xs font-bold text-on-surface">Kritis</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="flex-1 bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden relative shadow-inner">
            <div id="map" class="w-full h-full z-10"></div>
            
            <!-- Map Overlay Controls -->
            <div class="absolute top-4 right-4 z-[20] flex flex-col gap-2">
                <button class="p-2 bg-white rounded-lg shadow-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                    <span class="material-symbols-outlined">layers</span>
                </button>
                <button class="p-2 bg-white rounded-lg shadow-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                    <span class="material-symbols-outlined">my_location</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map focused on Indramayu area
            var map = L.map('map').setView([-6.3273, 108.3249], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Sample Farm Data
            var farms = [
                { name: "Kebun Mangga Bpk. Supardi", coords: [-6.33, 108.33], status: "Subur", color: "#22c55e" },
                { name: "Kebun Harum Manis Blok C", coords: [-6.35, 108.31], status: "Kritis", color: "#ef4444" },
                { name: "Lahan Percobaan Gincu", coords: [-6.31, 108.35], status: "Sedang", color: "#eab308" }
            ];

            farms.forEach(function(farm) {
                var marker = L.circleMarker(farm.coords, {
                    radius: 10,
                    fillColor: farm.color,
                    color: "#fff",
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.8
                }).addTo(map);

                marker.bindPopup("<b class='text-lg'>" + farm.name + "</b><br>Status: " + farm.status);
            });
        });
    </script>
</x-admin-layout>
