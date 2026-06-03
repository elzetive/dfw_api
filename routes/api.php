<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\PelangganApiController;
use App\Http\Controllers\Api\KonsolApiController;
use App\Http\Controllers\Api\TvApiController;
use App\Http\Controllers\Api\UnitApiController;
use App\Http\Controllers\Api\TransaksiApiController;
use App\Http\Controllers\Api\LaporanApiController; // Ditambahkan
use App\Http\Controllers\Api\PengaturanApiController; // Ditambahkan jika ada
use App\Http\Controllers\Api\AuthController;

// ==================== AUTHENTICATION ====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==================== DASHBOARD & DATA MASTER ====================
Route::get('/dashboard-data', [DashboardApiController::class, 'getDashboardData']);

Route::get('/pelanggan', [PelangganApiController::class, 'index']);
Route::post('/pelanggan', [PelangganApiController::class, 'store']);

// KONSOL CRUD
Route::get('/konsol', [KonsolApiController::class, 'index']);
Route::post('/konsol', [KonsolApiController::class, 'store']);
Route::put('/konsol/{id}', [KonsolApiController::class, 'update']);
Route::delete('/konsol/{id}', [KonsolApiController::class, 'destroy']);

// TV CRUD
Route::get('/tv', [TvApiController::class, 'index']);
Route::post('/tv', [TvApiController::class, 'store']);
Route::put('/tv/{id}', [TvApiController::class, 'update']);
Route::delete('/tv/{id}', [TvApiController::class, 'destroy']);

// UNIT CRUD
Route::get('/unit', [UnitApiController::class, 'index']);
Route::post('/unit', [UnitApiController::class, 'store']);
Route::put('/unit/{id}', [UnitApiController::class, 'update']);
Route::delete('/unit/{id}', [UnitApiController::class, 'destroy']);

// ==================== TRANSAKSI & OPERASIONAL ====================
Route::get('/transaksi', [TransaksiApiController::class, 'index']);
Route::post('/transaksi', [TransaksiApiController::class, 'store']);
Route::get('/transaksi/aktif', [TransaksiApiController::class, 'getTransaksiAktif']);
Route::post('/transaksi/selesai', [TransaksiApiController::class, 'selesaikanTransaksi']);

// ==================== LAPORAN (PERBAIKAN) ====================
Route::get('/laporan', [LaporanApiController::class, 'index']);
Route::get('/laporan/{tanggal}', [LaporanApiController::class, 'detail']);

// ==================== PENGATURAN TARIF (PERBAIKAN) ====================
// Jika file PengaturanApiController milik Wahyu sudah dibuat, gunakan baris ini:
Route::get('/pengaturan', [PengaturanApiController::class, 'index']);
Route::post('/pengaturan', [PengaturanApiController::class, 'update']);

// JIKA BELUM ADA file PengaturanApiController di proyek kalian, pakai rute sementara ini dulu
// (Buka tanda komentar di bawah ini jika error class PengaturanApiController not found)
/*
Route::get('/pengaturan', function() {
    return response()->json([
        'success' => true,
        'data' => [
            'nama_usaha' => 'DFW Playstation',
            'harga_ps4' => 12000,
            'harga_ps5' => 18000,
            'harga_xbox' => 15000,
            'harga_nintendo' => 10000
        ]
    ]);
});
*/
