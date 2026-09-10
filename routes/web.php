<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuestBookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik — Buku Tamu
|--------------------------------------------------------------------------
| Empat URL berbeda mengarah ke buku tamu yang sama, tetapi sumber
| pengunjung dicatat otomatis ke database.
*/

Route::get('/', [GuestBookController::class, 'create'])
    ->defaults('sumber', 'direct')
    ->name('guest.form');

Route::get('/{sumber}', [GuestBookController::class, 'create'])
    ->whereIn('sumber', ['whatsapp', 'instagram', 'facebook'])
    ->name('guest.form.sumber');

Route::post('/tamu', [GuestBookController::class, 'store'])
    ->name('guest.store');

/*
|--------------------------------------------------------------------------
| Autentikasi Admin
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Area Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('/tamu', [GuestController::class, 'index'])->name('guests.index');
        Route::get('/tamu/{guest}/edit', [GuestController::class, 'edit'])->name('guests.edit');
        Route::put('/tamu/{guest}', [GuestController::class, 'update'])->name('guests.update');
        Route::delete('/tamu/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
    });
