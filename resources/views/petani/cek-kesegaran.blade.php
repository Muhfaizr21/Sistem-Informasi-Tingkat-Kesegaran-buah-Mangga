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
                    <img id="captured-img" src="" class="w-full h-full object-cover opacity-60">
                    <div class="absolute inset-0 flex items-center justify-center flex-col text-white text-center p-10">
                        <div class="w-24 h-24 border-4 border-primary-500 border-t-transparent rounded-full animate-spin mb-8 shadow-2xl shadow-primary-500/20"></div>
                        <h4 class="font-extrabold text-2xl tracking-tight mb-2">Analyzing Biomarkers...</h4>
                        <p class="text-white/60 font-medium text-sm max-w-xs uppercase tracking-widest">Scanning color depth, texture defects, and ripeness indicators.</p>
                    </div>
                </div>
            </div>

            <!-- Main Control Button -->
            <div class="flex gap-6">
                <button id="btn-capture" class="flex-1 bg-primary-500 hover:bg-primary-600 text-white font-black py-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(16,185,129,0.3)] flex items-center justify-center gap-4 transition-all active:scale-95 group">
                    <span class="material-symbols-outlined text-4xl group-hover:rotate-12 transition-transform">photo_camera</span>
                    <span class="text-xl tracking-tight">MULAI PEMINDAIAN AI</span>
                </button>
                <button id="btn-reset" class="px-10 bg-white text-slate-900 font-extrabold rounded-[2.5rem] border border-slate-100 shadow-sm hidden hover:bg-slate-50 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Ulangi
                </button>
            </div>
        </div>

        <!-- Right: Parameters & Results -->
        <div class="lg:col-span-5 space-y-8">
            
            <!-- Parameters Card -->
            <div id="input-parameters" class="bg-white p-10 rounded-[3.5rem] border border-slate-100 shadow-sm transition-all relative overflow-hidden group">
                <h3 class="text-2xl font-extrabold text-slate-900 mb-8">Metadata Lahan</h3>
                <div class="space-y-8 relative z-10">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Varietas Mangga</label>
                        <select id="input-jenis" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 appearance-none">
                            <option value="Harum Manis">Harum Manis</option>
                            <option value="Gedong Gincu">Gedong Gincu</option>
                            <option value="Cengkir">Cengkir</option>
                            <option value="Manalagi">Manalagi</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Berat (Gram)</label>
                            <input type="number" id="input-berat" placeholder="500" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Diameter (Cm)</label>
                            <input type="number" id="input-diameter" placeholder="12" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Pilih Lahan Produksi</label>
                        <select id="input-lahan" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-5 focus:ring-4 focus:ring-primary-500/10 outline-none font-bold text-slate-700 appearance-none">
                            @foreach($lahan as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_lahan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <span class="material-symbols-outlined absolute -right-8 -bottom-8 text-[150px] text-slate-50 group-hover:scale-110 transition-transform">inventory_2</span>
            </div>

            <!-- Results Card (Hidden until scan) -->
            <div id="results-card" class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm transition-all opacity-30 pointer-events-none scale-95 blur-md">
                <div class="p-10 border-b border-slate-50 text-center relative overflow-hidden">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Biometric Freshness Score</p>
                    <div class="flex items-center justify-center gap-6">
                        <span id="res-score" class="text-8xl font-black text-slate-900 tracking-tighter">--</span>
                        <div class="text-left">
                            <p class="text-3xl font-black text-primary-500">%</p>
                            <p id="res-rekomendasi" class="text-[10px] font-black px-3 py-1.5 bg-primary-500/10 text-primary-500 rounded-xl uppercase tracking-tighter shadow-sm border border-primary-500/20">READY</p>
                        </div>
                    </div>
                </div>

                <div class="p-10 space-y-8">
                    <!-- Metrics Grid -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-6 bg-slate-50 rounded-3xl border border-white">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Color Matrix</p>
                            <div class="flex items-center justify-between">
                                <span id="res-warna" class="font-extrabold text-slate-900">--</span>
                                <div class="w-10 h-3 bg-primary-500 rounded-full shadow-sm"></div>
                            </div>
                        </div>
                        <div class="p-6 bg-slate-50 rounded-3xl border border-white">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">AI Confidence</p>
                            <span id="res-confidence" class="font-extrabold text-slate-900">--</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-6 bg-secondary/10 rounded-[2rem] border border-secondary/20">
                        <div class="flex items-center gap-3 text-secondary">
                            <span class="material-symbols-outlined text-2xl font-black">category</span>
                            <span class="text-xs font-black uppercase tracking-widest">Kategori Kematangan</span>
                        </div>
                        <span id="res-kategori" class="text-sm font-black text-slate-900 uppercase">--</span>
                    </div>

                    <button id="btn-save" class="w-full bg-slate-900 text-white font-black py-6 rounded-3xl shadow-2xl shadow-slate-900/20 hover:bg-black transition-all active:scale-95 uppercase tracking-widest text-xs">
                        Simpan ke Data Produksi
                    </button>
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
        const btnReset = document.getElementById('btn-reset');
        const scannerLine = document.getElementById('scanner-line');
        const capturedPreview = document.getElementById('captured-preview');
        const capturedImg = document.getElementById('captured-img');
        const resultsCard = document.getElementById('results-card');

        let lastScanData = null;

        // Initialize Camera
        async function initCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment',
                        width: { ideal: 1920 },
                        height: { ideal: 1080 }
                    } 
                });
                video.srcObject = stream;
            } catch (err) {
                console.error("Camera error:", err);
                alert("Gagal mengakses kamera. Pastikan izin kamera telah diberikan.");
            }
        }

        initCamera();

        // Capture Logic
        btnCapture.addEventListener('click', async () => {
            // UI Feedback
            scannerLine.classList.remove('hidden');
            
            // Wait for scan animation
            setTimeout(async () => {
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0);

                const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                capturedImg.src = dataUrl;
                capturedPreview.classList.remove('hidden');
                scannerLine.classList.add('hidden');

                // Analyze with Backend
                try {
                    const response = await fetch("{{ route('petani.cek-kesegaran.analyze') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            image: dataUrl,
                            jenis_mangga: document.getElementById('input-jenis').value,
                            berat_gram: document.getElementById('input-berat').value,
                            diameter_cm: document.getElementById('input-diameter').value,
                            lahan_id: document.getElementById('input-lahan').value
                        })
                    });

                    const result = await response.json();
                    if (result.status === 'success') {
                        showResults(result.data);
                        lastScanData = {
                            image: dataUrl,
                            results: result.data
                        };
                    }
                } catch (err) {
                    console.error("Analysis error:", err);
                    alert("Gagal menganalisis gambar. Pastikan koneksi stabil.");
                    btnReset.click();
                }
            }, 1500);
        });

        function showResults(data) {
            document.getElementById('res-score').innerText = data.skor_kesegaran;
            document.getElementById('res-warna').innerText = data.persentase_warna + '%';
            document.getElementById('res-confidence').innerText = data.skor_kepercayaan + '%';
            document.getElementById('res-kategori').innerText = data.kategori.replace('_', ' ');
            document.getElementById('res-rekomendasi').innerText = data.rekomendasi.replace('_', ' ');
            
            // Animate results card in
            resultsCard.classList.remove('opacity-30', 'pointer-events-none', 'scale-95', 'blur-md');
            btnCapture.classList.add('hidden');
            btnReset.classList.remove('hidden');
        }

        btnReset.addEventListener('click', () => {
            capturedPreview.classList.add('hidden');
            resultsCard.classList.add('opacity-30', 'pointer-events-none', 'scale-95', 'blur-md');
            btnCapture.classList.remove('hidden');
            btnReset.classList.add('hidden');
        });

        document.getElementById('btn-save').addEventListener('click', async () => {
            if (!lastScanData) return;

            const btnSave = document.getElementById('btn-save');
            btnSave.disabled = true;
            btnSave.innerText = 'MENYIMPAN...';

            try {
                const response = await fetch("{{ route('petani.cek-kesegaran.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        image: lastScanData.image,
                        jenis_mangga: document.getElementById('input-jenis').value,
                        berat_gram: document.getElementById('input-berat').value,
                        diameter_cm: document.getElementById('input-diameter').value,
                        lahan_id: document.getElementById('input-lahan').value,
                        results: lastScanData.results
                    })
                });

                const result = await response.json();
                if (result.status === 'success') {
                    alert(result.message);
                    window.location.href = "{{ route('petani.dashboard') }}";
                }
            } catch (err) {
                console.error("Save error:", err);
                alert("Gagal menyimpan hasil scan.");
                btnSave.disabled = false;
                btnSave.innerText = 'SIMPAN KE DATA PRODUKSI';
            }
        });
    </script>
</x-petani-layout>
