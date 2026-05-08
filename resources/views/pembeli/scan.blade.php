@extends('layouts.pembeli')

@section('title', 'AI Scanner Mangga Premium')

@section('content')
<div class="relative min-h-[calc(100vh-200px)] flex flex-col items-center justify-center animate-in fade-in duration-700">
    <!-- Header Info -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--mango-green);">
            <span class="w-8 h-[2px]" style="background: var(--gold);"></span>
            AI Diagnostic Core
        </div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--leaf-dark);" class="mb-4">
            Deteksi <span style="color: var(--gold);">Kesegaran</span>
        </h1>
        <p class="text-sm max-w-md mx-auto" style="color: var(--text-light);">
            Gunakan kamera Anda untuk menganalisis tingkat kematangan dan kualitas mangga secara real-time.
        </p>
    </div>

    <!-- Scanner View -->
    <div class="relative w-full max-w-[450px] aspect-square rounded-[3rem] overflow-hidden border-4 shadow-2xl group mb-12" style="border-color: var(--gold); box-shadow: 0 20px 50px rgba(212,160,23,0.2);">
        <video id="video" class="w-full h-full object-cover scale-x-[-1]" autoplay playsinline></video>
        
        <!-- Scanning Overlays -->
        <div class="absolute inset-0 border-[20px] border-black/10 pointer-events-none"></div>
        <div class="absolute inset-0 border-2 border-white/20 rounded-[2.5rem] pointer-events-none m-4"></div>
        
        <!-- Animated Scan Line -->
        <div id="scan-line" class="absolute left-0 right-0 h-[2px] z-20 hidden" style="background: var(--gold); box-shadow: 0 0 20px var(--gold); animation: scanLineMove 3s infinite linear;"></div>
        
        <canvas id="canvas" class="hidden"></canvas>
        
        <!-- Preview Image for Upload -->
        <img id="preview-overlay" class="w-full h-full object-cover hidden absolute inset-0 z-10">

        <!-- Status Indicator -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 px-4 py-2 bg-black/60 backdrop-blur-md rounded-full border border-white/10 flex items-center gap-2">
            <div id="status-dot" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <span id="status-text" class="text-[9px] font-bold uppercase tracking-[0.2em] text-white">System Ready</span>
        </div>
    </div>

    <!-- Controls -->
    <div class="w-full max-w-md space-y-8 pb-10">
        <div class="grid grid-cols-1 gap-6">
            <div class="space-y-3">
                <label class="text-[0.65rem] uppercase tracking-[0.15em] font-bold ml-1" style="color: var(--text-light);">Varietas Target</label>
                <div class="relative">
                    <select id="jenis_mangga" class="w-full px-6 py-4 bg-white border rounded-2xl focus:ring-4 focus:ring-var(--gold)/10 focus:border-var(--gold) outline-none transition-all font-bold appearance-none" style="border-color: var(--gold-pale); color: var(--text-dark);">
                        <option value="Harum Manis">Harum Manis (Default)</option>
                        <option value="Gedong Gincu">Gedong Gincu</option>
                        <option value="Manalagi">Manalagi</option>
                        <option value="Cengkir">Cengkir / Indramayu</option>
                        <option value="Golek">Golek</option>
                        <option value="Kweni">Kweni</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none opacity-40">keyboard_arrow_down</span>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <button id="capture-btn" class="w-full py-5 rounded-2xl font-black text-[0.75rem] uppercase tracking-widest transition-all shadow-xl active:scale-95 flex items-center justify-center gap-3"
                        style="background: var(--gold); color: white; box-shadow: 0 10px 25px rgba(212,160,23,0.3);">
                    <span class="material-symbols-outlined text-[24px]">photo_camera</span>
                    Mulai Scan AI
                </button>
                
                <div class="flex gap-4">
                    <button id="upload-btn" class="flex-1 py-4 bg-white border rounded-2xl font-bold text-[0.7rem] uppercase tracking-widest transition-all hover:bg-var(--gold-pale) flex items-center justify-center gap-2"
                            style="border-color: var(--gold-pale); color: var(--text-mid);">
                        <span class="material-symbols-outlined text-[18px]">upload_file</span>
                        Upload Gambar
                    </button>
                    <input type="file" id="file-upload" accept="image/*" class="hidden">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Results Modal (Elite Design) -->
