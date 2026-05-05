# 📦 Desain Database - Sistem Kesegaran Mangga Indramayu

## Status Saat Ini vs Yang Dibutuhkan

| Tabel Saat Ini | Status | Keterangan |
|:---|:---|:---|
| `users` | ✅ Ada | Perlu diperluas (tambah phone, alamat) |
| `harvest_reports` | ✅ Ada | Perlu di-rename & diperluas |
| `products` | ✅ Ada | Perlu diganti jadi `listing_mangga` |
| `sessions` | ✅ Ada | Bawaan Laravel |
| `cache` | ✅ Ada | Bawaan Laravel |
| `jobs` | ✅ Ada | Bawaan Laravel |

**Tabel Baru Yang Dibutuhkan:** `petani`, `pembeli`, `lahan`, `scan_kesegaran`, `laporan_tanam`, `listing_mangga`, `pesanan`, `detail_pesanan`, `alamat_pengiriman`, `review`, `data_cuaca`, `rekomendasi`, `notifikasi`, `log_aktivitas`

---

## 📐 Skema Lengkap (Bahasa Indonesia)

### 1. `pengguna` (users)
> Tabel utama autentikasi. Menyimpan data login semua role (Admin, Petani, Pembeli).

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik pengguna |
| `nama` | VARCHAR(255) | Nama lengkap |
| `email` | VARCHAR(255) UNIQUE | Email untuk login |
| `email_verified_at` | TIMESTAMP NULL | Kapan email diverifikasi |
| `password` | VARCHAR(255) | Password terenkripsi (bcrypt) |
| `role` | ENUM('admin','petani','pembeli') | Peran dalam sistem |
| `no_telepon` | VARCHAR(20) NULL | Nomor HP |
| `foto_profil` | VARCHAR(255) NULL | Path foto profil |
| `remember_token` | VARCHAR(100) NULL | Token "ingat saya" |
| `created_at` | TIMESTAMP | Tanggal daftar |
| `updated_at` | TIMESTAMP | Terakhir diubah |

**Index:** `email` (UNIQUE), `role` (INDEX untuk filter dashboard admin)

---

### 2. `petani`
> Data tambahan khusus petani. Relasi 1:1 dengan `pengguna`.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pengguna_id` | BIGINT FK → pengguna.id | Link ke tabel pengguna |
| `nik` | VARCHAR(16) UNIQUE | Nomor Induk Kependudukan |
| `pengalaman_tahun` | INT DEFAULT 0 | Lama bertani (tahun) |
| `sertifikasi` | VARCHAR(255) NULL | Sertifikasi pertanian |
| `rekening_bank` | VARCHAR(50) NULL | Nomor rekening untuk pembayaran |
| `nama_bank` | VARCHAR(50) NULL | Nama bank |
| `kelompok_tani` | VARCHAR(100) NULL | Nama kelompok tani |
| `dokumen_ktp` | VARCHAR(255) NULL | Path file scan KTP |
| `dokumen_lahan` | VARCHAR(255) NULL | Path file sertifikat lahan |
| `status_verifikasi` | ENUM('pending','verified','rejected') | Status verifikasi admin |
| `diverifikasi_oleh` | BIGINT FK NULL → pengguna.id | Admin yang memverifikasi |
| `diverifikasi_pada` | TIMESTAMP NULL | Kapan diverifikasi |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `pengguna_id` (UNIQUE), `nik` (UNIQUE), `status_verifikasi` (INDEX)

---

### 3. `pembeli`
> Data tambahan khusus pembeli. Relasi 1:1 dengan `pengguna`.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pengguna_id` | BIGINT FK → pengguna.id | Link ke tabel pengguna |
| `tipe_bisnis` | ENUM('individu','reseller','restoran') | Jenis pembeli |
| `npwp` | VARCHAR(30) NULL | NPWP untuk bisnis |
| `poin_loyalitas` | INT DEFAULT 0 | Poin belanja terakumulasi |
| `tier_member` | ENUM('silver','gold','platinum') DEFAULT 'silver' | Level keanggotaan |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `pengguna_id` (UNIQUE)

---

