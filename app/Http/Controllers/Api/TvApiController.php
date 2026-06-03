<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TvApiController extends Controller
{
    public function index()
    {
        try {
            $tv = DB::table('tvs')->orderBy('id', 'asc')->get();
            return response()->json(['success' => true, 'data' => $tv], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_tv_manual' => 'required|string|unique:tvs,id',
            'nama_tv' => 'required|string|max:255',
            'model' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            DB::table('tvs')->insert([
                'id' => $request->id_tv_manual,
                'nama_tv' => $request->nama_tv,
                'model' => $request->model,
                'kondisi' => 'Baik',
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['success' => true, 'message' => 'TV berhasil ditambahkan'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::table('tvs')->where('id', $id)->update([
                'nama_tv' => $request->nama_tv,
                'model' => $request->model,
                'kondisi' => $request->kondisi,
                'status' => $request->status,
                'updated_at' => now(),
            ]);
            return response()->json(['success' => true, 'message' => 'TV berhasil diubah'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('tvs')->where('id', $id)->delete();
            return response()->json(['success' => true, 'message' => 'TV dan Unit terkait berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
