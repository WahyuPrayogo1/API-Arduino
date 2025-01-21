<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'stok', 'harga','kode'];

    // Relasi dengan barang masuk
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    // Relasi dengan barang keluar
    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