<div id="results-panel" class="fixed inset-0 z-[200] hidden overflow-y-auto">
    <div class="min-h-screen flex items-center justify-center p-4 md:p-8">
        <div class="fixed inset-0 backdrop-blur-2xl animate-in fade-in duration-500" style="background: rgba(30, 58, 26, 0.9);"></div>
        
        <div class="relative bg-white rounded-[2.5rem] md:rounded-[3.5rem] w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl animate-in zoom-in-95 duration-500 border border-white/20">
            <div class="grid grid-cols-1 lg:grid-cols-2 w-full">
                <!-- Result Image Column -->
                <div class="relative aspect-square lg:aspect-auto bg-black">
                    <img id="result-img" src="" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-10 left-10">
                        <div class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full border border-white/20 mb-3 inline-block">
                            <p id="result-varietas" class="text-[0.65rem] font-bold text-white uppercase tracking-[0.2em]">Varietas</p>
                        </div>
                        <h2 id="result-cat" style="font-family: 'Playfair Display', serif; font-size: 3rem; color: white; line-height: 1;" class="capitalize">Kategori</h2>
                    </div>
                </div>

                <!-- Result Data Column -->
                <div class="p-8 md:p-10 lg:p-12 flex flex-col">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <p class="text-[0.6rem] font-black uppercase tracking-[0.2em]" style="color: var(--mango-green);">Analysis Report</p>
                            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--leaf-dark);">Quality Index</h3>
                        </div>
                        <button id="close-results" class="w-10 h-10 rounded-full bg-var(--gold-pale) flex items-center justify-center transition-colors hover:bg-var(--gold)/20" style="color: var(--gold);">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                        <!-- Score Circle -->
                        <div class="flex flex-col items-center justify-center p-6 rounded-[2rem] border border-var(--gold-pale)" style="background: rgba(212,160,23,0.03);">
                            <div class="relative w-24 h-24 mb-4">
                                <svg class="w-full h-full" viewBox="0 0 100 100">
                                    <circle class="text-var(--gold-pale)" stroke-width="8" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50"/>
                                    <circle id="progress-circle" class="progress-ring__circle" stroke-width="8" stroke-dasharray="263.89" stroke-dashoffset="263.89" stroke-linecap="round" style="color: var(--gold);" fill="transparent" r="42" cx="50" cy="50"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="result-score" class="text-2xl font-black" style="color: var(--leaf-dark);">0%</span>
                                </div>
                            </div>
                            <p class="text-[0.65rem] font-bold uppercase tracking-widest text-var(--text-light)">Freshness Score</p>
                        </div>

                        <!-- Stats List -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-var(--gold-pale)/20">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]" style="color: var(--mango-green);">verified</span>
                                </div>
                                <div>
                                    <p class="text-[0.6rem] font-bold uppercase tracking-widest text-var(--text-light)">Akurasi AI</p>
                                    <p id="result-acc" class="text-sm font-black" style="color: var(--text-dark);">-</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-var(--gold-pale)/20">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]" style="color: var(--mango-orange);">straighten</span>
                                </div>
                                <div>
                                    <p class="text-[0.6rem] font-bold uppercase tracking-widest text-var(--text-light)">Ukuran</p>
                                    <p id="result-size" class="text-sm font-black" style="color: var(--text-dark);">-</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-var(--gold-pale)/20">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]" style="color: var(--mango-green);">weight</span>
                                </div>
                                <div>
                                    <p class="text-[0.6rem] font-bold uppercase tracking-widest text-var(--text-light)">Estimasi Berat</p>
                                    <p id="result-weight" class="text-sm font-black" style="color: var(--text-dark);">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl mb-8 border border-var(--gold-pale)" style="background: rgba(212,160,23,0.03);">
                        <div class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-var(--gold)" style="font-size: 24px;">lightbulb</span>
                            <div>
                                <h4 class="font-bold text-sm mb-1" style="color: var(--text-dark);">Rekomendasi Cerdas</h4>
                                <p id="result-advice" class="text-xs leading-relaxed" style="color: var(--text-mid);">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-auto pt-6">
                        <button id="simpan-btn" class="flex-[2] py-5 text-white rounded-2xl font-black text-[0.7rem] uppercase tracking-widest transition-all shadow-xl shadow-orange-900/20 active:scale-95"
                                style="background: var(--gold);">
                            Simpan ke Riwayat
                        </button>
                        <button id="scan-ulang-btn" class="flex-1 py-5 border rounded-2xl font-bold text-[0.7rem] uppercase tracking-widest transition-all hover:bg-gray-50"
                                style="border-color: var(--gold-pale); color: var(--text-light);">
                            Scan Ulang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scanLineMove {
        0% { top: 10%; opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { top: 90%; opacity: 0; }
    }
    .progress-ring__circle {
        transition: stroke-dashoffset 1s cubic-bezier(0.4, 0, 0.2, 1);
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('capture-btn');
    const uploadBtn = document.getElementById('upload-btn');
    const fileUpload = document.getElementById('file-upload');
    const scanLine = document.getElementById('scan-line');
    const previewImg = document.getElementById('preview-overlay');
    const statusText = document.getElementById('status-text');
    const statusDot = document.getElementById('status-dot');
    
    let currentAnalysis = null;
    let currentTempPath = null;

    async function initCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'environment', width: 800, height: 800 }, 
                audio: false 
            });
            video.srcObject = stream;
            statusText.innerText = 'Camera Connected';
        } catch (err) {
            statusText.innerText = 'Camera Error';
            statusDot.style.backgroundColor = '#ef4444';
        }
    }

    uploadBtn.addEventListener('click', () => fileUpload.click());

    fileUpload.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const imageData = event.target.result;
                previewImg.src = imageData;
                previewImg.classList.remove('hidden');
                
                $(uploadBtn).prop('disabled', true).text('PROCESSING...');
                $(captureBtn).prop('disabled', true);
                scanImage(imageData);
            };
            reader.readAsDataURL(file);
        }
    });

    captureBtn.addEventListener('click', async () => {
        if (video.readyState < 2) {
            Swal.fire({ title: 'Gagal', text: 'Kamera belum siap. Mohon tunggu sebentar.', icon: 'warning', confirmButtonColor: '#d4a017' });
            return;
        }

        $(captureBtn).prop('disabled', true).text('ANALYZING...');
        $(uploadBtn).prop('disabled', true);
        
        const context = canvas.getContext('2d');
        // Ensure size is at least something if video is not reporting correctly
        canvas.width = video.videoWidth || 640;
        canvas.height = video.videoHeight || 640;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        const imageData = canvas.toDataURL('image/webp', 0.8);
        scanImage(imageData);
    });

    function scanImage(imageData) {
        const jenis = $('#jenis_mangga').val();
        scanLine.classList.remove('hidden');
        statusText.innerText = 'AI ANALYZING...';

        $.ajax({
            url: "{{ route('pembeli.scan.proses') }}",
            method: "POST",
            data: { _token: "{{ csrf_token() }}", image: imageData, jenis_mangga: jenis },
            success: function(response) {
                scanLine.classList.add('hidden');
                statusText.innerText = 'COMPLETED';
                currentAnalysis = response.analysis;
                currentTempPath = response.temp_path;
                setTimeout(() => { showResults(response.analysis, response.image_url, jenis); }, 500);
            },
            error: function(xhr) {
                scanLine.classList.add('hidden');
                statusText.innerText = 'SYSTEM READY';
                $(captureBtn).prop('disabled', false).html('<span class="material-symbols-outlined text-[24px]">photo_camera</span> Mulai Scan AI');
                $(uploadBtn).prop('disabled', false).html('<span class="material-symbols-outlined text-[18px]">upload_file</span> Upload Gambar');
                previewImg.classList.add('hidden');
                
                const msg = xhr.responseJSON ? xhr.responseJSON.message : 'AI Server Error';
                Swal.fire({ title: 'Gagal', text: msg, icon: 'warning', confirmButtonColor: '#d4a017' });
            }
        });
    }

    function showResults(data, imageUrl, varietas) {
        $('#result-img').attr('src', imageUrl);
        $('#result-varietas').text(varietas);
        $('#result-score').text(data.skor_kesegaran + '%');
        
        let displayCat = data.kategori.replace('_', ' ');
        let advice = "";
        if (data.kategori.includes('busuk')) advice = "Terdeteksi pembusukan! Segera pisahkan agar tidak menular.";
        else if (data.kategori == 'mentah') advice = "Mangga masih mentah. Simpan di suhu ruangan selama 3-5 hari.";
        else if (data.kategori == 'setengah_matang') advice = "Kondisi hampir optimal. Nikmati dalam 1-2 hari.";
        else advice = "Kondisi optimal! Sangat segar dan siap dikonsumsi.";
        
        $('#result-cat').text(displayCat);
        $('#result-advice').text(advice);
        $('#result-acc').text(data.skor_kepercayaan + '% Match');
        $('#result-warna').text(data.persentase_warna + '% Color Index');
        $('#result-size').text(data.panjang_cm + ' cm');
        $('#result-weight').text(data.berat_gr + ' gram');
        
        const circle = document.getElementById('progress-circle');
        const circumference = 42 * 2 * Math.PI;
        circle.style.strokeDashoffset = circumference - (data.skor_kesegaran / 100 * circumference);
        
        $('#results-panel').removeClass('hidden').addClass('animate-in fade-in duration-500');
    }

    $('#simpan-btn').click(function() {
        $(this).prop('disabled', true).text('SAVING...');
        $.ajax({
            url: "{{ route('pembeli.scan.simpan') }}",
            method: "POST",
            data: { _token: "{{ csrf_token() }}", temp_path: currentTempPath, jenis_mangga: $('#jenis_mangga').val(), ...currentAnalysis },
            success: function() {
                Swal.fire({ icon: 'success', title: 'Data Tersimpan', confirmButtonColor: '#d4a017' }).then(() => {
                    window.location.href = "{{ route('pembeli.scan.history') }}";
                });
            }
        });
    });

    $('#scan-ulang-btn, #close-results').click(() => window.location.reload());

    initCamera();
</script>
@endsection
