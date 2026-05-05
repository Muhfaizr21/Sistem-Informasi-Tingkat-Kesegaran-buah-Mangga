# 📦 Desain Database - Sistem Kesegaran Mangga Indramayu

## Status Saat Ini vs Yang Dibutuhkan

| Tabel Saat Ini | Status | Keterangan |
|:---|:---|:---|
| `users` | ✅ Ada | Perlu diperluas (tambah phone, alamat) |
| `harvest_reports` | ✅ Ada | Perlu di-rename & diperluas → `laporan_panen` |
| `products` | ✅ Ada | Perlu diganti jadi `listing_mangga` |
| `sessions` | ✅ Ada | Bawaan Laravel |
| `cache` | ✅ Ada | Bawaan Laravel |
| `jobs` | ✅ Ada | Bawaan Laravel |

**Tabel Baru Yang Dibutuhkan:** `petani`, `pembeli`, `lahan`, `kecamatan`, `scan_kesegaran`, `laporan_panen`, `laporan_tanam`, `listing_mangga`, `pesanan`, `detail_pesanan`, `alamat_pengiriman`, `review`, `data_cuaca`, `rekomendasi`, `ringkasan_produksi`, `notifikasi`, `log_aktivitas`

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
| `status_verifikasi` | ENUM('pending','verified','rejected') DEFAULT 'pending' | Status verifikasi admin |
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
| `tipe_bisnis` | ENUM('individu','reseller','restoran') DEFAULT 'individu' | Jenis pembeli |
| `npwp` | VARCHAR(30) NULL | NPWP untuk bisnis |
| `poin_loyalitas` | INT DEFAULT 0 | Poin belanja terakumulasi |
| `tier_member` | ENUM('silver','gold','platinum') DEFAULT 'silver' | Level keanggotaan |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `pengguna_id` (UNIQUE)

---

### 4. `kecamatan` ⭐ (Baru — Lookup Table)
> Referensi 31 kecamatan tetap di Kabupaten Indramayu. Mencegah typo dan inkonsistensi nama wilayah pada tabel `lahan` dan `alamat_pengiriman`.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `kode_bps` | VARCHAR(10) UNIQUE | Kode BPS kecamatan (misal: 3212010) |
| `nama` | VARCHAR(100) UNIQUE | Nama resmi kecamatan |
| `created_at` | TIMESTAMP | |

**Index:** `kode_bps` (UNIQUE), `nama` (UNIQUE)

**Data Awal (31 kecamatan):**
```sql
INSERT INTO kecamatan (kode_bps, nama) VALUES
('3212010','Haurgeulis'), ('3212011','Gantar'), ('3212020','Kroya'),
('3212030','Gabuswetan'), ('3212040','Cikedung'), ('3212041','Terisi'),
('3212050','Lelea'), ('3212060','Bangodua'), ('3212061','Tukdana'),
('3212070','Widasari'), ('3212080','Kertasemaya'), ('3212081','Sukagumiwang'),
('3212090','Krangkeng'), ('3212100','Karangampel'), ('3212101','Kedokan Bunder'),
('3212110','Juntinyuat'), ('3212120','Sliyeg'), ('3212130','Jatibarang'),
('3212140','Balongan'), ('3212150','Indramayu'), ('3212160','Sindang'),
('3212161','Cantigi'), ('3212162','Pasekan'), ('3212170','Lohbener'),
('3212171','Arahan'), ('3212180','Losarang'), ('3212190','Kandanghaur'),
('3212200','Bongas'), ('3212210','Anjatan'), ('3212220','Sukra'),
('3212221','Patrol');
```

---

