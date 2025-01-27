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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained()->onDelete('cascade'); // Relasi ke tabel barang
            $table->integer('jumlah'); // Jumlah barang terjual
            $table->decimal('harga', 15, 2); // Harga jual per item
            $table->decimal('total_harga', 20, 2); // Total harga (jumlah * harga)
            $table->date('tanggal_penjualan'); // Tanggal penjualan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
