<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanApiController extends Controller
{
    public function getPengaturan()
    {
        $pengaturan = DB::table('pengaturans')->where('id', 1)->first();

        // Kalo database kosong, balikin error 404 biar Flutter tau
        if (!$pengaturan) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengaturan belum ada di database'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pengaturan
        ]);
    }

    public function updatePengaturan(Request $request)
    {
        try {
            // Karena dari migration data ID 1 pasti udah ada, kita tinggal tembak update aja
            DB::table('pengaturans')->where('id', 1)->update([
                'nama_usaha'      => $request->nama_usaha,
                'jam_operasional' => $request->jam_operasional,
                'harga_ps4'       => $request->harga_ps4,
                'harga_ps5'       => $request->harga_ps5,
                'harga_xbox'      => $request->harga_xbox,
                'harga_nintendo'  => $request->harga_nintendo,
                'updated_at'      => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan berhasil disimpan!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pengaturan: ' . $e->getMessage()
            ], 500);
        }
    }
}