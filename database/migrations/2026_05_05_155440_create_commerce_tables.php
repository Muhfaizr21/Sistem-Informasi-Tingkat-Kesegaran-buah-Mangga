<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_mangga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->foreignId('lahan_id')->constrained('lahan')->onDelete('cascade');
            $table->foreignId('scan_id')->nullable()->constrained('scan_kesegaran')->onDelete('set null');
            $table->string('batch_id', 50)->nullable()->index();
            $table->string('jenis_mangga', 100);
            $table->decimal('skor_kesegaran', 5, 2)->nullable();
            $table->json('foto_batch')->nullable();
            $table->decimal('stok_tersedia_kg', 10, 2);
            $table->decimal('harga_per_kg', 15, 2);
            $table->decimal('minimal_order_kg', 8, 2)->default(1);
            $table->text('deskripsi')->nullable();
            $table->boolean('aktif')->default(true)->index();
            $table->timestamps();
            
            $table->index(['aktif', 'jenis_mangga', 'harga_per_kg']);
        });

        Schema::create('alamat_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembeli_id')->constrained('pembeli')->onDelete('cascade');
            $table->string('label', 50);
            $table->string('nama_penerima');
            $table->string('no_telepon', 20);
            $table->text('alamat_lengkap');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan')->onDelete('set null');
            $table->string('kota', 100);
            $table->string('kode_pos', 10);
            $table->boolean('utama')->default(false);
            $table->timestamps();
        });

        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan', 20)->unique();
            $table->foreignId('pembeli_id')->constrained('pembeli')->onDelete('cascade');
            $table->decimal('total_harga', 15, 2);
            $table->decimal('biaya_pengiriman', 15, 2)->default(0);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('total_bayar', 15, 2);
            $table->foreignId('alamat_id')->constrained('alamat_pengiriman')->onDelete('restrict');
            $table->enum('metode_pengiriman', ['same_day', 'next_day', 'reguler']);
            $table->enum('metode_pembayaran', ['transfer', 'ewallet', 'cod', 'kartu_kredit']);
            $table->enum('status', ['menunggu_bayar', 'dikonfirmasi', 'dikemas', 'dikirim', 'selesai', 'dibatalkan'])->index();
            $table->timestamp('dibayar_pada')->nullable();
            $table->timestamp('dikirim_pada')->nullable();
            $table->timestamp('selesai_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('alamat_pengiriman');
        Schema::dropIfExists('listing_mangga');
    }
};
