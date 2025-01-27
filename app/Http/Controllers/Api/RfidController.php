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
        $rfid = $request->input('rfid');

        $user = User::where('rfid', $rfid)->first();

        if ($user) {
            $now = now()->setTimezone('Asia/Jakarta');

            // Cek apakah sudah ada absensi untuk hari ini
            $absen = Absen::where('user_id', $user->id)
                ->whereDate('waktu_masuk', $now->toDateString())
                ->first();

            if (!$absen) {
                // Jika belum ada absensi, buat entri baru (waktu masuk)
                Absen::create([
                    'user_id' => $user->id,
                    'rfid' => $rfid,
                    'waktu_masuk' => $now,
                    'status' => 'hadir',
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
                return response()->json(
                    [
                        'message' => 'Coba Lagi Besok',
                        'user' => 'Silahkan',
                    ],
                    400,
                );
            }
        } else {
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
