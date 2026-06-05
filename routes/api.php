<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\PelangganApiController;
use App\Http\Controllers\Api\KonsolApiController;
use App\Http\Controllers\Api\TvApiController;
use App\Http\Controllers\Api\UnitApiController;
use App\Http\Controllers\Api\TransaksiApiController;
use App\Http\Controllers\Api\LaporanApiController;
use App\Http\Controllers\Api\PengaturanApiController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard-data', [DashboardApiController::class, 'getDashboardData']);

Route::get('/pelanggan', [PelangganApiController::class, 'index']);
Route::post('/pelanggan', [PelangganApiController::class, 'store']);

Route::get('/konsol', [KonsolApiController::class, 'index']);
Route::post('/konsol', [KonsolApiController::class, 'store']);
Route::put('/konsol/{id}', [KonsolApiController::class, 'update']);
Route::delete('/konsol/{id}', [KonsolApiController::class, 'destroy']);

Route::get('/tv', [TvApiController::class, 'index']);
Route::post('/tv', [TvApiController::class, 'store']);
Route::put('/tv/{id}', [TvApiController::class, 'update']);
Route::delete('/tv/{id}', [TvApiController::class, 'destroy']);

Route::get('/unit', [UnitApiController::class, 'index']);
Route::post('/unit', [UnitApiController::class, 'store']);
Route::put('/unit/{id}', [UnitApiController::class, 'update']);
Route::delete('/unit/{id}', [UnitApiController::class, 'destroy']);

Route::get('/transaksi', [TransaksiApiController::class, 'index']);
Route::post('/transaksi', [TransaksiApiController::class, 'store']);
Route::get('/transaksi/aktif', [TransaksiApiController::class, 'getTransaksiAktif']);
Route::post('/transaksi/selesai', [TransaksiApiController::class, 'selesaikanTransaksi']);

Route::get('/laporan', [LaporanApiController::class, 'index']);
Route::get('/laporan/{tanggal}', [LaporanApiController::class, 'detail']);

Route::get('/pengaturan', [PengaturanApiController::class, 'index']);
Route::post('/pengaturan', [PengaturanApiController::class, 'update']);

