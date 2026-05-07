<x-admin-layout>
    <x-slot name="title">Monitor Kualitas</x-slot>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-on-surface tracking-tight">Quality Control Center</h1>
            <p class="text-base text-on-surface-variant mt-1">Manajemen standar kualitas, verifikasi AI, dan laporan performa.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-primary-600 text-white rounded-xl text-sm font-bold flex items-center gap-2 premium-shadow hover:bg-primary-700 transition-all">
                <span class="material-symbols-outlined text-[18px]">export_notes</span>
                Export Report
            </button>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex items-center gap-1 bg-surface-container-low p-1.5 rounded-2xl mb-8 w-fit border border-outline-variant">
        <a href="{{ route('admin.quality-monitor', ['tab' => 'review']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ $tab === 'review' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">monitoring</span>
            Review Scan
        </a>
        <a href="{{ route('admin.quality-monitor', ['tab' => 'verification']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ $tab === 'verification' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">verified</span>
            Verifikasi Data
        </a>
        <a href="{{ route('admin.quality-monitor', ['tab' => 'calibration']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ $tab === 'calibration' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">precision_manufacturing</span>
            Kalibrasi AI
        </a>
        <a href="{{ route('admin.quality-monitor', ['tab' => 'report']) }}" 
           class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ $tab === 'report' ? 'bg-white text-primary-600 shadow-sm' : 'text-on-surface-variant hover:bg-white/50' }}">
            <span class="material-symbols-outlined text-[18px]">description</span>
            QC Report
        </a>
    </div>

    @if($tab === 'review')
    <!-- REVIEW TAB CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Trend Chart Placeholder -->
        <div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-3xl p-6 premium-shadow">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-600">trending_up</span>
                    Analisis Trend Kualitas (7 Hari Terakhir)
                </h3>
                <select class="bg-surface border-none text-xs font-bold rounded-lg focus:ring-primary-500">
                    <option>Skor Kesegaran</option>
                    <option>Volume Pindaian</option>
                </select>
            </div>
            <div class="h-64 w-full flex items-end gap-3 px-2">
                @foreach($trends as $trend)
                    <div class="flex-1 flex flex-col items-center gap-2 group">
                        <div class="relative w-full bg-primary-50 rounded-t-xl transition-all duration-500 group-hover:bg-primary-100" style="height: {{ $trend->avg_score }}%">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-on-surface text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ number_format($trend->avg_score, 1) }}
                            </div>
                        </div>
                        <span class="text-[10px] text-on-surface-variant font-bold uppercase">{{ date('D', strtotime($trend->date)) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Anomaly Detection -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-3xl p-6 premium-shadow">
            <h3 class="font-bold text-on-surface mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600">warning</span>
                Deteksi Anomali
            </h3>
            <div class="flex flex-col gap-4">
                @forelse($anomalies as $anomaly)
                <div class="p-3 bg-red-50 rounded-2xl border border-red-100 flex items-center gap-3 group hover:bg-red-100 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-white overflow-hidden flex-shrink-0 border border-red-200">
                        <img src="{{ asset('storage/' . $anomaly->path_foto) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-bold text-red-700">#{{ $anomaly->batch_id }}</div>
                        <div class="text-[10px] text-red-600/80">Skor: {{ $anomaly->skor_kesegaran }}% • Kepercayaan: {{ $anomaly->skor_kepercayaan }}%</div>
                    </div>
                    <form action="{{ route('admin.quality-monitor.anomaly', $anomaly->id) }}" method="POST">
                        @csrf
                        <button class="w-8 h-8 rounded-lg bg-white text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                        </button>
                    </form>
                </div>
                @empty
                <div class="py-12 text-center text-on-surface-variant text-sm">
                    Tidak ada anomali terdeteksi.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Scans Table (Review) -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-3xl overflow-hidden premium-shadow">
        <div class="p-6 border-b border-outline-variant flex justify-between items-center">
            <h3 class="text-lg font-bold">Riwayat Scan Semua Petani</h3>
            <div class="flex items-center gap-2">
                <span class="text-xs text-on-surface-variant font-medium">Filter Petani:</span>
                <select class="bg-surface border-none text-xs font-bold rounded-xl focus:ring-primary-500">
                    <option>Semua Petani</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-surface-container-low text-[10px] font-bold text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">
                        <th class="px-6 py-4">Produk & Batch</th>
                        <th class="px-6 py-4 text-center">Tingkat Kesegaran</th>
                        <th class="px-6 py-4">Pemilik / Petani</th>
                        <th class="px-6 py-4">Anomali</th>
                        <th class="px-6 py-4 text-right">Status AI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @foreach($scans as $scan)
                    <tr class="hover:bg-primary-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-high overflow-hidden border border-outline-variant">
                                    <img src="{{ asset('storage/' . $scan->path_foto) }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="font-mono text-[10px] font-bold text-primary-600 uppercase">#{{ $scan->batch_id }}</div>
                                    <div class="text-sm font-bold text-on-surface">{{ $scan->jenis_mangga }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-bold text-on-surface">{{ number_format($scan->skor_kesegaran) }}%</span>
                                <div class="w-16 h-1 bg-surface-container-high rounded-full overflow-hidden">
                                    <div class="h-full bg-primary-500" style="width: {{ $scan->skor_kesegaran }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center text-[10px] font-bold text-primary-700">
                                    {{ substr($scan->petani->user->nama ?? 'U', 0, 1) }}
                                </div>
                                <span class="text-sm">{{ $scan->petani->user->nama ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($scan->is_anomaly)
                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">ANOMALI</span>
                            @else
                                <span class="text-on-surface-variant text-[10px]">Normal</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="bg-primary-100 text-primary-700 text-[10px] font-bold px-3 py-1 rounded-full">
                                {{ $scan->rekomendasi }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-outline-variant">
            {{ $scans->links() }}
        </div>
    </div>

    @elseif($tab === 'verification')
    <!-- VERIFICATION TAB CONTENT -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($pendingScans as $scan)
        <div class="bg-surface-container-lowest border border-outline-variant rounded-3xl p-6 premium-shadow">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden border border-outline-variant">
                        <img src="{{ asset('storage/' . $scan->path_foto) }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="text-xs font-bold text-primary-600 uppercase">#{{ $scan->batch_id }}</div>
                        <h4 class="text-lg font-bold">{{ $scan->jenis_mangga }}</h4>
                        <p class="text-xs text-on-surface-variant">{{ $scan->petani->user->nama }} • {{ $scan->created_at->format('d M H:i') }}</p>
                    </div>
                </div>
                <div class="bg-mango-100 text-mango-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase">Perlu Verifikasi</div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="p-4 bg-primary-50 rounded-2xl">
                    <div class="text-[10px] font-bold text-primary-600 uppercase mb-2">AI Analysis</div>
                    <div class="text-2xl font-bold text-primary-700">{{ number_format($scan->skor_kesegaran) }}%</div>
                    <div class="text-[10px] text-primary-600/70">Confidence: {{ number_format($scan->skor_kepercayaan) }}%</div>
                </div>
                <div class="p-4 bg-surface rounded-2xl border border-outline-variant">
                    <div class="text-[10px] font-bold text-on-surface-variant uppercase mb-2">Manual Check</div>
                    <div class="text-xs text-on-surface-variant">Bandingkan visual foto dengan standar kualitas.</div>
                </div>
            </div>

            <form action="{{ route('admin.quality-monitor.verify', $scan->id) }}" method="POST">
                @csrf
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant mb-1.5 block uppercase">Skor Manual (%)</label>
                        <input type="number" name="skor_manual" placeholder="Masukkan skor pembanding..." 
                               class="w-full px-4 py-2.5 bg-surface border-outline-variant rounded-xl text-sm focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant mb-1.5 block uppercase">Catatan Verifikasi</label>
                        <textarea name="catatan" placeholder="Catatan untuk petani..." 
                                  class="w-full px-4 py-2.5 bg-surface border-outline-variant rounded-xl text-sm focus:ring-2 focus:ring-primary-500 h-20"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="submit" name="status" value="rejected" class="px-4 py-2.5 border border-red-200 text-red-600 rounded-xl text-sm font-bold hover:bg-red-50 transition-all">
                            Reject Hasil
                        </button>
                        <button type="submit" name="status" value="verified" class="px-4 py-2.5 bg-primary-600 text-white rounded-xl text-sm font-bold hover:bg-primary-700 transition-all premium-shadow">
                            Approve Hasil
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @empty
        <div class="col-span-2 py-20 text-center">
            <div class="w-16 h-16 bg-surface-container-high rounded-full flex items-center justify-center mx-auto mb-4 text-on-surface-variant opacity-50">
                <span class="material-symbols-outlined text-[32px]">check_circle</span>
            </div>
            <h4 class="text-on-surface font-bold">Semua Data Terverifikasi</h4>
            <p class="text-on-surface-variant text-sm">Tidak ada antrean verifikasi manual saat ini.</p>
        </div>
        @endforelse
    </div>

    @elseif($tab === 'calibration')
    <!-- CALIBRATION TAB CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-3xl p-8 premium-shadow">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-xl font-bold text-on-surface">Model Accuracy Calibration</h3>
                    <p class="text-sm text-on-surface-variant mt-1">Pantau akurasi AI terhadap verifikasi manual admin.</p>
                </div>
                <div class="px-4 py-2 bg-green-50 text-green-700 rounded-xl text-xs font-bold border border-green-100">
                    Sistem Optimal
                </div>
            </div>

            <!-- Accuracy Chart Mock -->
            <div class="h-64 flex items-end justify-between gap-6 px-4">
                @foreach($accuracyTrend as $accuracy)
                <div class="flex-1 flex flex-col items-center gap-3">
                    <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-2xl shadow-lg transition-all hover:scale-105 duration-300" style="height: {{ $accuracy }}%"></div>
                    <span class="text-[10px] font-bold text-on-surface-variant uppercase">Ver.{{ 1.0 + ($loop->index * 0.1) }}</span>
                </div>
                @endforeach
            </div>

            <div class="mt-12 flex flex-col md:flex-row gap-6">
                <button class="flex-1 p-6 border-2 border-dashed border-primary-200 rounded-3xl flex flex-col items-center text-center gap-3 hover:border-primary-500 hover:bg-primary-50 transition-all group">
                    <div class="w-12 h-12 rounded-2xl bg-primary-100 text-primary-600 flex items-center justify-center group-hover:bg-primary-600 group-hover:text-white transition-all">
                        <span class="material-symbols-outlined">upload_file</span>
                    </div>
                    <div>
                        <div class="font-bold text-on-surface">Update Training Data</div>
                        <div class="text-[10px] text-on-surface-variant uppercase font-bold tracking-wider mt-1">{{ $totalTrainingData }} Verified Scans Ready</div>
                    </div>
                </button>
                <button class="flex-1 p-6 border-2 border-dashed border-mango-200 rounded-3xl flex flex-col items-center text-center gap-3 hover:border-mango-500 hover:bg-mango-50 transition-all group">
                    <div class="w-12 h-12 rounded-2xl bg-mango-100 text-mango-600 flex items-center justify-center group-hover:bg-mango-600 group-hover:text-white transition-all">
                        <span class="material-symbols-outlined">model_training</span>
                    </div>
                    <div>
                        <div class="font-bold text-on-surface">Retrain accuracy Model</div>
                        <div class="text-[10px] text-on-surface-variant uppercase font-bold tracking-wider mt-1">Last Retrain: 2 Days Ago</div>
                    </div>
                </button>
            </div>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-3xl p-6 premium-shadow">
            <h3 class="font-bold text-on-surface mb-6">AI Health Metrics</h3>
            <div class="flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">bolt</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-on-surface">Latency</div>
                            <div class="text-[10px] text-on-surface-variant uppercase font-bold">Inference Speed</div>
                        </div>
                    </div>
                    <div class="text-lg font-bold text-on-surface">142ms</div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">error</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-on-surface">False Positive</div>
                            <div class="text-[10px] text-on-surface-variant uppercase font-bold">Error Margin</div>
                        </div>
                    </div>
                    <div class="text-lg font-bold text-on-surface">1.2%</div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">storage</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-on-surface">Data Points</div>
                            <div class="text-[10px] text-on-surface-variant uppercase font-bold">Historical Data</div>
                        </div>
                    </div>
                    <div class="text-lg font-bold text-on-surface">4.2k</div>
                </div>
            </div>
        </div>
    </div>

    @elseif($tab === 'report')
    <!-- REPORT TAB CONTENT -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Quality per Petani -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-3xl overflow-hidden premium-shadow">
            <div class="p-6 border-b border-outline-variant">
                <h3 class="font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-600">group</span>
                    Tingkat Kesegaran per Petani
                </h3>
            </div>
            <div class="p-6">
                <div class="flex flex-col gap-6">
                    @foreach($perPetani as $petani)
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-on-surface">{{ $petani->nama }}</span>
                                <span class="text-[10px] text-on-surface-variant bg-surface border border-outline-variant px-2 py-0.5 rounded-full font-bold uppercase">{{ $petani->total }} Scans</span>
                            </div>
                            <span class="text-sm font-bold text-primary-600">{{ number_format($petani->avg_score, 1) }}%</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                            <div class="bg-primary-500 h-full transition-all duration-1000" style="width: {{ $petani->avg_score }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quality per Jenis -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-3xl overflow-hidden premium-shadow">
            <div class="p-6 border-b border-outline-variant">
                <h3 class="font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-mango-600">category</span>
                    Tingkat Kesegaran per Jenis Mangga
                </h3>
            </div>
            <div class="p-6">
                <div class="flex flex-col gap-6">
                    @foreach($perJenis as $jenis)
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-on-surface">{{ $jenis->jenis_mangga }}</span>
                                <span class="text-[10px] text-on-surface-variant bg-surface border border-outline-variant px-2 py-0.5 rounded-full font-bold uppercase">{{ $jenis->total }} Scans</span>
                            </div>
                            <span class="text-sm font-bold text-mango-600">{{ number_format($jenis->avg_score, 1) }}%</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                            <div class="bg-mango-500 h-full transition-all duration-1000" style="width: {{ $jenis->avg_score }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</x-admin-layout>
