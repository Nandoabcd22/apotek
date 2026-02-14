<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianController;

// Auth Routes (Public)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (Require Auth)
Route::middleware('auth')->group(function () {
    // Dashboard - Accessible to all authenticated users
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Pelanggan Routes - Accessible to all authenticated users
    Route::resource('pelanggans', PelangganController::class)->parameters(['pelanggans' => 'pelanggan:id_pelanggan']);

    // Penjualan Routes - Accessible to all authenticated users
    Route::resource('penjualans', PenjualanController::class)->parameters(['penjualans' => 'penjualan:no_penjualan']);

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        // Supplier Routes
        Route::resource('suppliers', SupplierController::class)->parameters(['suppliers' => 'supplier:id_supplier']);

        // Obat Routes
        Route::resource('obats', ObatController::class)->parameters(['obats' => 'obat:id_obat']);

        // Pembelian Routes
        Route::resource('pembelians', PembelianController::class)->parameters(['pembelians' => 'pembelian:no_pembelian']);
    });
});
