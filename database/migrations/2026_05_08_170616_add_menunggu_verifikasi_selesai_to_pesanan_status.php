<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu_bayar', 
                'menunggu_verifikasi', 
                'dikonfirmasi', 
                'dikemas', 
                'dikirim', 
                'menunggu_verifikasi_selesai',
                'selesai', 
                'dibatalkan'
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->enum('status', [
                'menunggu_bayar', 
                'menunggu_verifikasi', 
                'dikonfirmasi', 
                'dikemas', 
                'dikirim', 
                'selesai', 
                'dibatalkan'
            ])->change();
        });
    }
};
