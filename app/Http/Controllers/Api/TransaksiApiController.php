<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiApiController extends Controller
{
    // MENAMPILKAN SEMUA DATA (Untuk Riwayat Hari Ini)
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

    // MENAMPILKAN HANYA YANG BERSTATUS AKTIF
    public function getTransaksiAktif()
    {
        try {
            $transaksi = DB::table('transaksis')
                ->join('units', 'transaksis.unit_id', '=', 'units.id')
                ->join('pelanggans', 'transaksis.pelanggan_id', '=', 'pelanggans.id')
                ->select(
                    'transaksis.id',
                    'transaksis.unit_id',
                    'pelanggans.nama_pelanggan',
                    'units.nama_unit',
                    'transaksis.tipe_penyewaan',
                    'transaksis.durasi_jam',
                    'transaksis.total_harga',
                    'transaksis.status'
                )
                ->where('transaksis.status', 'Aktif')
                ->orderBy('transaksis.id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data transaksi aktif',
                'data' => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data aktif',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // UPDATE STATUS TRANSAKSI & KEMBALIKAN STATUS UNIT PLAY
    public function selesaikanTransaksi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaksi_id' => 'required',
            'unit_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter tidak lengkap',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            DB::table('transaksis')
                ->where('id', $request->transaksi_id)
                ->update([
                    'status' => 'Selesai',
                    'updated_at' => now()
                ]);

            DB::table('units')
                ->where('id', $request->unit_id)
                ->update([
                    'status' => 'Tersedia',
                    'updated_at' => now()
                ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Transaksi Selesai'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyelesaikan transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // MEMBUAT TRANSAKSI BARU
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id'        => 'required|exists:units,id',
            'pelanggan_id'   => 'required|exists:pelanggans,id',
            'tipe_penyewaan' => 'required',
            'durasi_jam'     => 'required',
            'total_harga'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal, pastikan relasi unit dan pelanggan cocok.',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $unit = DB::table('units')->where('id', $request->unit_id)->first();

            if (!$unit || $unit->status !== 'Tersedia') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Unit play ini sedang dipakai atau dalam perawatan!'
                ], 400);
            }

            // Tambah riwayat transaksi sewa aktif
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

            // Kunci kombinasi unit menjadi tidak tersedia agar hilang dari dropdown menu sewa baru
            DB::table('units')->where('id', $request->unit_id)->update([
                'status' => 'Tidak Tersedia',
                'updated_at' => now()
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
