<?php

use Illuminate\Support\Facades\Route;

// Import semua controller yang kita butuhkan
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PenerbanganController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RiwayatController;
// ==========================================================
// === LANGKAH 1: Tambahkan use statement untuk ETicketController ===
// ==========================================================
use App\Http\Controllers\ETicketController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/auth/login');

// Route untuk otentikasi (Sudah Benar)
Route::prefix('auth')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});


// Route yang TIDAK memerlukan login
// Siapa saja boleh mencari jadwal penerbangan
Route::get('/jadwal', [PenerbanganController::class, 'index'])->name('jadwal');


// Grup untuk semua route yang MEMERLUKAN login
Route::middleware('auth')->group(function () {

    // Route untuk proses pemesanan
    Route::get('/pemesanan/{penerbangan}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');

    // Route untuk proses pembayaran
    Route::get('/pembayaran/{pemesanan}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{pemesanan}/process', [PembayaranController::class, 'process'])->name('pembayaran.process');

    // Route untuk halaman riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    // ==========================================================
    // === LANGKAH 2: Tambahkan route untuk download E-Tiket  ===
    // ==========================================================
    Route::get('/e-ticket/{pemesanan}/download', [ETicketController::class, 'download'])->name('eticket.download');

});