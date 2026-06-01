<x-petani-layout>
    <x-slot name="title">AI Freshness Scanner</x-slot>

    <!-- Header Section -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-3 py-1 bg-primary-500/10 text-primary-500 text-[10px] font-black rounded-full uppercase tracking-widest">Computer Vision</span>
                <span class="px-3 py-1 bg-secondary/10 text-secondary text-[10px] font-black rounded-full uppercase tracking-widest">Neural Engine Active</span>
            </div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">AI Freshness Scanner 🔍</h1>
            <p class="text-slate-500 font-medium mt-1">Pindai mangga Anda menggunakan teknologi Computer Vision terbaru.</p>
        </div>
        <div class="flex items-center gap-3 px-5 py-3 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <div class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></div>
            <span class="text-xs font-black text-slate-600 uppercase tracking-widest">Model V2.4 Connected</span>
        </div>
    </div>

    <!-- Main Scanning Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Left: Camera Preview -->
        <div class="lg:col-span-7 space-y-8">
            <div class="bg-slate-900 rounded-[3.5rem] aspect-video relative overflow-hidden shadow-2xl group border-8 border-slate-800">
                <!-- Video Feed -->
                <video id="video" class="w-full h-full object-cover opacity-90" autoplay playsinline muted></video>
                <canvas id="canvas" class="hidden"></canvas>

                <!-- Scanning Overlay UI -->
                <div class="absolute inset-0 pointer-events-none">
                    <!-- Tech Corners -->
                    <div class="absolute top-10 left-10 w-16 h-16 border-t-4 border-l-4 border-primary-500 rounded-tl-3xl opacity-40 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute top-10 right-10 w-16 h-16 border-t-4 border-r-4 border-primary-500 rounded-tr-3xl opacity-40 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-10 left-10 w-16 h-16 border-b-4 border-l-4 border-primary-500 rounded-bl-3xl opacity-40 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-10 right-10 w-16 h-16 border-b-4 border-r-4 border-primary-500 rounded-br-3xl opacity-40 group-hover:opacity-100 transition-opacity"></div>
                    
                    <!-- Scanner Line -->
                    <div id="scanner-line" class="absolute left-10 right-10 h-1 bg-gradient-to-r from-transparent via-primary-500 to-transparent shadow-[0_0_30px_#10B981] animate-scan-y hidden"></div>

                    <!-- Target Focus Circle -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-48 h-48 border-2 border-white/20 rounded-full border-dashed animate-spin-slow"></div>
                        <div class="absolute w-2 h-2 bg-primary-500 rounded-full shadow-[0_0_15px_#10B981]"></div>
                    </div>

                    <!-- HUD Text -->
                    <div class="absolute top-10 left-1/2 -translate-x-1/2 bg-slate-900/80 backdrop-blur-xl px-6 py-2.5 rounded-full border border-white/10 shadow-2xl">
                        <p class="text-[10px] font-black text-white tracking-[0.3em] uppercase">Align Mango within Frame</p>
                    </div>

                    <!-- Quality Stats -->
                    <div class="absolute bottom-10 left-10 right-10 flex justify-between items-end">
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-primary-500 shadow-[0_0_10px_#10B981] animate-pulse"></div>
                                <span class="text-[11px] font-black text-white/80 tracking-widest uppercase">Lighting: Optimal</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-blue-500 shadow-[0_0_10px_#3b82f6]"></div>
                                <span class="text-[11px] font-black text-white/80 tracking-widest uppercase">Engine: Ready</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-white/40 tracking-widest uppercase mb-1">Processing</p>
                            <p class="text-sm font-black text-white tracking-tight">4K NEURAL • 60 FPS</p>
                        </div>
                    </div>
                </div>

                <!-- Captured Preview -->
                <div id="captured-preview" class="absolute inset-0 bg-slate-900 hidden z-20">
                    <img id="captured-img" src="" class="w-full h-full object-cover opacity-60 transition-opacity duration-500">
                    <div id="analysis-loading" class="absolute inset-0 flex items-center justify-center flex-col text-white text-center p-10">
                        <div class="w-24 h-24 border-4 border-primary-500 border-t-transparent rounded-full animate-spin mb-8 shadow-2xl shadow-primary-500/20"></div>
                        <h4 class="font-extrabold text-2xl tracking-tight mb-2">Analyzing Biomarkers...</h4>
                        <p class="text-white/60 font-medium text-sm max-w-xs uppercase tracking-widest">Scanning color depth, texture defects, and ripeness indicators.</p>
                    </div>
                </div>
            </div>

            <!-- Main Control Button -->
            <div class="flex gap-4">
                <button id="btn-capture" class="flex-1 bg-primary-500 hover:bg-primary-600 text-white font-black py-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(16,185,129,0.3)] flex items-center justify-center gap-4 transition-all active:scale-95 group">
                    <span class="material-symbols-outlined text-4xl group-hover:rotate-12 transition-transform">photo_camera</span>
                    <span class="text-xl tracking-tight uppercase">Ambil Foto</span>
                </button>
                <button id="btn-upload" type="button" class="px-8 bg-white text-slate-900 font-extrabold rounded-[2.5rem] border border-slate-100 shadow-sm hover:bg-slate-50 transition-all active:scale-95 flex items-center justify-center gap-2 group">
                    <span class="material-symbols-outlined text-2xl text-slate-400 group-hover:text-primary-500 transition-colors">upload_file</span>
                    <span class="text-[10px] uppercase tracking-widest hidden md:block">Upload</span>
                </button>
                <input type="file" id="file-upload" accept="image/*" class="hidden">

                <button id="btn-reset" class="px-10 bg-white text-slate-900 font-extrabold rounded-[2.5rem] border border-slate-100 shadow-sm hidden hover:bg-slate-50 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Ulangi
                </button>
            </div>
        </div>

        <!-- Right: Parameters & Results -->
        <div class="lg:col-span-5 space-y-8">
            
            <!-- Unified Panel: Parameters & Results -->
            <div id="unified-panel" class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm transition-all relative overflow-hidden group min-h-[600px] flex flex-col">
                
                <!-- Fixed Header: Mango & Land Configuration (Always Visible) -->
                <div class="p-8 bg-slate-50/50 border-b border-slate-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                                <span class="material-symbols-outlined text-white text-xl">settings_suggest</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 leading-none">Konfigurasi</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Varietas & Asal Lahan</p>
                            </div>
                        </div>
                        <span id="badge-step" class="px-4 py-1.5 bg-white rounded-full border border-slate-200 text-[10px] font-black text-slate-400 uppercase tracking-widest shadow-sm">Langkah 1/2</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Varietas Mangga</label>
                            <div class="relative">
                                <select id="input-jenis" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 appearance-none text-xs transition-all hover:border-primary-500/30">
                                    <option value="Harum Manis">Harum Manis</option>
                                    <option value="Gedong Gincu">Gedong Gincu</option>
                                    <option value="Manalagi">Manalagi</option>
                                    <option value="Cengkir">Cengkir / Indramayu</option>
                                    <option value="Golek">Golek</option>
                                    <option value="Apel">Apel</option>
                                    <option value="Kweni">Kweni</option>
                                    <option value="Madu">Madu</option>
                                    <option value="Podang">Podang</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-sm">expand_more</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Asal Lahan Panen</label>
                            <div class="relative">
                                <select id="input-lahan" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 appearance-none text-xs transition-all hover:border-primary-500/30">
                                    @forelse($lahan as $l)
                                        <option value="{{ $l->id }}">{{ $l->nama_lahan }}</option>
                                    @empty
                                        <option value="" disabled>Belum ada lahan</option>
                                    @endforelse
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-sm">expand_more</span>
                            </div>
                                @if($lahan->isEmpty())
                                <a href="{{ route('petani.data-lahan') }}" class="text-[8px] font-black text-primary-500 uppercase tracking-widest hover:underline ml-1">+ Tambah Lahan Baru</a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content Area -->
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    <!-- Input State -->
                    <div id="input-state" class="p-8 space-y-8 animate-fade-in">
                        <div class="bg-primary-50 p-6 rounded-[2rem] border border-primary-100 relative overflow-hidden">
                            <div class="relative z-10">
                                <h4 class="text-sm font-black text-primary-900 mb-2 uppercase tracking-tight">Parameter Tambahan</h4>
                                <p class="text-xs text-primary-600 font-medium mb-6">Opsional: Masukkan data fisik jika tersedia untuk akurasi lebih baik.</p>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="block text-[9px] font-black text-primary-400 uppercase tracking-widest">Berat (Gram)</label>
                                        <input type="number" id="input-berat" placeholder="500" class="w-full bg-white border-none rounded-xl px-5 py-4 focus:ring-4 focus:ring-primary-500/20 outline-none font-bold text-sm shadow-sm">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-[9px] font-black text-primary-400 uppercase tracking-widest">Diameter (Cm)</label>
                                        <input type="number" id="input-diameter" placeholder="12" class="w-full bg-white border-none rounded-xl px-5 py-4 focus:ring-4 focus:ring-primary-500/20 outline-none font-bold text-sm shadow-sm">
                                    </div>
                                </div>
                            </div>
                            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-7xl text-primary-100/50 rotate-12">scale</span>
                        </div>

                        <div class="pt-6 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-50 mb-4">
                                <span class="material-symbols-outlined text-slate-300 animate-bounce">arrow_back</span>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Ambil Foto di Sisi Kiri Untuk Memulai</p>
                        </div>
                    </div>

                    <!-- Results State -->
                    <div id="results-state" class="hidden animate-fade-in">
                        <!-- Score Card -->
                        <div class="p-8 text-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-b from-primary-50/50 to-transparent"></div>
                            
                            <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Freshness Analysis</p>
                                <div class="flex items-center justify-center gap-6">
                                    <span id="res-score" class="text-8xl font-black text-slate-900 tracking-tighter drop-shadow-sm">--</span>
                                    <div class="text-left">
                                        <p class="text-3xl font-black text-primary-500">%</p>
                                        <p id="res-rekomendasi" class="text-[9px] font-black px-3 py-1.5 bg-emerald-500 text-white rounded-lg uppercase tracking-widest shadow-lg shadow-emerald-500/20 mb-2 inline-block">READY</p>
                                        <p id="res-kategori" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">MATANG</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Metrics Grid -->
                        <div class="px-8 space-y-8">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="p-4 bg-slate-50 rounded-2xl text-center border border-slate-100">
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">WARNA</p>
                                    <p id="res-warna" class="text-sm font-black text-orange-500">--%</p>
                                </div>
                                <div class="p-4 bg-slate-50 rounded-2xl text-center border border-slate-100">
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">TEKSTUR</p>
                                    <p id="res-tekstur" class="text-sm font-black text-orange-500">--/100</p>
                                </div>
                                <div class="p-4 bg-slate-50 rounded-2xl text-center border border-slate-100">
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">UKURAN</p>
                                    <p id="res-ukuran" class="text-[10px] font-black text-emerald-500 truncate">--</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between px-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Akurasi AI: <span id="res-confidence" class="text-slate-900 ml-1">--%</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status:</span>
                                    <span id="res-cacat" class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Aman</span>
                                </div>
                            </div>

                            <!-- Marketplace Context -->
                            <div id="marketplace-fields" class="p-8 bg-slate-900 rounded-[2.5rem] relative overflow-hidden group shadow-2xl">
                                <div class="relative z-10 space-y-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/40">
                                            <span class="material-symbols-outlined text-white text-xl">storefront</span>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-black text-white uppercase tracking-widest">Marketplace Listing</p>
                                            <p class="text-[9px] text-orange-400 font-bold uppercase tracking-widest">Lengkapi data untuk publikasi</p>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest">Harga/kg (Rp)</label>
                                            <input type="number" id="market-harga" placeholder="15000" class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-sm font-bold text-white focus:border-orange-500/50 outline-none transition-all">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest">Stok (kg)</label>
                                            <input type="number" id="market-stok" placeholder="50" class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-sm font-bold text-white focus:border-orange-500/50 outline-none transition-all">
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest">Deskripsi Produk</label>
                                        <textarea id="market-deskripsi" rows="3" class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 text-xs font-medium text-white focus:border-orange-500/50 outline-none transition-all" placeholder="Contoh: Mangga Harum Manis super manis..."></textarea>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 pt-4">
                                        <button id="btn-save" class="bg-white/10 hover:bg-white/20 text-white font-black py-4 rounded-xl transition-all uppercase tracking-widest text-[10px]">
                                            Simpan Saja
                                        </button>
                                        <button id="btn-publish" class="bg-orange-500 hover:bg-orange-600 text-white font-black py-4 rounded-xl shadow-xl shadow-orange-500/20 transition-all uppercase tracking-widest text-[10px]">
                                            Publish Produk
                                        </button>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined absolute -right-8 -bottom-8 text-[120px] text-white/5 rotate-12 group-hover:scale-110 transition-transform">shopping_cart</span>
                            </div>
                        </div>
                        <div class="h-10"></div> <!-- Spacer -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes scan-y {
            0% { top: 0%; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        .animate-scan-y {
            animation: scan-y 3s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 10s linear infinite;
        }
    </style>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const btnCapture = document.getElementById('btn-capture');
        const btnUpload = document.getElementById('btn-upload');
        const fileUpload = document.getElementById('file-upload');
        const btnReset = document.getElementById('btn-reset');
        const scannerLine = document.getElementById('scanner-line');
        const capturedPreview = document.getElementById('captured-preview');
        const capturedImg = document.getElementById('captured-img');
        
        const unifiedPanel = document.getElementById('unified-panel');
        const inputState = document.getElementById('input-state');
        const resultsState = document.getElementById('results-state');
        const analysisLoading = document.getElementById('analysis-loading');

        let lastScanData = null;
        let currentTempPath = null;

        // Initialize Camera
        async function initCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment',
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    } 
                });
                video.srcObject = stream;
            } catch (err) {
                console.error("Camera error:", err);
                alert("Gagal mengakses kamera. Anda masih bisa menggunakan fitur Upload Foto.");
            }
        }

        initCamera();

        // Unified Analyze Function
        async function processAnalysis(imageBlob) {
            // UI Feedback
            scannerLine.classList.remove('hidden');
            btnCapture.disabled = true;
            btnUpload.disabled = true;
            
            // Show preview
            capturedImg.src = imageBlob;
            capturedPreview.classList.remove('hidden');
            analysisLoading.classList.remove('hidden');
            capturedImg.classList.add('opacity-60');
            capturedImg.classList.remove('opacity-100');

            try {
                const response = await fetch("{{ route('petani.cek-kesegaran.analyze') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        image: imageBlob,
                        jenis_mangga: document.getElementById('input-jenis').value
                    })
                });

                const result = await response.json();
                if (result.status === 'success') {
                    showResults(result.data);
                    currentTempPath = result.temp_path;
                    lastScanData = result.data;
                } else {
                    throw new Error(result.message);
                }
            } catch (err) {
                console.error("Analysis error:", err);
                alert("Gagal menganalisis gambar: " + err.message);
                btnReset.click();
            } finally {
                btnCapture.disabled = false;
                btnUpload.disabled = false;
                scannerLine.classList.add('hidden');
            }
        }

        // Capture Logic
        btnCapture.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);

            // Convert to WebP
            const dataUrl = canvas.toDataURL('image/webp', 0.8);
            processAnalysis(dataUrl);
        });

        // Upload Logic
        btnUpload.addEventListener('click', () => fileUpload.click());
        fileUpload.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = () => {
                        const tempCanvas = document.createElement('canvas');
                        const ctx = tempCanvas.getContext('2d');
                        
                        let width = img.width;
                        let height = img.height;
                        const max = 1280;
                        if (width > max || height > max) {
                            if (width > height) {
                                height = Math.round(height * max / width);
                                width = max;
                            } else {
                                width = Math.round(width * max / height);
                                height = max;
                            }
                        }
                        
                        tempCanvas.width = width;
                        tempCanvas.height = height;
                        ctx.drawImage(img, 0, 0, width, height);
                        
                        const webpData = tempCanvas.toDataURL('image/webp', 0.8);
                        processAnalysis(webpData);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        function showResults(data) {
            // Map Results
            document.getElementById('res-score').innerText = data.skor_kesegaran;
            document.getElementById('res-kategori').innerText = data.kategori.replace('_', ' ');
            document.getElementById('res-rekomendasi').innerText = data.rekomendasi.replace('_', ' ');
            
            document.getElementById('res-warna').innerText = data.persentase_warna + '%';
            document.getElementById('res-tekstur').innerText = data.skor_tekstur + '/100';
            
            let ukuranText = '--';
            if (data.panjang_cm && data.berat_gr) {
                ukuranText = `${data.panjang_cm}cm / ${data.berat_gr}g`;
            } else {
                ukuranText = data.estimasi_ukuran || '--';
            }
            document.getElementById('res-ukuran').innerText = ukuranText;
            document.getElementById('res-confidence').innerText = data.skor_kepercayaan + '%';
            
            const resCacat = document.getElementById('res-cacat');
            if (data.cacat_terdeteksi) {
                resCacat.innerText = 'Terdeteksi';
                resCacat.classList.remove('text-emerald-500');
                resCacat.classList.add('text-red-500');
            } else {
                resCacat.innerText = 'Aman';
                resCacat.classList.remove('text-red-500');
                resCacat.classList.add('text-emerald-500');
            }
            
            // UI State Switch
            inputState.classList.add('hidden');
            resultsState.classList.remove('hidden');
            analysisLoading.classList.add('hidden');
            capturedImg.classList.remove('opacity-60');
            capturedImg.classList.add('opacity-100');
            
            btnCapture.classList.add('hidden');
            btnUpload.classList.add('hidden');
            btnReset.classList.remove('hidden');

            // Update Badge
            document.getElementById('badge-step').innerText = 'Analisis Selesai';
            document.getElementById('badge-step').classList.replace('text-slate-400', 'text-emerald-500');
            document.getElementById('badge-step').classList.replace('border-slate-200', 'border-emerald-200');
        }

        btnReset.addEventListener('click', () => {
            capturedPreview.classList.add('hidden');
            inputState.classList.remove('hidden');
            resultsState.classList.add('hidden');
            
            btnCapture.classList.remove('hidden');
            btnUpload.classList.remove('hidden');
            btnReset.classList.add('hidden');
            
            lastScanData = null;
            currentTempPath = null;
            fileUpload.value = '';

            // Reset Badge
            document.getElementById('badge-step').innerText = 'Langkah 1/2';
            document.getElementById('badge-step').classList.replace('text-emerald-500', 'text-slate-400');
            document.getElementById('badge-step').classList.replace('border-emerald-200', 'border-slate-200');
        });

        async function saveData(isPublish = false) {
            if (!lastScanData || !currentTempPath) return;

            const lahanId = document.getElementById('input-lahan').value;
            if (!lahanId || lahanId === 'Belum ada lahan') {
                alert("Harap pilih lahan produksi terlebih dahulu. Jika belum ada, silakan tambah lahan di menu Data Lahan.");
                return;
            }

            const btn = isPublish ? document.getElementById('btn-publish') : document.getElementById('btn-save');
            const originalText = btn.innerText;
            btn.disabled = true;
            btn.innerText = 'PROSES...';

            const payload = {
                temp_path: currentTempPath,
                jenis_mangga: document.getElementById('input-jenis').value,
                berat_gram: document.getElementById('input-berat').value,
                diameter_cm: document.getElementById('input-diameter').value,
                lahan_id: lahanId,
                results: lastScanData
            };

            if (isPublish) {
                payload.marketplace_data = {
                    harga: document.getElementById('market-harga').value,
                    stok: document.getElementById('market-stok').value,
                    deskripsi: document.getElementById('market-deskripsi').value
                };

                if (!payload.marketplace_data.harga || !payload.marketplace_data.stok) {
                    alert("Harap isi harga dan stok untuk memasarkan!");
                    btn.disabled = false;
                    btn.innerText = originalText;
                    return;
                }
            }

            try {
                const response = await fetch("{{ route('petani.cek-kesegaran.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();
                if (result.status === 'success') {
                    alert(result.message);
                    window.location.href = "{{ route('petani.produk.index') }}";
                } else {
                    alert("Gagal: " + result.message);
                }
            } catch (err) {
                console.error("Save error:", err);
                alert("Gagal menyimpan data.");
            } finally {
                btn.disabled = false;
                btn.innerText = originalText;
            }
        }

        document.getElementById('btn-save').addEventListener('click', () => saveData(false));
        document.getElementById('btn-publish').addEventListener('click', () => saveData(true));
    </script>
</x-petani-layout>
