<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TvApiController extends Controller
{
    public function index()
    {
        try {
            $tv = DB::table('tvs')->orderBy('id', 'asc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil daftar TV',
                'data' => $tv
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data TV',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|unique:tvs,id',
            'nama_tv' => 'required|string|max:255',
            'model' => 'required|string',
        ]);

        try {
            DB::table('tvs')->insert([
                'id' => $request->id,
                'nama_tv' => $request->nama_tv,
                'model' => $request->model,
                'kondisi' => 'Baik',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'TV baru berhasil ditambahkan',
                'data' => $request->all()
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data TV',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
