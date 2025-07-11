<?php

use Illuminate\Support\Facades\Route;

// Import semua controller yang kita butuhkan
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PenerbanganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembayaranController; // <-- PASTIKAN INI DI-IMPORT

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/auth/login');

// Route untuk otentikasi
Route::prefix('auth')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Grup untuk semua route yang memerlukan login
Route::middleware('auth')->group(function () {

    // Route untuk menampilkan hasil pencarian penerbangan
    Route::get('/jadwal', [PenerbanganController::class, 'index'])->name('jadwal');

    // Route untuk form pemesanan
    Route::get('/pemesanan/{penerbangan}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');

    // ======================================================================
    // === TAMBAHKAN BLOK INI UNTUK MEMPERBAIKI ERROR ROUTE               ===
    // ======================================================================
    // Route untuk menampilkan halaman pembayaran
    Route::get('/pembayaran/{id_pemesanan}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    
    // Route untuk memproses pembayaran (saat tombol "Bayar" diklik)
    Route::post('/pembayaran/{id_pemesanan}/process', [PembayaranController::class, 'processPayment'])->name('pembayaran.process');
    // ======================================================================

});