<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Penjualan;

class SalesPerDayChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        // Ambil total penjualan per bulan
        $penjualanPerBulan = Penjualan::selectRaw('SUM(total_harga) as total, MONTH(tanggal_penjualan) as month')
            ->groupBy('month')
            ->orderBy('month', 'asc') // Urutkan berdasarkan bulan
            ->pluck('total', 'month');  // Ambil data total per bulan

        // Tentukan nama bulan untuk X axis
        $bulanNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];


        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $penjualanPerBulan->get($i, 0);
        }

        return $this->chart->lineChart()

            ->addData('Penjualan', $chartData)
            ->setXAxis($bulanNames); // Set bulan sebagai X axis
    }
}
