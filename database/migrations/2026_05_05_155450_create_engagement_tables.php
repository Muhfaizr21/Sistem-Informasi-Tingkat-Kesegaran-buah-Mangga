<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('listing_id')->constrained('listing_mangga')->onDelete('restrict');
            $table->foreignId('petani_id')->constrained('petani')->onDelete('restrict');
            $table->decimal('jumlah_kg', 10, 2);
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });

        Schema::create('review', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('pembeli_id')->constrained('pembeli')->onDelete('cascade');
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->tinyInteger('rating')->index();
            $table->text('komentar')->nullable();
            $table->json('foto_review')->nullable();
            $table->timestamps();
            
            $table->unique(['pesanan_id', 'pembeli_id']);
        });

        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->foreignId('lahan_id')->constrained('lahan')->onDelete('cascade');
            $table->foreignId('data_cuaca_id')->nullable()->constrained('data_cuaca')->onDelete('set null');
            $table->enum('tipe', ['panen', 'tanam'])->index();
            $table->date('tanggal_disarankan');
            $table->decimal('skor_kepercayaan', 5, 2);
            $table->text('alasan');
            $table->boolean('diterima')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
        Schema::dropIfExists('review');
        Schema::dropIfExists('detail_pesanan');
    }
};
