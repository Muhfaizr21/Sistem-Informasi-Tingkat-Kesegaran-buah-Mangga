<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scan_kesegaran', function (Blueprint $table) {
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending')->after('rekomendasi');
            $table->decimal('skor_manual', 5, 2)->nullable()->after('status_verifikasi');
            $table->boolean('is_anomaly')->default(false)->after('skor_manual');
            $table->text('catatan_admin')->nullable()->after('is_anomaly');
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('pengguna')->onDelete('set null')->after('catatan_admin');
            $table->timestamp('diverifikasi_pada')->nullable()->after('diverifikasi_oleh');
        });
    }

    public function down(): void
    {
        Schema::table('scan_kesegaran', function (Blueprint $table) {
            $table->dropForeign(['diverifikasi_oleh']);
            $table->dropColumn([
                'status_verifikasi',
                'skor_manual',
                'is_anomaly',
                'catatan_admin',
                'diverifikasi_oleh',
                'diverifikasi_pada'
            ]);
        });
    }
};
