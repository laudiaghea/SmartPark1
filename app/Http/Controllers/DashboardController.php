<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Parking;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Parking::count();
        $keluar = Parking::whereNotNull('waktu_keluar')->count();
        $aktif = Parking::whereNull('waktu_keluar')->count();

        return response()->json([
            'total_kendaraan' => $total,
            'kendaraan_keluar' => $keluar,
            'parkir_aktif' => $aktif,
        ]);
    }

    public function chartPendapatan()
    {
        $data = Parking::selectRaw("
                MONTH(waktu_keluar) as bulan,
                SUM(total_bayar) as total
            ")
            ->whereNotNull('waktu_keluar')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $namaBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ];

        return response()->json([
            'labels' => $data->map(function ($item) use ($namaBulan) {
                return $namaBulan[$item->bulan];
            }),

            'values' => $data->pluck('total')
        ]);
    }


}
