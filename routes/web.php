<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\BookingAdminController;

/*
|--------------------------------------------------------------------------
| Portal Pelanggan (Public — Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/',                [PortalController::class, 'index'])->name('index');
    Route::get('/buku/{buku}',     [PortalController::class, 'detail'])->name('detail');
    Route::get('/booking/{buku}',  [PortalController::class, 'formBooking'])->name('booking');
    Route::post('/booking/{buku}', [PortalController::class, 'simpanBooking'])->name('booking.simpan');
    Route::get('/cek-booking',     [PortalController::class, 'cekBooking'])->name('cek-booking');
});

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/',       fn() => redirect()->route('portal.index'));
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Admin & Petugas)
|--------------------------------------------------------------------------
*/
Route::middleware('auth.custom')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('buku', BukuController::class);

    Route::resource('anggota', AnggotaController::class)->middleware('admin');

    Route::resource('peminjaman', PeminjamanController::class);
    Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');

    Route::get('/booking',                    [BookingAdminController::class, 'index'])->name('booking.index');
    Route::get('/booking/{booking}',          [BookingAdminController::class, 'show'])->name('booking.show');
    Route::post('/booking/{booking}/setujui', [BookingAdminController::class, 'setujui'])->name('booking.setujui');
    Route::post('/booking/{booking}/tolak',   [BookingAdminController::class, 'tolak'])->name('booking.tolak');
    Route::post('/booking/{booking}/selesai', [BookingAdminController::class, 'selesai'])->name('booking.selesai');
    Route::delete('/booking/{booking}',       [BookingAdminController::class, 'destroy'])->name('booking.destroy');
});
