<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanApiController extends Controller
{
    public function index()
    {
        try {
            $pengaturan = DB::table('pengaturans')->where('id', 1)->first();

            if (!$pengaturan) {
                DB::table('pengaturans')->insert([
                    'id'              => 1,
                    'nama_usaha'      => 'DFW Playstation',
                    'jam_operasional' => '09:00 - 23:00',
                    'harga_ps3'       => 8000,
                    'harga_ps4'       => 12000,
                    'harga_ps5'       => 18000,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
                $pengaturan = DB::table('pengaturans')->where('id', 1)->first();
            }

            return response()->json([
                'success' => true,
                'data'    => $pengaturan
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $ada = DB::table('pengaturans')->where('id', 1)->exists();

            $dataToSave = [
                'nama_usaha'      => $request->nama_usaha,
                'jam_operasional' => $request->jam_operasional,
                'harga_ps3'       => $request->has('harga_ps3') ? (int)$request->harga_ps3 : 8000,
                'harga_ps4'       => $request->has('harga_ps4') ? (int)$request->harga_ps4 : 12000,
                'harga_ps5'       => $request->has('harga_ps5') ? (int)$request->harga_ps5 : 18000,
                'updated_at'      => now(),
            ];

            if (!$ada) {
                $dataToSave['id'] = 1;
                $dataToSave['created_at'] = now();
                DB::table('pengaturans')->insert($dataToSave);
            } else {
                DB::table('pengaturans')->where('id', 1)->update($dataToSave);
            }

            return response()->json(['success' => true, 'message' => 'Berhasil disimpan!'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
