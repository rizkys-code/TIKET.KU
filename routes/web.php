<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
// Ganti PenerbanganController dengan JadwalController jika itu yang Anda gunakan
use App\Http\Controllers\PenerbanganController;
use App\Http\Controllers\PemesananController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/auth/login');

Route::prefix('auth')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Grup untuk semua route yang memerlukan login
Route::middleware('auth')->group(function () {

    // Route untuk menampilkan hasil pencarian penerbangan (sudah benar)
    Route::get('/jadwal', [PenerbanganController::class, 'index'])->name('jadwal');

    // === PERUBAHAN DI SINI ===

    Route::get('/pemesanan/{penerbangan}', [PemesananController::class, 'show'])->name('pemesanan.show');

    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');

    // Route::get('/pembayaran/{booking_id}', [PembayaranController::class, 'show'])->name('payment.page');

});
