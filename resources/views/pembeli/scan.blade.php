<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Scanner Mangga - SI-Mangga</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Instrument Sans', sans-serif; background-color: #0c0c0b; color: white; }
        .scanner-view { position: relative; width: 100%; max-width: 400px; aspect-ratio: 1/1; border-radius: 40px; overflow: hidden; background: #000; border: 4px solid #FFB800; }
        .scanner-overlay { position: absolute; inset: 0; border: 2px solid rgba(255, 184, 0, 0.3); border-radius: 36px; pointer-events: none; }
        .scanner-line { position: absolute; left: 0; right: 0; height: 2px; background: #FFB800; box-shadow: 0 0 20px #FFB800; animation: scan 3s infinite linear; }
        @keyframes scan { 0% { top: 0; } 100% { top: 100%; } }
        
        .glass-panel { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(24px); border: 1px solid rgba(255, 255, 255, 0.05); }
        
        .animate-stagger-1 { animation: fadeIn 0.5s ease-out both; }
        .animate-stagger-2 { animation: fadeIn 0.5s ease-out 0.1s both; }
        .animate-stagger-3 { animation: fadeIn 0.5s ease-out 0.2s both; }
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .progress-ring__circle { transition: stroke-dashoffset 0.8s ease-in-out; transform: rotate(-90deg); transform-origin: 50% 50%; }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    </style>
</head>
<body class="antialiased selection:bg-[#FFB800]/30 min-h-screen">
    <!-- Header -->
    <div class="fixed top-0 left-0 right-0 p-6 flex items-center justify-between z-[110] bg-gradient-to-b from-[#0c0c0b] via-[#0c0c0b]/80 to-transparent">
        <a href="{{ route('pembeli.dashboard') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all group backdrop-blur-md">
            <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div class="flex flex-col items-center">
            <h1 class="text-sm font-bold tracking-widest uppercase opacity-50">AI Diagnostic</h1>
            <div id="scan-status" class="flex items-center gap-2 mt-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span class="text-[8px] font-black uppercase tracking-[0.2em] text-emerald-500">Siap Menganalisis</span>
            </div>
        </div>
        <div class="w-12"></div>
    </div>

    <!-- Scanner View -->
    <div class="flex flex-col items-center justify-center min-h-screen px-6 pt-24 pb-12">
        <div class="scanner-view mb-12 shadow-[0_0_50px_-12px_rgba(255,184,0,0.5)] border-white/5">
            <video id="video" class="w-full h-full object-cover scale-x-[-1]" autoplay playsinline></video>
            <div class="scanner-overlay"></div>
            <div id="scan-line" class="scanner-line hidden"></div>
            <canvas id="canvas" class="hidden"></canvas>
        </div>

        <div id="controls" class="w-full max-w-md space-y-10">
            <div class="space-y-4">
                <label class="text-[10px] uppercase tracking-widest text-gray-500 font-bold ml-1">Pilih Varietas</label>
                <div class="relative">
                    <select id="jenis_mangga" class="w-full bg-white/5 border border-white/10 rounded-3xl p-5 text-white appearance-none focus:border-[#FFB800]/50 outline-none transition-all cursor-pointer">
                        <option value="Harum Manis" class="bg-[#0c0c0b]">Harum Manis (Default)</option>
                        <option value="Gedong Gincu" class="bg-[#0c0c0b]">Gedong Gincu</option>
                        <option value="Manalagi" class="bg-[#0c0c0b]">Manalagi</option>
                        <option value="Cengkir" class="bg-[#0c0c0b]">Cengkir / Indramayu</option>
                        <option value="Golek" class="bg-[#0c0c0b]">Golek</option>
                        <option value="Apel" class="bg-[#0c0c0b]">Apel</option>
                        <option value="Kweni" class="bg-[#0c0c0b]">Kweni</option>
                        <option value="Madu" class="bg-[#0c0c0b]">Madu</option>
                        <option value="Podang" class="bg-[#0c0c0b]">Podang</option>
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                
                <div class="flex flex-col gap-3">
                    <button id="capture-btn" class="w-full py-6 bg-[#FFB800] hover:bg-[#10B981] rounded-[2rem] font-black text-lg shadow-2xl shadow-orange-900/40 transition-all transform active:scale-[0.98] flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        SCAN KAMERA
                    </button>
                    <button id="upload-btn" type="button" class="w-full py-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-[2rem] font-bold text-sm tracking-wider transition-all transform active:scale-[0.98] flex items-center justify-center gap-2 text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        UPLOAD DARI GALERI
                    </button>
                    <input type="file" id="file-upload" accept="image/*" class="hidden">
                </div>
            </div>
            <p class="text-center text-gray-600 text-[10px] uppercase tracking-widest font-bold">Posisikan mangga di tengah area scan, atau upload gambar</p>
        </div>

        <!-- Results Panel -->
        <div id="results-panel" class="fixed inset-0 bg-[#0c0c0b] z-[150] hidden overflow-y-auto">
            <div class="max-w-5xl mx-auto min-h-screen p-6 md:p-12 flex flex-col justify-center">
                <div class="flex justify-between items-center mb-10 animate-stagger-1">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-black tracking-tight mb-2">HASIL ANALISIS</h2>
                        <div class="flex items-center gap-2 text-gray-500">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[10px] uppercase tracking-widest font-bold">Deep Neural Network Complete</span>
                        </div>
                    </div>
                    <button id="close-results" class="w-14 h-14 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center transition-all border border-white/5">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <div class="lg:col-span-5 animate-stagger-2">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-[#FFB800] to-orange-600 rounded-[2.5rem] blur opacity-25 group-hover:opacity-40 transition-opacity"></div>
                            <div class="relative rounded-[2.5rem] overflow-hidden border border-white/10 aspect-square bg-black">
                                <img id="result-img" src="" class="w-full h-full object-cover">
                                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/80 to-transparent">
                                    <p id="result-varietas" class="text-xs font-bold tracking-widest uppercase text-white/60">Harum Manis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:col-span-7 space-y-6 animate-stagger-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="glass-panel p-8 rounded-[2.5rem] flex flex-col items-center justify-center text-center relative overflow-hidden group">
                                <div class="absolute top-0 right-0 p-4">
                                    <div id="result-badge" class="px-3 py-1 bg-emerald-500/20 text-emerald-500 rounded-full text-[8px] font-black uppercase tracking-tighter border border-emerald-500/20">PREMIUM</div>
                                </div>
                                <div class="relative w-32 h-32 mb-4">
                                    <svg class="w-full h-full" viewBox="0 0 100 100">
                                        <circle class="text-white/5" stroke-width="8" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50"/>
                                        <circle id="progress-circle" class="text-[#FFB800] progress-ring__circle" stroke-width="8" stroke-dasharray="263.89" stroke-dashoffset="263.89" stroke-linecap="round" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50"/>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center flex-col">
                                        <span id="result-score" class="text-4xl font-black text-white">0%</span>
                                    </div>
                                </div>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Tingkat Kesegaran</p>
                            </div>

                            <div class="space-y-4">
                                <div class="glass-panel p-6 rounded-[2rem] flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-orange-500/10 flex items-center justify-center text-orange-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-500 uppercase font-black">Status Kematangan</p>
                                        <p id="result-cat" class="text-xl font-bold capitalize">-</p>
                                    </div>
                                </div>
                                <div class="glass-panel p-6 rounded-[2rem] flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04L12 21.35s-8-4.55-8-11.35V6.3a11.955 11.955 0 018-3.05 11.955 11.955 0 018 3.05v3.7c0 6.8-8 11.35-8 11.35z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-500 uppercase font-black">Akurasi Prediksi</p>
                                        <p id="result-acc" class="text-xl font-bold">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tambahan Metrik Detail (Warna, Tekstur, Ukuran) -->
                        <div class="grid grid-cols-3 gap-4">
                            <div class="glass-panel p-4 rounded-2xl flex flex-col items-center justify-center text-center">
                                <p class="text-[10px] text-gray-500 uppercase font-black mb-1">Warna</p>
                                <p id="result-warna" class="text-lg font-bold text-[#FFB800]">-</p>
                            </div>
                            <div class="glass-panel p-4 rounded-2xl flex flex-col items-center justify-center text-center">
                                <p class="text-[10px] text-gray-500 uppercase font-black mb-1">Tekstur</p>
                                <p id="result-tekstur" class="text-lg font-bold text-orange-400">-</p>
                            </div>
                            <div class="glass-panel p-4 rounded-2xl flex flex-col items-center justify-center text-center">
                                <p class="text-[10px] text-gray-500 uppercase font-black mb-1">Ukuran</p>
                                <p id="result-bentuk" class="text-lg font-bold text-emerald-400">-</p>
                            </div>
                        </div>

                        <div class="glass-panel p-8 rounded-[2.5rem] bg-gradient-to-br from-white/[0.05] to-transparent">
                            <div class="flex items-start gap-4">
                                <div class="text-2xl mt-1">💡</div>
                                <div>
                                    <h4 class="font-bold text-lg mb-2">Rekomendasi Cerdas</h4>
                                    <p id="result-advice" class="text-sm text-gray-400 leading-relaxed font-medium">-</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button id="simpan-btn" class="flex-1 py-5 bg-white text-black hover:bg-gray-200 rounded-[1.5rem] font-black text-sm tracking-widest uppercase transition-all shadow-[0_20px_40px_-12px_rgba(255,255,255,0.2)]">
                                SIMPAN KE RIWAYAT
                            </button>
                            <button id="scan-ulang-btn" class="flex-1 py-5 bg-white/5 hover:bg-white/10 rounded-[1.5rem] font-bold text-sm tracking-widest uppercase transition-all border border-white/5">
                                SCAN ULANG
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture-btn');
        const uploadBtn = document.getElementById('upload-btn');
        const fileUpload = document.getElementById('file-upload');
        const scanLine = document.getElementById('scan-line');
        const scanStatus = $('#scan-status');
        
        let currentAnalysis = null;
        let currentTempPath = null;
        
        // Preview Image Element for Upload
        const previewImg = document.createElement('img');
        previewImg.id = 'preview-overlay';
        previewImg.className = 'w-full h-full object-cover hidden absolute inset-0 z-10 rounded-[36px]';
        document.querySelector('.scanner-view').appendChild(previewImg);

        uploadBtn.addEventListener('click', () => {
            fileUpload.click();
        });

        fileUpload.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const imageData = event.target.result;
                    previewImg.src = imageData;
                    previewImg.classList.remove('hidden');
                    
                    $(uploadBtn).prop('disabled', true).text('PROSES AI...');
                    $(captureBtn).prop('disabled', true);
                    scanImage(imageData);
                };
                reader.readAsDataURL(file);
            }
        });

        async function initCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: 'environment', width: 800, height: 800 }, 
                    audio: false 
                });
                video.srcObject = stream;
            } catch (err) {
                Swal.fire({ title: 'Akses Kamera Gagal', text: 'Berikan izin kamera.', icon: 'error', confirmButtonColor: '#FFB800' });
            }
        }

        async function performScan() {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const imageData = canvas.toDataURL('image/webp', 0.6);
            return scanImage(imageData);
        }

        function scanImage(imageData) {
            const jenis = $('#jenis_mangga').val();

            scanLine.classList.remove('hidden');
            scanStatus.find('span:last').text('MENGANALISIS...').addClass('animate-pulse');

            return $.ajax({
                url: "{{ route('pembeli.scan.proses') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", image: imageData, jenis_mangga: jenis },
                success: function(response) {
                    scanLine.classList.add('hidden');
                    scanStatus.find('span:last').text('ANALISIS BERHASIL').removeClass('animate-pulse');
                    currentAnalysis = response.analysis;
                    currentTempPath = response.temp_path;
                    setTimeout(() => { showResults(response.analysis, response.image_url, jenis); }, 500);
                },
                error: function(xhr) {
                    scanLine.classList.add('hidden');
                    scanStatus.find('span:last').text('SIAP MENGANALISIS').removeClass('animate-pulse');
                    if (xhr.status === 422) {
                        Swal.fire({
                            title: 'Objek Tidak Valid',
                            text: xhr.responseJSON.message,
                            icon: 'warning',
                            confirmButtonColor: '#FFB800'
                        });
                    } else {
                        Swal.fire({ title: 'Error', text: 'Gagal menghubungi AI Server.', icon: 'error', confirmButtonColor: '#FFB800' });
                    }
                    
                    // Reset UI Buttons
                    $(captureBtn).prop('disabled', false).html('<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> SCAN KAMERA');
                    $(uploadBtn).prop('disabled', false).html('<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg> UPLOAD DARI GALERI');
                    
                    // Reset preview
                    previewImg.classList.add('hidden');
                    fileUpload.value = '';
                }
            });
        }

        captureBtn.addEventListener('click', async () => {
            $(captureBtn).prop('disabled', true).text('PROSES AI...');
            $(uploadBtn).prop('disabled', true);
            await performScan();
        });

        function showResults(data, imageUrl, varietas) {
            $('#result-img').attr('src', imageUrl);
            $('#result-varietas').text(varietas);
            $('#result-score').text(data.skor_kesegaran + '%');
            let displayCat = data.kategori.replace('_', ' ');
            let advice = "";
            
            if (data.kategori == 'busuk' || data.kategori == 'busuk_awal') {
                advice = "Terdeteksi pembusukan! Buang atau jadikan kompos.";
            } else if (data.kategori == 'mentah') {
                advice = "Mangga masih mentah. Simpan di suhu ruangan bersama apel/pisang.";
            } else if (data.kategori == 'setengah_matang') {
                advice = "Perlu penyimpanan 1-2 hari di suhu ruangan.";
            } else if (data.kategori == 'sangat_matang') {
                advice = "Sangat matang. Segera konsumsi atau simpan di kulkas.";
            } else {
                advice = "Kondisi optimal. Nikmati segera atau siap jual!";
            }
            
            $('#result-cat').text(displayCat);
            $('#result-advice').text(advice);
            $('#result-acc').text(data.skor_kepercayaan + '%');
            $('#result-warna').text(data.persentase_warna + '%');
            $('#result-tekstur').text(data.skor_tekstur + '/100');
            $('#result-bentuk').text(data.estimasi_ukuran);
            
            const circle = document.getElementById('progress-circle');
            const circumference = 42 * 2 * Math.PI;
            circle.style.strokeDashoffset = circumference - (data.skor_kesegaran / 100 * circumference);
            
            $('#results-panel').removeClass('hidden').addClass('animate-in fade-in duration-500');
        }

        $('#simpan-btn').click(function() {
            $.ajax({
                url: "{{ route('pembeli.scan.simpan') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", temp_path: currentTempPath, jenis_mangga: $('#jenis_mangga').val(), ...currentAnalysis },
                success: function() {
                    Swal.fire({ icon: 'success', title: 'Tersimpan!', confirmButtonColor: '#FFB800' }).then(() => {
                        window.location.href = "{{ route('pembeli.scan.history') }}";
                    });
                }
            });
        });

        function batalScan() {
            if (currentTempPath) {
                $.ajax({ url: "{{ route('pembeli.scan.batal') }}", method: "POST", data: { _token: "{{ csrf_token() }}", temp_path: currentTempPath } });
            }
            window.location.reload();
        }

        $('#scan-ulang-btn, #close-results').click(batalScan);
        initCamera();
    </script>
</body>
</html>