### 5. `lahan`
> Data kebun/lahan mangga milik petani. Setiap petani bisa punya banyak lahan.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik lahan |
| `petani_id` | BIGINT FK → petani.id | Pemilik lahan |
| `nama_lahan` | VARCHAR(255) | Nama identitas lahan |
| `latitude` | DECIMAL(10,8) | Koordinat GPS (lintang) |
| `longitude` | DECIMAL(11,8) | Koordinat GPS (bujur) |
| `kecamatan_id` | BIGINT FK → kecamatan.id | Kecamatan di Indramayu (FK, bukan free-text) |
| `desa` | VARCHAR(100) NULL | Nama desa |
| `luas_hektar` | DECIMAL(8,2) | Luas lahan dalam hektar |
| `jenis_mangga` | VARCHAR(100) | Varietas utama (Harum Manis, Gedong, dll) |
| `jumlah_pohon` | INT | Total pohon mangga |
| `tahun_tanam` | YEAR | Tahun awal penanaman |
| `status` | ENUM('produktif','persiapan','tidak_aktif') DEFAULT 'persiapan' | Status lahan |
| `foto_lahan` | JSON NULL | Array path foto (min 3 foto) |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |
| `deleted_at` | TIMESTAMP NULL | Soft delete — histori panen tetap terjaga |

**Index:** `petani_id` (INDEX), `kecamatan_id` (INDEX), `jenis_mangga` (INDEX), `status` (INDEX)

---

### 6. `scan_kesegaran` ⭐ (Tabel Utama Big Data)
> Hasil pemindaian AI kesegaran mangga. Volume tinggi (ribuan record/hari).

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik scan |
| `lahan_id` | BIGINT FK NULL → lahan.id | Dari lahan mana (NULL jika pembeli scan tanpa lahan) |
| `petani_id` | BIGINT FK NULL → petani.id | Petani yang scan (NULL jika scan dari Pembeli) |
| `pembeli_id` | BIGINT FK NULL → pembeli.id | Pembeli yang scan (NULL jika scan dari Petani) |
| `path_foto` | VARCHAR(255) | Path foto mangga asli |
| `berat_gram` | DECIMAL(8,2) NULL | Berat mangga (input manual, opsional) |
| `diameter_cm` | DECIMAL(5,2) NULL | Diameter mangga (input manual, opsional) |
| `jenis_mangga` | VARCHAR(100) | Varietas mangga yang discan |
| `skor_kesegaran` | DECIMAL(5,2) | Skor 0-100% (hasil AI) |
| `persentase_warna` | DECIMAL(5,2) | Skor warna dari analisis RGB |
| `skor_tekstur` | DECIMAL(5,2) | Skor tekstur permukaan |
| `skor_bentuk` | DECIMAL(5,2) NULL | Skor bentuk/simetri mangga |
| `skor_aroma` | DECIMAL(5,2) NULL | Skor estimasi aroma (opsional, jika model mendukung) |
| `cacat_terdeteksi` | BOOLEAN DEFAULT false | Ada cacat/luka? |
| `kategori` | ENUM('mentah','setengah_matang','matang','sangat_matang') | Klasifikasi kematangan |
| `rekomendasi` | ENUM('siap_jual','perlu_penyimpanan','belum_siap') | Saran AI |
| `skor_kepercayaan` | DECIMAL(5,2) | Confidence score model AI (0-100%) |
| `batch_id` | VARCHAR(50) NULL | ID batch untuk grouping scan |
| `dipindai_pada` | TIMESTAMP | Waktu pemindaian |
| `created_at` | TIMESTAMP | |

> **Catatan `skor_aroma`:** Kolom ini dipersiapkan sesuai flowchart yang menyebut aroma sebagai fitur ekstraksi. Diisi NULL jika model AI belum mendukung deteksi aroma.

> **Catatan `lahan_id`:** NULL jika pembeli scan mangga tanpa relasi ke lahan petani.

> **Catatan `petani_id` / `pembeli_id`:** Salah satu wajib diisi, tidak boleh keduanya NULL.

**CHECK Constraint (MySQL 8+):**
```sql
CHECK (petani_id IS NOT NULL OR pembeli_id IS NOT NULL)
```

**Index:** `lahan_id` (INDEX), `petani_id` (INDEX), `pembeli_id` (INDEX), `kategori` (INDEX), `dipindai_pada` (INDEX)
**Composite Index:** `(petani_id, dipindai_pada)`, `(lahan_id, kategori)`, `(pembeli_id, dipindai_pada)`

**🔹 PARTISI:** Range by YEAR(`dipindai_pada`)
```sql
PARTITION BY RANGE (YEAR(dipindai_pada)) (
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027),
    PARTITION p2027 VALUES LESS THAN (2028),
    PARTITION pmax  VALUES LESS THAN MAXVALUE
);
```

