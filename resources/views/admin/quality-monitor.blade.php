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
                    <div class="flex-1 h-full flex flex-col justify-end items-center gap-2 group">
                        <div class="w-full relative flex flex-col justify-end h-full max-w-[36px]">
                            <!-- Tooltip -->
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-on-surface text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap font-black shadow-lg z-20">
                                {{ number_format($trend->avg_score, 1) }}%
                            </div>
                            <!-- Bar -->
                            <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-t-xl transition-all duration-500 group-hover:from-primary-600 group-hover:to-primary-400 hover:scale-[1.02] shadow-sm" style="height: {{ number_format($trend->avg_score, 2, '.', '') }}%">
                            </div>
                        </div>
                        <span class="text-[10px] text-on-surface-variant font-bold uppercase whitespace-nowrap">{{ date('D', strtotime($trend->date)) }}</span>
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
                        <div class="text-[10px] text-red-600/80">Skor: {{ number_format($anomaly->skor_kesegaran) }}% • Kepercayaan: {{ number_format($anomaly->skor_kepercayaan) }}%</div>
                    </div>
                    <button type="button" onclick="showAnomalyDetail('{{ $anomaly->id }}', '{{ $anomaly->batch_id }}', '{{ $anomaly->jenis_mangga }}', '{{ number_format($anomaly->skor_kesegaran) }}', '{{ number_format($anomaly->skor_kepercayaan) }}', '{{ asset('storage/' . $anomaly->path_foto) }}', '{{ $anomaly->kategori }}', '{{ $anomaly->rekomendasi }}', '{{ $anomaly->created_at->format('d M Y H:i') }}')" class="w-8 h-8 rounded-lg bg-white text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Lihat Detail Anomali">
                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                    </button>
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
                <div class="flex-1 h-full flex flex-col justify-end items-center gap-3 group">
                    <div class="w-full relative flex flex-col justify-end h-full max-w-[48px]">
                        <div id="{{ $loop->last ? 'recent-accuracy-bar' : '' }}" class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-2xl shadow-lg transition-all hover:scale-105 duration-300 relative animate-in slide-in-from-bottom duration-500" style="height: {{ $accuracy }}%">
                            @if($loop->last)
                                <div id="accuracy-tooltip" class="absolute -top-8 left-1/2 -translate-x-1/2 bg-primary-600 text-white text-[10px] py-1 px-2 rounded font-black opacity-100 transition-opacity">{{ $accuracy }}%</div>
                            @endif
                        </div>
                    </div>
                    <span id="{{ $loop->last ? 'recent-accuracy-label' : '' }}" class="text-[10px] font-bold text-on-surface-variant uppercase whitespace-nowrap">Ver.{{ number_format(1.0 + ($loop->index * 0.1), 1) }}</span>
                </div>
                @endforeach
            </div>

            <div class="mt-12 flex flex-col md:flex-row gap-6">
                <button onclick="alert('Sinkronisasi data otomatis aktif! Semua {{ $totalTrainingData }} pindaian terverifikasi dan {{ $totalAnomalies ?? 0 }} data anomali telah diindeks ke dalam set pelatihan AI.')" class="flex-1 p-6 border-2 border-dashed border-primary-200 rounded-3xl flex flex-col items-center text-center gap-3 hover:border-primary-500 hover:bg-primary-50 transition-all group">
                    <div class="w-12 h-12 rounded-2xl bg-primary-100 text-primary-600 flex items-center justify-center group-hover:bg-primary-600 group-hover:text-white transition-all">
                        <span class="material-symbols-outlined">upload_file</span>
                    </div>
                    <div>
                        <div class="font-bold text-on-surface">Update Training Data</div>
                        <div class="text-[10px] text-on-surface-variant uppercase font-bold tracking-wider mt-1">{{ $totalTrainingData }} Verified & {{ $totalAnomalies ?? 0 }} Anomalies Ready</div>
                    </div>
                </button>
                <button id="btn-retrain" onclick="startTraining()" class="flex-1 p-6 border-2 border-dashed border-mango-200 rounded-3xl flex flex-col items-center text-center gap-3 hover:border-mango-500 hover:bg-mango-50 transition-all group">
                    <div class="w-12 h-12 rounded-2xl bg-mango-100 text-mango-600 flex items-center justify-center group-hover:bg-mango-600 group-hover:text-white transition-all animate-pulse">
                        <span class="material-symbols-outlined">model_training</span>
                    </div>
                    <div>
                        <div class="font-bold text-on-surface">Retrain Accuracy Model</div>
                        <div id="last-retrain-time" class="text-[10px] text-on-surface-variant uppercase font-bold tracking-wider mt-1">Last Retrain: 2 Days Ago</div>
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

    <!-- Retraining Progress Modal -->
    <div id="training-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
        <div class="bg-white border border-outline-variant rounded-[40px] p-8 max-w-2xl w-full premium-shadow space-y-6 animate-scale-up">
            <div class="flex justify-between items-start">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-2xl flex items-center justify-center animate-spin-slow">
                        <span class="material-symbols-outlined text-2xl">smart_toy</span>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-on-surface">Pelatihan Model AI (Kalibrasi)</h4>
                        <p class="text-xs text-on-surface-variant mt-0.5" id="training-subtitle">Menghubungkan ke Mesin Neural Network...</p>
                    </div>
                </div>
                <button onclick="closeTrainingModal()" id="btn-close-modal" class="p-2 bg-surface hover:bg-slate-100 rounded-xl text-on-surface-variant hidden">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="space-y-2">
                <div class="flex justify-between text-xs font-bold text-on-surface-variant uppercase">
                    <span id="training-status">Memproses Epoch...</span>
                    <span id="training-percentage">0%</span>
                </div>
                <div class="h-4 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div id="training-bar" class="h-full bg-gradient-to-r from-primary-500 to-emerald-400 rounded-full transition-all duration-300 w-0"></div>
                </div>
            </div>

            <!-- Terminal Logs -->
            <div class="bg-slate-950 text-emerald-400 font-mono text-[11px] p-6 rounded-3xl border border-slate-900 h-64 overflow-y-auto custom-scrollbar flex flex-col gap-1.5 shadow-inner">
                <div id="terminal-logs" class="flex-1 flex flex-col justify-end text-left">
                    <!-- Dynamic logs here -->
                </div>
            </div>
            
            <div class="flex justify-end gap-3" id="training-footer">
                <!-- Close Button -->
            </div>
        </div>
    </div>

    <!-- Styles for animation -->
    <style>
        .animate-spin-slow {
            animation: spin 8s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>

    <!-- Javascript retrain AI controller -->
    <script>
        let trainingActive = false;

        async function startTraining() {
            if (trainingActive) return;
            trainingActive = true;

            const modal = document.getElementById('training-modal');
            const terminal = document.getElementById('terminal-logs');
            const bar = document.getElementById('training-bar');
            const percentage = document.getElementById('training-percentage');
            const status = document.getElementById('training-status');
            const subtitle = document.getElementById('training-subtitle');
            const footer = document.getElementById('training-footer');
            const closeBtn = document.getElementById('btn-close-modal');

            // Reset UI
            modal.classList.remove('hidden');
            terminal.innerHTML = '';
            bar.style.width = '0%';
            percentage.innerText = '0%';
            status.innerText = 'Menghubungkan ke Mesin Neural...';
            subtitle.innerText = 'Mempersiapkan lingkungan pelatihan model';
            footer.innerHTML = '';
            closeBtn.classList.add('hidden');

            try {
                const response = await fetch("{{ route('admin.quality-monitor.train') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();
                if (response.status !== 200 || result.status !== 'success') {
                    throw new Error(result.message || 'Gagal memulai training.');
                }

                // Simulate Live Logs Stream
                let logIndex = 0;
                const logs = result.logs;
                const totalLogs = logs.length;

                const interval = setInterval(() => {
                    if (logIndex < totalLogs) {
                        const line = document.createElement('div');
                        line.className = 'animate-fade-in py-0.5 leading-relaxed';
                        line.innerText = logs[logIndex];
                        
                        // Style special lines
                        if (logs[logIndex].includes('[SUCCESS]')) {
                            line.className += ' text-emerald-300 font-bold';
                        } else if (logs[logIndex].includes('[EPOCH')) {
                            line.className += ' text-sky-300';
                        }
                        
                        terminal.appendChild(line);
                        
                        // Scroll to bottom
                        terminal.parentElement.scrollTop = terminal.parentElement.scrollHeight;

                        // Update progress bar dynamically
                        const progressPercent = Math.round(((logIndex + 1) / totalLogs) * 100);
                        bar.style.width = `${progressPercent}%`;
                        percentage.innerText = `${progressPercent}%`;

                        if (logs[logIndex].includes('[EPOCH')) {
                            const match = logs[logIndex].match(/EPOCH (\d+)\/10/);
                            if (match) {
                                status.innerText = `Menjalankan Epoch ${match[1]}/10...`;
                            }
                        } else if (logs[logIndex].includes('[SUCCESS]')) {
                            status.innerText = 'Pelatihan Selesai!';
                            subtitle.innerText = 'Model terkalibrasi siap digunakan.';
                        }

                        logIndex++;
                    } else {
                        clearInterval(interval);
                        trainingActive = false;

                        // Update page stats dynamically
                        document.getElementById('last-retrain-time').innerText = 'Last Retrain: Baru saja';
                        
                        const accuracyBar = document.getElementById('recent-accuracy-bar');
                        if (accuracyBar) {
                            accuracyBar.style.height = `${result.new_accuracy}%`;
                        }
                        const accuracyTooltip = document.getElementById('accuracy-tooltip');
                        if (accuracyTooltip) {
                            accuracyTooltip.innerText = `${result.new_accuracy}%`;
                        }

                        const accuracyLabel = document.getElementById('recent-accuracy-label');
                        if (accuracyLabel) {
                            accuracyLabel.innerText = 'Ver.1.7 (NEW)';
                            accuracyLabel.classList.add('text-primary-600', 'font-black');
                        }

                        // Add action close button
                        closeBtn.classList.remove('hidden');
                        footer.innerHTML = `
                            <button onclick="closeTrainingModal()" class="px-8 py-4 bg-primary-600 text-white font-black rounded-2xl hover:bg-primary-700 transition-all uppercase tracking-widest text-xs shadow-lg shadow-primary-500/20">
                                Selesai & Terapkan
                            </button>
                        `;
                    }
                }, 600);

            } catch (err) {
                console.error(err);
                const errorLine = document.createElement('div');
                errorLine.className = 'text-red-500 font-bold py-1';
                errorLine.innerText = `[ERROR] Gagal: ${err.message}`;
                terminal.appendChild(errorLine);
                status.innerText = 'Pelatihan Gagal';
                subtitle.innerText = 'Terjadi kesalahan sistem.';
                closeBtn.classList.remove('hidden');
                trainingActive = false;
            }
        }

        function closeTrainingModal() {
            if (trainingActive) return;
            document.getElementById('training-modal').classList.add('hidden');
        }

        function showAnomalyDetail(id, batchId, jenis, skorKesegaran, skorKepercayaan, pathFoto, kategori, rekomendasi, tanggal) {
            document.getElementById('anomaly-batch-id').innerText = `#${batchId}`;
            document.getElementById('anomaly-img').src = pathFoto;
            document.getElementById('anomaly-score').innerText = `${skorKesegaran}%`;
            document.getElementById('anomaly-confidence').innerText = `${skorKepercayaan}%`;
            document.getElementById('anomaly-variety').innerText = jenis;
            document.getElementById('anomaly-time').innerText = tanggal;

            // Set dynamic action route for toggling anomaly
            const form = document.getElementById('anomaly-toggle-form');
            form.action = `/admin/quality-monitor/${id}/anomaly`;

            document.getElementById('anomaly-modal').classList.remove('hidden');
        }

        function closeAnomalyModal() {
            document.getElementById('anomaly-modal').classList.add('hidden');
        }
    </script>

    <!-- Anomaly Detail Modal -->
    <div id="anomaly-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
        <div class="bg-white border border-outline-variant rounded-[32px] p-6 md:p-8 max-w-md w-full premium-shadow space-y-5 animate-scale-up max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex justify-between items-start">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">warning</span>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-on-surface">Detail Anomali Kualitas</h4>
                        <p class="text-xs text-on-surface-variant mt-0.5" id="anomaly-batch-id">#BATCH-XXXXXX</p>
                    </div>
                </div>
                <button onclick="closeAnomalyModal()" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-xl text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Image -->
            <div class="w-full h-48 md:h-56 rounded-3xl overflow-hidden border border-slate-100 shadow-inner bg-slate-50 relative">
                <img id="anomaly-img" src="" class="w-full h-full object-cover" alt="Foto Anomali">
            </div>

            <!-- Parameters Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-red-50 p-4 rounded-2xl border border-red-100">
                    <p class="text-[8px] font-black text-red-600 uppercase tracking-widest mb-1">Skor Kesegaran</p>
                    <p class="text-xl font-black text-red-700" id="anomaly-score">--%</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Kepercayaan AI</p>
                    <p class="text-xl font-black text-slate-900" id="anomaly-confidence">--%</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Varietas</p>
                    <p class="text-xs font-black text-slate-900 truncate text-left" id="anomaly-variety">--</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Waktu Scan</p>
                    <p class="text-xs font-black text-slate-900 truncate text-left" id="anomaly-time">--</p>
                </div>
            </div>

            <!-- Warning Notice -->
            <div class="p-5 bg-amber-50 text-amber-800 rounded-3xl border border-amber-200 text-xs leading-relaxed text-left">
                <div class="font-bold mb-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">info</span>
                    Catatan Kalibrasi
                </div>
                Data pindaian ini ditandai sebagai anomali karena skor kepercayaan model yang rendah atau ditolak admin. Data ini akan dimasukkan secara khusus ke dalam set retraining model AI.
            </div>

            <div class="flex justify-between items-center gap-3 pt-4 border-t border-slate-100">
                <form id="anomaly-toggle-form" action="" method="POST" class="w-full">
                    @csrf
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeAnomalyModal()" class="px-6 py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition-all text-xs uppercase tracking-widest">
                            Tutup
                        </button>
                        <button type="submit" class="px-6 py-4 bg-red-50 text-red-600 font-black rounded-2xl hover:bg-red-600 hover:text-white transition-all text-xs uppercase tracking-widest">
                            Bukan Anomali
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
