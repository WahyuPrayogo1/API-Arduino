<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $fillable = ['barang_id', 'jumlah', 'harga', 'total_harga', 'tanggal_penjualan'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