---

### 7. `laporan_panen`
> Catatan hasil panen petani per lahan. Diverifikasi oleh admin.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `petani_id` | BIGINT FK → petani.id | Siapa yang panen |
| `lahan_id` | BIGINT FK → lahan.id | Lahan mana |
| `tanggal_panen` | DATE | Tanggal panen dilakukan |
| `jumlah_kg` | DECIMAL(10,2) | Total berat panen (kg) |
| `luas_panen_hektar` | DECIMAL(8,2) NULL | Snapshot luas lahan saat panen (agar histori akurat jika lahan berubah) |
| `jenis_mangga` | VARCHAR(100) | Varietas yang dipanen |
| `kondisi_cuaca` | VARCHAR(100) NULL | Cuaca saat panen (cerah/mendung/hujan) |
| `data_cuaca_id` | BIGINT FK NULL → data_cuaca.id | Link ke data cuaca API saat panen |
| `catatan` | TEXT NULL | Catatan tambahan petani |
| `foto_panen` | JSON NULL | Array path foto dokumentasi |
| `status` | ENUM('draft','submitted','verified','rejected') DEFAULT 'draft' | Status verifikasi |
| `diverifikasi_oleh` | BIGINT FK NULL → pengguna.id | Admin verifikator |
| `diverifikasi_pada` | TIMESTAMP NULL | Waktu verifikasi |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `petani_id` (INDEX), `lahan_id` (INDEX), `status` (INDEX), `tanggal_panen` (INDEX)

---

### 8. `laporan_tanam`
> Catatan aktivitas penanaman bibit baru.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `petani_id` | BIGINT FK → petani.id | Siapa yang menanam |
| `lahan_id` | BIGINT FK → lahan.id | Lahan mana |
| `tanggal_tanam` | DATE | Tanggal penanaman |
| `jumlah_bibit` | INT | Jumlah bibit ditanam |
| `jenis_bibit` | VARCHAR(100) | Varietas bibit |
| `biaya_tanam` | DECIMAL(15,2) NULL | Biaya penanaman (Rp) |
| `kondisi_cuaca` | VARCHAR(100) NULL | Cuaca saat tanam (selaras dengan laporan_panen) |
| `data_cuaca_id` | BIGINT FK NULL → data_cuaca.id | Link ke data cuaca API saat tanam |
| `catatan` | TEXT NULL | Catatan proses tanam |
| `foto_dokumentasi` | JSON NULL | Array path foto |
| `status` | ENUM('draft','submitted','verified','rejected') DEFAULT 'draft' | Status verifikasi |
| `diverifikasi_oleh` | BIGINT FK NULL → pengguna.id | Admin verifikator |
| `diverifikasi_pada` | TIMESTAMP NULL | Waktu verifikasi (selaras dengan laporan_panen) |
| `estimasi_panen` | DATE NULL | Perkiraan tanggal panen |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `petani_id` (INDEX), `lahan_id` (INDEX), `status` (INDEX)

---

### 9. `listing_mangga`
> Mangga yang dipajang untuk dijual di marketplace. Menggantikan tabel `products`. Listing mewakili **batch panen** (bukan 1 buah mangga).

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik listing |
| `petani_id` | BIGINT FK → petani.id | Penjual |
| `lahan_id` | BIGINT FK → lahan.id | Dari lahan mana |
| `scan_id` | BIGINT FK NULL → scan_kesegaran.id | Link ke salah satu hasil scan (bukti kualitas AI representatif) |
| `batch_id` | VARCHAR(50) NULL | ID batch panen (bisa banyak scan per batch) |
| `jenis_mangga` | VARCHAR(100) | Varietas |
| `skor_kesegaran` | DECIMAL(5,2) NULL | Skor dari scan (disalin dari scan_kesegaran untuk performa query) |
| `foto_batch` | JSON NULL | Array foto produk |
| `stok_tersedia_kg` | DECIMAL(10,2) | Stok dalam kg |
| `harga_per_kg` | DECIMAL(15,2) | Harga jual per kg (Rp) |
| `minimal_order_kg` | DECIMAL(8,2) DEFAULT 1 | Minimum pembelian |
| `deskripsi` | TEXT NULL | Deskripsi produk |
| `aktif` | BOOLEAN DEFAULT true | Tampil di katalog? |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

