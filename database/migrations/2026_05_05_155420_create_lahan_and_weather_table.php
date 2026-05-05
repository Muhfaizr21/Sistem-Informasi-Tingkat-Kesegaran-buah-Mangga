<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->string('nama_lahan');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->onDelete('restrict');
            $table->string('desa', 100)->nullable();
            $table->decimal('luas_hektar', 8, 2);
            $table->string('jenis_mangga', 100);
            $table->integer('jumlah_pohon');
            $table->year('tahun_tanam');
            $table->enum('status', ['produktif', 'persiapan', 'tidak_aktif'])->default('persiapan')->index();
            $table->json('foto_lahan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('data_cuaca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan')->onDelete('set null');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->date('tanggal_prakiraan');
            $table->decimal('suhu_min', 5, 2);
            $table->decimal('suhu_max', 5, 2);
            $table->decimal('kelembaban', 5, 2);
            $table->decimal('curah_hujan_mm', 8, 2);
            $table->decimal('kecepatan_angin', 5, 2);
            $table->enum('risiko_penyakit', ['rendah', 'sedang', 'tinggi']);
            $table->boolean('optimal_panen')->default(false);
            $table->string('sumber_api', 50);
            $table->timestamp('diambil_pada');
            $table->timestamps();
            
            $table->index(['latitude', 'longitude']);
            $table->index('tanggal_prakiraan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_cuaca');
        Schema::dropIfExists('lahan');
    }
};
