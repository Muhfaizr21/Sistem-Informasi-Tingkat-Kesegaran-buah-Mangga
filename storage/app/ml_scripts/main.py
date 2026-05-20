import os
import time
from fastapi import FastAPI, File, UploadFile, Form
from fastapi.responses import JSONResponse
from contextlib import asynccontextmanager

# Inisialisasi status modul
HAS_CV = False
model = None

try:
    import cv2
    import numpy as np
    import joblib
    from skimage.feature import graycomatrix, graycoprops
    HAS_CV = True
except ImportError:
    pass

def tentukan_kategori(skor):
    if skor < 45: 
        return 'busuk'
    if skor < 50:
        return 'busuk_awal'
    if skor < 68:
        return 'mentah'
    if skor < 85: 
        return 'setengah_matang'
    if skor < 95: 
        return 'matang'
    return 'sangat_matang'

def tentukan_rekomendasi(kategori):
    if kategori == 'matang': return 'siap_jual'
    if kategori == 'sangat_matang': return 'siap_jual'
    if kategori == 'setengah_matang': return 'perlu_penyimpanan'
    return 'belum_siap'

def hitung_skor_aroma_dari_fitur(persentase_warna, skor_tekstur, skor_bentuk):
    """Hitung skor aroma berdasarkan fitur visual (korelasi empiris)"""
    # Mangga matang sempurna biasanya wangi: warna kuning + tekstur lembut
    skor_dasar = (persentase_warna * 0.5) + (skor_tekstur * 0.3) + (skor_bentuk * 0.2)
    # Tambah bonus jika di range optimal (70-90% warna kuning)
    if 70 <= persentase_warna <= 90:
        skor_dasar += 8
    # Kurangi jika terlalu matang (>90% kuning, aroma mulai berkurang/fermentasi)
    elif persentase_warna > 90:
        skor_dasar -= 5
    return min(100, max(40, int(skor_dasar)))

def hitung_skor_kepercayaan(persentase_warna, skor_tekstur, skor_bentuk, is_model_active=False):
    """Hitung confidence score dari konsistensi fitur"""
    # Makin konsisten antar fitur, makin tinggi confidence
    total = persentase_warna + skor_tekstur + skor_bentuk
    rata2 = total / 3
    
    # Hitung deviasi dari rata-rata
    deviasi = (abs(persentase_warna - rata2) + abs(skor_tekstur - rata2) + abs(skor_bentuk - rata2)) / 3
    konsistensi = max(0, 100 - deviasi)
    
    # Model AI lebih terpercaya
    if is_model_active:
        return min(99, int(70 + konsistensi * 0.3))
    else:
        return min(95, int(60 + konsistensi * 0.35))

