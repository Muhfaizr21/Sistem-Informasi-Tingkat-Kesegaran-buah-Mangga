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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('variety');
            $table->decimal('stock', 10, 2);
            $table->decimal('price', 15, 2);
            $table->string('grade');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('harvest_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('variety');
            $table->decimal('weight', 10, 2);
            $table->string('location');
            $table->string('grade');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_reports');
        Schema::dropIfExists('products');
    }
};