### 4. `lahan`
> Data kebun/lahan mangga milik petani. Setiap petani bisa punya banyak lahan.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik lahan |
| `petani_id` | BIGINT FK → petani.id | Pemilik lahan |
| `nama_lahan` | VARCHAR(255) | Nama identitas lahan |
| `latitude` | DECIMAL(10,8) | Koordinat GPS (lintang) |
| `longitude` | DECIMAL(11,8) | Koordinat GPS (bujur) |
| `kecamatan` | VARCHAR(100) | Kecamatan di Indramayu |
| `desa` | VARCHAR(100) NULL | Nama desa |
| `luas_hektar` | DECIMAL(8,2) | Luas lahan dalam hektar |
| `jenis_mangga` | VARCHAR(100) | Varietas utama (Harum Manis, dll) |
| `jumlah_pohon` | INT | Total pohon mangga |
| `tahun_tanam` | YEAR | Tahun awal penanaman |
| `status` | ENUM('produktif','persiapan','tidak_aktif') | Status lahan |
| `foto_lahan` | JSON NULL | Array path foto (min 3 foto) |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |
| `deleted_at` | TIMESTAMP NULL | Soft delete |

**Index:** `petani_id` (INDEX), `kecamatan` (INDEX), `jenis_mangga` (INDEX), `status` (INDEX)

---

### 5. `scan_kesegaran` ⭐ (Tabel Utama Big Data)
> Hasil pemindaian AI kesegaran mangga. Volume tinggi (ribuan record/hari).

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik scan |
| `lahan_id` | BIGINT FK → lahan.id | Dari lahan mana |
| `petani_id` | BIGINT FK → petani.id | Siapa yang scan |
| `path_foto` | VARCHAR(255) | Path foto mangga asli |
| `berat_gram` | DECIMAL(8,2) | Berat mangga (input manual) |
| `diameter_cm` | DECIMAL(5,2) | Diameter mangga (input manual) |
| `jenis_mangga` | VARCHAR(100) | Varietas mangga yang discan |
| `skor_kesegaran` | DECIMAL(5,2) | Skor 0-100% (hasil AI) |
| `persentase_warna` | DECIMAL(5,2) | Skor warna dari analisis RGB |
| `skor_tekstur` | DECIMAL(5,2) | Skor tekstur permukaan |
| `cacat_terdeteksi` | BOOLEAN DEFAULT false | Ada cacat/luka? |
| `kategori` | ENUM('mentah','setengah_matang','matang','sangat_matang') | Klasifikasi kematangan |
| `rekomendasi` | ENUM('siap_jual','perlu_penyimpanan','belum_siap') | Saran AI |
| `skor_kepercayaan` | DECIMAL(5,2) | Confidence score model AI (0-100%) |
| `batch_id` | VARCHAR(50) NULL | ID batch untuk grouping scan |
| `dipindai_pada` | TIMESTAMP | Waktu pemindaian |
| `created_at` | TIMESTAMP | |

**Index:** `lahan_id` (INDEX), `petani_id` (INDEX), `kategori` (INDEX), `dipindai_pada` (INDEX)
**Composite Index:** `(petani_id, dipindai_pada)`, `(lahan_id, kategori)`

**🔹 PARTISI:** Range by YEAR(`dipindai_pada`) — Memisahkan data per tahun agar query historis tetap cepat.
```sql
PARTITION BY RANGE (YEAR(dipindai_pada)) (
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027),
    PARTITION p2027 VALUES LESS THAN (2028),
    PARTITION pmax  VALUES LESS THAN MAXVALUE
);
```

---

### 6. `laporan_panen`
> Catatan hasil panen petani per lahan. Diverifikasi oleh admin.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `petani_id` | BIGINT FK → petani.id | Siapa yang panen |
| `lahan_id` | BIGINT FK → lahan.id | Lahan mana |
| `tanggal_panen` | DATE | Tanggal panen dilakukan |
| `jumlah_kg` | DECIMAL(10,2) | Total berat panen (kg) |
| `jenis_mangga` | VARCHAR(100) | Varietas yang dipanen |
| `kondisi_cuaca` | VARCHAR(100) NULL | Cuaca saat panen (cerah/mendung/hujan) |
| `catatan` | TEXT NULL | Catatan tambahan petani |
| `foto_panen` | JSON NULL | Array path foto dokumentasi |
| `status` | ENUM('draft','submitted','verified','rejected') | Status verifikasi |
| `diverifikasi_oleh` | BIGINT FK NULL → pengguna.id | Admin verifikator |
| `diverifikasi_pada` | TIMESTAMP NULL | Waktu verifikasi |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `petani_id` (INDEX), `lahan_id` (INDEX), `status` (INDEX), `tanggal_panen` (INDEX)

---

