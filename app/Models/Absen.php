<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan oleh model ini
    protected $table = 'absens';

    // Menentukan kolom mana yang boleh diisi (mass assignment)
    protected $fillable = [
        'user_id',      // ID pengguna yang melakukan absensi
        'rfid',         // RFID yang digunakan untuk absensi
        'waktu_masuk',
        'waktu_keluar',  // Waktu saat absensi dilakukan
        'status',       // Status absensi (hadir, izin, terlambat)
    ];

    // Menentukan kolom yang harus di-casting (misal: waktu dalam format datetime)
    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_keluar'=> 'datetime'
    ];

    // Relasi dengan tabel User (misalnya, setiap absensi memiliki satu user)
    public function user()
    {
        return $this->belongsTo(User::class); // Relasi satu ke banyak, satu user memiliki banyak absensi
    }
}