> **Catatan `batch_id`:** Satu listing = satu batch panen. Bisa terhubung ke banyak `scan_kesegaran` via `batch_id`. `scan_id` menunjuk ke scan representatif terbaik.

**Index:** `petani_id` (INDEX), `jenis_mangga` (INDEX), `aktif` (INDEX), `harga_per_kg` (INDEX), `batch_id` (INDEX)
**Composite Index:** `(aktif, jenis_mangga, harga_per_kg)` — untuk filter katalog pembeli

---

### 10. `pesanan`
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

**🔹 PARTISI:** Range by YEAR(`created_at`)
```sql
PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027),
    PARTITION pmax  VALUES LESS THAN MAXVALUE
);
```

---

### 11. `detail_pesanan`
> Item-item dalam satu pesanan.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pesanan_id` | BIGINT FK → pesanan.id | Pesanan induk |
| `listing_id` | BIGINT FK → listing_mangga.id | Produk yang dibeli |
| `petani_id` | BIGINT FK → petani.id | Penjual (denormalisasi untuk query cepat) |
| `jumlah_kg` | DECIMAL(10,2) | Jumlah yang dibeli |
| `harga_satuan` | DECIMAL(15,2) | Harga per kg saat beli (snapshot, tidak berubah walau listing diupdate) |
| `subtotal` | DECIMAL(15,2) | jumlah × harga_satuan |
| `created_at` | TIMESTAMP | |

**Index:** `pesanan_id` (INDEX), `listing_id` (INDEX), `petani_id` (INDEX)

---

### 12. `alamat_pengiriman`
> Alamat pengiriman pembeli (bisa punya banyak alamat).

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pembeli_id` | BIGINT FK → pembeli.id | Pemilik alamat |
| `label` | VARCHAR(50) | Label (Rumah, Kantor, Toko) |
| `nama_penerima` | VARCHAR(255) | Nama penerima |
| `no_telepon` | VARCHAR(20) | HP penerima |
| `alamat_lengkap` | TEXT | Alamat lengkap |
| `kecamatan_id` | BIGINT FK NULL → kecamatan.id | Kecamatan (FK ke lookup table) |
| `kota` | VARCHAR(100) | Kota/Kabupaten |
| `kode_pos` | VARCHAR(10) | Kode pos |
| `utama` | BOOLEAN DEFAULT false | Alamat utama? |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

**Index:** `pembeli_id` (INDEX)

---

### 13. `review`
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
**Constraint:** UNIQUE `(pesanan_id, pembeli_id)` — satu pesanan hanya bisa di-review sekali

---

### 14. `data_cuaca` ⭐ (Big Data - Time Series)
> Data cuaca dari API eksternal. Diambil setiap 6 jam, volume sangat tinggi.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `kecamatan_id` | BIGINT FK NULL → kecamatan.id | Kecamatan yang direferensikan (jika tersedia) |
| `latitude` | DECIMAL(10,8) | Koordinat lokasi |
| `longitude` | DECIMAL(11,8) | Koordinat lokasi |
| `tanggal_prakiraan` | DATE | Tanggal prakiraan cuaca |
| `suhu_min` | DECIMAL(5,2) | Suhu minimum (°C) |
| `suhu_max` | DECIMAL(5,2) | Suhu maksimum (°C) |
| `kelembaban` | DECIMAL(5,2) | Kelembaban udara (%) |
| `curah_hujan_mm` | DECIMAL(8,2) | Curah hujan (mm) |
| `kecepatan_angin` | DECIMAL(5,2) | Kecepatan angin (km/h) |
| `risiko_penyakit` | ENUM('rendah','sedang','tinggi') | Risiko hama/penyakit |
| `optimal_panen` | BOOLEAN DEFAULT false | Apakah ideal untuk panen? |
| `sumber_api` | VARCHAR(50) | Provider API (OpenWeatherMap/BMKG) |
| `diambil_pada` | TIMESTAMP | Waktu fetch dari API |
| `created_at` | TIMESTAMP | |