### 7. `laporan_tanam`
> Catatan aktivitas penanaman bibit baru.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `petani_id` | BIGINT FK → petani.id | Siapa yang menanam |
| `lahan_id` | BIGINT FK → lahan.id | Lahan mana |
| `tanggal_tanam` | DATE | Tanggal penanaman |
| `jumlah_bibit` | INT | Jumlah bibit ditanam |
| `jenis_bibit` | VARCHAR(100) | Varietas bibit |
| `biaya_tanam` | DECIMAL(15,2) | Biaya penanaman (Rp) |
| `catatan` | TEXT NULL | Catatan proses tanam |
| `foto_dokumentasi` | JSON NULL | Array path foto |
| `status` | ENUM('draft','submitted','verified','rejected') | Status verifikasi |
| `diverifikasi_oleh` | BIGINT FK NULL → pengguna.id | Admin verifikator |
| `estimasi_panen` | DATE NULL | Perkiraan tanggal panen |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `petani_id` (INDEX), `lahan_id` (INDEX), `status` (INDEX)

---

### 8. `listing_mangga`
> Mangga yang dipajang untuk dijual di marketplace. Menggantikan tabel `products`.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik listing |
| `petani_id` | BIGINT FK → petani.id | Penjual |
| `lahan_id` | BIGINT FK → lahan.id | Dari lahan mana |
| `scan_id` | BIGINT FK NULL → scan_kesegaran.id | Link ke hasil scan |
| `jenis_mangga` | VARCHAR(100) | Varietas |
| `skor_kesegaran` | DECIMAL(5,2) | Skor dari scan |
| `foto_batch` | JSON NULL | Array foto produk |
| `stok_tersedia_kg` | DECIMAL(10,2) | Stok dalam kg |
| `harga_per_kg` | DECIMAL(15,2) | Harga jual per kg (Rp) |
| `minimal_order_kg` | DECIMAL(8,2) DEFAULT 1 | Minimum pembelian |
| `deskripsi` | TEXT NULL | Deskripsi produk |
| `aktif` | BOOLEAN DEFAULT true | Tampil di katalog? |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `petani_id` (INDEX), `jenis_mangga` (INDEX), `aktif` (INDEX), `harga_per_kg` (INDEX)
**Composite Index:** `(aktif, jenis_mangga, harga_per_kg)` — untuk filter katalog pembeli

---

### 9. `pesanan`
> Header transaksi pembelian mangga.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID pesanan |
| `kode_pesanan` | VARCHAR(20) UNIQUE | Kode unik pesanan (contoh: ORD-20260505-001) |
| `pembeli_id` | BIGINT FK → pembeli.id | Siapa yang beli |
| `total_harga` | DECIMAL(15,2) | Total harga semua item |
| `biaya_pengiriman` | DECIMAL(15,2) DEFAULT 0 | Ongkir |
| `diskon` | DECIMAL(15,2) DEFAULT 0 | Potongan harga |
| `total_bayar` | DECIMAL(15,2) | Grand total (harga + ongkir - diskon) |
| `alamat_id` | BIGINT FK → alamat_pengiriman.id | Alamat tujuan |
| `metode_pengiriman` | ENUM('same_day','next_day','reguler') | Jenis pengiriman |
| `metode_pembayaran` | ENUM('transfer','ewallet','cod','kartu_kredit') | Cara bayar |
| `status` | ENUM('menunggu_bayar','dikonfirmasi','dikemas','dikirim','selesai','dibatalkan') | Status pesanan |
| `dibayar_pada` | TIMESTAMP NULL | Waktu pembayaran |
| `dikirim_pada` | TIMESTAMP NULL | Waktu pengiriman |
| `selesai_pada` | TIMESTAMP NULL | Waktu barang diterima |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `pembeli_id` (INDEX), `kode_pesanan` (UNIQUE), `status` (INDEX), `created_at` (INDEX)

**🔹 PARTISI:** Range by YEAR(`created_at`) — Data pesanan akan terus bertambah.
```sql
PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027),
    PARTITION pmax  VALUES LESS THAN MAXVALUE
);
```

---

