<x-petani-layout>
    <x-slot name="title">Rekomendasi AI & Prakiraan Cuaca</x-slot>

    <!-- Header Section (The General's War Room) -->
    <div class="mb-12 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-8">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="px-4 py-1.5 bg-primary-500/10 text-primary-500 text-[10px] font-black rounded-full uppercase tracking-[0.2em] border border-primary-500/20 shadow-sm">AI Recommendation Engine</span>
                <span class="px-4 py-1.5 bg-slate-900/5 text-slate-900 text-[10px] font-black rounded-full uppercase tracking-[0.2em] border border-slate-900/10 shadow-sm">Territory: {{ $lahanUtama->nama_lahan ?? 'Pusat Riset' }}</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tight">Strategi Pertanian AI ⚔️</h1>
            
            <!-- Land Selector (Alexander's Map Selection) -->
            <div class="flex flex-wrap items-center gap-3 mt-4">
                @foreach($lahan as $l)
                <a href="{{ route('petani.rekomendasi', ['lahan_id' => $l->id]) }}" 
                   class="flex items-center gap-3 px-5 py-2.5 rounded-2xl border transition-all duration-500 {{ $lahanUtama->id == $l->id ? 'bg-slate-900 text-white border-slate-900 shadow-xl shadow-slate-900/20 scale-105' : 'bg-white text-slate-500 border-slate-100 hover:border-primary-500 hover:text-primary-500' }}">
                    <span class="material-symbols-outlined text-sm {{ $lahanUtama->id == $l->id ? 'text-primary-500' : '' }}">location_on</span>
                    <span class="text-[11px] font-black uppercase tracking-widest">{{ $l->nama_lahan }}</span>
                    @if($lahanUtama->id == $l->id)
                    <div class="w-1.5 h-1.5 bg-primary-500 rounded-full animate-pulse"></div>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:flex items-center gap-4 w-full xl:w-auto">
            <div class="flex-1 md:flex-none flex items-center gap-4 p-5 bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 group">
                <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20 group-hover:rotate-12 transition-transform duration-500">
                    <span class="material-symbols-outlined text-2xl">thermostat</span>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Suhu Wilayah</p>
                    <p class="text-sm font-black text-slate-900 leading-tight">{{ $forecast->first()->suhu_max ?? '28' }}°C</p>
                </div>
            </div>
            <div class="flex-1 md:flex-none flex items-center gap-4 p-5 bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40 group">
                <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-500/20 group-hover:rotate-12 transition-transform duration-500">
                    <span class="material-symbols-outlined text-2xl">humidity_mid</span>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Kelembaban</p>
                    <p class="text-sm font-black text-slate-900 leading-tight">{{ $forecast->first()->kelembaban ?? '75' }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Bar (Historical Context) -->
    <div class="mb-12 grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Produksi Wilayah (2024)</p>
            <p class="text-xl font-black text-slate-900">{{ number_format($lastYearData->total_produksi_kuintal ?? 0) }} <span class="text-[10px] text-slate-400 uppercase font-bold">Kuintal</span></p>
        </div>
        <div class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Luas Lahan (2024)</p>
            <p class="text-xl font-black text-slate-900">{{ number_format($lastYearData->total_lahan_hektar ?? 0) }} <span class="text-[10px] text-slate-400 uppercase font-bold">Ha</span></p>
        </div>
        <div class="p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Sumber Data</p>
            <p class="text-xl font-black text-primary-500 uppercase tracking-tight">Dataset CSV</p>
        </div>
        <div class="p-6 bg-slate-900 rounded-[2rem] border border-slate-800 shadow-xl shadow-slate-900/10 flex items-center justify-between">
            <div>
                <p class="text-white/40 text-[9px] font-black uppercase tracking-widest mb-1">AI Recommendation</p>
                <p class="text-sm font-black text-white">Optimal Growth</p>
            </div>
            <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center text-white">
                <span class="material-symbols-outlined text-xl">auto_awesome</span>
            </div>
        </div>
    </div>

    <!-- Alert System -->
    @if(count($extremeWeather) > 0)
    <div class="mb-12 space-y-6">
        @foreach($extremeWeather as $alert)
        @php $isHistorical = str_contains($alert['date'] ?? '', 'Historis'); @endphp
        <div class="p-8 {{ $isHistorical ? 'bg-amber-50 border-amber-100' : 'bg-red-50 border-red-100' }} rounded-[3rem] flex items-center gap-8 animate-in slide-in-from-top duration-700 relative overflow-hidden group">
            <div class="absolute inset-0 {{ $isHistorical ? 'bg-gradient-to-r from-amber-500/5' : 'bg-gradient-to-r from-red-500/5' }} to-transparent"></div>
            <div class="w-20 h-20 {{ $isHistorical ? 'bg-amber-500 shadow-amber-500/30' : 'bg-red-500 shadow-red-500/30' }} rounded-[2rem] flex items-center justify-center text-white shrink-0 shadow-2xl group-hover:scale-110 transition-transform duration-500 relative z-10">
                <span class="material-symbols-outlined text-4xl {{ !$isHistorical ? 'animate-pulse' : '' }}">{{ $isHistorical ? 'history' : 'warning' }}</span>
            </div>
            <div class="relative z-10">
                <p class="text-[11px] font-black {{ $isHistorical ? 'text-amber-500' : 'text-red-500' }} uppercase tracking-[0.2em] mb-2 flex items-center gap-2">
                    @if(!$isHistorical) <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span> @endif
                    {{ $isHistorical ? 'Historical Context' : 'Critical Weather Alert' }} ({{ $alert['date'] }})
                </p>
                <h4 class="text-2xl font-extrabold {{ $isHistorical ? 'text-amber-900' : 'text-red-900' }} leading-tight mb-2 tracking-tight">{{ $alert['message'] }}</h4>
                <p class="text-sm {{ $isHistorical ? 'text-amber-700/80' : 'text-red-700/80' }} font-medium leading-relaxed max-w-2xl italic">"{{ $alert['reason'] ?? 'Tim AI merekomendasikan penutupan pelindung buah atau percepatan panen jika tingkat kematangan sudah mencapai 75%.' }}"</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Main Analysis Column -->
        <div class="lg:col-span-8 space-y-10">
            
            <!-- Recommendations Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Harvest Advice -->
                <div class="bg-white p-10 rounded-[4rem] border border-slate-100 shadow-sm relative overflow-hidden group h-full">
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-14 h-14 bg-primary-500 rounded-[1.5rem] flex items-center justify-center text-white shadow-xl shadow-primary-500/20">
                                <span class="material-symbols-outlined text-3xl">inventory</span>
                            </div>
                            <span class="text-[10px] font-black text-primary-600 bg-primary-500/10 px-4 py-2 rounded-full uppercase tracking-widest border border-primary-500/20">Harvest Window</span>
                        </div>
                        <h3 class="text-2xl font-extrabold text-slate-900 mb-4 tracking-tight">Optimal Harvest</h3>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8 italic">Berdasarkan kelembaban tanah dan paparan UV, waktu terbaik untuk panen:</p>
                        
                        <div class="space-y-4 flex-1">
                            @forelse(array_slice($harvestAlerts, 0, 3) as $alert)
                            <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 group-hover:bg-primary-500/5 group-hover:border-primary-500/20 transition-all duration-300">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-primary-500 shadow-sm">
                                        <span class="material-symbols-outlined text-xl">event_available</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ Carbon\Carbon::parse($alert['date'])->format('d M Y') }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $alert['message'] }}</p>
                                    </div>
                                </div>
                                <p class="text-[10px] text-slate-500 font-bold leading-relaxed mb-1">{{ $alert['reason'] }}</p>
                                <p class="text-[10px] text-primary-600 font-black uppercase tracking-tight flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">auto_fix</span>
                                    {{ $alert['action'] }}
                                </p>
                            </div>
                            @empty
                            <div class="p-8 text-center bg-slate-50 rounded-[2.5rem] border border-dashed border-slate-200">
                                <span class="material-symbols-outlined text-slate-200 text-4xl mb-3">cloud_off</span>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">No optimal window detected</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -right-12 -bottom-12 text-[220px] text-slate-50 rotate-12 group-hover:text-primary-500/5 transition-colors duration-700">agriculture</span>
                </div>

                <!-- Planting Advice -->
                <div class="bg-white p-10 rounded-[4rem] border border-slate-100 shadow-sm relative overflow-hidden group h-full">
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-14 h-14 bg-blue-500 rounded-[1.5rem] flex items-center justify-center text-white shadow-xl shadow-blue-500/20">
                                <span class="material-symbols-outlined text-3xl">potted_plant</span>
                            </div>
                            <span class="text-[10px] font-black text-blue-600 bg-blue-500/10 px-4 py-2 rounded-full uppercase tracking-widest border border-blue-500/20">Growth Analysis</span>
                        </div>
                        <h3 class="text-2xl font-extrabold text-slate-900 mb-4 tracking-tight">Planting Strategic</h3>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8 italic">Peluang keberhasilan penanaman berdasarkan kelembaban tanah 14 hari ke depan:</p>
                        
                        <div class="space-y-4 flex-1">
                            @forelse(array_slice($plantingAlerts, 0, 3) as $alert)
                            <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 group-hover:bg-blue-500/5 group-hover:border-blue-500/20 transition-all duration-300">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-500 shadow-sm">
                                        <span class="material-symbols-outlined text-xl">temp_preferences_eco</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 tracking-tight">{{ Carbon\Carbon::parse($alert['date'])->format('d M Y') }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $alert['message'] }}</p>
                                    </div>
                                </div>
                                <p class="text-[10px] text-slate-500 font-bold leading-relaxed mb-1">{{ $alert['reason'] }}</p>
                                <p class="text-[10px] text-blue-600 font-black uppercase tracking-tight flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">water_drop</span>
                                    {{ $alert['action'] }}
                                </p>
                            </div>
                            @empty
                            <div class="space-y-8">
                                <div class="p-6 bg-blue-50/50 rounded-3xl border border-blue-100">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-xs font-black text-slate-700 uppercase tracking-widest">{{ $varietyStrategic['name'] ?? 'Varietas Unggul' }}</span>
                                        <span class="text-[10px] font-black text-blue-600 bg-white px-3 py-1 rounded-full border border-blue-100 shadow-sm">{{ $varietyStrategic['success_rate'] ?? '90' }}% SUCCESS RATE</span>
                                    </div>
                                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden mb-3">
                                        <div class="bg-blue-500 h-full rounded-full" style="width: {{ $varietyStrategic['success_rate'] ?? '90' }}%"></div>
                                    </div>
                                    <p class="text-[10px] text-blue-700/70 font-bold italic">"{{ $varietyStrategic['advice'] ?? 'Kondisi tanah saat ini sangat mendukung pertumbuhan vegetatif.' }}"</p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Soil Temp</p>
                                        <p class="text-sm font-black text-slate-900">{{ $agroData['soil']['t10'] ?? '28.5' }}°C</p>
                                    </div>
                                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Moisture</p>
                                        <p class="text-sm font-black text-slate-900">{{ round(($agroData['soil']['moisture'] ?? 0.32) * 100) }}%</p>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weather Forecast Grid -->
            <div class="bg-white p-10 rounded-[4rem] border border-slate-100 shadow-sm overflow-hidden relative group">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Prakiraan 14 Hari Kedepan</h2>
                            <div class="flex items-center gap-2 px-3 py-1 bg-slate-900 text-white rounded-full">
                                <span class="material-symbols-outlined text-[12px]">location_on</span>
                                <span class="text-[9px] font-black uppercase tracking-widest">{{ $lahanUtama->nama_lahan ?? 'Territory Alpha' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="px-2 py-0.5 {{ $synopticReport['alert_class'] }} text-white text-[8px] font-black rounded-md uppercase tracking-widest">{{ $synopticReport['status'] }}</span>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Trend: {{ $synopticReport['trend'] }}</p>
                        </div>
                        <p class="text-[10px] text-slate-500 font-medium mt-2 max-w-xl italic">"{{ $synopticReport['summary'] }}"</p>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100 shrink-0">
                        <span class="w-2 h-2 bg-primary-500 rounded-full animate-pulse"></span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">LIVE UPDATING</span>
                    </div>
                </div>
                <div class="flex gap-6 overflow-x-auto pb-8 custom-scrollbar scroll-smooth">
                    @foreach($forecast as $index => $day)
                    <div onclick="openHourly({{ $index }})"
                         class="min-w-[140px] p-8 bg-slate-50 rounded-[3rem] text-center border-2 border-transparent hover:border-primary-500 hover:bg-white hover:shadow-2xl transition-all duration-500 group/card cursor-pointer active:scale-95">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 group-hover/card:text-primary-500">{{ Carbon\Carbon::parse($day->tanggal_prakiraan)->format('D, d M') }}</p>
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm group-hover/card:shadow-lg transition-all">
                            <span class="material-symbols-outlined text-4xl {{ $day->color }}">{{ $day->icon }}</span>
                        </div>
                        <div class="space-y-1 mb-6">
                            <p class="text-2xl font-black text-slate-900 tracking-tighter">{{ round($day->suhu_max) }}°</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ round($day->suhu_min) }}° LOW</p>
                        </div>

                        <p class="text-[10px] font-black uppercase tracking-widest mb-6 {{ $day->color }}">
                            {{ $day->kondisi }}
                        </p>
                        
                        <div class="flex items-center justify-center gap-4 mb-6">
                            <div class="text-center">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">UV Index</p>
                                <p class="text-[10px] font-black {{ $day->uv_index > 7 ? 'text-red-500' : 'text-slate-900' }}">{{ $day->uv_index }}</p>
                            </div>
                            <div class="text-center border-l border-slate-100 pl-4">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Radiation</p>
                                <p class="text-[10px] font-black text-slate-900">{{ round($day->radiation) }}W</p>
                            </div>
                        </div>
                        
                        <div class="pt-6 border-t border-slate-200 flex flex-col gap-2">
                            <div class="flex items-center justify-center gap-2 text-[10px] font-black text-blue-500 uppercase tracking-tight">
                                <span class="material-symbols-outlined text-[16px]">water_drop</span>
                                {{ round($day->curah_hujan_mm) }}mm ({{ $day->peluang_hujan }}%)
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Insights Column -->
        <div class="lg:col-span-4 space-y-10">
            <!-- Historical Insights -->
            <div class="bg-slate-900 text-white p-10 rounded-[4rem] shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-2xl font-extrabold mb-3 tracking-tight">Wawasan Historis 📊</h3>
                    <p class="text-xs text-white/50 mb-10 leading-relaxed font-medium uppercase tracking-widest">Korelasi yield vs presipitasi bulanan.</p>
                    
                    <div class="space-y-8">
                        @php $maxYield = $historicalInsights->max('yield') ?: 1; @endphp
                        @foreach($historicalInsights as $insight)
                        <div class="space-y-3">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-[0.2em] text-white/40">
                                <span class="group-hover:text-primary-500 transition-colors">{{ $insight['month'] }}</span>
                                <span class="text-white/80">Yield: {{ number_format($insight['yield']) }} Kg</span>
                            </div>
                            <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden flex shadow-inner">
                                <div class="bg-primary-500 h-full rounded-full transition-all duration-1000 shadow-[0_0_15px_#10B981]" style="width: {{ ($insight['yield'] / $maxYield) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-10 p-6 bg-white/5 rounded-3xl border border-white/10 backdrop-blur-md">
                        <div class="flex items-center gap-3 mb-2 text-primary-500">
                            <span class="material-symbols-outlined text-sm">auto_awesome</span>
                            <p class="text-[10px] font-black uppercase tracking-widest">AI Expert Prediction</p>
                        </div>
                        <p class="text-xs font-bold text-white/70 leading-relaxed italic">"Bulan Mei diprediksi menjadi periode produktivitas tertinggi dengan intensitas cahaya matahari optimal 8.2 jam/hari."</p>
                    </div>
                </div>
                <span class="material-symbols-outlined absolute -right-16 top-0 text-[250px] text-white/5 rotate-12 group-hover:scale-110 transition-transform duration-1000">monitoring</span>
            </div>

            <!-- Risk Assessment -->
            <div class="bg-white p-10 rounded-[4rem] border border-slate-100 shadow-sm group">
                <h3 class="text-2xl font-extrabold text-slate-900 mb-8 tracking-tight">Analisis Bio-Risiko</h3>
                <div class="space-y-8">
                    @forelse($bioRisks as $name => $risk)
                    <div class="flex items-start gap-6 group/item">
                        <div class="w-14 h-14 rounded-2xl bg-{{ $risk['color'] }}-500/10 flex items-center justify-center text-{{ $risk['color'] }}-500 shrink-0 border border-{{ $risk['color'] }}-500/10 group-hover/item:bg-{{ $risk['color'] }}-500 group-hover/item:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-2xl">{{ $name == 'Lalat Buah' ? 'pest_control' : 'coronavirus' }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-900 tracking-tight mb-1">{{ $name }}</p>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-2 h-2 bg-{{ $risk['color'] }}-500 rounded-full {{ $risk['level'] == 'Kritis' ? 'animate-pulse' : '' }}"></div>
                                <p class="text-[10px] text-{{ $risk['color'] }}-500 font-black uppercase tracking-widest">Risiko {{ $risk['level'] }}: {{ $risk['score'] }}%</p>
                            </div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-relaxed mb-2">{{ $risk['message'] }}</p>
                            <p class="text-[10px] text-slate-900 font-black flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">medical_services</span>
                                {{ $risk['action'] }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center bg-slate-50 rounded-[2.5rem] border border-dashed border-slate-200">
                        <span class="material-symbols-outlined text-primary-500 text-4xl mb-3">verified_user</span>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Biosecurity Secure</p>
                    </div>
                    @endforelse
                </div>
                
                <button class="w-full mt-10 py-5 bg-slate-50 border border-slate-100 text-slate-900 text-[10px] font-black rounded-3xl hover:bg-slate-900 hover:text-white hover:shadow-2xl transition-all uppercase tracking-[0.2em]">
                    Buka Panduan Mitigasi AI
                </button>
            </div>
        </div>
    </div>

    <!-- Hourly Forecast Modal (iOS Style) -->
    <div id="modal-hourly" class="fixed inset-0 z-[150] hidden bg-slate-900/40 backdrop-blur-xl flex items-center justify-center p-6">
        <div class="bg-white/80 w-full max-w-lg rounded-[3rem] shadow-2xl overflow-hidden animate-in zoom-in fade-in duration-500 border border-white/20">
            <div class="p-8 flex justify-between items-center border-b border-white/20">
                <div>
                    <h3 id="hourly-title" class="text-2xl font-black text-slate-900 tracking-tight">Prakiraan Per Jam</h3>
                    <p id="hourly-date" class="text-xs text-slate-500 font-bold uppercase tracking-widest"></p>
                </div>
                <button onclick="document.getElementById('modal-hourly').classList.add('hidden')" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-lg active:scale-90 transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="p-8 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <div id="hourly-list" class="space-y-4">
                    <!-- Hourly items injected by JS -->
                </div>
            </div>
            
            <div class="p-8 bg-slate-900/5 flex items-center justify-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data disinkronkan via Open-Meteo Satelit</p>
            </div>
        </div>
    </div>

    <script>
        const forecastData = @json($forecast);

        function openHourly(index) {
            console.log('Opening hourly for index:', index);
            const day = forecastData[index];
            if (day) {
                showHourlyForecast(day);
            }
        }

        function showHourlyForecast(day) {
            const modal = document.getElementById('modal-hourly');
            const list = document.getElementById('hourly-list');
            const dateText = document.getElementById('hourly-date');
            
            dateText.innerText = new Date(day.tanggal_prakiraan).toLocaleDateString('id-ID', { 
                weekday: 'long', 
                day: 'numeric', 
                month: 'long' 
            });
            
            list.innerHTML = '';
            
            day.hourly.forEach(hour => {
                const hourDiv = document.createElement('div');
                hourDiv.className = 'flex items-center justify-between p-4 bg-white rounded-2xl shadow-sm border border-slate-50';
                
                hourDiv.innerHTML = `
                    <div class="flex items-center gap-4">
                        <p class="text-sm font-black text-slate-900 w-12">${hour.time}</p>
                        <span class="material-symbols-outlined ${hour.condition.color}">${hour.condition.icon}</span>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="text-right">
                            <p class="text-[9px] font-bold ${hour.condition.color} uppercase tracking-widest mb-0.5">${hour.condition.text}</p>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">${hour.rain}mm</p>
                        </div>
                        <p class="text-lg font-black text-slate-900 w-12 text-right">${Math.round(hour.temp)}°</p>
                    </div>
                `;
                list.appendChild(hourDiv);
            });
            
            modal.classList.remove('hidden');
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            @apply bg-slate-50 rounded-full;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            @apply bg-slate-200 rounded-full hover:bg-slate-300 transition-colors;
        }
    </style>
</x-petani-layout>