**Index:** `tanggal_prakiraan` (INDEX), `kecamatan_id` (INDEX)
**Composite Index:** `(latitude, longitude)`, `(kecamatan_id, tanggal_prakiraan)`

**🔹 PARTISI:** Range by YEAR(`tanggal_prakiraan`)
```sql
PARTITION BY RANGE (YEAR(tanggal_prakiraan)) (
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027),
    PARTITION pmax  VALUES LESS THAN MAXVALUE
);
```

---

### 15. `rekomendasi`
> Rekomendasi AI untuk petani (waktu panen/tanam optimal).

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `petani_id` | BIGINT FK → petani.id | Untuk petani siapa |
| `lahan_id` | BIGINT FK → lahan.id | Untuk lahan mana |
| `data_cuaca_id` | BIGINT FK NULL → data_cuaca.id | Data cuaca yang mendasari rekomendasi ini (traceability) |
| `tipe` | ENUM('panen','tanam') | Jenis rekomendasi |
| `tanggal_disarankan` | DATE | Tanggal optimal yang disarankan |
| `skor_kepercayaan` | DECIMAL(5,2) | Confidence AI (%) |
| `alasan` | TEXT | Penjelasan dari AI (faktor cuaca, histori panen, dll) |
| `diterima` | BOOLEAN NULL | Petani terima/tolak? (NULL = belum direspons) |
| `created_at` | TIMESTAMP | |

**Index:** `petani_id` (INDEX), `lahan_id` (INDEX), `tipe` (INDEX), `data_cuaca_id` (INDEX)

---

### 16. `ringkasan_produksi` ⭐ (Baru — Analytics Cache)
> Hasil agregasi ETL produksi per kecamatan per tahun/triwulan untuk dashboard Admin. Menghindari query berat ke tabel transaksional saat generate laporan.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `kecamatan_id` | BIGINT FK → kecamatan.id | Kecamatan |
| `tahun` | YEAR | Tahun produksi |
| `triwulan` | TINYINT NULL | Triwulan 1-4 (NULL = data tahunan agregat) |
| `total_produksi_kuintal` | DECIMAL(15,2) | Total produksi (kuintal) |
| `total_lahan_hektar` | DECIMAL(10,2) NULL | Total luas lahan aktif (ha) |
| `total_petani_aktif` | INT DEFAULT 0 | Jumlah petani yang melaporkan panen |
| `rata_skor_kesegaran` | DECIMAL(5,2) NULL | Rata-rata skor scan dari kecamatan tersebut |
| `total_pesanan` | INT DEFAULT 0 | Total transaksi dari kecamatan ini |
| `sumber_data` | VARCHAR(100) DEFAULT 'sistem' | Asal data: `sistem` (ETL) atau `bps` (seed Excel) |
| `diperbarui_pada` | TIMESTAMP | Terakhir dijalankan ETL |
| `created_at` | TIMESTAMP | |
| `updated_at` | TIMESTAMP | |

> **Fleksibilitas data:** `triwulan = NULL` → data tahunan agregat. `triwulan = 1-4` → data BPS per triwulan. Keduanya bisa hidup berdampingan.

**Index:** `kecamatan_id` (INDEX), `tahun` (INDEX), `triwulan` (INDEX)
**Constraint:** `UNIQUE (kecamatan_id, tahun, triwulan)` — satu record per kecamatan per tahun per triwulan

> **Catatan:** Tabel ini diisi oleh scheduled job (cron/Laravel Queue) setiap malam. Data historis BPS 2018–2025 (tahunan & triwulan) dari file Excel di-seed sebagai baseline analitik.

---

