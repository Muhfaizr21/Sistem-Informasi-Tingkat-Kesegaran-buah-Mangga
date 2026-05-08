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
        Schema::create('penarikan_danas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->decimal('nominal', 15, 2);
            $table->string('no_ktp');
            $table->string('nama_bank');
            $table->string('no_rekening');
            $table->string('nama_rekening');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('disetujui_pada')->nullable();
            $table->foreignId('disetujui_oleh')->nullable()->constrained('pengguna');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan_danas');
    }
};
