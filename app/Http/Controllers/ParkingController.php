<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index()
    {
        $data = Parking::with('tarif')
            ->whereNull('waktu_keluar')
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required',
            'tarif_id' => 'required|exists:tarifs,id'
        ]);

        // Generate kode unik
        $last = Parking::latest()->first();

        $number = $last
            ? ((int) substr($last->kode_unik, 3)) + 1
            : 1;

        $kode = 'PKR' . str_pad(
            $number,
            3,
            '0',
            STR_PAD_LEFT
        );

          $parkir = Parking::create([
            'kode_unik' => $kode,
            'plat_nomor' => strtoupper($request->plat_nomor),
            'tarif_id' => $request->tarif_id,
            'waktu_masuk' => now(),
            'total_bayar' => 0
        ]);

        return response()->json([
            'message' => 'Berhasil tambah kendaraan',
            'data' => $parkir
        ]);
    }

    public function cekKeluar(Request $request)
    {
        $request->validate([
            'kode_unik' => 'required'
        ]);

        $parkir = Parking::with('tarif')->where('kode_unik', $request->kode_unik)->first();

        if (!$parkir) {
            return response()->json([
                'message' => 'Data parkir tidak ditemukan'
            ], 404);
        }

        if ($parkir->waktu_keluar) {
            return response()->json([
                'message' => 'Kendaraan sudah keluar'
            ], 400);
        }

        $waktuKeluar = now();

        $durasiDetik =
            strtotime($waktuKeluar) -
            strtotime($parkir->waktu_masuk);

        $durasiHari = ceil($durasiDetik / 86400);

        if ($durasiHari < 1) {
            $durasiHari = 1;
        }

        $totalBayar = $durasiHari * $parkir->tarif->harga_per_hari;

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => [
                'id' => $parkir->id,
                'kode_unik' => $parkir->kode_unik,
                'plat_nomor' => $parkir->plat_nomor,
                'jenis_kendaraan' => $parkir->tarif->jenis_kendaraan,
                'harga_per_hari' => $parkir->tarif->harga_per_hari,
                'durasi_hari' => $durasiHari,
                'total_bayar' => $totalBayar,
                'waktu_masuk' => $parkir->waktu_masuk
            ]
        ]);

    }

    public function keluar(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $parkir = Parking::with('tarif')
            ->find($request->id);

        if (!$parkir) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if ($parkir->waktu_keluar) {
            return response()->json([
                'message' => 'Kendaraan sudah keluar'
            ], 400);
        }

        $waktuKeluar = now();

        $durasiDetik =
            strtotime($waktuKeluar) -
            strtotime($parkir->waktu_masuk);

        $durasiHari = ceil($durasiDetik / 86400);

        if ($durasiHari < 1) {
            $durasiHari = 1;
        }

        $totalBayar =
            $durasiHari *
            $parkir->tarif->harga_per_hari;

        $parkir->update([
            'waktu_keluar' => $waktuKeluar,
            'total_bayar' => $totalBayar
        ]);

        return response()->json([
            'message' => 'Pembayaran berhasil',

            'data' => [
                'kode_unik' => $parkir->kode_unik,
                'plat_nomor' => $parkir->plat_nomor,
                'jenis_kendaraan' => $parkir->tarif->jenis_kendaraan,
                'durasi_hari' => $durasiHari,
                'total_bayar' => $totalBayar,
                'waktu_keluar' => $waktuKeluar
            ]
        ]);
    }
}
