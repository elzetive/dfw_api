<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardApiController;

Route::get('/dashboard-data', [DashboardApiController::class, 'getDashboardData']);
