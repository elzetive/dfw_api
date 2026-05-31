<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganApiController extends Controller
{
    public function index()
    {
        try {
            $pelanggan = DB::table('pelanggans')->orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil daftar pelanggan',
                'data' => $pelanggan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon'        => 'required|string',
            'alamat'         => 'required|string',
        ]);

        try {
            $idBaru = DB::table('pelanggans')->insertGetId([
                'nama_pelanggan' => $request->nama_pelanggan,
                'telepon'        => $request->telepon,
                'alamat'         => $request->alamat,
                'status'         => 'Aktif',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pelanggan baru berhasil didaftarkan',
                'data' => [
                    'id' => $idBaru,
                    'nama_pelanggan' => $request->nama_pelanggan
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data pelanggan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $pelanggan = DB::table('pelanggans')->where('id', $id)->first();
            
            if (!$pelanggan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pelanggan tidak ditemukan'
                ], 404);
            }

            DB::table('pelanggans')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data pelanggan berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon'        => 'required|string',
            'alamat'         => 'required|string',
            'status'         => 'required|in:Aktif,Nonaktif'
        ]);

        try {
            $pelanggan = DB::table('pelanggans')->where('id', $id)->first();
            
            if (!$pelanggan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pelanggan tidak ditemukan'
                ], 404);
            }

            DB::table('pelanggans')->where('id', $id)->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'telepon'        => $request->telepon,
                'alamat'         => $request->alamat,
                'status'         => $request->status,
                'updated_at'     => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data pelanggan berhasil diubah'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
