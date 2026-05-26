<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KonsolApiController extends Controller
{
    public function index()
    {
        try {
            $konsol = DB::table('konsols')->orderBy('id', 'asc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil daftar konsol',
                'data' => $konsol
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data konsol',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|unique:konsols,id',
            'nama_unit' => 'required|string|max:255',
            'tipe' => 'required|in:PS3,PS4,PS5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            DB::table('konsols')->insert([
                'id' => $request->id,
                'nama_unit' => $request->nama_unit,
                'tipe' => $request->tipe,
                'kondisi' => 'Baik',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Konsol baru berhasil ditambahkan',
                'data' => $request->all()
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data konsol',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
