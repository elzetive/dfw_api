<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\PelangganApiController;
use App\Http\Controllers\Api\KonsolApiController;
use App\Http\Controllers\Api\TvApiController;
use App\Http\Controllers\Api\UnitApiController;
use App\Http\Controllers\Api\TransaksiApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LaporanApiController;
use App\Http\Controllers\Api\PengaturanApiController;

// ==================== AUTHENTICATION ====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']); // <--- INI SUDAH DITAMBAHKAN

// ==================== DASHBOARD & DATA MASTER ====================
Route::get('/dashboard-data', [DashboardApiController::class, 'getDashboardData']);

Route::get('/pelanggan', [PelangganApiController::class, 'index']);
Route::post('/pelanggan', [PelangganApiController::class, 'store']);
Route::delete('/pelanggan/{id}', [PelangganApiController::class, 'destroy']);
Route::put('/pelanggan/{id}', [PelangganApiController::class, 'update']);

Route::get('/konsol', [KonsolApiController::class, 'index']);
Route::post('/konsol', [KonsolApiController::class, 'store']);

Route::get('/tv', [TvApiController::class, 'index']);
Route::post('/tv', [TvApiController::class, 'store']);

Route::get('/unit', [UnitApiController::class, 'index']);
Route::post('/unit', [UnitApiController::class, 'store']);

// ==================== TRANSAKSI & OPERASIONAL ====================
Route::get('/transaksi', [TransaksiApiController::class, 'index']);
Route::post('/transaksi', [TransaksiApiController::class, 'store']);

Route::get('/transaksi/aktif', [TransaksiApiController::class, 'getTransaksiAktif']);
Route::post('/transaksi/selesai', [TransaksiApiController::class, 'selesaikanTransaksi']);

// ==================== LAPORAN ====================
Route::get('/laporan', [LaporanApiController::class, 'index']);
Route::get('/laporan/{tanggal}', [LaporanApiController::class, 'detail']);

// ==================== PENGATURAN ====================
Route::get('/pengaturan', [PengaturanApiController::class, 'getPengaturan']);
Route::post('/pengaturan', [PengaturanApiController::class, 'updatePengaturan']);