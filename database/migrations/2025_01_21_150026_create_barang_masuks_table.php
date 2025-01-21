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
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained()->onDelete('cascade'); // Relasi ke tabel barangs
            $table->integer('jumlah'); // Jumlah barang yang masuk
            $table->decimal('harga', 15, 2); // Harga barang per unit
            $table->timestamp('tanggal_masuk'); // Tanggal barang masuk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
