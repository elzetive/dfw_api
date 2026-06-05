<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
                    'units.konsol_id',
                    'units.tv_id',
                    'konsols.nama_unit as nama_konsol',
                    'konsols.tipe as tipe',
                    'tvs.nama_tv as nama_tv',
                    'units.status'
                )
                ->orderBy('units.id', 'asc')
                ->get();

            return response()->json(['success' => true, 'data' => $units], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_unit' => 'required|string|max:255',
            'konsol_id' => 'required|string|exists:konsols,id',
            'tv_id' => 'required|string|exists:tvs,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            DB::table('units')->insert([
                'nama_unit' => $request->nama_unit,
                'konsol_id' => $request->konsol_id,
                'tv_id' => $request->tv_id,
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['success' => true, 'message' => 'Unit Play berhasil dibuat'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::table('units')->where('id', $id)->update([
                'nama_unit' => $request->nama_unit,
                'konsol_id' => $request->konsol_id,
                'tv_id' => $request->tv_id,
                'status' => $request->status,
                'updated_at' => now(),
            ]);
            return response()->json(['success' => true, 'message' => 'Unit Play berhasil diubah'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('units')->where('id', $id)->delete();
            return response()->json(['success' => true, 'message' => 'Unit Play berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