### 17. `notifikasi`
> Notifikasi untuk semua pengguna.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pengguna_id` | BIGINT FK → pengguna.id | Penerima notifikasi |
| `tipe` | VARCHAR(50) | Jenis: `pesanan`, `verifikasi`, `cuaca`, `rekomendasi`, `review` |
| `judul` | VARCHAR(255) | Judul notifikasi |
| `pesan` | TEXT | Isi pesan |
| `referensi_tipe` | VARCHAR(100) NULL | Nama tabel terkait (polymorphic, misal: `pesanan`) |
| `referensi_id` | BIGINT NULL | ID record terkait |
| `sudah_dibaca` | BOOLEAN DEFAULT false | Sudah dibaca? |
| `created_at` | TIMESTAMP | |

**Index:** `pengguna_id` (INDEX), `sudah_dibaca` (INDEX)
**Composite Index:** `(pengguna_id, sudah_dibaca)` — untuk query "notifikasi belum dibaca"

---

### 18. `log_aktivitas`
> Audit trail semua aksi pengguna untuk keamanan dan compliance.

| Kolom | Tipe | Keterangan |
|:---|:---|:---|
| `id` | BIGINT PK AUTO | ID unik |
| `pengguna_id` | BIGINT FK NULL → pengguna.id | Siapa yang melakukan (NULL jika sistem/cron) |
| `aksi` | VARCHAR(100) | Jenis aksi: `login`, `logout`, `create`, `update`, `delete`, `verify`, `scan` |
| `tabel_terkait` | VARCHAR(100) NULL | Tabel yang diubah |
| `data_lama` | JSON NULL | Data sebelum perubahan |
| `data_baru` | JSON NULL | Data sesudah perubahan |
| `ip_address` | VARCHAR(45) NULL | IP pengguna (supports IPv6) |
| `user_agent` | TEXT NULL | Browser/device info |
| `created_at` | TIMESTAMP | |

**Index:** `pengguna_id` (INDEX), `aksi` (INDEX), `created_at` (INDEX)

**🔹 PARTISI:** Range by YEAR(`created_at`) — Log tumbuh sangat cepat
```sql
PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027),
    PARTITION pmax  VALUES LESS THAN MAXVALUE
);
```

---

## 🔗 Diagram Relasi (ERD)

```
kecamatan (lookup) ──┬── (N) lahan
                     ├── (N) alamat_pengiriman
                     ├── (N) data_cuaca
                     └── (N) ringkasan_produksi

pengguna (1) ──── (1) petani ──── (N) lahan ──── (N) scan_kesegaran
    │                  │              │
    │                  │              ├──── (N) laporan_panen ──── data_cuaca
    │                  │              └──── (N) laporan_tanam ──── data_cuaca
    │                  │
    │                  ├──── (N) listing_mangga ──── scan_kesegaran
    │                  ├──── (N) rekomendasi ──── data_cuaca
    │                  └──── (N) review (sebagai penerima)
    │
    ├──── (1) pembeli ──── (N) pesanan ──── (N) detail_pesanan
    │         │              │
    │         │              └──── (1) review
    │         └──── (N) alamat_pengiriman
    │
    ├──── (N) notifikasi
    └──── (N) log_aktivitas

