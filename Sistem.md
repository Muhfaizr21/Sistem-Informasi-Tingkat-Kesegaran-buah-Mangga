# Sistem Informasi Tingkat Kesegaran Buah Mangga
## Studi Kasus Kabupaten Indramayu (Proyek 3 + Big Data)

---

## 📋 Daftar Isi
1. [Overview Sistem](#overview-sistem)
2. [Fitur Autentikasi](#fitur-autentikasi)
3. [Fitur Admin](#fitur-admin)
4. [Fitur Petani](#fitur-petani)
5. [Fitur Pembeli](#fitur-pembeli)
6. [Integrasi Big Data](#integrasi-big-data)
7. [Arsitektur Teknis](#arsitektur-teknis)

---

## 🎯 Overview Sistem

### Tujuan Sistem
Sistem ini dirancang untuk meningkatkan efisiensi dan transparansi dalam industri mangga Kabupaten Indramayu dengan:
- **Penilaian Otomatis Kesegaran** menggunakan teknologi computer vision
- **Manajemen Data Produksi** real-time untuk petani
- **Akses Informasi Pasar** untuk pembeli
- **Rekomendasi Berbasis Data** menggunakan API cuaca dan analitik big data

### Stakeholder Utama
| Role | Deskripsi |
|------|-----------|
| **Admin** | Mengelola sistem, verifikasi data, monitoring |
| **Petani** | Menginput data lahan, mencatat panen/tanam, cek kesegaran |
| **Pembeli** | Melihat ketersediaan, kualitas, dan lokasi mangga |

---

## 🔐 Fitur Autentikasi

### 1. Sistem Login & Sign Up
```
Fitur Umum:
├── Login dengan Email/Username + Password
├── Sign Up dengan Validasi Data
│   ├── Verifikasi Email (OTP)
│   ├── Pilih Role (Admin/Petani/Pembeli)
│   └── Validasi NIK (untuk Petani)
├── Lupa Password dengan Reset Link
├── Two-Factor Authentication (2FA) untuk Admin
├── Session Management & Auto-Logout
└── Integrasi Social Login (Google/Facebook) - Optional
```

### 2. Keamanan Autentikasi
```
Implementasi:
├── Password Hashing (bcrypt)
├── JWT Token dengan Expiry
├── Refresh Token untuk Extended Session
├── CSRF Protection
├── Rate Limiting Login (5x percobaan = lockout 15 menit)
└── Audit Log untuk semua login/logout
```

---

## 👨‍💼 Fitur Admin

### 1. Dashboard Admin
```
Elemen Dashboard:
├── Statistik Keseluruhan
│   ├── Total Petani Terdaftar
│   ├── Total Pembeli Terdaftar
│   ├── Total Panen (ton/bulan)
│   ├── Total Transaksi Penjualan
│   └── Rata-rata Kualitas Mangga
├── Grafik Trend
│   ├── Produksi Harian/Mingguan
│   ├── Kualitas Mangga Over Time
│   └── Aktivitas Pengguna
└── Alert & Notifikasi
    ├── Data Anomali
    └── Verifikasi Pending
```

### 2. Manajemen Pengguna
```
Fitur:
├── Daftar Pengguna (Petani & Pembeli)
│   ├── Filter by Role
│   ├── Search & Sort
│   └── Status (Active/Inactive/Banned)
├── Verifikasi Akun Petani
│   ├── Cek Dokumen (KTP, Sertifikat Lahan)
│   ├── Approve/Reject
│   └── Edit Data Petani
├── Manajemen Role & Permission
│   └── Assign/Revoke Rights
├── Aktivasi/Deaktivasi Akun
└── Hapus User (dengan soft delete)
```

### 3. Manajemen Wilayah & Lahan
```
Fitur:
├── Data Master Wilayah Indramayu
│   ├── Kecamatan (15 kecamatan)
│   ├── Kelurahan/Desa
│   └── Koordinat GPS
├── Pemetaan Lahan Mangga
│   ├── Verifikasi Lokasi Petani
│   ├── Luas Lahan per Petani
│   ├── Jenis Mangga yang Ditanam
│   └── Visualisasi Peta GIS
├── Update Data Lahan
│   └── Perubahan Status Lahan (Aktif/Tidak Aktif)
└── Report Lahan Berdasarkan Area
    ├── Total Lahan per Kecamatan
    └── Produktivitas Lahan
```

### 4. Monitoring Kualitas & Kesegaran
```
Fitur:
├── Review Hasil Scan Kesegaran
│   ├── Lihat Riwayat Scan Semua Petani
│   ├── Analisis Trend Kualitas
│   └── Deteksi Anomali Hasil Scan
├── Verifikasi Data Scan Manual
│   ├── Bandingkan AI vs Manual Check
│   └── Approve/Reject Hasil
├── Kalibrasi Sistem AI
│   ├── Update Training Data
│   └── Improve Accuracy Model
└── Quality Control Report
    ├── Tingkat Kesegaran per Petani
    ├── Tingkat Kesegaran per Jenis Mangga
    └── Export Report
```

### 5. Manajemen Laporan
```
Fitur:
├── Review Laporan Panen Petani
│   ├── Filter by Tanggal/Petani/Lokasi
│   ├── Verifikasi Data Inputan
│   └── Approve/Reject
├── Review Laporan Tanam Petani
│   ├── Cek Konsistensi dengan Lahan
│   └── Approve/Reject
├── Laporan Penjualan
│   ├── Lihat Semua Transaksi
│   ├── Filter by Pembeli/Petani/Tanggal
│   └── Analisis Omset
└── Generate Report Otomatis
    ├── Daily/Weekly/Monthly Report
    ├── Export ke PDF/Excel
    └── Email Notifikasi Stakeholder
```

### 6. Manajemen API & Integrasi
```
Fitur:
├── Konfigurasi API Cuaca
│   ├── API Key Management
│   ├── Update Endpoint
│   └── Test Connection
├── Monitor API Usage
│   ├── Hit Rate per Hari
│   ├── Error Tracking
│   └── Cost Monitoring (jika berbayar)
├── Integrasi External Services
│   └── Maintenance & Logs
└── Backup & Recovery
    ├── Database Backup Schedule
    ├── Data Recovery Options
    └── Disaster Recovery Plan
```

### 7. Pengaturan Sistem
```
Fitur:
├── Konfigurasi Umum
│   ├── Nama Sistem & Logo
│   ├── Timezone & Locale
│   └── Email Configuration
├── Pengaturan Notifikasi
│   ├── Email Alert
│   ├── SMS Alert (Optional)
│   └── Push Notification
├── Manajemen File
│   ├── Upload Ukuran Max
│   ├── Allowed File Types
│   └── Storage Management
└── Log & Audit
    ├── Activity Log semua User
    ├── Error Log
    ├── Access Log
    └── Compliance Report
```

---

## 🌾 Fitur Petani

### 1. Dashboard Petani
```
Elemen Dashboard:
├── Ringkasan Lahan
│   ├── Total Lahan (Ha)
│   ├── Jenis Mangga yang Ditanam
│   ├── Status Lahan (Produktif/Persiapan)
│   └── Visualisasi Lokasi Lahan
├── Statistik Panen
│   ├── Total Panen Bulan Ini (Kg)
│   ├── Rata-rata Kualitas Kesegaran
│   ├── Grafik Trend Panen
│   └── Perbandingan dengan Bulan Lalu
├── Status Penjualan
│   ├── Mangga Tersedia (Kg)
│   ├── Mangga Terjual (Kg)
│   ├── Pendapatan Bulan Ini
│   └── Daftar Pembeli Aktif
└── Alert & Rekomendasi
    ├── Rekomendasi Panen (dari AI cuaca)
    ├── Rekomendasi Tanam (dari AI cuaca)
    └── Notifikasi Penting
```

### 2. Manajemen Data Lahan
```
Fitur:
├── Input Data Lahan
│   ├── Nama Lahan
│   ├── Lokasi (GPS Coordinates)
│   ├── Luas (Hectares)
│   ├── Jenis Mangga (Dropdown: Harum Manis, Manalagi, Arumanis, etc)
│   ├── Jumlah Pohon
│   ├── Tahun Tanam
│   ├── Status (Produktif/Persiapan/Tidak Aktif)
│   └── Foto Lahan (min 3 foto)
├── Edit Data Lahan
│   ├── Update Informasi
│   └── Ganti Foto
├── Lihat Daftar Lahan
│   ├── List View dengan Filter
│   ├── Map View (Google Maps/Leaflet)
│   └── Detail per Lahan
└── Hapus Lahan (Archive)
    └── Soft Delete untuk Historical Data
```

### 3. Sistem Cek Kesegaran Real-Time (Fitur Utama)
```
Fitur Scanning:
├── Akses Camera/Webcam
│   ├── Request Permission
│   ├── Live Preview
│   └── Quality Check (Pencahayaan, Fokus)
├── Input Parameter Manual
│   ├── Berat Mangga (gram) - Timbangan Digital Connect
│   ├── Diamater (cm)
│   └── Jenis Mangga (dropdown)
├── Scan Otomatis dengan Computer Vision
│   ├── Deteksi Warna RGB
│   │   ├── Green: Mentah (0-25%)
│   │   ├── Yellow-Green: Setengah Matang (26-50%)
│   │   ├── Yellow: Matang (51-75%)
│   │   └── Orange-Yellow: Sangat Matang (76-100%)
│   ├── Analisis Tekstur Permukaan
│   │   ├── Smoothness
│   │   ├── Defect Detection (cacat/luka)
│   │   └── Disease Spots Detection
│   ├── Estimasi Berat dengan Weight Prediction Model
│   └── Analisis Keseluruhan
└── Output Hasil Scan
    ├── Persentase Kesegaran (%)
    │   ├── Kalkulasi: 40% Warna + 30% Berat + 20% Tekstur + 10% Defect
    │   └── Confidence Score
    ├── Rekomendasi Status
    │   ├── Siap Jual (>70%)
    │   ├── Perlu Penyimpanan (50-70%)
    │   └── Belum Siap (<50%)
    ├── Simpan Data Scan
    │   ├── Foto Asli
    │   ├── Hasil Analisis
    │   ├── Timestamp
    │   └── ID Batch Mangga
    └── Export Data
        ├── CSV per Batch
        └── Report Harian
```

### 4. Laporan Panen
```
Fitur:
├── Input Laporan Panen
│   ├── Pilih Lahan
│   ├── Tanggal Panen
│   ├── Jumlah Panen (Kg)
│   ├── Jenis Mangga
│   ├── Kondisi Cuaca (manual input)
│   ├── Catatan Khusus
│   └── Foto Hasil Panen
├── Edit Laporan Panen
│   ├── Update Data sebelum verifikasi
│   └── Add/Remove Foto
├── List Laporan Panen
│   ├── Filter by Tanggal/Lahan
│   ├── Status (Draft/Submitted/Verified)
│   └── Detail View
├── Verifikasi oleh Admin
│   └── Notifikasi Status Verifikasi
└── Statistik Panen
    ├── Total Panen (Kg)
    ├── Rata-rata per Lahan
    ├── Trend Produktivitas
    └── Prediksi Panen Musim Depan
```

### 5. Laporan Tanam
```
Fitur:
├── Input Laporan Tanam
│   ├── Pilih Lahan
│   ├── Tanggal Tanam
│   ├── Jumlah Bibit (pohon)
│   ├── Jenis Bibit (dropdown)
│   ├── Biaya Tanam (Rp)
│   ├── Catatan Proses Tanam
│   └── Foto Dokumentasi
├── Edit Laporan Tanam
│   ├── Update Sebelum Verified
│   └── Add/Remove Foto
├── List Laporan Tanam
│   ├── Filter by Tanggal/Lahan
│   ├── Status Timeline
│   └── Detail View
├── Verifikasi oleh Admin
│   └── Status Update Notification
└── Prediksi Hasil Tanam
    ├── Estimasi Panen (berdasarkan jenis & umur)
    ├── Estimasi Produktivitas
    └── Timeline Panen (diestimasi)
```

### 6. Wilayah Produksi & Data Lahan
```
Fitur:
├── Visualisasi Peta Lahan
│   ├── Google Maps / Leaflet Integration
│   ├── Marker Lokasi Lahan
│   ├── Cluster View untuk Multiple Lahan
│   ├── Heatmap Produktivitas
│   └── Click untuk Detail Lahan
├── Data Lahan Terstruktur
│   ├── Tabel List Lahan
│   ├── Filter by Jenis Mangga
│   ├── Filter by Status
│   └── Sort by Produktivitas
├── Detail Lahan
│   ├── Informasi Dasar
│   ├── Foto Lahan
│   ├── Riwayat Panen
│   ├── Riwayat Tanam
│   └── Performa Lahan (Kg/Ha/Tahun)
├── Laporan Wilayah
│   ├── Ringkasan Semua Lahan
│   ├── Total Produksi per Jenis
│   └── Export Report
└── Geo-Analytics
    ├── Produktivitas per Area
    ├── Kualitas per Area
    └── Cuaca Impact Analysis
```

### 7. Profil Petani
```
Fitur:
├── Informasi Personal
│   ├── Nama Lengkap
│   ├── NIK (tidak bisa diubah)
│   ├── No Telepon
│   ├── Email
│   ├── Alamat Rumah
│   ├── Bank Account untuk Pembayaran
│   └── Foto Profil
├── Informasi Usaha
│   ├── Pengalaman Bertani (tahun)
│   ├── Sertifikasi (jika ada)
│   ├── Anggota Kelompok Tani (dropdown)
│   └── Catatan Tambahan
├── Edit Profil
│   ├── Update Data Personal
│   ├── Update Bank Account
│   └── Change Password
├── Verifikasi Profil
│   ├── Status Verifikasi Admin
│   ├── Upload Dokumen Pendukung
│   │   ├── KTP
│   │   ├── Sertifikat Lahan
│   │   └── Surat Keterangan Petani
│   └── Request Verifikasi Ulang
└── Statistik Profil
    ├── Rating dari Pembeli
    ├── Review & Testimoni
    └── Track Record Penjualan
```

### 8. Rekomendasi & Alert (Big Data Integration)
```
Fitur:
├── Rekomendasi Panen
│   ├── Analisis Cuaca Real-time (API Cuaca)
│   ├── Optimal Harvest Time
│   │   ├── Temperature Range: 20-25°C ideal
│   │   ├── Humidity: 60-80%
│   │   ├── Avoid High Rain Days
│   │   └── Best Time: Early Morning
│   ├── Historical Pattern Analysis
│   │   └── Kapan musim panen optimal di wilayah Indramayu
│   ├── Predictive Model
│   │   ├── Machine Learning Model
│   │   └── Prediction Accuracy: ±3 hari
│   └── Notifikasi Alert
│       ├── "Cuaca Optimal untuk Panen Hari Ini"
│       ├── Email + Push Notification
│       └── 48 Jam Sebelumnya
├── Rekomendasi Tanam
│   ├── Seasonal Analysis
│   │   ├── Best Planting Season per Jenis
│   │   └── Avoid Extreme Weather Periods
│   ├── Rainfall Pattern
│   │   ├── Water Availability Analysis
│   │   └── Irrigation Planning
│   ├── Cuaca Forecast 14 Hari
│   │   └── Risk Assessment
│   └── Personalized Recommendation
│       ├── Based on Petani History
│       ├── Success Rate Petani Serupa
│       └── Timing Recommendation
├── Alert Cuaca Ekstrem
│   ├── Heavy Rain Warning
│   ├── Drought Alert
│   ├── Temperature Extreme
│   └── Disease Risk Alert
└── Historical Insights
    ├── Data Panen Historis
    ├── Korelasi Cuaca & Hasil Panen
    └── Trend Analysis
```

---

## 🛒 Fitur Pembeli

### 1. Dashboard Pembeli
```
Elemen Dashboard:
├── Ringkasan Aktivitas
│   ├── Pesanan Aktif
│   ├── Pesanan Selesai (Bulan Ini)
│   ├── Total Pengeluaran (Bulan Ini)
│   └── Pembeli Regular (Sering Transaksi)
├── Rekomendasi Produk
│   ├── Mangga Terbaik (Berdasarkan Kualitas)
│   ├── Promo & Diskon
│   └── Produk Terbaru
├── Daftar Pembeli Favorit (Saved Sellers)
├── Status Pengiriman
│   ├── Pesanan dalam Proses
│   ├── Sedang Dikemas
│   └── Dalam Perjalanan
└── Quick Action
    ├── Browse Mangga
    └── Buat Pesanan
```

### 2. Browse & Search Mangga
```
Fitur:
├── Katalog Mangga
│   ├── Filter by Jenis Mangga
│   │   ├── Harum Manis
│   │   ├── Manalagi
│   │   ├── Arumanis
│   │   ├── Gedong
│   │   └── Lainnya
│   ├── Filter by Tingkat Kesegaran
│   │   ├── Mentah (0-25%)
│   │   ├── Setengah Matang (26-50%)
│   │   ├── Matang (51-75%)
│   │   └── Sangat Matang (76-100%)
│   ├── Filter by Lokasi Petani
│   │   ├── Kecamatan (dropdown)
│   │   └── Radius Pencarian (Km)
│   ├── Filter by Harga (Rp)
│   │   └── Range Slider
│   ├── Sort Options
│   │   ├── Harga Terendah
│   │   ├── Kesegaran Terbaik
│   │   ├── Rating Petani
│   │   └── Terbaru
│   └── Search Bar
│       ├── by Nama Petani
│       ├── by Jenis Mangga
│       └── by Lokasi
├── Detail Produk Mangga
│   ├── Info Mangga
│   │   ├── Jenis
│   │   ├── Kesegaran (%)
│   │   ├── Berat/Size
│   │   ├── Harga per Kg
│   │   ├── Stok Tersedia
│   │   └── Minimum Order
│   ├── Foto Mangga
│   │   ├── Hasil Scan (Asli)
│   │   └── Gallery (Multiple Angles)
│   ├── Informasi Petani
│   │   ├── Nama Petani
│   │   ├── Lokasi Lahan (Peta)
│   │   ├── Rating & Review
│   │   ├── Pengalaman
│   │   └── Contact Information
│   ├── Spesifikasi Teknis
│   │   ├── Date Harvested
│   │   ├── Storage Temperature
│   │   ├── Expected Shelf Life
│   │   └── Handling Instructions
│   └── Review & Rating
│       ├── User Reviews
│       ├── Photo Reviews
│       └── Rating (1-5 Star)
└── Add to Cart / Wishlist
```

### 3. Sistem Pemesanan & Checkout
```
Fitur:
├── Shopping Cart
│   ├── List Item Terpilih
│   ├── Edit Jumlah per Item
│   ├── Hapus Item
│   ├── Save for Later (Wishlist)
│   ├── Calculate Total
│   │   ├── Subtotal
│   │   ├── Delivery Cost
│   │   ├── Discount/Coupon
│   │   └── Total Final
│   └── Proceed to Checkout
├── Checkout Process
│   ├── Confirm Shipping Address
│   │   ├── Select dari Saved Address
│   │   ├── Add New Address
│   │   └── Deliver to Business/Home
│   ├── Select Delivery Method
│   │   ├── Same Day (Extra Cost)
│   │   ├── Next Day (Standard)
│   │   └── 2-3 Days (Economy)
│   ├── Select Payment Method
│   │   ├── Bank Transfer
│   │   ├── E-Wallet (OVO, GoPay, Dana)
│   │   ├── Credit Card
│   │   └── Cash on Delivery (COD)
│   ├── Apply Coupon/Promo
│   ├── Review Order
│   │   ├── Item List
│   │   ├── Final Price
│   │   └── Shipping Info
│   └── Confirm & Pay
│       ├── Payment Processing
│       └── Order Confirmation (Email + SMS)
├── Order History
│   ├── List Semua Pesanan
│   ├── Filter by Status
│   │   ├── Pending Payment
│   │   ├── Confirmed
│   │   ├── Shipped
│   │   ├── Delivered
│   │   └── Cancelled
│   ├── Search by Order ID
│   ├── Detail Pesanan
│   │   ├── Item Details
│   │   ├── Shipping Tracking
│   │   ├── Payment Status
│   │   └── Timeline
│   └── Invoice Download (PDF)
└── Order Tracking
    ├── Real-time Status Update
    ├── Estimated Delivery
    ├── Driver Location (jika ada)
    └── Live Chat dengan Petani/Kurir
```

### 4. Manajemen Pembeli
```
Fitur:
├── Profil Pembeli
│   ├── Informasi Personal
│   │   ├── Nama Lengkap
│   │   ├── Email
│   │   ├── No Telepon
│   │   ├── Foto Profil
│   │   └── Alamat Utama
│   ├── Alamat Pengiriman (Multiple)
│   │   ├── Add New Address
│   │   ├── Edit Existing
│   │   ├── Set Default
│   │   └── Delete Address
│   ├── Payment Methods
│   │   ├── Simpan Bank Account
│   │   ├── Simpan Credit Card
│   │   └── E-Wallet Settings
│   ├── Edit Profil
│   │   ├── Update Personal Data
│   │   └── Change Password
│   └── Preferences
│       ├── Notification Settings
│       ├── Marketing Consent
│       └── Privacy Settings
├── Wishlist & Favorites
│   ├── Save Mangga untuk Nanti
│   ├── Saved Petani/Sellers
│   ├── Follow Petani untuk Notifikasi
│   └── Manage Collections
├── Review & Rating
│   ├── Write Review untuk Mangga
│   ├── Upload Foto
│   ├── Add Star Rating
│   └── Share Review
└── Loyalty Program
    ├── Poin Accumulation per Pembelian
    ├── Redeem Poin untuk Discount
    ├── Membership Tier (Silver/Gold/Platinum)
    └── Exclusive Offers
```

### 5. Komunikasi & Support
```
Fitur:
├── Direct Chat dengan Petani
│   ├── Real-time Messaging
│   ├── Photo/File Sharing
│   ├── Order Discussion
│   └── Chat History
├── Customer Support
│   ├── FAQ Section
│   ├── Ticketing System
│   ├── Live Chat Support
│   └── Email Support
├── Notifikasi
│   ├── Order Updates (Email + SMS)
│   ├── Promo & Deals
│   ├── Restock Alert
│   └── In-app Notifications
└── Report & Complaint
    ├── Report Produk Bermasalah
    ├── Report Petani Tidak Responsif
    ├── Track Complaint Status
    └── Resolution Timeline
```

### 6. Analytics untuk Pembeli
```
Fitur:
├── Purchase Analytics
│   ├── Total Spending (Bulan/Tahun)
│   ├── Favorite Type of Mangga
│   ├── Average Purchase Value
│   └── Frequency of Purchase
├── Spending Pattern
│   ├── Monthly Trend Chart
│   ├── Budget Tracking
│   └── Category Breakdown
└── Seasonal Insights
    ├── Peak Season Data
    ├── Price Trend
    └── Recommendation Based on Pattern
```

---

## 🔬 Integrasi Big Data

### 1. API Cuaca Integration
```
Provider: OpenWeatherMap / WeatherAPI / BMKG
Endpoint: /api/weather/forecast

Parameter Input:
├── Lokasi (Latitude, Longitude) - dari GPS Petani
├── Tipe Forecast (14 hari ke depan)
└── Update Frequency (Setiap 6 jam)

Data yang Diambil:
├── Temperature (Min/Max/Current)
├── Humidity (%)
├── Rainfall Prediction (mm)
├── Wind Speed
├── Sunshine Duration
├── Soil Moisture (kalau tersedia)
└── Disease Risk Index (Rust/Powdery Mildew, dll)

Response Format:
{
  "location": {
    "latitude": -6.3154,
    "longitude": 108.2089,
    "region": "Indramayu"
  },
  "forecast": [
    {
      "date": "2024-01-15",
      "temperature": {
        "min": 22,
        "max": 32,
        "avg": 27
      },
      "humidity": 75,
      "rainfall": 5,
      "wind_speed": 15,
      "optimal_for_harvest": true,
      "disease_risk": "low"
    }
  ],
  "recommendations": {
    "best_harvest_day": "2024-01-15",
    "confidence": 0.85,
    "reason": "Optimal temperature dan minimal rain forecast"
  }
}
```

### 2. Machine Learning Model - Kesegaran Mangga
```
Model Architecture:
├── Input Layer
│   ├── Foto Mangga (Image Input: 224x224 pixels)
│   ├── Berat (Numerical)
│   ├── Diameter (Numerical)
│   └── Jenis Mangga (Categorical)
├── Processing Pipeline
│   ├── Image Processing
│   │   ├── Color Space Conversion (RGB to HSV)
│   │   ├── Feature Extraction
│   │   │   ├── Color Distribution (Hue histogram)
│   │   │   ├── Texture Analysis (GLCM features)
│   │   │   └── Defect Detection (Edge detection)
│   │   └── Preprocessing (Normalization)
│   ├── Deep Learning Model
│   │   ├── Pre-trained Model: MobileNetV2 atau ResNet50
│   │   ├── Transfer Learning Approach
│   │   ├── Fine-tuned dengan Data Mangga Lokal
│   │   └── Output: Class Probability
│   └── Weighted Calculation
│       ├── Color Factor: 40%
│       ├── Weight Factor: 30%
│       ├── Texture Factor: 20%
│       └── Defect Factor: 10%
└── Output Layer
    ├── Freshness Score (0-100%)
    ├── Confidence Level (0-100%)
    ├── Category (Mentah/Setengah/Matang/SangatMatang)
    └── Recommendation (Siap Jual / Simpan / Belum Siap)

Training Data:
├── Minimal 5000+ labeled images
├── Diverse Mango Types (Harum Manis, Manalagi, Arumanis, etc)
├── Various Ripeness Levels
├── Different Lighting Conditions
└── Quality Control dengan Domain Expert

Model Deployment:
├── Framework: TensorFlow Lite / PyTorch Mobile
├── Inference Time: < 2 detik per foto
├── Edge Deployment (lokal di device) untuk offline capability
└── Regular Retraining (monthly dengan new data)
```

### 3. Predictive Analytics - Panen & Tanam
```
Model A: Harvest Prediction
Input Features:
├── Historical Harvest Data (5 tahun terakhir)
├── Weather Data (suhu, curah hujan, kelembaban)
├── Soil Properties
├── Lahan Characteristics (luas, jenis tanah, drainase)
├── Management Practices (pupuk, irigasi, pestisida)
└── Seasonal Patterns

Algorithm: Time Series Forecasting (ARIMA / LSTM / Prophet)

Output:
├── Predicted Harvest Date (±3 hari)
├── Predicted Yield (Kg/Ha)
├── Confidence Interval (80-95%)
└── Risk Factors

Model B: Planting Recommendation
Input Features:
├── Lokasi (latitude, longitude)
├── Cuaca 6 Bulan ke Depan
├── Soil Moisture Forecast
├── Historical Success Rate
├── Petani Experience Level
└── Budget Constraints

Algorithm: Classification Model (Logistic Regression / Gradient Boosting)

Output:
├── Optimal Planting Window (Range Tanggal)
├── Confidence Score (%)
├── Risk Assessment
│   ├── Drought Risk
│   ├── Flood Risk
│   └── Disease Risk
└── Alternative Recommendations (jika risk tinggi)
```

### 4. Quality Analytics Dashboard
```
Real-time Metrics:
├── Average Freshness Score
│   ├── By Petani
│   ├── By Region
│   ├── By Mango Type
│   └── Over Time Trend
├── Quality Distribution
│   ├── % Mentah
│   ├── % Setengah Matang
│   ├── % Matang
│   └── % Sangat Matang
├── Scan Data Volume
│   ├── Total Scans (Daily/Weekly/Monthly)
│   ├── Scans per Petani
│   └── Scans per Location
└── Model Performance
    ├── Accuracy Rate
    ├── Confidence Score Trend
    └── False Positive / False Negative Rate

Visualization:
├── Time Series Chart (Freshness Trend)
├── Heatmap (Quality by Region & Time)
├── Scatter Plot (Price vs Freshness)
├── Distribution Chart (Quality Categories)
└── Predictive Chart (Forecast 7 hari ke depan)
```

### 5. Market Analytics
```
Price Analytics:
├── Average Price Trend
│   ├── by Mango Type
│   ├── by Freshness Level
│   ├── by Season
│   └── by Region
├── Price Elasticity
│   └── Demand vs Price Relationship
├── Competitive Price Comparison
│   └── Price Range Recommendation
└── Price Forecast (Next 30 days)

Demand Analytics:
├── Demand Trend (Volume Pembelian)
├── Seasonal Demand Pattern
├── Popular Mango Types
├── Peak Buying Times
└── Buyer Demographics

Supply Analytics:
├── Available Inventory Trend
├── Supply by Region
├── Supply by Freshness Level
└── Stockout Risk Alert

Market Insights:
├── Market Share Petani
├── Customer Acquisition Cost
├── Customer Lifetime Value
└── Churn Rate Analysis
```

### 6. Recommendation Engine
```
Sistem Rekomendasi untuk Pembeli:
├── Collaborative Filtering
│   ├── Similar Buyers
│   └── Similar Purchase Patterns
├── Content-Based Filtering
│   ├── Mango Type Preference
│   ├── Freshness Level Preference
│   └── Price Range Preference
├── Hybrid Approach
│   ├── Combine Multiple Signals
│   └── User Feedback Integration
└── Real-time Personalization
    ├── A/B Testing
    └── Performance Tracking

Output:
├── Product Recommendations
├── Petani Recommendations
├── Cross-sell Suggestions
└── Discount Recommendations

Sistem Rekomendasi untuk Petani:
├── Best Time to Harvest (dari AI Cuaca)
├── Best Time to Plant (dari AI Cuaca)
├── Yield Optimization Tips
├── Pricing Strategy Recommendation
└── Market Demand Forecast
```

---

## 🏗️ Arsitektur Teknis

### Technology Stack
```
Frontend:
├── React.js / Vue.js / Angular
├── TailwindCSS / Material-UI
├── Redux / Vuex (State Management)
├── Axios / Fetch API
└── Google Maps / Leaflet (Mapping)

Backend:
├── Node.js (Express.js) / Python (Flask/Django) / Java (Spring Boot)
├── REST API / GraphQL
├── JWT Authentication
└── Middleware (CORS, Rate Limiting, Logging)

Database:
├── PostgreSQL (Relational Data)
├── Redis (Caching & Session)
├── MongoDB (Optional untuk Log)
└── TimescaleDB (Optional untuk Time-Series Data)

AI/ML:
├── TensorFlow / PyTorch (Model Training)
├── TensorFlow Lite / ONNX (Model Deployment)
├── Scikit-learn (Data Processing)
├── OpenCV / Pillow (Image Processing)
└── Pandas / NumPy (Data Analysis)

Cloud/DevOps:
├── AWS / Google Cloud / Azure
├── Docker (Containerization)
├── Kubernetes (Orchestration)
├── CI/CD Pipeline (GitHub Actions / GitLab CI)
├── Cloud Storage (S3 / GCS)
└── Cloud Functions (Serverless)

Real-time:
├── WebSocket / Socket.io (Live Chat, Notifications)
├── Message Queue (RabbitMQ / Kafka)
└── Pub/Sub Service
```

### Database Schema (Simplified)
```
Tables:

1. users
   ├── user_id (PK)
   ├── email (UNIQUE)
   ├── password_hash
   ├── role (enum: admin, petani, pembeli)
   ├── name
   ├── phone
   ├── created_at
   └── updated_at

2. petani
   ├── petani_id (PK, FK from users)
   ├── nik (UNIQUE)
   ├── years_experience
   ├── certification
   ├── bank_account
   ├── verification_status
   └── verified_at

3. lahan (fields)
   ├── lahan_id (PK)
   ├── petani_id (FK)
   ├── name
   ├── location_lat
   ├── location_lng
   ├── area_hectares
   ├── mango_type
   ├── total_trees
   ├── year_planted
   ├── status (enum: produktif, persiapan, tidak_aktif)
   └── created_at

4. scan_kesegaran
   ├── scan_id (PK)
   ├── lahan_id (FK)
   ├── photo_path
   ├── weight_grams
   ├── diameter_cm
   ├── mango_type
   ├── freshness_score (0-100)
   ├── color_percentage
   ├── texture_score
   ├── defect_detected (boolean)
   ├── category (enum: mentah, setengah, matang, sangat_matang)
   ├── recommendation
   ├── confidence_score
   ├── scanned_at
   └── created_at

5. laporan_panen
   ├── laporan_id (PK)
   ├── petani_id (FK)
   ├── lahan_id (FK)
   ├── harvest_date
   ├── quantity_kg
   ├── mango_type
   ├── weather_condition
   ├── notes
   ├── status (enum: draft, submitted, verified)
   ├── verified_by (FK to admin)
   ├── verified_at
   └── created_at

6. laporan_tanam
   ├── laporan_id (PK)
   ├── petani_id (FK)
   ├── lahan_id (FK)
   ├── planting_date
   ├── seedlings_count
   ├── seedling_type
   ├── cost_idr
   ├── notes
   ├── status (enum: draft, submitted, verified)
   ├── verified_by (FK to admin)
   ├── estimated_harvest_date
   └── created_at

7. pembeli
   ├── pembeli_id (PK, FK from users)
   ├── business_type (individual/reseller/restaurant)
   ├── tax_id (optional)
   └── verified_at

8. listing_mangga
   ├── listing_id (PK)
   ├── petani_id (FK)
   ├── lahan_id (FK)
   ├── mango_type
   ├── freshness_score
   ├── batch_photo
   ├── quantity_available_kg
   ├── price_per_kg
   ├── min_order_kg
   ├── is_available (boolean)
   ├── listed_at
   └── updated_at

9. pesanan (orders)
   ├── order_id (PK)
   ├── pembeli_id (FK)
   ├── petani_id (FK)
   ├── listing_id (FK)
   ├── quantity_kg
   ├── price_total
   ├── delivery_address
   ├── delivery_method
   ├── payment_method
   ├── status (enum: pending, confirmed, shipped, delivered)
   ├── created_at
   ├── delivered_at
   └── updated_at

10. weather_data
    ├── weather_id (PK)
    ├── location_lat
    ├── location_lng
    ├── forecast_date
    ├── temp_min
    ├── temp_max
    ├── humidity
    ├── rainfall_mm
    ├── wind_speed
    ├── disease_risk
    ├── optimal_for_harvest
    ├── fetched_at
    └── source (API provider)

11. recommendations
    ├── recommendation_id (PK)
    ├── petani_id (FK)
    ├── type (enum: harvest, planting)
    ├── recommended_date
    ├── confidence_score
    ├── reasoning
    ├── accepted (boolean)
    └── created_at
```

### API Endpoints (Sample)
```
AUTENTIKASI:
POST   /api/auth/register
POST   /api/auth/login
POST   /api/auth/logout
POST   /api/auth/refresh-token
POST   /api/auth/forgot-password
POST   /api/auth/reset-password

PETANI - LAHAN:
GET    /api/petani/lahan
POST   /api/petani/lahan
GET    /api/petani/lahan/:id
PUT    /api/petani/lahan/:id
DELETE /api/petani/lahan/:id
GET    /api/petani/lahan/:id/analytics

PETANI - KESEGARAN:
POST   /api/petani/scan-kesegaran (upload foto)
GET    /api/petani/scan-kesegaran
GET    /api/petani/scan-kesegaran/:id
GET    /api/petani/scan-kesegaran/statistics

PETANI - LAPORAN:
POST   /api/petani/laporan-panen
GET    /api/petani/laporan-panen
PUT    /api/petani/laporan-panen/:id
POST   /api/petani/laporan-tanam
GET    /api/petani/laporan-tanam
PUT    /api/petani/laporan-tanam/:id

PETANI - REKOMENDASI:
GET    /api/petani/rekomendasi/panen
GET    /api/petani/rekomendasi/tanam
GET    /api/petani/cuaca/forecast
POST   /api/petani/rekomendasi/:id/feedback

PEMBELI - BROWSE:
GET    /api/pembeli/mangga (dengan filter)
GET    /api/pembeli/mangga/:id
GET    /api/pembeli/mangga/search
GET    /api/pembeli/petani/:id

PEMBELI - PESANAN:
POST   /api/pembeli/pesanan
GET    /api/pembeli/pesanan
GET    /api/pembeli/pesanan/:id
PUT    /api/pembeli/pesanan/:id/cancel
POST   /api/pembeli/pesanan/:id/review

PEMBELI - PROFIL:
GET    /api/pembeli/profil
PUT    /api/pembeli/profil
POST   /api/pembeli/alamat
GET    /api/pembeli/alamat
PUT    /api/pembeli/alamat/:id

ADMIN - DASHBOARD:
GET    /api/admin/dashboard/statistics
GET    /api/admin/dashboard/charts

ADMIN - VERIFIKASI:
GET    /api/admin/verifikasi/petani
POST   /api/admin/verifikasi/petani/:id/approve
POST   /api/admin/verifikasi/petani/:id/reject

ADMIN - MONITORING:
GET    /api/admin/monitoring/kualitas
GET    /api/admin/monitoring/penjualan
GET    /api/admin/monitoring/anomali

ADMIN - LAPORAN:
GET    /api/admin/laporan
GET    /api/admin/laporan/:type
POST   /api/admin/laporan/generate

SISTEM:
GET    /api/health
GET    /api/system/logs
```

### Deployment Architecture
```
Production Environment:

Load Balancer
    ├── HTTPS/SSL
    └── Traffic Distribution

API Server (Multiple Instances)
├── Node.js/Express Server 1
├── Node.js/Express Server 2
└── Node.js/Express Server 3

ML Service (Separate)
├── TensorFlow Serving / PyTorch Serving
├── GPU Instance untuk Inference
└── Load Balanced

Database Layer
├── Primary PostgreSQL
├── Replica PostgreSQL (Read-only)
└── Redis Cache

External Services
├── Weather API
├── Payment Gateway
├── Email Service (SendGrid/AWS SES)
└── SMS Service

Storage
├── AWS S3 (Photos/Uploads)
└── CDN (CloudFront)

Monitoring & Logging
├── Prometheus (Metrics)
├── ELK Stack (Logs)
├── Sentry (Error Tracking)
└── New Relic / DataDog (APM)
```

---

## 📊 Fitur Reporting & Export

### Laporan untuk Admin
```
1. Daily Report
   ├── Total Scans
   ├── Average Quality
   ├── New Orders
   ├── New Users
   └── System Health

2. Weekly Report
   ├── Sales Performance
   ├── Quality Trend
   ├── User Engagement
   └── Revenue

3. Monthly Report
   ├── Production Summary
   ├── Market Analysis
   ├── Financial Summary
   ├── User Activity
   └── System Performance

4. Custom Report Builder
   ├── Select Metrics
   ├── Date Range
   ├── Filter Conditions
   ├── Export Format (PDF/Excel)
   └── Schedule Automated Reports

5. Financial Report
   ├── Revenue by Petani
   ├── Revenue by Mango Type
   ├── Commission Calculation
   ├── Payment Status
   └── Tax Report
```

### Export Formats
```
Tersedia Format:
├── PDF (dengan Chart/Grafik)
├── Excel (.xlsx dengan Multiple Sheets)
├── CSV (untuk Data Analysis)
├── JSON (untuk Integration)
└── Email (Automated Delivery)
```

---

## 🔒 Security & Compliance

### Authentication & Authorization
```
├── Password Policy
│   ├── Min 8 characters
│   ├── Mix of Upper/Lower/Number/Symbol
│   └── Auto-expire setiap 90 hari
├── Two-Factor Authentication (Admin)
│   ├── Email OTP
│   ├── Google Authenticator
│   └── SMS OTP
├── Role-Based Access Control (RBAC)
└── Session Management
    ├── Max 24 hours
    ├── Refresh Token
    └── Auto-logout
```

### Data Protection
```
├── Encryption at Rest (AES-256)
├── Encryption in Transit (HTTPS/TLS 1.2+)
├── Database Encryption
├── File Upload Virus Scan
└── API Rate Limiting
    ├── 100 req/minute per user
    ├── 1000 req/minute per IP
    └── Burst Limit: 200 req/minute
```

### Compliance
```
├── GDPR Compliance (jika ada user EU)
├── Data Privacy Policy
├── Terms of Service
├── Audit Logging
│   ├── All User Actions
│   ├── Admin Actions
│   ├── System Changes
│   └── 30-day Retention
└── Regular Security Audit
    ├── Penetration Testing
    ├── Vulnerability Scanning
    └── Quarterly Assessment
```

---

## 📱 Mobile App (Optional)

### Native Apps:
```
iOS (Swift) & Android (Kotlin):
├── Camera Integration untuk Scan Kesegaran
├── Push Notifications
├── Offline Mode (Limited Features)
├── Biometric Authentication (Fingerprint/Face)
├── Location Services
└── Photo Gallery Access
```

---

## 🎯 Roadmap & Future Enhancement

### Phase 1 (MVP - 3-4 Bulan)
```
✓ Core Authentication & User Management
✓ Basic Petani Features (Lahan, Laporan)
✓ Basic Pembeli Features (Browse, Order)
✓ Simple Kesegaran Scan (Manual + Basic ML)
✓ Admin Dashboard (Basic)
✓ Integration Weather API
```

### Phase 2 (6-8 Bulan)
```
✓ Advanced ML Model untuk Scan Kesegaran
✓ Predictive Analytics (Panen/Tanam)
✓ Real-time Chat & Notifications
✓ Payment Gateway Integration
✓ Mobile App (iOS/Android)
✓ Advanced Analytics Dashboard
✓ QR Code Traceability
```

### Phase 3 (9-12 Bulan)
```
✓ IoT Integration (Sensor Suhu/Kelembaban)
✓ Blockchain untuk Supply Chain Traceability
✓ Advanced Price Prediction
✓ Export Certification Module
✓ B2B Marketplace Features
✓ Subscription Plans
```

---

## 🔄 Flow & User Journey

### Flow Petani (Main Workflow)

```
┌─────────────────┐
│  Login/Sign Up  │
└────────┬────────┘
         │
         ▼
┌─────────────────────────┐
│  Dashboard Petani       │
│ • Statistik Lahan       │
│ • Panen Bulan Ini       │
│ • Alert Rekomendasi     │
└────────┬────────────────┘
         │
    ┌────┴────┬──────────┬──────────┐
    │          │          │          │
    ▼          ▼          ▼          ▼
┌───────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐
│ Manajemen │ │  Scan    │ │ Laporan  │ │ Profil   │
│  Lahan    │ │Kesegaran │ │Panen/Tnn │ │  Petani  │
└───┬───────┘ └────┬─────┘ └────┬─────┘ └──────────┘
    │              │             │
    ▼              ▼             ▼
┌─────────┐  ┌──────────┐  ┌─────────────┐
│ Input   │  │ Ambil    │  │ Submit Data │
│ Data    │  │ Foto     │  │ Laporan     │
└────┬────┘  └───┬──────┘  └──────┬──────┘
     │           │                │
     ▼           ▼                ▼
┌─────────┐  ┌──────────┐  ┌─────────────┐
│ Edit    │  │ Input    │  │ Verifikasi  │
│ Lahan   │  │ Berat    │  │ Admin       │
└─────────┘  └───┬──────┘  └─────────────┘
                 │
                 ▼
           ┌──────────────────┐
           │ Hasil Analisis   │
           │ • Skor Kesegaran │
           │ • Rekomendasi    │
           │ • Confidence %   │
           └────────┬─────────┘
                    │
    ┌───────────────┼───────────────┐
    │               │               │
    ▼               ▼               ▼
┌─────────┐  ┌──────────┐  ┌──────────────┐
│ Siap    │  │ Simpan   │  │ Belum Siap   │
│ Jual    │  │ Lanjutan │  │ Panen        │
│(>70%)   │  │(50-70%)  │  │(<50%)        │
└────┬────┘  └────┬─────┘  └──────┬───────┘
     │            │               │
     └────────────┼───────────────┘
                  │
                  ▼
        ┌──────────────────────┐
        │ Rekomendasi AI       │
        │ (dari API Cuaca)     │
        │ • Waktu Panen Optimal│
        │ • Waktu Tanam Optimal│
        │ • Alert Cuaca Ekstrem│
        └──────────┬───────────┘
                   │
    ┌──────────────┼──────────────┐
    │              │              │
    ▼              ▼              ▼
┌──────────┐ ┌──────────┐ ┌──────────┐
│Alert     │ │Email &   │ │Dashboard │
│Notifikasi│ │SMS       │ │Update    │
└──────────┘ └──────────┘ └──────────┘
```

### Flow Pembeli (Shopping Journey)

```
┌──────────────────┐
│  Login/Sign Up   │
│  (atau Browse)   │
└────────┬─────────┘
         │
         ▼
┌──────────────────────────┐
│  Dashboard Pembeli       │
│ • Rekomendasi Produk     │
│ • Pesanan Aktif          │
│ • Seller Favorit         │
└────────┬─────────────────┘
         │
    ┌────┴─────────────────────┐
    │                          │
    ▼                          ▼
┌──────────────────┐  ┌──────────────────┐
│ Browse Katalog   │  │ Search Mangga    │
│ • Filter Jenis   │  │ • By Petani      │
│ • Filter Segar   │  │ • By Lokasi      │
│ • Filter Harga   │  │ • By Kesegaran   │
│ • Filter Area    │  │ • By Harga       │
└────────┬─────────┘  └────────┬─────────┘
         │                     │
         └────────┬────────────┘
                  │
                  ▼
        ┌──────────────────────┐
        │ Detail Produk Mangga  │
        │ • Foto Scan Asli      │
        │ • Skor Kesegaran      │
        │ • Info Petani         │
        │ • Rating & Review     │
        │ • Harga & Stok        │
        └──────────┬────────────┘
                   │
         ┌─────────┴──────────┐
         │                    │
         ▼                    ▼
    ┌────────────┐     ┌──────────────┐
    │ Add to     │     │ Add to       │
    │ Cart       │     │ Wishlist     │
    └─────┬──────┘     └──────────────┘
          │
          ▼
    ┌──────────────┐
    │ Shopping Cart│
    │ • List Items │
    │ • Edit Qty   │
    │ • Total      │
    └──────┬───────┘
           │
           ▼
    ┌──────────────┐
    │  Checkout    │
    │ • Address    │
    │ • Delivery   │
    │ • Payment    │
    │ • Promo Code │
    └──────┬───────┘
           │
           ▼
    ┌──────────────┐
    │ Confirm Order│
    │ & Pay        │
    └──────┬───────┘
           │
           ▼
    ┌──────────────────┐
    │ Order Confirmed  │
    │ (Email + SMS)    │
    └──────┬───────────┘
           │
           ▼
    ┌──────────────────┐
    │ Order Tracking   │
    │ • Status Update  │
    │ • Delivery Est.  │
    │ • Chat Seller    │
    └──────┬───────────┘
           │
           ▼
    ┌──────────────────┐
    │ Delivery Complete│
    └──────┬───────────┘
           │
           ▼
    ┌──────────────────┐
    │ Write Review &   │
    │ Rating           │
    └──────────────────┘
```

### Flow Admin (Verification & Monitoring)

```
┌──────────────────┐
│  Login Admin      │
│  (dengan 2FA)    │
└────────┬─────────┘
         │
         ▼
┌─────────────────────────────┐
│  Admin Dashboard             │
│ • Statistics & Charts        │
│ • Real-time Monitoring       │
│ • Alert Anomali              │
│ • Pending Verifikasi         │
└────────┬────────────────────┘
         │
    ┌────┴────┬──────────┬──────────┬─────────┐
    │          │          │          │         │
    ▼          ▼          ▼          ▼         ▼
┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐
│Verif.  │ │Monitor │ │Manajemen│ │Laporan │ │Setting │
│Petani  │ │Kualitas│ │Wilayah  │ │& Export│ │Sistem  │
└───┬────┘ └───┬────┘ └───┬────┘ └───┬────┘ └────────┘
    │          │          │          │
    ▼          ▼          ▼          ▼
┌────────┐ ┌──────────┐ ┌────────┐ ┌────────┐
│Cek     │ │Review    │ │Peta    │ │Generate│
│Dokumen │ │Scan Data │ │GIS     │ │Report  │
└───┬────┘ └────┬─────┘ └───┬────┘ └────┬───┘
    │           │           │           │
    ▼           ▼           ▼           ▼
┌────────┐ ┌──────────┐ ┌────────┐ ┌────────┐
│Approve │ │Kalibrasi │ │Export  │ │Email   │
│/Reject │ │AI Model  │ │Peta    │ │Laporan │
└────────┘ └──────────┘ └────────┘ └────────┘
```

### User Journey - Scan Kesegaran Detail

```
PETANI USER JOURNEY - SCAN KESEGARAN MANGGA

START
  │
  ▼
┌─────────────────────────┐
│ Buka Menu Scan          │
│ Kesegaran               │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ Pilih Lahan             │
│ (Dropdown)              │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ Request Camera          │
│ Permission              │
└────────┬────────────────┘
         │
    ┌────┴────┐
    │          │
 ALLOW      DENY
    │          │
    ▼          ▼
  ✓         ERROR MSG
    │
    ▼
┌──────────────────────────┐
│ Live Camera Preview      │
│ • Quality Check          │
│ • Pencahayaan OK?        │
│ • Fokus OK?              │
└────────┬─────────────────┘
         │
    ┌────┴────┐
    │          │
  LANJUT    ULANGI
    │          │
    ▼          ◄─────┐
┌──────────────┐     │
│ Ambil Foto   │─────┘
│ (Snapshot)   │
└────┬─────────┘
     │
     ▼
┌────────────────────┐
│ Input Manual Data  │
│ • Berat (gram)     │
│ • Diameter (cm)    │
│ • Jenis Mangga     │
└────┬───────────────┘
     │
     ▼
┌────────────────────┐
│ Lanjutkan...       │
│ (Loading)          │
│                    │
│ Sedang Analisis:   │
│ • Color Detection  │
│ • Texture Analysis │
│ • Defect Check     │
│ • Scoring...       │
└────┬───────────────┘
     │
     ▼ (2-3 detik)
┌────────────────────────────┐
│ HASIL ANALISIS             │
│                            │
│ Kesegaran: 78%             │
│ Status: MATANG             │
│ Rekomendasi: Siap Jual     │
│ Confidence: 92%            │
│                            │
│ Breakdown:                 │
│ • Warna: 85%               │
│ • Berat: 75%               │
│ • Tekstur: 78%             │
│ • Cacat: Minimal           │
└────┬─────────────────────────┘
     │
     ▼
┌─────────────────────┐
│ [Simpan] [Hapus]    │
│ [Scan Lagi]         │
└────┬────────────────┘
     │
     ▼
┌─────────────────────┐
│ Foto & Data Tersimpan
│ • Database          │
│ • Di-Preview pada   │
│   list scan         │
└─────────────────────┘
```

### Integration Flow - API Cuaca & Rekomendasi

```
DATABASE PETANI
      │
      ▼
┌─────────────────────────────┐
│ Ambil Data:                 │
│ • Lokasi GPS (lat/long)     │
│ • Riwayat Panen             │
│ • Riwayat Tanam             │
│ • Jenis Mangga              │
│ • Umur Pohon                │
└──────────┬──────────────────┘
           │
    ┌──────┴──────┐
    │             │
    ▼             ▼
┌────────────┐ ┌──────────────────────┐
│ API CUACA  │ │ ML MODEL             │
│            │ │ Predictive Analytics │
│ • Temp     │ │                      │
│ • Humidity │ │ • ARIMA/LSTM         │
│ • Rainfall │ │ • Gradient Boosting  │
│ • Wind     │ │ • Random Forest      │
└──────┬─────┘ └──────────┬───────────┘
       │                  │
       └──────────┬───────┘
                  │
                  ▼
        ┌──────────────────────┐
        │ REKOMENDASI OUTPUT   │
        │                      │
        │ Panen:               │
        │ • Tanggal Optimal    │
        │ • Confidence: 85%    │
        │ • Risk: Low          │
        │                      │
        │ Tanam:               │
        │ • Musim Optimal      │
        │ • Risk Assessment    │
        └──────────┬───────────┘
                   │
         ┌─────────┴──────────┐
         │                    │
         ▼                    ▼
    ┌─────────┐          ┌──────────┐
    │ Notifikasi       │ Dashboard
    │ • Email         │ Update
    │ • Push Notif    │
    │ • SMS (opt)     │
    └─────────┘        └──────────┘
```

---

## 🗂️ Entity Relationship (Data Model)

### Core Entities

```
┌────────────────────┐
│      USERS         │
├────────────────────┤
│ user_id (PK)       │
│ email              │
│ password_hash      │
│ role (Admin/Petani/│
│       Pembeli)     │
│ name               │
│ phone              │
│ created_at         │
└─────────┬──────────┘
          │
    ┌─────┴─────┬─────────┐
    │           │         │
    ▼           ▼         ▼
┌────────┐ ┌────────┐ ┌─────────┐
│ ADMIN  │ │PETANI  │ │ PEMBELI │
└────────┘ └───┬────┘ └─────────┘
              │
              ▼
        ┌──────────────┐
        │    LAHAN     │
        ├──────────────┤
        │ lahan_id (PK)│
        │ petani_id(FK)│
        │ name         │
        │ location_lat │
        │ location_lng │
        │ area_hectares│
        │ mango_type   │
        │ status       │
        └──────┬───────┘
               │
    ┌──────────┴──────────┐
    │                     │
    ▼                     ▼
┌──────────────────┐ ┌────────────────┐
│ LAPORAN_PANEN    │ │ LAPORAN_TANAM  │
├──────────────────┤ ├────────────────┤
│ laporan_id (PK)  │ │ laporan_id(PK) │
│ petani_id (FK)   │ │ petani_id (FK) │
│ lahan_id (FK)    │ │ lahan_id (FK)  │
│ harvest_date     │ │ planting_date  │
│ quantity_kg      │ │ seedlings_count│
│ status           │ │ cost_idr       │
│ verified_at      │ │ est_harvest_dt │
└──────────────────┘ └────────────────┘
    │
    ▼
┌──────────────────────────┐
│ SCAN_KESEGARAN           │
├──────────────────────────┤
│ scan_id (PK)             │
│ lahan_id (FK)            │
│ photo_path               │
│ weight_grams             │
│ diameter_cm              │
│ freshness_score (0-100)  │
│ category (enum)          │
│ confidence_score         │
│ recommendation           │
│ scanned_at               │
└──────────┬───────────────┘
           │
           ▼
    ┌──────────────────┐
    │ LISTING_MANGGA   │
    ├──────────────────┤
    │ listing_id (PK)  │
    │ petani_id (FK)   │
    │ scan_id (FK)     │
    │ mango_type       │
    │ freshness_score  │
    │ quantity_kg      │
    │ price_per_kg     │
    │ is_available     │
    └────┬─────────────┘
         │
         ▼
    ┌──────────────┐
    │   PESANAN    │
    ├──────────────┤
    │ order_id(PK) │
    │ pembeli_id(FK)
    │ listing_id(FK)
    │ petani_id (FK)
    │ quantity_kg  │
    │ price_total  │
    │ delivery_addr│
    │ status       │
    │ created_at   │
    │ delivered_at │
    └──────────────┘
```

### Support Entities

```
┌──────────────────┐
│  WEATHER_DATA    │
├──────────────────┤
│ weather_id (PK)  │
│ location_lat     │
│ location_lng     │
│ forecast_date    │
│ temp_min/max     │
│ humidity         │
│ rainfall_mm      │
│ disease_risk     │
│ fetched_at       │
└──────────────────┘

┌──────────────────┐
│ RECOMMENDATIONS  │
├──────────────────┤
│ rec_id (PK)      │
│ petani_id (FK)   │
│ type (harvest/   │
│  planting)       │
│ recommended_date │
│ confidence_score │
│ accepted         │
│ created_at       │
└──────────────────┘

┌──────────────────┐
│  NOTIFICATIONS   │
├──────────────────┤
│ notif_id (PK)    │
│ user_id (FK)     │
│ type             │
│ message          │
│ is_read          │
│ created_at       │
└──────────────────┘

┌──────────────────┐
│   CHAT_MESSAGE   │
├──────────────────┤
│ msg_id (PK)      │
│ sender_id (FK)   │
│ receiver_id (FK) │
│ message_text     │
│ file_path        │
│ created_at       │
└──────────────────┘

┌──────────────────┐
│      REVIEW      │
├──────────────────┤
│ review_id (PK)   │
│ order_id (FK)    │
│ pembeli_id (FK)  │
│ petani_id (FK)   │
│ rating (1-5)     │
│ comment          │
│ photo_path       │
│ created_at       │
└──────────────────┘
```

---

## 💡 Use Cases & User Stories

### Use Case 1: Petani Scan Mangga & Cek Kesegaran
**Actor:** Petani
**Precondition:** Petani sudah login, memiliki lahan aktif

**Main Flow:**
1. Petani membuka fitur "Scan Kesegaran"
2. Pilih lahan dari dropdown
3. Klik tombol kamera (ambil foto mangga)
4. Input manual: berat (gram), diameter (cm), jenis mangga
5. Sistem menjalankan analisis CV untuk mendeteksi:
   - Warna (RGB analysis)
   - Tekstur permukaan
   - Cacat/luka
   - Estimasi berat akurat
6. Output: Skor kesegaran (0-100%) + kategori + rekomendasi
7. Hasil disimpan ke database dengan timestamp
8. Petani bisa lihat riwayat scan dan export ke CSV

**Postcondition:** Data scan tersimpan, dapat digunakan untuk listing penjualan

---

### Use Case 2: Petani Menerima Rekomendasi Panen Otomatis
**Actor:** Sistem, Petani
**Precondition:** Petani memiliki lahan, API Cuaca terhubung

**Main Flow:**
1. Setiap hari jam 6 pagi, sistem mengambil data cuaca dari API OpenWeatherMap
2. Sistem menganalisis:
   - Temperatur optimal (20-25°C)
   - Kelembaban (60-80%)
   - Prediksi hujan (hindari cuaca hujan)
   - Prediksi 14 hari ke depan
3. Sistem menjalankan ML model (ARIMA/Prophet) dengan input:
   - Data cuaca historis 5 tahun
   - Riwayat panen petani
   - Umur pohon mangga
4. Model menghasilkan: Tanggal panen optimal ± 3 hari, confidence score 85%
5. Sistem mengirim notifikasi:
   - Email: "Cuaca optimal untuk panen hari ini, disarankan pukul 6-7 pagi"
   - Push notifikasi di app
   - SMS (optional)
6. Petani bisa melihat detail rekomendasi, alasan, dan forecast cuaca
7. Petani bisa accept/reject rekomendasi (untuk improvement model)

**Postcondition:** Petani mendapat data-driven decision untuk panen

---

### Use Case 3: Pembeli Mencari & Membeli Mangga Segar
**Actor:** Pembeli
**Precondition:** Pembeli sudah login, ada listing mangga tersedia

**Main Flow:**
1. Pembeli membuka katalog mangga
2. Filter:
   - Jenis: Harum Manis, Manalagi, Arumanis, dll
   - Kesegaran: 0-25%, 26-50%, 51-75%, 76-100%
   - Lokasi: Kecamatan di Indramayu
   - Harga: Rp per kg
3. Lihat detail produk:
   - Foto hasil scan (asli dari petani)
   - Skor kesegaran + breakdown
   - Nama petani, lokasi, rating
   - Harga, stok, minimum order
   - Review dari pembeli lain
4. Klik "Add to Cart"
5. Lanjut ke checkout:
   - Pilih alamat pengiriman
   - Pilih metode pengiriman (same day, next day, 2-3 hari)
   - Pilih payment method (transfer, e-wallet, cod)
   - Apply coupon
6. Review order, klik "Confirm & Pay"
7. Pembayaran diproses
8. SMS/Email konfirmasi pesanan
9. Tracking real-time status pengiriman
10. Terima barang, bisa tulis review + rating

**Postcondition:** Transaksi selesai, pembeli mendapat mangga segar berkualitas terjamin

---

### Use Case 4: Admin Verifikasi Petani Baru
**Actor:** Admin
**Precondition:** Ada petani yang baru registrasi pending verifikasi

**Main Flow:**
1. Admin login (dengan 2FA)
2. Buka menu "Verifikasi Pengguna" → "Pending Petani"
3. Lihat data petani:
   - Nama, NIK, No Telepon
   - Alamat, Bank Account
   - Upload dokumen: KTP, Sertifikat Lahan
4. Admin review:
   - KTP valid (scan foto jelas)
   - Sertifikat lahan valid
   - Area lahan sesuai Indramayu
5. Klik "Approve" atau "Reject" + catatan
6. Jika approve:
   - Status berubah menjadi "Verified"
   - Email konfirmasi ke petani
   - Petani bisa akses fitur full (input lahan, scan, laporan)
7. Jika reject:
   - Email notifikasi alasan reject
   - Petani bisa reupload dokumen dan request verifikasi ulang

**Postcondition:** Petani terverifikasi atau need to resubmit dokumen

---

### Use Case 5: Admin Monitor Kualitas Mangga Real-time
**Actor:** Admin
**Precondition:** Sudah ada scan kesegaran dari petani

**Main Flow:**
1. Admin buka "Dashboard Monitoring"
2. Lihat statistik real-time:
   - Total scans hari ini: 125
   - Average freshness score: 72%
   - Quality distribution: 10% mentah, 25% setengah, 50% matang, 15% sangat matang
3. Lihat per-region breakdown:
   - Kecamatan Indramayu: avg 75%
   - Kecamatan Jatibarang: avg 68%
   - dst (15 kecamatan)
4. Lihat per-petani:
   - Top quality: Petani A (avg 82%), Petani B (avg 79%)
   - Need improvement: Petani X (avg 55%)
5. Lihat trend chart: freshness score over 30 hari
6. Alert system:
   - Anomali: Petani Z tiba-tiba turun dari 80% ke 45% → investigate
   - Model accuracy: confidence score suddenly drop → perlu retrain
7. Klik detail scan → lihat foto asli + AI analysis
8. Bisa approve/reject hasil scan (untuk quality control)
9. Generate monthly report: PDF dengan chart dan insight

**Postcondition:** Admin punya visibility penuh terhadap kualitas di lapangan

---

## 🎯 Feature Priority & MVP

### Phase 1 - MVP (Must Have, 3-4 bulan)

**Priority 1 (Week 1-4):**
- ✅ Authentication system (login, sign up, email verification)
- ✅ User roles (Admin, Petani, Pembeli)
- ✅ Basic Petani features:
  - Input data lahan (form sederhana)
  - Dashboard dengan statistics
  - Laporan panen/tanam (form + list)
- ✅ Basic Pembeli features:
  - Browse listing
  - Simple search & filter
  - Add to cart & checkout
  - Order tracking
- ✅ Basic Admin features:
  - User verification (approve/reject)
  - View all users
  - Basic analytics dashboard

**Priority 2 (Week 5-8):**
- ✅ Scan kesegaran (basic version)
  - Camera access
  - Manual parameter input (berat, diameter, jenis)
  - Rule-based calculation (simple scoring)
  - Save hasil scan
- ✅ Integration Weather API
  - Fetch data cuaca
  - Display di dashboard petani
- ✅ Payment gateway integration
  - Test dengan sandbox
  - Transaction logging

**Priority 3 (Week 9-12):**
- ✅ Email notifications (SendGrid/AWS SES)
- ✅ Database & API production ready
- ✅ Basic mobile responsive UI
- ✅ QA & bug fixes

### Phase 2 - Advanced (Should Have, bulan 5-8)

- ✅ ML Model untuk scan kesegaran
  - TensorFlow Lite integration
  - Real scan dengan computer vision
  - Color detection, texture analysis
  - Defect detection
  - Model accuracy ≥ 85%
- ✅ Predictive analytics
  - Harvest date prediction (LSTM)
  - Yield prediction
  - Planting recommendation
- ✅ Real-time notifications
  - WebSocket untuk live chat
  - Push notification
  - SMS alerts
- ✅ Mobile app (iOS & Android)
  - Native app dengan camera integration
  - Offline mode (limited features)
  - Biometric authentication
- ✅ Advanced analytics
  - Dashboard with multiple charts
  - Custom report builder
  - Export to PDF/Excel
- ✅ GIS/Peta integration
  - Map view lahan petani
  - Heatmap produktivitas
  - GPS tracking

### Phase 3 - Future (Nice to Have, bulan 9-12)

- IoT integration (soil moisture sensor, temperature sensor)
- Blockchain untuk supply chain traceability
- Advanced price prediction model
- Export certification module
- B2B marketplace features
- Subscription plans & revenue features
- Video call untuk customer support
- AR/VR features untuk product preview

---

## ⚡ Performance & Scalability Targets

```
Metrics Target:

API Response Time:
├── GET requests: < 200ms (p95)
├── POST requests: < 500ms (p95)
└── ML inference: < 3 detik per scan

Throughput:
├── Concurrent users: 5,000+
├── API requests/sec: 100+ RPS
└── Database: 10,000+ transactions/min

Availability:
├── SLA: 99.5% uptime
├── Scheduled maintenance: < 2 jam/minggu
└── Disaster recovery: < 1 jam RTO

Storage:
├── Database: 500 GB (Year 1)
├── File storage (photos): 1 TB
└── Retention policy: 5 tahun data

Security:
├── SSL/TLS 1.2+
├── Database encryption: AES-256
├── Rate limiting: 100 req/min per user
└── WAF protection
```

---

## 📊 Success Metrics (KPI)

```
User Adoption:
├── Petani registered: 10,000+ (Year 1)
├── Pembeli registered: 50,000+ (Year 1)
└── Admin/Moderator: 50+ (Year 1)

Engagement:
├── Daily active users (DAU): 30%+ of registered
├── Monthly active users (MAU): 60%+ of registered
├── Scan per petani per bulan: 20+
└── Order conversion rate: 15%+

Quality:
├── Scan accuracy: 85%+ confidence
├── On-time delivery: 95%+
├── Customer satisfaction: 4.5+ rating
└── System uptime: 99.5%+

Business:
├── GMV (Gross Merchandise Value): 1 Miliar+ (Year 1)
├── Commission revenue: 3-5% of GMV
├── User retention: 70%+ after 3 bulan
└── NPS (Net Promoter Score): 50+
```

---

## 📞 Contact & Support

**Project Stakeholders:**
- PM / Project Owner
- Tech Lead
- ML Engineer
- Frontend Developer
- Backend Developer
- DevOps Engineer

**Support Channels:**
- Email: support@sistemmangga.id
- Phone: +62-XXX-XXXXX
- WhatsApp: +62-XXX-XXXXX
- Website: https://sistemmangga.id

---

## 📚 Dokumentasi Lengkap

Seluruh dokumentasi teknis, API specification, dan user manual tersedia di:
- **Technical Docs**: `/docs/technical`
- **API Docs**: `/docs/api` (Swagger/OpenAPI)
- **User Manual**: `/docs/user-manual`
- **Database Schema**: `/docs/database`

---

**Dokumen ini bersifat living document dan akan terus diupdate seiring development.**