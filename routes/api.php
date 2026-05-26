<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\PelangganApiController;
use App\Http\Controllers\Api\KonsolApiController;
use App\Http\Controllers\Api\TvApiController;
use App\Http\Controllers\Api\UnitApiController;
use App\Http\Controllers\Api\TransaksiApiController;

Route::get('/dashboard-data', [DashboardApiController::class, 'getDashboardData']);

Route::get('/pelanggan', [PelangganApiController::class, 'index']);
Route::post('/pelanggan', [PelangganApiController::class, 'store']);

Route::get('/konsol', [KonsolApiController::class, 'index']);
Route::post('/konsol', [KonsolApiController::class, 'store']);

Route::get('/tv', [TvApiController::class, 'index']);
Route::post('/tv', [TvApiController::class, 'store']);

Route::get('/unit', [UnitApiController::class, 'index']);
Route::post('/unit', [UnitApiController::class, 'store']);

Route::get('/transaksi', [TransaksiApiController::class, 'index']);
Route::post('/transaksi', [TransaksiApiController::class, 'store']);
