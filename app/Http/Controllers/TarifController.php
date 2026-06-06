<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;

class TarifController extends Controller
{
    public function index()
    {
        return response()->json(
            Tarif::latest()->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|unique:tarifs',
            'harga_per_hari' => 'required|numeric|min:0'
        ]);

        $tarif = Tarif::create([
            'jenis_kendaraan' => strtolower($request->jenis_kendaraan),
            'harga_per_hari' => $request->harga_per_hari
        ]);

        return response()->json([
            'message' => 'Tarif berhasil ditambahkan',
            'data' => $tarif
        ]);
    }

    public function show($id)
    {
        $tarif = Tarif::find($id);

        if (!$tarif) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json($tarif);
    }

    public function update(Request $request, $id)
    {
        $tarif = Tarif::find($id);

        if (!$tarif) {
            return response()->json([
                'message' => 'Tarif tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'jenis_kendaraan' => 'required',
            'harga_per_hari' => 'required|numeric|min:0'
        ]);

        $tarif->update([
            'jenis_kendaraan' => strtolower($request->jenis_kendaraan),
            'harga_per_hari' => $request->harga_per_hari
        ]);

        return response()->json([
            'message' => 'Tarif berhasil diupdate',
            'data' => $tarif
        ]);
    }

    public function destroy($id)
    {
        $tarif = Tarif::find($id);

        if (!$tarif) {
            return response()->json([
                'message' => 'Tarif tidak ditemukan'
            ], 404);
        }

        $tarif->delete();

        return response()->json([
            'message' => 'Tarif berhasil dihapus'
        ]);
    }
}
