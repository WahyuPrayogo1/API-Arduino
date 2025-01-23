<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absen;
use App\Models\BarangMasuk;
use App\Models\Barang;



class DashboardController extends Controller
{
    public function index() {

        // Start Ini untuk Tampilan Di dashboard
            $totalUsers = User::count();
            $absenToday = Absen::whereDate('waktu_masuk', today())->distinct('user_id')->count('user_id');
            $percentage = $totalUsers > 0 ? ($absenToday / $totalUsers) * 100 : 0;
        //END

        // Start Barang Masuk
            $totalBarangMasuk = BarangMasuk::sum('jumlah');
            // Barang masuk per hari untuk 7 hari terakhir
            $barangMasukPerHari = BarangMasuk::selectRaw('DATE(tanggal_masuk) as tanggal, SUM(jumlah) as total')
                ->where('tanggal_masuk', '>=', now()->subDays(7)) // 7 hari terakhir
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'asc')
                ->get();
        // END

        // Start Barang
            $totalBarang = Barang::count();
        // END


            return view('dashboard',[
                'totalUsers' => $totalUsers,
                'absenToday' => $absenToday,
                'percentage' => $percentage,
                'totalBarangMasuk' => $totalBarangMasuk,
                'barangMasukPerHari' => $barangMasukPerHari,
                'totalBarang' => $totalBarang
            ]);



    }
}
