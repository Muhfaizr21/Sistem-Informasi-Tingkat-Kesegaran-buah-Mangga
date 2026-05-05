# 🥭 Sistem Informasi Tingkat Kesegaran Buah Mangga

## 📋 Deskripsi Proyek
Sistem ini merupakan solusi digital berbasis **Big Data** dan **Computer Vision** yang dirancang khusus untuk industri mangga di **Kabupaten Indramayu**. Proyek ini bertujuan untuk menjembatani kesenjangan informasi antara petani dan pembeli melalui teknologi penilaian kualitas otomatis dan analitik prediktif.

---

## 🎯 Maksud dan Tujuan
Sistem ini dibangun dengan visi untuk memodernisasi ekosistem pertanian mangga melalui:

1.  **Penilaian Kesegaran Otomatis (Computer Vision)**: Menghilangkan subjektivitas dalam penentuan kualitas mangga dengan menggunakan analisis citra (warna, tekstur, dan deteksi cacat) secara real-time.
2.  **Transparansi & Efisiensi Pasar**: Memberikan akses langsung kepada pembeli untuk melihat stok dan kualitas mangga dari berbagai lahan petani terverifikasi di Indramayu.
3.  **Manajemen Produksi Berbasis Data**: Membantu petani mengelola data lahan, laporan tanam, dan laporan panen secara digital dan terstruktur.
4.  **Rekomendasi Cerdas (Big Data Analytics)**: Mengintegrasikan API Cuaca dan algoritma Machine Learning untuk memberikan rekomendasi waktu panen dan tanam yang optimal guna meminimalkan risiko gagal panen.

---

## 🚀 Fitur Utama

### 🌾 Untuk Petani
*   **Real-time Freshness Scan**: Cek tingkat kesegaran mangga hanya dengan mengambil foto.
*   **Data-Driven Recommendations**: Notifikasi waktu panen optimal berdasarkan ramalan cuaca dan data historis.
*   **Digital Farm Log**: Pencatatan otomatis laporan tanam dan panen per lahan.
*   **GIS Mapping**: Visualisasi lokasi lahan pada peta digital.

### 🛒 Untuk Pembeli
*   **Katalog Mangga Terverifikasi**: Cari mangga berdasarkan jenis, lokasi (kecamatan), dan tingkat kesegaran.
*   **Quality Guarantee**: Melihat hasil scan asli dan skor kualitas dari sistem sebelum membeli.
*   **Direct Transaction**: Sistem pemesanan dan checkout yang terintegrasi dengan Payment Gateway.

### 👨‍💼 Untuk Admin
*   **Quality Monitoring**: Dashboard analitik untuk memantau tren kualitas mangga di seluruh wilayah Indramayu.
*   **Verification System**: Validasi data petani dan dokumen lahan untuk menjaga integritas sistem.
*   **Market Insight**: Analisis harga dan permintaan pasar secara real-time.

---

## 🛠️ Tech Stack & Integrasi
Sistem ini menggunakan arsitektur modern untuk menjamin performa dan skalabilitas:

*   **Backend**: [Laravel Framework](https://laravel.com) (PHP)
*   **AI/ML**: TensorFlow / MobileNetV2 untuk analisis citra.
*   **Database**: PostgreSQL & Redis.
*   **Integrasi Service (API)**:
    *   **Weather**: OpenWeatherMap / BMKG.
    *   **Payment**: Midtrans.
    *   **Mapping**: Google Maps / Leaflet.
    *   **Storage**: AWS S3 / DigitalOcean Spaces.

---

## 📖 Dokumentasi Lanjutan
Untuk informasi lebih detail mengenai arsitektur dan layanan pihak ketiga, silakan merujuk pada:
*   [**Sistem.md**](./Sistem.md) - Dokumentasi fitur, alur kerja, dan skema database.
*   [**API.md**](./API.md) - Daftar layanan pihak ketiga dan rekomendasi stack teknologi.

---

## 📄 Lisensi
Proyek ini bersifat open-source dan berada di bawah lisensi [MIT](https://opensource.org/licenses/MIT).
