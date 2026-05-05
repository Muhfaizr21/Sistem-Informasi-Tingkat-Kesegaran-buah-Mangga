<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ringkasan_produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->onDelete('cascade');
            $table->year('tahun');
            $table->tinyInteger('triwulan')->nullable();
            $table->decimal('total_produksi_kuintal', 15, 2);
            $table->decimal('total_lahan_hektar', 10, 2)->nullable();
            $table->integer('total_petani_aktif')->default(0);
            $table->decimal('rata_skor_kesegaran', 5, 2)->nullable();
            $table->integer('total_pesanan')->default(0);
            $table->string('sumber_data', 100)->default('sistem');
            $table->timestamp('diperbarui_pada');
            $table->timestamps();
            
            $table->unique(['kecamatan_id', 'tahun', 'triwulan']);
        });

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('tipe', 50);
            $table->string('judul');
            $table->text('pesan');
            $table->string('referensi_tipe', 100)->nullable();
            $table->bigInteger('referensi_id')->nullable();
            $table->boolean('sudah_dibaca')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->nullable()->constrained('pengguna')->onDelete('set null');
            $table->string('aksi', 100);
            $table->string('tabel_terkait', 100)->nullable();
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('ringkasan_produksi');
    }
};
