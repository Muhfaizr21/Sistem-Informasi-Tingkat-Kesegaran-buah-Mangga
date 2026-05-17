<x-petani-layout>
    <x-slot name="title">Rekomendasi AI & Prakiraan Cuaca</x-slot>

    <!-- Header Section (The General's War Room) -->
    <div class="mb-12 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-8">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-700 text-[10px] font-black rounded-full uppercase tracking-wider border border-emerald-500/20">AI Recommendation Engine</span>
                <span class="px-4 py-1.5 bg-slate-100 text-slate-700 text-[10px] font-black rounded-full uppercase tracking-wider border border-slate-200">Lahan: {{ $lahanUtama->nama_lahan ?? 'Pusat Riset' }}</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight">Strategi Pertanian AI ⚔️</h1>
            
            <!-- Land Selector (Alexander's Map Selection) -->
            <div class="flex flex-wrap items-center gap-2 mt-4">
                @foreach($lahan as $l)
                <a href="{{ route('petani.rekomendasi', ['lahan_id' => $l->id]) }}" 
                   class="flex items-center gap-2 px-4 py-2.5 rounded-2xl border transition-all duration-300 {{ $lahanUtama->id == $l->id ? 'bg-slate-800 text-white border-slate-800 shadow-md scale-[1.02]' : 'bg-white text-slate-655 border-slate-200 hover:border-emerald-500 hover:text-emerald-600' }}">
                    <span class="material-symbols-outlined text-sm {{ $lahanUtama->id == $l->id ? 'text-[#FFB800]' : '' }}">location_on</span>
                    <span class="text-[10px] font-black uppercase tracking-wider">{{ $l->nama_lahan }}</span>
                    @if($lahanUtama->id == $l->id)
                    <div class="w-1.5 h-1.5 bg-emerald-450 rounded-full animate-pulse"></div>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        
        <div class="grid grid-cols-2 sm:flex items-center gap-4 w-full xl:w-auto">
            <div class="flex-1 sm:flex-none flex items-center gap-4 p-4 bg-slate-50/50 rounded-2xl border border-slate-100 shadow-sm group">
                <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-600 group-hover:rotate-12 transition-transform shrink-0">
                    <span class="material-symbols-outlined text-xl">thermostat</span>
                </div>
                <div>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Suhu Wilayah</p>
                    <p class="text-xs font-black text-slate-800 leading-none">{{ $forecast->first()->suhu_max ?? '28' }}°C</p>
                </div>
            </div>
            <div class="flex-1 sm:flex-none flex items-center gap-4 p-4 bg-slate-50/50 rounded-2xl border border-slate-100 shadow-sm group">
                <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-600 group-hover:rotate-12 transition-transform shrink-0">
                    <span class="material-symbols-outlined text-xl">humidity_mid</span>
                </div>
                <div>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Kelembaban</p>
                    <p class="text-xs font-black text-slate-800 leading-none">{{ $forecast->first()->kelembaban ?? '75' }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Bar (Historical Context) -->
    <div class="mb-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-6 bg-slate-50/50 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Produksi Wilayah (2024)</p>
            <p class="text-lg font-black text-slate-800">{{ number_format($lastYearData->total_produksi_kuintal ?? 0) }} <span class="text-xs font-medium text-slate-400 uppercase">Kuintal</span></p>
        </div>
        <div class="p-6 bg-slate-50/50 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Luas Lahan (2024)</p>
            <p class="text-lg font-black text-slate-800">{{ number_format($lastYearData->total_lahan_hektar ?? 0) }} <span class="text-xs font-medium text-slate-400 uppercase">Ha</span></p>
        </div>
        <div class="p-6 bg-slate-50/50 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Sumber Data</p>
            <p class="text-lg font-black text-emerald-600 uppercase tracking-wide">Dataset CSV BPS</p>
        </div>
        <div class="p-6 bg-[#064E3B] bg-gradient-to-br from-[#064E3B] to-[#022C22] rounded-2xl shadow-xl flex items-center justify-between text-white">
            <div>
                <p class="text-emerald-300/60 text-[8px] font-black uppercase tracking-widest mb-1">AI Recommendation</p>
                <p class="text-sm font-black tracking-wide">Optimal Growth</p>
            </div>
            <div class="w-9 h-9 bg-emerald-600 rounded-lg flex items-center justify-center text-white shrink-0">
                <span class="material-symbols-outlined text-lg">auto_awesome</span>
            </div>
        </div>
    </div>

    <!-- Alert System -->
    @if(count($extremeWeather) > 0)
    <div class="mb-12 space-y-6">
        @foreach($extremeWeather as $alert)
        @php $isHistorical = str_contains($alert['date'] ?? '', 'Historis'); @endphp
        <div class="p-6 md:p-8 {{ $isHistorical ? 'bg-amber-50/80 border-amber-200 text-amber-900' : 'bg-rose-50/80 border-rose-200 text-rose-900' }} rounded-[2.5rem] border flex flex-col md:flex-row items-start md:items-center gap-6 animate-in slide-in-from-top duration-700 relative overflow-hidden group">
            <div class="w-16 h-16 {{ $isHistorical ? 'bg-amber-500 shadow-amber-500/20' : 'bg-rose-500 shadow-rose-500/20' }} rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg group-hover:scale-105 transition-all relative z-10">
                <span class="material-symbols-outlined text-3xl">{{ $isHistorical ? 'history' : 'warning' }}</span>
            </div>
            <div class="relative z-10 flex-1">
                <p class="text-[9px] font-black {{ $isHistorical ? 'text-amber-700' : 'text-rose-700' }} uppercase tracking-[0.2em] mb-1.5 flex items-center gap-1.5">
                    @if(!$isHistorical) <span class="w-1.5 h-1.5 bg-rose-600 rounded-full animate-ping"></span> @endif
                    {{ $isHistorical ? 'Historical Context' : 'Critical Weather Alert' }} ({{ $alert['date'] }})
                </p>
                <h4 class="text-xl font-extrabold {{ $isHistorical ? 'text-amber-950' : 'text-rose-950' }} leading-tight mb-1.5 tracking-tight">{{ $alert['message'] }}</h4>
                <p class="text-xs {{ $isHistorical ? 'text-amber-800/80' : 'text-rose-800/80' }} font-medium leading-relaxed max-w-2xl italic">"{{ $alert['reason'] ?? 'Tim AI merekomendasikan penutupan pelindung buah atau percepatan panen jika tingkat kematangan sudah mencapai 75%.' }}"</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Analysis Column -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Recommendations Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Harvest Advice -->
                <div class="bg-white p-8 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden group h-full">
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-md">
                                <span class="material-symbols-outlined text-2xl">inventory</span>
                            </div>
                            <span class="text-[9px] font-black text-emerald-700 bg-emerald-500/10 px-3 py-1.5 rounded-full uppercase tracking-wider border border-emerald-500/20">Harvest Window</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 mb-2 tracking-tight">Optimal Harvest</h3>
                        <p class="text-xs text-slate-450 font-medium leading-relaxed mb-6 italic">Berdasarkan kelembaban tanah dan paparan UV, waktu terbaik untuk panen:</p>
                        
                        <div class="space-y-4 flex-1">
                            @forelse(array_slice($harvestAlerts, 0, 3) as $alert)
                            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:bg-emerald-500/5 hover:border-emerald-500/20 transition-all duration-300">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center text-emerald-600 shadow-sm border border-slate-100">
                                        <span class="material-symbols-outlined text-lg">event_available</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-slate-800 tracking-tight">{{ Carbon\Carbon::parse($alert['date'])->format('d M Y') }}</p>
                                        <p class="text-[9px] text-slate-450 font-bold uppercase tracking-wider">{{ $alert['message'] }}</p>
                                    </div>
                                </div>
                                <p class="text-[10px] text-slate-500 font-bold leading-relaxed mb-1.5">{{ $alert['reason'] }}</p>
                                <p class="text-[9px] text-emerald-600 font-black uppercase tracking-wide flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">auto_fix</span>
                                    {{ $alert['action'] }}
                                </p>
                            </div>
                            @empty
                            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                <span class="material-symbols-outlined text-slate-300 text-3xl mb-2">cloud_off</span>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">No optimal window detected</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Planting Advice -->
                <div class="bg-white p-8 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden group h-full">
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center text-white shadow-md">
                                <span class="material-symbols-outlined text-2xl">potted_plant</span>
                            </div>
                            <span class="text-[9px] font-black text-blue-700 bg-blue-500/10 px-3 py-1.5 rounded-full uppercase tracking-wider border border-blue-500/20">Growth Analysis</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 mb-2 tracking-tight">Planting Strategy</h3>
                        <p class="text-xs text-slate-450 font-medium leading-relaxed mb-6 italic">Peluang keberhasilan penanaman berdasarkan kelembaban tanah 14 hari ke depan:</p>
                        
                        <div class="space-y-4 flex-1">
                            @forelse(array_slice($plantingAlerts, 0, 3) as $alert)
                            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:bg-blue-500/5 hover:border-blue-500/20 transition-all duration-300">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center text-blue-600 shadow-sm border border-slate-100">
                                        <span class="material-symbols-outlined text-lg">temp_preferences_eco</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-slate-800 tracking-tight">{{ Carbon\Carbon::parse($alert['date'])->format('d M Y') }}</p>
                                        <p class="text-[9px] text-slate-450 font-bold uppercase tracking-wider">{{ $alert['message'] }}</p>
                                    </div>
                                </div>
                                <p class="text-[10px] text-slate-500 font-bold leading-relaxed mb-1.5">{{ $alert['reason'] }}</p>
                                <p class="text-[9px] text-blue-600 font-black uppercase tracking-wide flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">water_drop</span>
                                    {{ $alert['action'] }}
                                </p>
                            </div>
                            @empty
                            <div class="space-y-6">
                                <div class="p-5 bg-blue-50/50 rounded-2xl border border-blue-100">
                                    <div class="flex justify-between items-center mb-2.5">
                                        <span class="text-xs font-black text-slate-800 uppercase tracking-widest">{{ $varietyStrategic['name'] ?? 'Varietas Unggul' }}</span>
                                        <span class="text-[9px] font-black text-blue-700 bg-white px-2.5 py-0.5 rounded-full border border-blue-100 shadow-sm">{{ $varietyStrategic['success_rate'] ?? '90' }}% SUCCESS</span>
                                    </div>
                                    <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden mb-2.5">
                                        <div class="bg-blue-500 h-full rounded-full" style="width: {{ $varietyStrategic['success_rate'] ?? '90' }}%"></div>
                                    </div>
                                    <p class="text-[10px] text-blue-750 font-bold italic leading-relaxed">"{{ $varietyStrategic['advice'] ?? 'Kondisi tanah saat ini sangat mendukung pertumbuhan vegetatif.' }}"</p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Soil Temp</p>
                                        <p class="text-xs font-black text-slate-800">{{ $agroData['soil']['t10'] ?? '28.5' }}°C</p>
                                    </div>
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Moisture</p>
                                        <p class="text-xs font-black text-slate-800">{{ round(($agroData['soil']['moisture'] ?? 0.32) * 100) }}%</p>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weather Forecast Grid -->
            <div class="bg-white p-8 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden relative group">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <h2 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">Prakiraan 14 Hari Kedepan</h2>
                            <div class="flex items-center gap-1.5 px-2.5 py-0.5 bg-slate-800 text-white rounded-full text-[9px] font-black uppercase tracking-wider shrink-0">
                                <span class="material-symbols-outlined text-[10px]">location_on</span>
                                <span>{{ $lahanUtama->nama_lahan ?? 'Territory Alpha' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-0.5 {{ $synopticReport['alert_class'] }} text-white text-[8px] font-black rounded-md uppercase tracking-widest">{{ $synopticReport['status'] }}</span>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Trend: {{ $synopticReport['trend'] }}</p>
                        </div>
                        <p class="text-[10px] text-slate-500 font-medium mt-2 max-w-xl italic">"{{ $synopticReport['summary'] }}"</p>
                    </div>
                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl shrink-0">
                        <span class="w-1.5 h-1.5 bg-emerald-550 rounded-full animate-pulse"></span>
                        <span class="text-[9px] font-black text-slate-450 uppercase tracking-widest">LIVE UPDATING</span>
                    </div>
                </div>
                
                <div class="flex gap-4 overflow-x-auto pb-6 custom-scrollbar scroll-smooth">
                    @foreach($forecast as $index => $day)
                    <div onclick="openHourly({{ $index }})"
                         class="min-w-[120px] p-6 bg-slate-50 rounded-[2rem] text-center border-2 border-transparent hover:border-emerald-500 hover:bg-white hover:shadow-lg transition-all duration-300 group/card cursor-pointer active:scale-95">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4 group-hover/card:text-emerald-650">{{ Carbon\Carbon::parse($day->tanggal_prakiraan)->format('D, d M') }}</p>
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mx-auto mb-4 shadow-sm group-hover/card:shadow-md transition-all">
                            <span class="material-symbols-outlined text-2xl {{ $day->color }}">{{ $day->icon }}</span>
                        </div>
                        <div class="space-y-0.5 mb-4">
                            <p class="text-xl font-black text-slate-800 tracking-tight">{{ round($day->suhu_max) }}°</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ round($day->suhu_min) }}° LOW</p>
                        </div>

                        <p class="text-[9px] font-black uppercase tracking-widest mb-4 {{ $day->color }}">
                            {{ $day->kondisi }}
                        </p>
                        
                        <div class="flex items-center justify-center gap-3 mb-4">
                            <div class="text-center">
                                <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest">UV Index</p>
                                <p class="text-[9px] font-black {{ $day->uv_index > 7 ? 'text-rose-600' : 'text-slate-800' }}">{{ $day->uv_index }}</p>
                            </div>
                            <div class="text-center border-l border-slate-200 pl-3">
                                <p class="text-[7px] font-black text-slate-400 uppercase tracking-widest">Radiation</p>
                                <p class="text-[9px] font-black text-slate-800">{{ round($day->radiation) }}W</p>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-200/60">
                            <div class="flex items-center justify-center gap-1 text-[9px] font-black text-blue-600 uppercase tracking-tight">
                                <span class="material-symbols-outlined text-xs">water_drop</span>
                                {{ round($day->curah_hujan_mm) }}mm ({{ $day->peluang_hujan }}%)
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Insights Column -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Historical Insights -->
            <div class="bg-[#022C22] bg-gradient-to-br from-[#022C22] to-[#0F172A] text-white p-8 md:p-10 rounded-[3rem] shadow-xl relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-xl md:text-2xl font-extrabold mb-2 tracking-tight text-white">Wawasan Historis 📊</h3>
                    <p class="text-[10px] text-emerald-300/60 mb-8 leading-relaxed font-black uppercase tracking-widest">Korelasi yield vs presipitasi bulanan.</p>
                    
                    <div class="space-y-6">
                        @php $maxYield = $historicalInsights->max('yield') ?: 1; @endphp
                        @foreach($historicalInsights as $insight)
                        <div class="space-y-2">
                            <div class="flex justify-between text-[9px] font-black uppercase tracking-wider text-emerald-300/40">
                                <span class="group-hover:text-emerald-400 transition-colors">{{ $insight['month'] }}</span>
                                <span class="text-emerald-100">Yield: {{ number_format($insight['yield']) }} Kg</span>
                            </div>
                            <div class="w-full bg-white/5 h-1.5 rounded-full overflow-hidden flex shadow-inner">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-700" style="width: {{ ($insight['yield'] / $maxYield) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-8 p-5 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-md">
                        <div class="flex items-center gap-2 mb-2 text-emerald-400">
                            <span class="material-symbols-outlined text-sm">auto_awesome</span>
                            <p class="text-[8px] font-black uppercase tracking-widest">AI Expert Prediction</p>
                        </div>
                        <p class="text-xs font-bold text-emerald-100/70 leading-relaxed italic">"Bulan Mei diprediksi menjadi periode produktivitas tertinggi dengan intensitas cahaya matahari optimal 8.2 jam/hari."</p>
                    </div>
                </div>
            </div>

            <!-- Risk Assessment -->
            <div class="bg-white p-8 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm group">
                <h3 class="text-xl md:text-2xl font-extrabold text-slate-800 mb-6 tracking-tight">Analisis Bio-Risiko</h3>
                <div class="space-y-6">
                    @forelse($bioRisks as $name => $risk)
                    <div class="flex items-start gap-4 group/item">
                        <div class="w-12 h-12 rounded-xl bg-{{ $risk['color'] }}-500/10 flex items-center justify-center text-{{ $risk['color'] }}-600 shrink-0 border border-{{ $risk['color'] }}-550/10 group-hover/item:bg-{{ $risk['color'] }}-600 group-hover/item:text-white transition-all shrink-0">
                            <span class="material-symbols-outlined text-xl">{{ $name == 'Lalat Buah' ? 'pest_control' : 'coronavirus' }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800 tracking-tight mb-0.5">{{ $name }}</p>
                            <div class="flex items-center gap-1.5 mb-1.5">
                                <div class="w-1.5 h-1.5 bg-{{ $risk['color'] }}-500 rounded-full {{ $risk['level'] == 'Kritis' ? 'animate-pulse' : '' }}"></div>
                                <p class="text-[9px] text-{{ $risk['color'] }}-600 font-black uppercase tracking-widest">Risiko {{ $risk['level'] }}: {{ $risk['score'] }}%</p>
                            </div>
                            <p class="text-[9px] text-slate-450 font-bold uppercase tracking-widest leading-relaxed mb-1.5">{{ $risk['message'] }}</p>
                            <p class="text-[9px] text-slate-800 font-black flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">medical_services</span>
                                {{ $risk['action'] }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <span class="material-symbols-outlined text-emerald-600 text-3xl mb-2">verified_user</span>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Biosecurity Secure</p>
                    </div>
                    @endforelse
                </div>
                
                <button class="w-full mt-8 py-4 bg-slate-50 hover:bg-slate-850 hover:text-white border border-slate-200 rounded-2xl text-slate-700 text-[9px] font-black transition-all uppercase tracking-widest active:scale-[0.98]">
                    Buka Panduan Mitigasi AI
                </button>
            </div>
        </div>
    </div>

    <!-- Hourly Forecast Modal (iOS Style) -->
    <div id="modal-hourly" class="fixed inset-0 z-[150] hidden bg-slate-900/40 backdrop-blur-xl flex items-center justify-center p-4">
        <div class="bg-white/95 w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden animate-in zoom-in fade-in duration-300 border border-slate-200">
            <div class="p-6 flex justify-between items-center border-b border-slate-100 bg-white">
                <div>
                    <h3 id="hourly-title" class="text-xl font-black text-slate-800 tracking-tight">Prakiraan Per Jam</h3>
                    <p id="hourly-date" class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5"></p>
                </div>
                <button onclick="document.getElementById('modal-hourly').classList.add('hidden')" class="w-10 h-10 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center active:scale-90 transition-all shrink-0">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            
            <div class="p-6 max-h-[50vh] overflow-y-auto custom-scrollbar">
                <div id="hourly-list" class="space-y-3">
                    <!-- Hourly items injected by JS -->
                </div>
            </div>
            
            <div class="p-6 bg-slate-50/50 border-t border-slate-150/60 flex items-center justify-center">
                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Data disinkronkan via Open-Meteo Satelit</p>
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
                hourDiv.className = 'flex items-center justify-between p-3.5 bg-white rounded-xl shadow-sm border border-slate-100';
                
                hourDiv.innerHTML = `
                    <div class="flex items-center gap-3">
                        <p class="text-xs font-black text-slate-800 w-10">${hour.time}</p>
                        <span class="material-symbols-outlined text-xl ${hour.condition.color}">${hour.condition.icon}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-[8px] font-black ${hour.condition.color} uppercase tracking-wider mb-0.5">${hour.condition.text}</p>
                            <p class="text-[8px] font-black text-slate-450 uppercase tracking-tighter">${hour.rain}mm</p>
                        </div>
                        <p class="text-base font-black text-slate-800 w-10 text-right">${Math.round(hour.temp)}°</p>
                    </div>
                `;
                list.appendChild(hourDiv);
            });
            
            modal.classList.remove('hidden');
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 5px;
            width: 5px;
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
