<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\User;

class RfidController extends Controller
{
    public function receiveRfid(Request $request)
    {
        // Pastikan request berisi data RFID
        $request->validate([
            'rfid' => 'required|string',
        ]);

        // Ambil UID RFID dari request
        $rfid = $request->input('rfid');

        // Cari pengguna berdasarkan UID RFID yang dipindai
        $user = User::where('rfid', $rfid)->first();

        if ($user) {
            // Cek apakah pengguna sudah ada di absensi hari ini
            $absen = Absen::where('user_id', $user->id)
                          ->whereDate('waktu_masuk', now()->toDateString())  // Memastikan absensi untuk hari ini
                          ->first();

            if (!$absen) {
                // Jika tidak ada absensi, berarti pengguna melakukan absensi pertama kali (waktu masuk)
                Absen::create([
                    'user_id' => $user->id,
                    'rfid' => $rfid,
                    'waktu_masuk' => now(),
                    'status' => 'hadir',  // Anda bisa menyesuaikan status jika diperlukan
                ]);

                return response()->json([
                    'message' => 'Absensi masuk berhasil!',
                    'user' => $user->name,
                    'waktu_masuk' => now()->toString(),
                ], 200);
            } else {
                // Jika absensi sudah ada (waktu masuk), maka kita anggap ini sebagai waktu keluar
                $absen->update([
                    'waktu_keluar' => now(),
                ]);

                return response()->json([
                    'message' => 'Absensi keluar berhasil!',
                    'user' => $user->name,
                    'waktu_keluar' => now()->toString(),
                ], 200);
            }
        } else {
            // Jika pengguna tidak ditemukan
            return response()->json([
                'message' => 'Pengguna tidak ditemukan!',
            ], 404);
        }
    }
}
