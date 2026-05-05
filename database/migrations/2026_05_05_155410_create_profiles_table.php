<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petani', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->unique()->constrained('pengguna')->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->integer('pengalaman_tahun')->default(0);
            $table->string('sertifikasi')->nullable();
            $table->string('rekening_bank', 50)->nullable();
            $table->string('nama_bank', 50)->nullable();
            $table->string('kelompok_tani', 100)->nullable();
            $table->string('dokumen_ktp')->nullable();
            $table->string('dokumen_lahan')->nullable();
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending')->index();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('pengguna')->onDelete('set null');
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->timestamps();
        });

        Schema::create('pembeli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->unique()->constrained('pengguna')->onDelete('cascade');
            $table->enum('tipe_bisnis', ['individu', 'reseller', 'restoran'])->default('individu');
            $table->string('npwp', 30)->nullable();
            $table->integer('poin_loyalitas')->default(0);
            $table->enum('tier_member', ['silver', 'gold', 'platinum'])->default('silver');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembeli');
        Schema::dropIfExists('petani');
    }
};
