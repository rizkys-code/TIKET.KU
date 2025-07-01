<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
    // Route::post('logout', [LoginController::class, 'login'])->name('logout');
});

// Route::get('login', function () {
//     return view('auth.login');
// });



Route::get('/', function () {
    return view('welcome');
});
