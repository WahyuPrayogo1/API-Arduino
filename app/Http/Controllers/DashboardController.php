<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absen;
use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Charts\SalesPerDayChart;

class DashboardController extends Controller
{
    public function index(SalesPerDayChart $salesPerDayChart) {

        // Start Ini untuk Tampilan Di dashboard
            $totalUsers = User::count();
            $absenToday = Absen::whereDate('waktu_masuk', today())->distinct('user_id')->count('user_id');
            $percentage = $totalUsers > 0 ? ($absenToday / $totalUsers) * 100 : 0;
        //END

        // Start Barang Masuk
            $totalBarangMasuk = BarangMasuk::sum('jumlah');
        // END

        // Start Barang
            $totalBarang = Barang::count();
        // END

            return view('dashboard',[
                'totalUsers' => $totalUsers,
                'absenToday' => $absenToday,
                'percentage' => $percentage,
                'totalBarangMasuk' => $totalBarangMasuk,
                'totalBarang' => $totalBarang,
                'salesPerDayChart' => $salesPerDayChart->build()
            ]);

    }
}
