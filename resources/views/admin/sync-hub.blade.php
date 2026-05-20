<x-admin-layout>
    <x-slot name="title">Pusat Sinkronisasi Sistem</x-slot>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-on-surface tracking-tight">Pusat Sinkronisasi</h1>
            <p class="text-base text-on-surface-variant mt-1">Kelola sinkronisasi data eksternal, pembaruan stok pasar, verifikasi transaksi pembayaran, serta model prediksi AI.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="location.reload()" class="p-2.5 bg-surface-container-low border border-outline-variant text-on-surface-variant rounded-xl hover:bg-white transition-all shadow-sm flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]">refresh</span>
            </button>
            <button onclick="triggerSync('all')" class="flex items-center gap-2 px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-bold transition-all premium-shadow">
                <span class="material-symbols-outlined text-[18px]" id="icon-sync-all">sync</span>
                <span>Sinkronisasi Semua Sistem</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    <div id="toast-container" class="space-y-4 mb-8 hidden">
        <div id="toast-alert" class="p-4 rounded-2xl flex items-center justify-between transition-all duration-300">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined" id="toast-icon">check_circle</span>
                <span class="text-sm font-bold" id="toast-message"></span>
            </div>
            <button onclick="document.getElementById('toast-container').classList.add('hidden')" class="text-current hover:opacity-75">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in">
        <span class="material-symbols-outlined">check_circle</span>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 animate-fade-in">
        <span class="material-symbols-outlined">error</span>
        <span class="text-sm font-bold">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Operational Metrics Dashboard Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
        <!-- Weather Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-[24px] premium-shadow hover:scale-[1.02] transition-all">
            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center mb-3">
                <span class="material-symbols-outlined">partly_cloudy_day</span>
            </div>
            <div class="text-xs text-on-surface-variant font-bold">Data Cuaca</div>
            <div class="text-2xl font-black text-on-surface mt-1" id="stat-weather">{{ $stats['weather_records'] }}</div>
            <div class="text-[9px] text-on-surface-variant mt-0.5">Prakiraan Wilayah</div>
        </div>

        <!-- Scan Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-[24px] premium-shadow hover:scale-[1.02] transition-all">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-3">
                <span class="material-symbols-outlined">camera</span>
            </div>
            <div class="text-xs text-on-surface-variant font-bold">Pemindaian</div>
            <div class="text-2xl font-black text-on-surface mt-1" id="stat-scans">{{ $stats['quality_scans'] }}</div>
            <div class="text-[9px] text-on-surface-variant mt-0.5">Total Scan Kesegaran</div>
        </div>

        <!-- Harvest Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-[24px] premium-shadow hover:scale-[1.02] transition-all">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                <span class="material-symbols-outlined">agriculture</span>
            </div>
            <div class="text-xs text-on-surface-variant font-bold">Laporan Panen</div>
            <div class="text-2xl font-black text-on-surface mt-1" id="stat-harvest">{{ $stats['harvest_reports'] }}</div>
            <div class="text-[9px] text-on-surface-variant mt-0.5">Verified Logs</div>
        </div>

        <!-- Products Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-[24px] premium-shadow hover:scale-[1.02] transition-all">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                <span class="material-symbols-outlined">storefront</span>
            </div>
            <div class="text-xs text-on-surface-variant font-bold">Listing Produk</div>
            <div class="text-2xl font-black text-on-surface mt-1" id="stat-products">{{ $stats['products'] }}</div>
            <div class="text-[9px] text-on-surface-variant mt-0.5">Katalog Aktif</div>
        </div>

        <!-- Transactions Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-[24px] premium-shadow hover:scale-[1.02] transition-all">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                <span class="material-symbols-outlined">credit_card</span>
            </div>
            <div class="text-xs text-on-surface-variant font-bold">Transaksi</div>
            <div class="text-2xl font-black text-on-surface mt-1" id="stat-transactions">{{ $stats['transactions'] }}</div>
            <div class="text-[9px] text-on-surface-variant mt-0.5">Gerbang Midtrans</div>
        </div>

        <!-- Historical Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-5 rounded-[24px] premium-shadow hover:scale-[1.02] transition-all">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-3">
                <span class="material-symbols-outlined">analytics</span>
            </div>
            <div class="text-xs text-on-surface-variant font-bold">Data BPS</div>
            <div class="text-2xl font-black text-on-surface mt-1" id="stat-history">{{ $stats['historical_records'] }}</div>
            <div class="text-[9px] text-on-surface-variant mt-0.5">Dataset AI Kuartal</div>
        </div>
    </div>

    <!-- Sync Channels Modules -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- MODULE: Weather Integration -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">cloud_sync</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Prakiraan Cuaca Indramayu</h3>
                            <p class="text-xs text-on-surface-variant mt-0.5">Integrasi prakiraan iklim OpenWeatherMap API.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-sky-100 text-sky-700 text-[10px] font-black rounded-lg uppercase tracking-wider">Live Weather</span>
                </div>
                
                <div class="space-y-4 my-6 bg-surface p-6 rounded-3xl border border-outline-variant">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-on-surface-variant">Terakhir Disinkronkan</span>
                        <span class="font-bold text-on-surface" id="sync-time-weather">{{ $sync_times['weather'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-3 border-t border-dashed border-outline-variant">
                        <span class="text-on-surface-variant">Data Cuaca Tersimpan</span>
                        <span class="font-bold text-sky-600">{{ $stats['weather_records'] }} Titik</span>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-3 border-t border-dashed border-outline-variant">
                        <span class="text-on-surface-variant">API Target Endpoint</span>
                        <span class="font-semibold text-xs text-on-surface truncate max-w-[200px]" title="OpenWeather 3.0 OneCall">api.openweathermap.org</span>
                    </div>
                </div>
            </div>

            <button onclick="triggerSync('weather')" class="w-full py-3 bg-sky-50 text-sky-600 hover:bg-sky-100 rounded-2xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]" id="icon-sync-weather">sync</span>
                <span>Sinkronisasi Prakiraan Cuaca</span>
            </button>
        </div>

        <!-- MODULE: Inventory Integration -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">inventory_2</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Inventaris Kebun & Stok Pasar</h3>
                            <p class="text-xs text-on-surface-variant mt-0.5">Penyelarasan stok marketplace dengan laporan panen petani.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-lg uppercase tracking-wider">Internal Stock</span>
                </div>
                
                <div class="space-y-4 my-6 bg-surface p-6 rounded-3xl border border-outline-variant">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-on-surface-variant">Terakhir Disinkronkan</span>
                        <span class="font-bold text-on-surface" id="sync-time-inventory">{{ $sync_times['inventory'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-3 border-t border-dashed border-outline-variant">
                        <span class="text-on-surface-variant">Listing Produk Aktif</span>
                        <span class="font-bold text-emerald-600">{{ $stats['products'] }} Produk</span>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-3 border-t border-dashed border-outline-variant">
                        <span class="text-on-surface-variant">Stok Komparatif</span>
                        <span class="font-bold text-on-surface">Pencocokan Otomatis Lahan</span>
                    </div>
                </div>
            </div>

            <button onclick="triggerSync('inventory')" class="w-full py-3 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-2xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]" id="icon-sync-inventory">sync</span>
                <span>Sinkronisasi Stok Inventaris</span>
            </button>
        </div>

        <!-- MODULE: Payment Integration -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow flex flex-col justify-between mt-8">
            <div>
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">payments</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Transaksi Keuangan Midtrans</h3>
                            <p class="text-xs text-on-surface-variant mt-0.5">Penarikan status pembayaran real-time & kedaluwarsa tagihan.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 text-[10px] font-black rounded-lg uppercase tracking-wider">Gateway Callback</span>
                </div>
                
                <div class="space-y-4 my-6 bg-surface p-6 rounded-3xl border border-outline-variant">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-on-surface-variant">Terakhir Disinkronkan</span>
                        <span class="font-bold text-on-surface" id="sync-time-transaction">{{ $sync_times['transaction'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-3 border-t border-dashed border-outline-variant">
                        <span class="text-on-surface-variant">Total Pesanan Tercatat</span>
                        <span class="font-bold text-indigo-600">{{ $stats['transactions'] }} Pesanan</span>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-3 border-t border-dashed border-outline-variant">
                        <span class="text-on-surface-variant">Mode Lingkungan</span>
                        <span class="font-bold text-on-surface uppercase text-xs">Midtrans Sandbox</span>
                    </div>
                </div>
            </div>

            <button onclick="triggerSync('transaction')" class="w-full py-3 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-2xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]" id="icon-sync-transaction">sync</span>
                <span>Sinkronisasi Status Transaksi</span>
            </button>
        </div>

        <!-- MODULE: AI Prediction & Datasets -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow flex flex-col justify-between mt-8">
            <div>
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">model_training</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Dataset Kuartal BPS & Prediksi AI</h3>
                            <p class="text-xs text-on-surface-variant mt-0.5">Sinkronisasi dataset historis regional untuk melatih model Random Forest.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-purple-100 text-purple-700 text-[10px] font-black rounded-lg uppercase tracking-wider">Predictive ML</span>
                </div>
                
                <div class="space-y-4 my-6 bg-surface p-6 rounded-3xl border border-outline-variant">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-on-surface-variant">Terakhir Disinkronkan</span>
                        <span class="font-bold text-on-surface" id="sync-time-ai">{{ $sync_times['ai'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-3 border-t border-dashed border-outline-variant">
                        <span class="text-on-surface-variant">Data Historis BPS</span>
                        <span class="font-bold text-purple-600">{{ $stats['historical_records'] }} Rekaman</span>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-3 border-t border-dashed border-outline-variant">
                        <span class="text-on-surface-variant">Model File Target</span>
                        <span class="font-semibold text-xs text-on-surface truncate">random_forest_model.pkl</span>
                    </div>
                </div>
            </div>

            <button onclick="triggerSync('ai')" class="w-full py-3 bg-purple-50 text-purple-600 hover:bg-purple-100 rounded-2xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]" id="icon-sync-ai">sync</span>
                <span>Sinkronisasi Dataset & Model AI</span>
            </button>
        </div>

    </div>

    <!-- Script for AJAX Interactions -->
    <script>
        function triggerSync(type) {
            const btn = event.currentTarget;
            const iconId = 'icon-sync-' + type;
            const icon = document.getElementById(iconId);
            
            // Start Loading State
            if (icon) icon.classList.add('animate-spin');
            btn.disabled = true;

            fetch('{{ route("admin.sync-hub.trigger") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => {
                if (!response.ok) throw new Error('Respons jaringan gagal');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update sync time labels
                    if (type === 'all') {
                        document.getElementById('sync-time-weather').innerText = data.sync_times.weather;
                        document.getElementById('sync-time-inventory').innerText = data.sync_times.inventory;
                        document.getElementById('sync-time-transaction').innerText = data.sync_times.transaction;
                        document.getElementById('sync-time-ai').innerText = data.sync_times.ai;
                    } else {
                        const targetLabel = document.getElementById('sync-time-' + type);
                        if (targetLabel && data.sync_times[type]) {
                            targetLabel.innerText = data.sync_times[type];
                        }
                    }

                    // Show success Toast Alert
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                showToast('Terjadi kesalahan jaringan: Gagal menyinkronkan data.', 'error');
                console.error(error);
            })
            .finally(() => {
                // End Loading State
                if (icon) icon.classList.remove('animate-spin');
                btn.disabled = false;
            });
        }

        function showToast(message, type) {
            const container = document.getElementById('toast-container');
            const alertBox = document.getElementById('toast-alert');
            const icon = document.getElementById('toast-icon');
            const text = document.getElementById('toast-message');

            text.innerText = message;
            container.classList.remove('hidden');

            if (type === 'success') {
                alertBox.className = 'p-4 rounded-2xl flex items-center justify-between bg-emerald-50 border border-emerald-200 text-emerald-700 animate-fade-in';
                icon.innerText = 'check_circle';
            } else {
                alertBox.className = 'p-4 rounded-2xl flex items-center justify-between bg-red-50 border border-red-200 text-red-700 animate-fade-in';
                icon.innerText = 'error';
            }

            // Auto dismiss toast after 6 seconds
            setTimeout(() => {
                container.classList.add('hidden');
            }, 6000);
        }
    </script>
</x-admin-layout>
