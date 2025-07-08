<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\PelangganApiController;
use App\Http\Controllers\Api\KamarApiController;
use App\Http\Controllers\Api\PemesananApiController;
use App\Http\Controllers\Api\PembayaranApiController;
use App\Http\Controllers\Api\UlasanApiController;
use App\Http\Controllers\Api\AuthApiController;

// Auth


// Resource API
Route::apiResource('users', UserApiController::class);
Route::apiResource('pelanggan', PelangganApiController::class);
Route::apiResource('kamar', KamarApiController::class);
Route::apiResource('pemesanan', PemesananApiController::class);
Route::apiResource('pembayaran', PembayaranApiController::class);
Route::apiResource('ulasan', UlasanApiController::class);