### 10. `detail_pesanan`
> Item-item dalam satu pesanan.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pesanan_id` | BIGINT FK → pesanan.id | Pesanan induk |
| `listing_id` | BIGINT FK → listing_mangga.id | Produk yang dibeli |
| `petani_id` | BIGINT FK → petani.id | Penjual |
| `jumlah_kg` | DECIMAL(10,2) | Jumlah yang dibeli |
| `harga_satuan` | DECIMAL(15,2) | Harga per kg saat beli |
| `subtotal` | DECIMAL(15,2) | jumlah × harga_satuan |
| `created_at` | TIMESTAMP | |

**Index:** `pesanan_id` (INDEX), `listing_id` (INDEX), `petani_id` (INDEX)

---

### 11. `alamat_pengiriman`
> Alamat pengiriman pembeli (bisa punya banyak alamat).

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pembeli_id` | BIGINT FK → pembeli.id | Pemilik alamat |
| `label` | VARCHAR(50) | Label (Rumah, Kantor, Toko) |
| `nama_penerima` | VARCHAR(255) | Nama penerima |
| `no_telepon` | VARCHAR(20) | HP penerima |
| `alamat_lengkap` | TEXT | Alamat lengkap |
| `kecamatan` | VARCHAR(100) | Kecamatan |
| `kota` | VARCHAR(100) | Kota/Kabupaten |
| `kode_pos` | VARCHAR(10) | Kode pos |
| `utama` | BOOLEAN DEFAULT false | Alamat utama? |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `pembeli_id` (INDEX)

---

### 12. `review`
> Ulasan dan rating pembeli terhadap petani setelah pesanan selesai.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pesanan_id` | BIGINT FK → pesanan.id | Pesanan terkait |
| `pembeli_id` | BIGINT FK → pembeli.id | Siapa yang review |
| `petani_id` | BIGINT FK → petani.id | Petani yang di-review |
| `rating` | TINYINT | Bintang 1-5 |
| `komentar` | TEXT NULL | Isi ulasan |
| `foto_review` | JSON NULL | Foto bukti kualitas |
| `created_at` | TIMESTAMP | |

**Index:** `petani_id` (INDEX), `rating` (INDEX)

---

### 13. `data_cuaca` ⭐ (Big Data - Time Series)
> Data cuaca dari API eksternal. Diambil setiap 6 jam, volume sangat tinggi.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `latitude` | DECIMAL(10,8) | Koordinat lokasi |
| `longitude` | DECIMAL(11,8) | Koordinat lokasi |
| `tanggal_prakiraan` | DATE | Tanggal prakiraan cuaca |
| `suhu_min` | DECIMAL(5,2) | Suhu minimum (°C) |
| `suhu_max` | DECIMAL(5,2) | Suhu maksimum (°C) |
| `kelembaban` | DECIMAL(5,2) | Kelembaban udara (%) |
| `curah_hujan_mm` | DECIMAL(8,2) | Curah hujan (mm) |
| `kecepatan_angin` | DECIMAL(5,2) | Kecepatan angin (km/h) |
| `risiko_penyakit` | ENUM('rendah','sedang','tinggi') | Risiko hama/penyakit |
| `optimal_panen` | BOOLEAN | Apakah ideal untuk panen? |
| `sumber_api` | VARCHAR(50) | Provider API (OpenWeatherMap/BMKG) |
| `diambil_pada` | TIMESTAMP | Waktu fetch dari API |
| `created_at` | TIMESTAMP | |

**Index:** `tanggal_prakiraan` (INDEX), `(latitude, longitude)` (COMPOSITE)

**🔹 PARTISI:** Range by YEAR(`tanggal_prakiraan`)
```sql
PARTITION BY RANGE (YEAR(tanggal_prakiraan)) (
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027),
    PARTITION pmax  VALUES LESS THAN MAXVALUE
);
```

---

### 14. `rekomendasi`
> Rekomendasi AI untuk petani (waktu panen/tanam optimal).

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `petani_id` | BIGINT FK → petani.id | Untuk petani siapa |
| `lahan_id` | BIGINT FK → lahan.id | Untuk lahan mana |
| `tipe` | ENUM('panen','tanam') | Jenis rekomendasi |
| `tanggal_disarankan` | DATE | Tanggal optimal |
| `skor_kepercayaan` | DECIMAL(5,2) | Confidence AI (%) |
| `alasan` | TEXT | Penjelasan dari AI |
| `diterima` | BOOLEAN NULL | Petani terima/tolak? |
| `created_at` | TIMESTAMP | |

**Index:** `petani_id` (INDEX), `tipe` (INDEX)

---

### 15. `notifikasi`
> Notifikasi untuk semua pengguna.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pengguna_id` | BIGINT FK → pengguna.id | Penerima notifikasi |
| `tipe` | VARCHAR(50) | Jenis (pesanan, verifikasi, cuaca, dll) |
| `judul` | VARCHAR(255) | Judul notifikasi |
| `pesan` | TEXT | Isi pesan |
| `sudah_dibaca` | BOOLEAN DEFAULT false | Sudah dibaca? |
| `created_at` | TIMESTAMP | |

