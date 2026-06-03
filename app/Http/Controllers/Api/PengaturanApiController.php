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

            // Jika data kosong, buat row default memanfaatkan kolom ready (harga_xbox)
            if (!$pengaturan) {
                DB::table('pengaturans')->insert([
                    'id'              => 1,
                    'nama_usaha'      => 'DFW Playstation',
                    'jam_operasional' => '09:00 - 23:00',
                    'harga_ps4'       => 12000,
                    'harga_ps5'       => 18000,
                    'harga_xbox'      => 8000,  // Kita pakai kolom xbox sebagai wadah tarif PS3
                    'harga_nintendo'  => 0,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                $pengaturan = DB::table('pengaturans')->where('id', 1)->first();
            }

            // AKAL PINTAR: Suntik properti hantu 'harga_ps3' agar Flutter membacanya dengan normal
            $pengaturan->harga_ps3 = $pengaturan->harga_xbox;

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data pengaturan usaha',
                'data'    => $pengaturan
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil pengaturan',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $ada = DB::table('pengaturans')->where('id', 1)->exists();

            if (!$ada) {
                DB::table('pengaturans')->insert([
                    'id'              => 1,
                    'nama_usaha'      => $request->nama_usaha,
                    'jam_operasional' => $request->jam_operasional,
                    'harga_ps4'       => $request->harga_ps4 ?? 12000,
                    'harga_ps5'       => $request->harga_ps5 ?? 18000,
                    'harga_xbox'      => $request->harga_ps3 ?? 8000, // Belokkan data PS3 dari Flutter ke kolom xbox
                    'harga_nintendo'  => 0,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            } else {
                DB::table('pengaturans')->where('id', 1)->update([
                    'nama_usaha'      => $request->nama_usaha,
                    'jam_operasional' => $request->jam_operasional,
                    'harga_ps4'       => $request->harga_ps4,
                    'harga_ps5'       => $request->harga_ps5,
                    'harga_xbox'      => $request->harga_ps3, // Belokkan data PS3 dari Flutter ke kolom xbox
                    'harga_nintendo'  => 0,
                    'updated_at'      => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan berhasil disimpan!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pengaturan: ' . $e->getMessage()
            ], 500);
        }
    }
}
