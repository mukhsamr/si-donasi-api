<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\InfaqController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Auth
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/', 'authenticate')->name('authenticate');
    Route::get('logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

// User
Route::middleware('auth:sanctum')->prefix('user')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::patch('/', 'update');
});

// Infaq
Route::prefix('infaq')->controller(InfaqController::class)->name('infaq')->group(function () {
    Route::get('/', 'index')->name('.all');
    Route::get('/{infaq}', 'find')->name('.find');
    Route::post('/', 'store')->name('.store');
    Route::patch('/', 'update')->name('.update');
    Route::delete('/{id}', 'destroy')->name('.destroy');
});

// Berita
Route::prefix('berita')->controller(BeritaController::class)->name('berita')->group(function () {
    Route::get('/', 'index')->name('.all');
    Route::get('/{berita}', 'find')->name('.find');
    Route::post('/', 'store')->name('.store');
    Route::patch('/', 'update')->name('.update');
    Route::delete('/{id}', 'destroy')->name('.destroy');
});

// Laporan
Route::prefix('laporan')->controller(LaporanController::class)->name('laporan')->group(function () {
    Route::get('/bulan', 'bulan')->name('.bulan');
    Route::get('/', 'index')->name('.all');
    Route::get('/{laporan}', 'find')->name('.find');
    Route::post('/', 'store')->name('.store');
    Route::patch('/', 'update')->name('.update');
    Route::delete('/{id}', 'destroy')->name('.destroy');
});

// Payment
Route::prefix('pay')->controller(MidtransController::class)->group(function () {
    Route::get('snap', 'snap')->name('snap');
    Route::post('token', 'token')->name('token');
    Route::post('store', 'store')->name('store');
    Route::post('handler', 'handler')->name('handler');
});
