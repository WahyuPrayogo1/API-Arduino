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
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained()->onDelete('cascade'); // Relasi ke tabel barangs
            $table->integer('jumlah'); // Jumlah barang yang keluar
            $table->string('keperluan'); // Keperluan barang keluar
            $table->timestamp('tanggal_keluar'); // Tanggal barang keluar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
