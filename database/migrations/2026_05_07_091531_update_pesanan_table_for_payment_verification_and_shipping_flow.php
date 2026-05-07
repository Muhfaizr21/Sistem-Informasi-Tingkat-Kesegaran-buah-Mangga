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
            $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
            $table->string('foto_selesai')->nullable()->after('selesai_pada');
            $table->string('catatan_admin')->nullable()->after('foto_selesai');
            
            // Laravel doesn't support changing enum directly in SQLite, 
            // but for MySQL we can use change(). Since we are in development, 
            // we will just update the column.
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'foto_selesai', 'catatan_admin']);
            $table->enum('status', ['menunggu_bayar', 'dikonfirmasi', 'dikemas', 'dikirim', 'selesai', 'dibatalkan'])->change();
        });
    }
};
