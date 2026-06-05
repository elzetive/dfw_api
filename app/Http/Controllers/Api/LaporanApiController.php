<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanApiController extends Controller
{
    public function index()
    {
        try {
            $laporan = DB::table('transaksis')
                ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as tanggal"))
                ->where('status', 'Selesai')
                ->distinct()
                ->orderBy('tanggal', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil daftar laporan harian',
                'data' => $laporan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function detail(string $tanggal)
    {
        try {
            $transaksi = DB::table('transaksis')
                ->leftJoin('pelanggans', 'transaksis.pelanggan_id', '=', 'pelanggans.id')
                ->leftJoin('units', 'transaksis.unit_id', '=', 'units.id')
                ->select(
                    'transaksis.*',
                    'pelanggans.nama_pelanggan',
                    'units.nama_unit'
                )
                ->whereDate('transaksis.created_at', $tanggal)
                ->where('transaksis.status', 'Selesai')
                ->orderBy('transaksis.id', 'desc')
                ->get();

            $total_pendapatan = (int) $transaksi->sum('total_harga');
            $total_transaksi = $transaksi->count();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil detail laporan tanggal: ' . $tanggal,
                'summary' => [
                    'total_transaksi' => $total_transaksi,
                    'total_pendapatan' => $total_pendapatan
                ],
                'data' => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
