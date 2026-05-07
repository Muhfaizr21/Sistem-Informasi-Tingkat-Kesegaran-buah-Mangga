<x-admin-layout>
    <x-slot name="title">Manajemen API & Integrasi</x-slot>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-on-surface tracking-tight">API & Integrasi</h1>
            <p class="text-base text-on-surface-variant mt-1">Konfigurasi endpoint eksternal, monitoring traffic, dan sistem backup.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="p-2.5 bg-surface-container-low border border-outline-variant text-on-surface-variant rounded-xl hover:bg-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">help</span>
            </button>
            <button onclick="location.reload()" class="p-2.5 bg-surface-container-low border border-outline-variant text-on-surface-variant rounded-xl hover:bg-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">refresh</span>
            </button>
        </div>
    </div>

    <!-- Alert Success/Error -->
    @if(session('success'))
    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in">
        <span class="material-symbols-outlined">check_circle</span>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Tab Navigation -->
    <div class="flex items-center gap-1 bg-surface-container-low p-1.5 rounded-2xl mb-8 w-fit border border-outline-variant overflow-x-auto max-w-full">
        <a href="{{ route('admin.api-integration', ['tab' => 'weather']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'weather' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">cloud</span>
            API Cuaca
        </a>
        <a href="{{ route('admin.api-integration', ['tab' => 'monitor']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'monitor' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">monitoring</span>
            Monitor Usage
        </a>
        <a href="{{ route('admin.api-integration', ['tab' => 'external']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'external' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">hub</span>
            External Services
        </a>
        <a href="{{ route('admin.api-integration', ['tab' => 'backup']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $tab === 'backup' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">settings_backup_restore</span>
            Backup & Recovery
        </a>
    </div>

    @if($tab === 'weather')
    <!-- WEATHER CONFIG TAB -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
            <h3 class="text-xl font-bold text-on-surface mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary-600">settings</span>
                Konfigurasi OpenWeatherMap
            </h3>
            <form action="{{ route('admin.api-integration.update') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">API Key Management</label>
                    <div class="relative">
                        <input type="password" name="weather_api_key" value="{{ $settings['weather_api_key'] }}" class="w-full bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500">
                        <button type="button" onclick="togglePassword(this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-on-surface-variant uppercase tracking-widest mb-2">Update Endpoint</label>
                    <input type="text" name="weather_endpoint" value="{{ $settings['weather_endpoint'] }}" class="w-full bg-surface border-outline-variant rounded-2xl px-4 py-3 text-sm font-bold focus:ring-primary-500">
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="testConnection('weather')" class="flex-1 px-6 py-3 bg-primary-50 text-primary-600 rounded-2xl text-sm font-bold hover:bg-primary-100 transition-all">
                        Test Connection
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-primary-600 text-white rounded-2xl text-sm font-bold hover:bg-primary-700 transition-all premium-shadow">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow flex flex-col">
            <h3 class="text-xl font-bold text-on-surface mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-600">info</span>
                Status Integrasi
            </h3>
            <div class="flex-1 space-y-4">
                <div class="p-4 bg-emerald-50 rounded-3xl border border-emerald-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-emerald-800">API Status: Connected</div>
                            <div class="text-[10px] text-emerald-600 font-bold">Terakhir diuji: {{ now()->diffForHumans() }}</div>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-emerald-500 text-white text-[10px] font-black rounded-lg uppercase">Online</span>
                </div>
                <div class="p-4 bg-surface rounded-3xl border border-outline-variant flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-on-surface-variant">
                            <span class="material-symbols-outlined">speed</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-on-surface">Average Latency</div>
                            <div class="text-[10px] text-on-surface-variant font-bold">Berdasarkan pengujian terakhir</div>
                        </div>
                    </div>
                    <span class="text-sm font-black text-on-surface" id="latencyDisplay">245ms</span>
                </div>
            </div>
            <div class="mt-6 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-start gap-3">
                <span class="material-symbols-outlined text-amber-600">lightbulb</span>
                <p class="text-[11px] text-amber-800 font-medium leading-relaxed">Pastikan API Key memiliki izin akses ke "One Call API 3.0" agar prakiraan cuaca 14 hari dapat berfungsi.</p>
            </div>
        </div>
    </div>

    @elseif($tab === 'monitor')
    <!-- MONITOR USAGE TAB -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
            <h3 class="font-bold text-on-surface mb-8 flex items-center gap-2 text-xl">
                <span class="material-symbols-outlined text-primary-600">bar_chart</span>
                Hit Rate per Hari
            </h3>
            <div class="h-64 w-full flex items-end gap-3 px-2">
                @foreach($usage['hits'] as $index => $hit)
                    <div class="flex-1 flex flex-col items-center gap-2 group">
                        <div class="relative w-full bg-primary-100 rounded-t-2xl transition-all duration-500 group-hover:bg-primary-600" style="height: {{ ($hit/max($usage['hits']))*100 }}%">
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-on-surface text-white text-[10px] py-2 px-3 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-xl">
                                {{ $hit }} Hits
                            </div>
                        </div>
                        <span class="text-[10px] text-on-surface-variant font-black uppercase">{{ $usage['labels'][$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
            <h3 class="font-bold text-on-surface mb-8 flex items-center gap-2 text-xl">
                <span class="material-symbols-outlined text-red-600">error_medley</span>
                Error Tracking
            </h3>
            <div class="space-y-4">
                @foreach($usage['errors'] as $index => $err)
                <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-surface transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg {{ $err > 5 ? 'bg-red-50 text-red-600' : 'bg-surface text-on-surface-variant' }} flex items-center justify-center text-xs font-bold">
                            {{ $usage['labels'][$index] }}
                        </div>
                        <span class="text-sm font-bold text-on-surface">{{ $err }} Errors</span>
                    </div>
                    @if($err > 0)
                    <span class="w-2 h-2 rounded-full {{ $err > 5 ? 'bg-red-500 animate-pulse' : 'bg-amber-500' }}"></span>
                    @else
                    <span class="material-symbols-outlined text-emerald-500 text-sm">check_circle</span>
                    @endif
                </div>
                @endforeach
            </div>
            <button class="w-full mt-6 py-3 border border-outline-variant rounded-2xl text-xs font-black uppercase tracking-wider text-on-surface-variant hover:bg-surface transition-all">View Full Error Logs</button>
        </div>
    </div>

    @elseif($tab === 'external')
    <!-- EXTERNAL SERVICES TAB -->
    <form action="{{ route('admin.api-integration.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
        @csrf
        <!-- Google Maps -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined">map</span>
            </div>
            <h4 class="font-bold text-on-surface text-lg mb-2">Google Maps SDK</h4>
            <div class="mb-4">
                <label class="block text-[10px] font-black text-on-surface-variant uppercase mb-1">API Key</label>
                <input type="password" name="google_maps_key" value="{{ $settings['google_maps_key'] }}" class="w-full bg-surface border-outline-variant rounded-xl px-3 py-2 text-xs font-bold focus:ring-primary-500">
            </div>
            <button type="submit" class="w-full py-2.5 bg-primary-600 text-white rounded-xl text-xs font-bold premium-shadow hover:bg-primary-700 transition-all">Save Google Config</button>
        </div>

        <!-- Payment Gateway -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined">payments</span>
            </div>
            <h4 class="font-bold text-on-surface text-lg mb-2">Midtrans Gateway</h4>
            <div class="mb-4">
                <label class="block text-[10px] font-black text-on-surface-variant uppercase mb-1">Server Key</label>
                <input type="password" name="midtrans_server_key" value="{{ $settings['midtrans_server_key'] }}" class="w-full bg-surface border-outline-variant rounded-xl px-3 py-2 text-xs font-bold focus:ring-primary-500">
            </div>
            <button type="submit" class="w-full py-2.5 bg-primary-600 text-white rounded-xl text-xs font-bold premium-shadow hover:bg-primary-700 transition-all">Save Payment Config</button>
        </div>
    </form>

    @elseif($tab === 'backup')
    <!-- BACKUP & RECOVERY TAB -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
            <h3 class="text-xl font-bold text-on-surface mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary-600">schedule</span>
                Database Backup Schedule
            </h3>
            <form action="{{ route('admin.api-integration.update') }}" method="POST" class="space-y-6">
                @csrf
                <div class="p-6 bg-surface rounded-3xl border border-outline-variant">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-black text-on-surface-variant uppercase mb-1">Frequency</p>
                            <select name="backup_frequency" class="w-full bg-white border-outline-variant rounded-xl text-xs font-bold px-3 py-2">
                                <option value="6h" {{ $settings['backup_frequency'] == '6h' ? 'selected' : '' }}>Setiap 6 Jam</option>
                                <option value="daily" {{ $settings['backup_frequency'] == 'daily' ? 'selected' : '' }}>Harian (00:00)</option>
                                <option value="weekly" {{ $settings['backup_frequency'] == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            </select>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-on-surface-variant uppercase mb-1">Retention</p>
                            <select name="backup_retention" class="w-full bg-white border-outline-variant rounded-xl text-xs font-bold px-3 py-2">
                                <option value="30" {{ $settings['backup_retention'] == '30' ? 'selected' : '' }}>30 Hari</option>
                                <option value="90" {{ $settings['backup_retention'] == '90' ? 'selected' : '' }}>90 Hari</option>
                                <option value="0" {{ $settings['backup_retention'] == '0' ? 'selected' : '' }}>Selamanya</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full py-3 bg-on-surface text-white rounded-2xl text-xs font-bold hover:opacity-90 transition-all">Update Backup Schedule</button>
            </form>
            
            <form action="{{ route('admin.api-integration.backup') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-primary-600 text-white rounded-3xl font-bold premium-shadow hover:bg-primary-700 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">backup</span>
                    Run Backup Now
                </button>
            </form>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-[40px] p-8 premium-shadow">
            <h3 class="text-xl font-bold text-on-surface mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600">clinical_notes</span>
                Disaster Recovery Plan
            </h3>
            <div class="space-y-4">
                <div class="p-4 bg-red-50 rounded-2xl border border-red-100 flex items-start gap-3">
                    <span class="material-symbols-outlined text-red-600">emergency</span>
                    <div>
                        <p class="text-sm font-bold text-red-800">Critical Data Recovery</p>
                        <p class="text-xs text-red-700/80 mt-1 leading-relaxed">Opsi ini akan me-restore database ke titik backup terakhir.</p>
                        <button type="button" onclick="confirmRecovery()" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase hover:bg-red-700 transition-all">Initialize Recovery</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        function togglePassword(btn) {
            const input = btn.previousElementSibling;
            const icon = btn.querySelector('.material-symbols-outlined');
            if (input.type === "password") {
                input.type = "text";
                icon.innerText = "visibility_off";
            } else {
                input.type = "password";
                icon.innerText = "visibility";
            }
        }

        function testConnection(service) {
            const btn = event.currentTarget;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[18px]">sync</span> Testing...';
            btn.disabled = true;

            fetch('{{ route("admin.api-integration.test") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ service: service })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('latencyDisplay').innerText = data.latency;
                    alert(data.message + '\nLatency: ' + data.latency);
                }
            })
            .catch(err => alert('Gagal menghubungi API.'))
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        function confirmRecovery() {
            if(confirm('PERINGATAN: Recovery akan menimpa data saat ini dengan data backup. Lanjutkan?')) {
                alert('Fungsi recovery memerlukan akses root server. Silakan hubungi DevOps.');
            }
        }
    </script>
</x-admin-layout>
