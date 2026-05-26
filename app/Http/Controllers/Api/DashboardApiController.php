<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardApiController extends Controller
{
    public function getDashboardData()
    {
        try {
            $totalUnit = DB::table('units')->count();
            $sedangAktif = DB::table('units')->where('status', 'Tidak Tersedia')->count();
            $tersedia = DB::table('units')->where('status', 'Tersedia')->count();
            $maintenance = DB::table('units')->where('status', 'Maintenance')->count();

            $transaksiTerbaru = [];

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data dashboard DFW',
                'data' => [
                    'statistics' => [
                        'total_unit' => $totalUnit,
                        'sedang_aktif' => $sedangAktif,
                        'tersedia' => $tersedia,
                        'dalam_perawatan' => $maintenance,
                    ],
                    'transactions' => $transaksiTerbaru
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
