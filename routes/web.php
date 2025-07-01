<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JadwalController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/auth/login');

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login']); 

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register']); 
});



Route::middleware('auth')->group(function () {
    
    Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});