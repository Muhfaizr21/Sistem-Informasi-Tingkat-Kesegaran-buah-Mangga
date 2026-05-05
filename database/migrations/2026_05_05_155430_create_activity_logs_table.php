<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scan_kesegaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lahan_id')->nullable()->constrained('lahan')->onDelete('set null');
            $table->foreignId('petani_id')->nullable()->constrained('petani')->onDelete('set null');
            $table->foreignId('pembeli_id')->nullable()->constrained('pembeli')->onDelete('set null');
            $table->string('path_foto');
            $table->decimal('berat_gram', 8, 2)->nullable();
            $table->decimal('diameter_cm', 5, 2)->nullable();
            $table->string('jenis_mangga', 100);
            $table->decimal('skor_kesegaran', 5, 2);
            $table->decimal('persentase_warna', 5, 2);
            $table->decimal('skor_tekstur', 5, 2);
            $table->decimal('skor_bentuk', 5, 2)->nullable();
            $table->decimal('skor_aroma', 5, 2)->nullable();
            $table->boolean('cacat_terdeteksi')->default(false);
            $table->enum('kategori', ['mentah', 'setengah_matang', 'matang', 'sangat_matang']);
            $table->enum('rekomendasi', ['siap_jual', 'perlu_penyimpanan', 'belum_siap']);
            $table->decimal('skor_kepercayaan', 5, 2);
            $table->string('batch_id', 50)->nullable()->index();
            $table->timestamp('dipindai_pada');
            $table->timestamps();
        });

        Schema::create('laporan_panen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->foreignId('lahan_id')->constrained('lahan')->onDelete('cascade');
            $table->date('tanggal_panen');
            $table->decimal('jumlah_kg', 10, 2);
            $table->decimal('luas_panen_hektar', 8, 2)->nullable();
            $table->string('jenis_mangga', 100);
            $table->string('kondisi_cuaca', 100)->nullable();
            $table->foreignId('data_cuaca_id')->nullable()->constrained('data_cuaca')->onDelete('set null');
            $table->text('catatan')->nullable();
            $table->json('foto_panen')->nullable();
            $table->enum('status', ['draft', 'submitted', 'verified', 'rejected'])->default('draft')->index();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('pengguna')->onDelete('set null');
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->timestamps();
        });

        Schema::create('laporan_tanam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->foreignId('lahan_id')->constrained('lahan')->onDelete('cascade');
            $table->date('tanggal_tanam');
            $table->integer('jumlah_bibit');
            $table->string('jenis_bibit', 100);
            $table->decimal('biaya_tanam', 15, 2)->nullable();
            $table->string('kondisi_cuaca', 100)->nullable();
            $table->foreignId('data_cuaca_id')->nullable()->constrained('data_cuaca')->onDelete('set null');
            $table->text('catatan')->nullable();
            $table->json('foto_dokumentasi')->nullable();
            $table->enum('status', ['draft', 'submitted', 'verified', 'rejected'])->default('draft')->index();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('pengguna')->onDelete('set null');
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->date('estimasi_panen')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_tanam');
        Schema::dropIfExists('laporan_panen');
        Schema::dropIfExists('scan_kesegaran');
    }
};
