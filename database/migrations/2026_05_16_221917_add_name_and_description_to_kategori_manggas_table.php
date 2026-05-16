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
        Schema::table('kategori_manggas', function (Blueprint $table) {
            $table->string('nama')->unique()->after('id');
            $table->string('deskripsi')->nullable()->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_manggas', function (Blueprint $table) {
            $table->dropColumn(['nama', 'deskripsi']);
        });
    }
};