**Index:** `pengguna_id` (INDEX), `sudah_dibaca` (INDEX)
**Composite Index:** `(pengguna_id, sudah_dibaca)` — untuk query "notifikasi belum dibaca"

---

### 16. `log_aktivitas`
> Audit trail semua aksi pengguna untuk keamanan dan compliance.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pengguna_id` | BIGINT FK NULL → pengguna.id | Siapa yang melakukan |
| `aksi` | VARCHAR(100) | Jenis aksi (login, logout, create, update, delete) |
| `tabel_terkait` | VARCHAR(100) NULL | Tabel yang diubah |
| `data_lama` | JSON NULL | Data sebelum perubahan |
| `data_baru` | JSON NULL | Data sesudah perubahan |
| `ip_address` | VARCHAR(45) NULL | IP pengguna |
| `user_agent` | TEXT NULL | Browser/device info |
| `created_at` | TIMESTAMP | |

**Index:** `pengguna_id` (INDEX), `aksi` (INDEX), `created_at` (INDEX)

**🔹 PARTISI:** Range by YEAR(`created_at`) — Log tumbuh sangat cepat.

---

## 🔗 Diagram Relasi (ERD)

```
pengguna (1) ──── (1) petani ──── (N) lahan ──── (N) scan_kesegaran
    │                  │              │              
    │                  │              ├──── (N) laporan_panen
    │                  │              └──── (N) laporan_tanam
    │                  │
    │                  ├──── (N) listing_mangga
    │                  ├──── (N) rekomendasi
    │                  └──── (N) review (sebagai penerima)
    │
    ├──── (1) pembeli ──── (N) pesanan ──── (N) detail_pesanan
    │         │              │
    │         │              └──── (1) review
    │         └──── (N) alamat_pengiriman
    │
    ├──── (N) notifikasi
    └──── (N) log_aktivitas
```

---

## 📊 Ringkasan Strategi

### Indexing
- **Single Index:** Kolom yang sering di-WHERE atau JOIN (foreign keys, status, email)
- **Composite Index:** Kolom yang sering dikombinasikan dalam query filter (contoh: `aktif + jenis_mangga + harga` untuk katalog)
- **Unique Index:** Kolom yang harus unik (email, NIK, kode_pesanan)

### Partitioning (4 tabel)
| Tabel | Alasan | Metode |
|:---|:---|:---|
| `scan_kesegaran` | Volume sangat tinggi (ribuan scan/hari) | RANGE by YEAR |
| `pesanan` | Transaksi terus bertambah | RANGE by YEAR |
| `data_cuaca` | Time-series data dari API (setiap 6 jam) | RANGE by YEAR |
| `log_aktivitas` | Audit log tumbuh sangat cepat | RANGE by YEAR |

### Soft Delete
- `lahan` — Agar histori panen tetap terjaga walau lahan di-nonaktifkan

---

## 🔢 Total: 16 Tabel
| # | Tabel | Fungsi Utama |
|:--|:---|:---|
| 1 | `pengguna` | Autentikasi & data dasar user |
| 2 | `petani` | Profil lengkap petani + verifikasi |
| 3 | `pembeli` | Profil pembeli + loyalty |
| 4 | `lahan` | Data kebun mangga + GPS |
| 5 | `scan_kesegaran` | Hasil AI scan kesegaran (⭐ Big Data) |
| 6 | `laporan_panen` | Catatan panen + verifikasi admin |
| 7 | `laporan_tanam` | Catatan tanam + estimasi panen |
| 8 | `listing_mangga` | Produk dijual di marketplace |
| 9 | `pesanan` | Header transaksi |
| 10 | `detail_pesanan` | Item dalam pesanan |
| 11 | `alamat_pengiriman` | Alamat pembeli |
| 12 | `review` | Ulasan & rating |
| 13 | `data_cuaca` | Data cuaca API (⭐ Big Data) |
| 14 | `rekomendasi` | Saran AI panen/tanam |
| 15 | `notifikasi` | Notifikasi semua user |
| 16 | `log_aktivitas` | Audit trail keamanan |

> **Catatan:** Tabel bawaan Laravel (`sessions`, `cache`, `jobs`, `password_reset_tokens`) tetap dipertahankan dan tidak di-rename.
