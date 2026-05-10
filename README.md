# 🥭 Sistem Informasi Tingkat Kesegaran Buah Mangga
## 🏢 Studi Kasus Kabupaten Indramayu (Proyek 3 + Big Data)

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![TensorFlow](https://img.shields.io/badge/TensorFlow-FF6F00?style=for-the-badge&logo=tensorflow&logoColor=white)](https://tensorflow.org)
[![Indramayu](https://img.shields.io/badge/Focus-Indramayu-green?style=for-the-badge)](https://indramayukab.go.id)

---

## 📋 Overview Sistem
Sistem ini dirancang untuk meningkatkan efisiensi dan transparansi dalam industri mangga Kabupaten Indramayu. Menggabungkan teknologi **Computer Vision** untuk penilaian kualitas otomatis dan **Analitik Big Data** untuk memberikan rekomendasi strategis bagi para stakeholder.

### 🎯 Tujuan Utama
*   **Penilaian Otomatis Kesegaran**: Menggunakan model AI (MobileNetV2/ResNet50) untuk mendeteksi kematangan berdasarkan warna, tekstur, dan berat.
*   **Optimalisasi Panen**: Integrasi API Cuaca untuk menentukan waktu panen terbaik guna menjaga kualitas buah.
*   **Digitalisasi Ekosistem**: Transformasi pelaporan manual petani menjadi data digital yang terpusat dan transparan.
*   **Akses Pasar Langsung**: Mempermudah pembeli mendapatkan mangga berkualitas premium langsung dari tangan pertama.

---

## 👥 Stakeholder & Peran
| Role | Deskripsi & Tanggung Jawab |
| :--- | :--- |
| **👨‍💼 Admin** | Pengelola sistem, verifikasi dokumen petani, monitoring anomali data, dan kalibrasi model AI. |
| **🌾 Petani** | Pemilik lahan yang melakukan manajemen data tanam, panen, serta melakukan scanning kesegaran mangga. |
| **🛒 Pembeli** | Pengguna akhir (individu/reseller) yang mencari mangga berdasarkan filter kualitas, jenis, dan lokasi. |

---

## 🚀 Fitur Unggulan

### 1. 🤖 Smart Freshness Scanning (Computer Vision)
Fitur inti yang memungkinkan petani melakukan scanning mangga secara real-time:
*   **Deteksi Warna RGB**: Analisis persentase kematangan (Mentah, Setengah Matang, Matang, Sangat Matang).
*   **Analisis Tekstur & Cacat**: Mendeteksi luka atau bintik penyakit pada permukaan buah.
*   **Confidence Score**: Memberikan tingkat kepastian hasil analisis sistem.

### 2. 📊 Predictive Analytics (Big Data)
Sistem menganalisis data eksternal untuk memberikan rekomendasi:
*   **Harvest Recommendation**: Prediksi waktu panen ideal berdasarkan suhu (20-25°C), kelembaban (60-80%), dan curah hujan.
*   **Yield Prediction**: Estimasi hasil panen berdasarkan riwayat tanam dan kondisi lingkungan.
*   **Market Insight**: Tren harga dan permintaan pasar untuk membantu strategi penjualan.

### 3. 🗺️ GIS-Based Field Management
*   Pemetaan lokasi lahan mangga di 15+ kecamatan di Indramayu.
*   Visualisasi heatmap produktivitas wilayah.
*   Digital Farm Log untuk melacak histori setiap pohon.

---

## 🛠️ Arsitektur Teknis & Tech Stack
Sistem ini dibangun dengan teknologi pilihan untuk menjamin skalabilitas dan performa tinggi:

*   **Backend Framework**: Laravel 11 (PHP 8.2+)
*   **Frontend**: Blade / React (Modern UI/UX)
*   **Database**: MySQL (Relational Data) & Redis (Caching)
*   **AI Engine**: TensorFlow Lite / Python AI Service
*   **Third-Party Services**:
    *   **Weather**: OpenWeatherMap / WeatherAPI / BMKG.
    *   **Payment**: Midtrans / Xendit (Payment Gateway).
    *   **Mapping**: Google Maps API / Leaflet JS.
    *   **Cloud Storage**: AWS S3 / DigitalOcean Spaces (Foto Scan).
    *   **Notification**: Firebase Cloud Messaging (Push Notif) & SendGrid (Email).

---

## 🛣️ Roadmap Pengembangan

### 📍 Phase 1: Foundation (MVP)
*   Autentikasi User & Role Management.
*   Manajemen Lahan & Pelaporan Digital.
*   Integrasi Dasar API Cuaca.

### 📍 Phase 2: AI & Mobile Integration
*   Implementasi Model Computer Vision yang lebih akurat.
*   Aplikasi Mobile (iOS/Android) untuk scanning di lapangan.
*   Integrasi Payment Gateway.

### 📍 Phase 3: Advanced Optimization
*   Implementasi IoT (Sensor Tanah & Kelembaban).
*   Traceability mangga menggunakan QR Code.
*   Analitik Prediktif tingkat lanjut (ARIMA/LSTM).

---

## 📖 Dokumentasi Terkait
Untuk rincian teknis yang lebih dalam, silakan merujuk ke file berikut:
*   📜 [**Sistem.md**](./Sistem.md) - Detail fitur lengkap, alur User Journey, dan Skema Database.
*   🔌 [**API.md**](./API.md) - Daftar lengkap API Service, perbandingan harga, dan rekomendasi stack.

---

## ⚙️ Instalasi (Development)

### 1. Persiapan Aplikasi Wajib
Pastikan di laptop Anda sudah terinstal:
* **PHP** (via XAMPP/Laragon) versi 8.2 atau 8.3
* **Composer** (v2.x)
* **Node.js** (versi 18 LTS / 20 LTS)
* **Python** (versi 3.10, 3.11, atau 3.12). *Sangat Penting: Saat instalasi Python, pastikan Anda mencentang kotak "Add Python to PATH".*

### 2. Clone & Install Dependensi Web
Buka Terminal/CMD, lalu jalankan secara berurutan:
```bash
git clone https://github.com/Muhfaizr21/Sistem-Informasi-Tingkat-Kesegaran-buah-Mangga.git
cd Sistem-Informasi-Tingkat-Kesegaran-buah-Mangga
composer install
npm install
```

### 3. Konfigurasi Environment & Database
1. Duplikat file environment:
   ```bash
   copy .env.example .env  # (Di Windows)
   cp .env.example .env    # (Di Mac/Linux)
   ```
2. Buat App Key baru:
   ```bash
   php artisan key:generate
   ```
3. Buka **XAMPP/Laragon** dan pastikan MySQL berjalan.
4. Buka phpMyAdmin, buat database dengan nama **`mangga`**.
5. Jalankan migrasi dan seeder untuk tabel:
   ```bash
   php artisan migrate:fresh --seed
   ```
6. Hubungkan folder storage gambar:
   ```bash
   php artisan storage:link
   ```

### 4. Install Dependensi Python (AI Scanner)
Pindah ke folder script AI dan install library yang dibutuhkan melalui `pip`:
```bash
cd storage/app/ml_scripts
pip install -r requirements.txt
cd ../../../
```

### 5. Jalankan Semua Server Sekaligus! 🚀
Kembali ke folder root project, lalu jalankan perintah ini:
```bash
npm run start
```
*(Perintah ini akan menggunakan package `concurrently` untuk otomatis membuka 3 server: Laravel di Port 8000, Vite untuk Frontend, dan API AI Python di Port 8001)*. 

Project siap diakses di `http://localhost:8000`!

---
**© 2024 - Sistem Informasi Kesegaran Mangga Indramayu**