scan_kesegaran ──── petani_id OR pembeli_id (salah satu wajib diisi)
```

---

## 📊 Ringkasan Strategi

### Indexing
- **Single Index:** Kolom yang sering di-WHERE atau JOIN (foreign keys, status, email)
- **Composite Index:** Kolom yang sering dikombinasikan dalam query filter
- **Unique Index:** Kolom yang harus unik (email, NIK, kode_pesanan)

### Partitioning (4 tabel big data)
| Tabel | Alasan | Metode |
|:---|:---|:---|
| `scan_kesegaran` | Volume sangat tinggi (ribuan scan/hari) | RANGE by YEAR |
| `pesanan` | Transaksi terus bertambah | RANGE by YEAR |
| `data_cuaca` | Time-series data dari API (setiap 6 jam) | RANGE by YEAR |
| `log_aktivitas` | Audit log tumbuh sangat cepat | RANGE by YEAR |

### Soft Delete
- `lahan` — Agar histori panen dan scan tetap terjaga walau lahan di-nonaktifkan

### ETL & Analytics
- `ringkasan_produksi` diisi via scheduled job Laravel setiap malam
- Data historis BPS 2018–2025 (dari file Excel) di-seed sebagai data awal
- Dashboard Admin membaca `ringkasan_produksi`, bukan query langsung ke `laporan_panen`

---

## 🔢 Total: 18 Tabel

| # | Tabel | Fungsi Utama | Baru/Diubah |
|:--|:---|:---|:---|
| 1 | `pengguna` | Autentikasi & data dasar user | — |
| 2 | `petani` | Profil lengkap petani + verifikasi | — |
| 3 | `pembeli` | Profil pembeli + loyalty | — |
| 4 | `kecamatan` | Lookup 31 kecamatan Indramayu | ⭐ **Baru** |
| 5 | `lahan` | Data kebun mangga + GPS | Diubah: `kecamatan` → FK |
| 6 | `scan_kesegaran` | Hasil AI scan kesegaran (Big Data) | Diubah: tambah `pembeli_id`, `skor_bentuk`, `skor_aroma` |
| 7 | `laporan_panen` | Catatan panen + verifikasi admin | Diubah: tambah `luas_panen_hektar`, `data_cuaca_id` |
| 8 | `laporan_tanam` | Catatan tanam + estimasi panen | Diubah: tambah `kondisi_cuaca`, `data_cuaca_id`, `diverifikasi_pada` |
| 9 | `listing_mangga` | Produk dijual di marketplace | — |
| 10 | `pesanan` | Header transaksi | — |
| 11 | `detail_pesanan` | Item dalam pesanan | — |
| 12 | `alamat_pengiriman` | Alamat pembeli | Diubah: `kecamatan` → FK |
| 13 | `review` | Ulasan & rating | Diubah: tambah UNIQUE constraint |
| 14 | `data_cuaca` | Data cuaca API (Big Data) | Diubah: tambah `kecamatan_id` |
| 15 | `rekomendasi` | Saran AI panen/tanam | Diubah: tambah `data_cuaca_id` (traceability) |
| 16 | `ringkasan_produksi` | Cache agregasi untuk dashboard Admin | ⭐ **Baru** |
| 17 | `notifikasi` | Notifikasi semua user | Diubah: tambah polymorphic reference |
| 18 | `log_aktivitas` | Audit trail keamanan | — |

> **Catatan:** Tabel bawaan Laravel (`sessions`, `cache`, `jobs`, `password_reset_tokens`) tetap dipertahankan dan tidak di-rename.

---

## 📋 Changelog dari Versi Sebelumnya

| # | Perubahan | Alasan |
|:--|:---|:---|
| 1 | **Tambah tabel `kecamatan`** | Validasi 31 kecamatan dari data BPS; cegah typo pada `lahan` dan `alamat_pengiriman` |
| 2 | **`lahan.kecamatan` → FK `kecamatan_id`** | Konsistensi dengan lookup table |
| 3 | **`scan_kesegaran`: tambah `pembeli_id`** | Flowchart: Alur Pembeli bisa scan mandiri |
| 4 | **`scan_kesegaran`: tambah `skor_bentuk`, `skor_aroma`** | Sesuai flowchart (fitur: warna, berat, tekstur, **bentuk**, **aroma**) |
| 5 | **`laporan_panen`: tambah `luas_panen_hektar`** | Snapshot luas lahan saat panen agar histori akurat |
| 6 | **`laporan_panen` & `laporan_tanam`: tambah `data_cuaca_id`** | Traceability: laporan panen/tanam terhubung ke kondisi cuaca aktual |
| 7 | **`laporan_tanam`: tambah `kondisi_cuaca`, `diverifikasi_pada`** | Sinkronisasi struktur dengan `laporan_panen` |
| 8 | **`rekomendasi`: tambah `data_cuaca_id`** | Traceability: rekomendasi AI bisa di-trace ke data cuaca yang digunakan |
| 9 | **`data_cuaca`: tambah `kecamatan_id`** | Hubungkan data cuaca ke wilayah spesifik Indramayu |
| 10 | **Tambah tabel `ringkasan_produksi`** | Flowchart menyebut Generate Laporan & Visualization; hindari query berat di tabel transaksional |
| 11 | **`review`: tambah UNIQUE(pesanan_id, pembeli_id)** | Cegah double review untuk pesanan yang sama |
| 12 | **`notifikasi`: tambah polymorphic reference** | Notifikasi bisa diarahkan ke record spesifik (pesanan, verifikasi, dll) |