<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\TarifController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/chart-pendapatan', [DashboardController::class, 'chartPendapatan']);

    Route::get('/parkir', [ParkingController::class, 'index']);
    Route::post('/parkir', [ParkingController::class, 'store']);

    Route::post('/parkir/cek-keluar', [ParkingController::class, 'cekKeluar']);
    Route::post('/parkir/keluar', [ParkingController::class, 'keluar']);

    Route::get('/tarif', [TarifController::class, 'index']);
    Route::get('/tarif/{id}', [TarifController::class, 'show']);
    Route::post('/tarif', [TarifController::class, 'store']);
    Route::put('/tarif/{id}', [TarifController::class, 'update']);
    Route::delete('/tarif/{id}', [TarifController::class, 'destroy']);

});

