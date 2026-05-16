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
        Schema::table('data_produksi_historis', function (Blueprint $table) {
            $table->decimal('luas_hektar', 10, 2)->nullable()->after('produksi_kuintal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_produksi_historis', function (Blueprint $table) {
            $table->dropColumn('luas_hektar');
        });
    }
};
