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
        Schema::create('data_produksi_historis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->onDelete('cascade');
            $table->year('tahun');
            $table->string('kuartal', 2);
            $table->decimal('produksi_kuintal', 15, 2);
            $table->string('jenis_mangga', 100);
            $table->string('keberhasilan_panen', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('data_lahan_historis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->onDelete('cascade');
            $table->year('tahun');
            $table->decimal('luas_hektar', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_lahan_historis');
        Schema::dropIfExists('data_produksi_historis');
    }
};
