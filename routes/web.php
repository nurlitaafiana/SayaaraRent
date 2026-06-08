<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PembayaranController;

Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return redirect()->route(auth()->user()->role . '.dashboard');
    });
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('kategori', KategoriController::class);
        Route::resource('kendaraan', KendaraanController::class);

        Route::get('/rental', [RentalController::class, 'index'])->name('rental.index');
        Route::patch('/rental/{id}/verify', [RentalController::class, 'verify'])->name('rental.verify');
        Route::patch('/rental/{id}/reject', [RentalController::class, 'reject'])->name('rental.reject');
        Route::patch('/rental/{id}/complete', [RentalController::class, 'complete'])->name('rental.complete');

        Route::get('/pembayaran', [PembayaranController::class, 'adminIndex'])->name('pembayaran.index');
        Route::get('/pembayaran/verified', [PembayaranController::class, 'verifiedPayments'])->name('pembayaran.verified');
        Route::patch('/pembayaran/{id}/verify', [PembayaranController::class, 'verifyPayment'])->name('pembayaran.verify');
        Route::patch('/pembayaran/{id}/reject', [PembayaranController::class, 'rejectPayment'])->name('pembayaran.reject');
    });

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [RentalController::class, 'customerDashboard'])->name('dashboard');
        Route::get('/kendaraan', [KendaraanController::class, 'available'])->name('kendaraan.index');
        Route::get('/rental', [RentalController::class, 'index'])->name('rental.index');
        Route::get('/rental/create', [RentalController::class, 'create'])->name('rental.create');
        Route::post('/rental/store', [RentalController::class, 'store'])->name('rental.store');
        Route::patch('/rental/{id}/cancel', [RentalController::class, 'cancel'])->name('rental.cancel');
        Route::get('/rental/history', [RentalController::class, 'history'])->name('rental.history');
        Route::get('/payment', [PembayaranController::class, 'index'])->name('payment.index');
        Route::get('/payment/{rental_id}', [PembayaranController::class, 'create'])->name('payment.create');
        Route::post('/payment', [PembayaranController::class, 'store'])->name('payment.store');
        
    });