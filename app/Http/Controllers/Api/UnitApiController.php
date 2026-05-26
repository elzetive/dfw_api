<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitApiController extends Controller
{
    public function index()
    {
        try {
            $units = DB::table('units')
                ->join('konsols', 'units.konsol_id', '=', 'konsols.id')
                ->join('tvs', 'units.tv_id', '=', 'tvs.id')
                ->select(
                    'units.id',
                    'units.nama_unit',
                    'konsols.nama_unit as nama_konsol',
                    'tvs.nama_tv as nama_tv',
                    'units.status'
                )
                ->orderBy('units.id', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil daftar unit play',
                'data' => $units
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data unit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'konsol_id' => 'required|string|exists:konsols,id',
            'tv_id'     => 'required|string|exists:tvs,id',
        ]);

        try {
            DB::table('units')->insert([
                'nama_unit' => $request->nama_unit,
                'konsol_id' => $request->konsol_id,
                'tv_id'     => $request->tv_id,
                'status'    => 'Tersedia',
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kombinasi Unit Play baru berhasil dibuat',
            ], 21);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat unit play',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
