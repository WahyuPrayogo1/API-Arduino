<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\User;
use Carbon\Carbon;  // Pastikan Carbon sudah di-import untuk mengatur waktu

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
            // Atur zona waktu ke Asia/Jakarta
            $now = now()->setTimezone('Asia/Jakarta');

            // Cek apakah sudah ada absensi untuk hari ini
            $absen = Absen::where('user_id', $user->id)
                ->whereDate('waktu_masuk', $now->toDateString()) // Cek berdasarkan tanggal
                ->first();

            if (!$absen) {
                // Jika belum ada absensi, buat entri baru (waktu masuk)
                Absen::create([
                    'user_id' => $user->id,
                    'rfid' => $rfid,
                    'waktu_masuk' => $now,
                    'status' => 'hadir', // Anda bisa menyesuaikan status jika diperlukan
                ]);

                return response()->json(
                    [
                        'message' => 'Absen Masuk',
                        'user' => $user->name,
                        'waktu_masuk' => $now->toString(),
                    ],
                    200,
                );
            } elseif (!$absen->waktu_keluar) {
                // Jika absensi masuk ada tapi belum ada waktu keluar, tambahkan waktu keluar
                $absen->update([
                    'waktu_keluar' => $now,
                ]);

                return response()->json(
                    [
                        'message' => 'Absen Pulang',
                        'user' => $user->name,
                        'waktu_keluar' => $now->toString(),
                    ],
                    200,
                );
            } else {
                // Jika absensi masuk dan keluar sudah ada di hari yang sama
                return response()->json(
                    [
                        'message' => 'Coba Lagi Besok',
                        'user' => 'Silahkan',
                    ],
                    400,
                );
            }
        } else {
            // Jika pengguna tidak ditemukan
            return response()->json(
                [
                    'message' => 'Tidak ditemukan',
                    'user' => 'Kartu',
                ],
                404,
            );
        }
    }
}
