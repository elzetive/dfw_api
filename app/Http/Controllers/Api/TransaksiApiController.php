<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiApiController extends Controller
{
    public function index()
    {
        try {
            $transaksi = DB::table('transaksis')
                ->join('units', 'transaksis.unit_id', '=', 'units.id')
                ->join('pelanggans', 'transaksis.pelanggan_id', '=', 'pelanggans.id')
                ->select(
                    'transaksis.id',
                    'pelanggans.nama_pelanggan',
                    'units.nama_unit',
                    'transaksis.tipe_penyewaan',
                    'transaksis.durasi_jam',
                    'transaksis.total_harga',
                    'transaksis.status',
                    'transaksis.created_at'
                )
                ->orderBy('transaksis.id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data riwayat transaksi',
                'data' => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id'        => 'required|integer|exists:units,id',
            'pelanggan_id'   => 'required|integer|exists:pelanggans,id',
            'tipe_penyewaan' => 'required|in:Main di Tempat,Dibawa Pulang',
            'durasi_jam'     => 'required|integer',
            'total_harga'    => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $unit = DB::table('units')->where('id', $request->unit_id)->first();
            if ($unit->status !== 'Tersedia') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unit play ini sedang dipakai atau dalam perawatan!'
                ], 400);
            }

            DB::table('transaksis')->insert([
                'unit_id'        => $request->unit_id,
                'pelanggan_id'   => $request->pelanggan_id,
                'tipe_penyewaan' => $request->tipe_penyewaan,
                'durasi_jam'     => $request->durasi_jam,
                'total_harga'    => $request->total_harga,
                'status'         => 'Aktif',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            DB::table('units')->where('id', $request->unit_id)->update([
                'status' => 'Tidak Tersedia'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibuat! Unit resmi aktif.',
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses transaksi sewa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