def deteksi_apakah_mangga(image_bytes):
    """Deteksi apakah gambar mengandung mangga menggunakan contour analysis"""
    if not HAS_CV:
        return True  # Jika CV tidak ada, asumsikan valid
        
    try:
        nparr = np.frombuffer(image_bytes, np.uint8)
        img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
        
        if img is None:
            return False
            
        img_hsv = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
        img_gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        
        # Deteksi warna dominan (hijau, kuning, oranye - warna mangga)
        mask_hijau = cv2.inRange(img_hsv, (35, 40, 40), (85, 255, 255))
        mask_kuning = cv2.inRange(img_hsv, (15, 50, 50), (35, 255, 255))
        mask_oranye = cv2.inRange(img_hsv, (5, 50, 50), (15, 255, 255))
        
        total_pixel_mangga = np.count_nonzero(mask_hijau) + np.count_nonzero(mask_kuning) + np.count_nonzero(mask_oranye)
        total_pixel = img.shape[0] * img.shape[1]
        
        rasio_warna_mangga = total_pixel_mangga / total_pixel
        
        # Deteksi bentuk (apakah berbentuk oval/bulat)
        edges = cv2.Canny(img_gray, 50, 150)
        contours, _ = cv2.findContours(edges, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
        
        if not contours:
            return False
            
        # Cari kontur terbesar
        c = max(contours, key=cv2.contourArea)
        area = cv2.contourArea(c)
        img_area = img.shape[0] * img.shape[1]
        
        # Kontur harus menempati minimal 30% gambar
        if area / img_area < 0.3:
            return False
            
        # Hitung circularity (mangga cenderung oval, tidak terlalu melingkar sempurna)
        perimeter = cv2.arcLength(c, True)
        if perimeter == 0:
            return False
        circularity = 4 * np.pi * area / (perimeter * perimeter)
        
        # Mangga biasanya memiliki circularity antara 0.5 - 0.8 (tidak terlalu bulat)
        is_mango_shape = 0.4 < circularity < 0.85
        
        # Minimal 40% gambar harus berwarna seperti mangga
        is_mango_color = rasio_warna_mangga > 0.4
        
        return is_mango_color and is_mango_shape
        
    except Exception as e:
        print(f"Error deteksi objek: {e}")
        return True  # Jika error, asumsikan valid agar tidak mengganggu user

def ekstraksi_fitur(image_bytes, jenis_mangga="Harum Manis"):
    if not HAS_CV:
        return None
        
    # Parameter kematangan per varietas (sebagai acuan fitur)
    ripeness_params = {
        'Harum Manis': {'hue_range': (15, 45), 'expected_shape': 'lonjong'},
        'Gedong Gincu': {'hue_range': (0, 15), 'red_dominant': True, 'expected_shape': 'bulat'},
        'Manalagi': {'hue_range': (35, 85), 'green_remains': True, 'expected_shape': 'bulat'},
        'Golek': {'hue_range': (15, 45), 'expected_shape': 'lonjong_sangat'},
        'Cengkir': {'hue_range': (15, 45), 'expected_shape': 'bulat'},
        'Kweni': {'hue_range': (15, 45), 'expected_shape': 'kecil'},
        'Apel': {'hue_range': (15, 85), 'expected_shape': 'bulat_sempurna'},
        'Madu': {'hue_range': (15, 45), 'expected_shape': 'lonjong'},
        'Podang': {'hue_range': (15, 45), 'expected_shape': 'lonjong'},
    }
    
    params = ripeness_params.get(jenis_mangga, ripeness_params['Harum Manis'])
        
    try:
        nparr = np.frombuffer(image_bytes, np.uint8)
        img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
        
        if img is None:
            return None
            
        # Normalisasi pencahayaan menggunakan CLAHE (Contrast Limited Adaptive Histogram Equalization)
        img_lab = cv2.cvtColor(img, cv2.COLOR_BGR2LAB)
        l, a, b = cv2.split(img_lab)
        clahe = cv2.createCLAHE(clipLimit=2.0, tileGridSize=(8,8))
        l = clahe.apply(l)
        img_lab = cv2.merge([l, a, b])
        img = cv2.cvtColor(img_lab, cv2.COLOR_LAB2BGR)
            
        img_hsv = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
        img_gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        
        # EKSTRAKSI WARNA
        h, s, v = cv2.split(img_hsv)
        mean_h = np.mean(h)
        mean_s = np.mean(s)
        mean_v = np.mean(v)
        
        hue_min, hue_max = params.get('hue_range', (15, 45))
        mask_matang = cv2.inRange(img_hsv, (hue_min, 50, 50), (hue_max, 255, 255))
        
        if params.get('red_dominant'):
            # Menangkap warna merah yang melewati batas hue 180 kembali ke 0
            mask_merah = cv2.inRange(img_hsv, (170, 50, 50), (179, 255, 255))
            mask_matang = cv2.bitwise_or(mask_matang, mask_merah)
            
        persentase_warna = (np.count_nonzero(mask_matang) / (img.shape[0] * img.shape[1])) * 100
        
        mask_hijau = cv2.inRange(img_hsv, (45, 40, 40), (85, 255, 255))
        persentase_hijau = (np.count_nonzero(mask_hijau) / (img.shape[0] * img.shape[1])) * 100
        
        mask_gelap = cv2.inRange(img_hsv, (0, 0, 0), (180, 255, 50))
        persentase_gelap = (np.count_nonzero(mask_gelap) / (img.shape[0] * img.shape[1])) * 100
        
        # Perbaiki threshold warna untuk Gedong Gincu setengah matang
        if jenis_mangga == 'Gedong Gincu':
            if persentase_gelap < 8 and 15 < persentase_warna < 45:
                persentase_warna = max(persentase_warna, 35)
                
        # EKSTRAKSI TEKSTUR (DETERMINISTIK)
        glcm = graycomatrix(img_gray, distances=[1], angles=[0], levels=256, symmetric=True, normed=True)
        kontras = graycoprops(glcm, 'contrast')[0, 0]
        homogenitas = graycoprops(glcm, 'homogeneity')[0, 0]
        
        # Normalisasi kontras (biasanya 0-500)
        skor_kontras = max(0, 100 - (kontras / 5))
        skor_homogen = homogenitas * 100
        skor_tekstur = int((skor_kontras * 0.4) + (skor_homogen * 0.6))
        
        # EKSTRAKSI BENTUK & UKURAN (DETERMINISTIK)
        edges = cv2.Canny(img_gray, 50, 150)
        contours, _ = cv2.findContours(edges, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
        
        panjang_cm, lebar_cm = 12.0, 7.0  # Default
        skor_bentuk = 85
        
        if contours:
            c = max(contours, key=cv2.contourArea)
            x, y, w, h_box = cv2.boundingRect(c)
            px_to_cm = 0.026  # Asumsi 1px = 0.026cm (kalibrasi untuk jarak 30cm)
            panjang_cm = round(max(w, h_box) * px_to_cm, 1)
            lebar_cm = round(min(w, h_box) * px_to_cm, 1)
            
            # Hitung skor bentuk deterministik
            aspect_ratio = max(w, h_box) / min(w, h_box) if min(w, h_box) > 0 else 1
            area = cv2.contourArea(c)
            rect_area = w * h_box
            solidity = area / rect_area if rect_area > 0 else 0
            
            perimeter = cv2.arcLength(c, True)
            roundness = (4 * np.pi * area) / (perimeter * perimeter) if perimeter > 0 else 0
            
            skor_aspect = max(0, 100 - abs(aspect_ratio - 1.2) * 50)
            skor_bentuk = int((skor_aspect * 0.3) + (solidity * 100 * 0.4) + (roundness * 100 * 0.3))
            skor_bentuk = min(100, max(0, skor_bentuk))
            
        # Hitung berat berdasarkan densitas varietas
        volume = panjang_cm * lebar_cm * lebar_cm * 0.5236
        densitas = {
            'Harum Manis': 1.02,
            'Gedong Gincu': 0.95,
            'Arum Manis': 1.08,
            'default': 1.03
        }
        dens = densitas.get(jenis_mangga, densitas['default'])
        berat_gr = int(volume * dens)
        berat_gr = min(max(berat_gr, 150), 800)
        
        return {
            'persentase_warna': round(persentase_warna, 1),
            'persentase_hijau': round(persentase_hijau, 1),
            'persentase_gelap': round(persentase_gelap, 1),
            'skor_tekstur': round(skor_tekstur, 1),
            'skor_bentuk': skor_bentuk,
            'panjang_cm': panjang_cm,
            'berat_gr': berat_gr,
            'features_array': [mean_h, mean_s, mean_v, kontras, homogenitas, panjang_cm, berat_gr]
        }
    except Exception as e:
        print(f"Error ekstraksi fitur: {e}")
        return None

def hitung_skor_fallback(data_fitur):
    """Fallback deterministik tanpa random"""
    p_warna = data_fitur['persentase_warna']
    p_hijau = data_fitur['persentase_hijau']
    p_gelap = data_fitur['persentase_gelap']
    homogenitas = data_fitur['features_array'][4]
    
    # PRIORITAS: Deteksi busuk hanya jika gelap SIGNIFIKAN
    if p_gelap > 20:  # Naikkan threshold dari 15 ke 20
        skor = max(15, 20 + (p_gelap * 0.2))
        skor = min(skor, 45)
    elif p_gelap > 10:  # Area gelap sedang (mungkin memar)
        skor = 45 + (p_warna * 0.2)
        skor = min(skor, 65)
    elif p_hijau > p_warna * 1.5:
        skor = 50 + (p_warna * 0.15)
        skor = min(skor, 68)
    elif 30 <= p_warna <= 60 and homogenitas > 0.45:
        # SETENGAH MATANG: Warna cukup, tekstur mulai lunak
        skor = 65 + (p_warna * 0.2)
        skor = min(skor, 82)
    elif p_warna > 40 and homogenitas > 0.55:
        skor = 75 + (p_warna * 0.12)
        skor = min(skor, 98)
    else:
        skor = 55 + (p_warna * 0.25)
        skor = min(skor, 85)
    
    return int(skor)

# Lifespan context manager
@asynccontextmanager
async def lifespan(app: FastAPI):
    global model
    model_path = os.path.join(os.path.dirname(__file__), 'random_forest_model.pkl')
    if HAS_CV and os.path.exists(model_path):
        try:
            # Menggunakan mmap_mode='r' untuk loading lebih efisien
            model = joblib.load(model_path, mmap_mode='r')
            print("INFO: Random Forest Model dimuat ke memori dengan sukses.")
        except Exception as e:
            print(f"WARNING: Gagal memuat model. Error: {e}")
            print("Menggunakan mode Fallback deterministik.")
    else:
        print("WARNING: Model tidak ditemukan. Menggunakan mode Fallback deterministik.")
    yield
    model = None

app = FastAPI(title="Mango Scanner API", lifespan=lifespan)

@app.post("/api/detect-mango")
async def detect_mango(image: UploadFile = File(...)):
    """Endpoint untuk deteksi apakah gambar mengandung mangga"""
    image_bytes = await image.read()
    is_mango = deteksi_apakah_mangga(image_bytes)
    
    return JSONResponse(content={
        'is_mango': is_mango,
        'message': 'Mangga terdeteksi' if is_mango else 'Objek bukan mangga'
    })

@app.post("/api/scan")
async def scan_mangga(
    image: UploadFile = File(...),
    jenis_mangga: str = Form("Harum Manis")
):
    image_bytes = await image.read()
    data_fitur = ekstraksi_fitur(image_bytes, jenis_mangga)
    
    # CASE 1: Gagal ekstraksi fitur (gambar rusak/bukan mangga)
    if data_fitur is None:
        return JSONResponse(content={
            'success': False,
            'message': 'Gambar tidak valid atau tidak terdeteksi sebagai mangga',
            'skor_kesegaran': 0,
            'kategori': 'tidak_terdeteksi',
            'rekomendasi': 'ulangi_scan',
            'status_engine': 'Error: CV gagal memproses gambar'
        }, status_code=422)
    
    # CASE 2: Model Random Forest tersedia dan aktif
    if model is not None:
        try:
            skor_prediksi = model.predict([data_fitur['features_array']])[0]
            
            # KOREKSI PINTAR (BACKGROUND RAMAI / TUMPUKAN MANGGA):
            # Jika AI memprediksi busuk (< 50) TETAPI mendeteksi persentase warna matang yang signifikan (> 20%),
            # ini berarti AI tertipu oleh tekstur daun atau bayangan antar mangga (yang menyebabkan GLCM kontras tinggi).
            # Kita override prediksinya mengandalkan kekuatan warnanya.
            if skor_prediksi < 50 and data_fitur['persentase_warna'] > 20:
                skor_prediksi = 60 + (data_fitur['persentase_warna'] * 0.8)
                
            skor_kesegaran = int(min(max(skor_prediksi, 0), 100))
            is_model_active = True
        except Exception as e:
            # Fallback jika model error
            skor_kesegaran = hitung_skor_fallback(data_fitur)
            is_model_active = False
    else:
        # CASE 3: Model tidak tersedia, pakai fallback cerdas
        skor_kesegaran = hitung_skor_fallback(data_fitur)
        is_model_active = False
    
    # Ambil semua fitur dari hasil ekstraksi
    persentase_warna = data_fitur['persentase_warna']
    skor_tekstur = data_fitur['skor_tekstur']
    skor_bentuk = data_fitur['skor_bentuk']
    panjang_cm = data_fitur['panjang_cm']
    berat_gr = data_fitur['berat_gr']
    
    # Hitung skor aroma dan kepercayaan (TANPA RANDOM!)
    skor_aroma = hitung_skor_aroma_dari_fitur(persentase_warna, skor_tekstur, skor_bentuk)
    skor_kepercayaan = hitung_skor_kepercayaan(persentase_warna, skor_tekstur, skor_bentuk, is_model_active)
    
    kategori = tentukan_kategori(skor_kesegaran)
    rekomendasi = tentukan_rekomendasi(kategori)
    
    estimasi_ukuran = f"{panjang_cm} cm / {berat_gr} gr"
    
    status_engine = 'AI Random Forest Aktif' if is_model_active else 'Fallback Deterministik (Tanpa Model)'
    
    hasil = {
        'skor_kesegaran': skor_kesegaran,
        'kategori': kategori,
        'rekomendasi': rekomendasi,
        'skor_kepercayaan': skor_kepercayaan,
        'persentase_warna': persentase_warna,
        'skor_tekstur': skor_tekstur,
        'skor_bentuk': skor_bentuk,
        'panjang_cm': panjang_cm,
        'berat_gr': berat_gr,
        'estimasi_ukuran': estimasi_ukuran,
        'skor_aroma': skor_aroma,
        'jenis_terdeteksi': jenis_mangga,
        'status_engine': f"{status_engine} (FastAPI)"
    }
    
    return JSONResponse(content=hasil)