<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\UserController;

// Auth Routes (Public)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman Publik - Daftar Obat yang Terjual
Route::get('/', [HomeController::class, 'index'])->name('home');

// Protected Routes (Require Auth)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Apoteker Routes - Apoteker dapat mengelola obat dan melihat penjualan
    Route::middleware('role:apoteker')->group(function () {
        // Obat - Apoteker dapat CRUD obat
        Route::resource('obats', ObatController::class)->parameters(['obats' => 'obat:id_obat']);
        // Penjualan - Apoteker dapat melihat history penjualan
        Route::resource('penjualans', PenjualanController::class)->only(['index', 'show'])->parameters(['penjualans' => 'penjualan:no_penjualan']);
    });

    // Pelanggan Routes - Pelanggan dapat melihat obat dan melakukan pembelian
    Route::middleware('role:pelanggan')->group(function () {
        // Obat - Pelanggan dapat melihat daftar obat
        Route::resource('obats', ObatController::class)->only(['index', 'show'])->parameters(['obats' => 'obat:id_obat']);
        // Penjualan - Pelanggan dapat melihat penjualannya dan membuat penjualan baru
        Route::resource('penjualans', PenjualanController::class)->parameters(['penjualans' => 'penjualan:no_penjualan']);
    });

    // Admin Routes - Admin dapat mengakses semua
    Route::middleware('role:admin')->group(function () {
        // Users/Apoteker - Admin dapat mengelola apoteker
        Route::resource('users', UserController::class)->parameters(['users' => 'user:id']);

        // Supplier Routes
        Route::resource('suppliers', SupplierController::class)->parameters(['suppliers' => 'supplier:id_supplier']);

        // Obat Routes
        Route::resource('obats', ObatController::class)->parameters(['obats' => 'obat:id_obat']);

        // Pelanggan Routes
        Route::resource('pelanggans', PelangganController::class)->only(['index', 'show'])->parameters(['pelanggans' => 'pelanggan:id_pelanggan']);

        // Penjualan Routes - Admin dapat melihat report penjualan
        Route::resource('penjualans', PenjualanController::class)->only(['index', 'show'])->parameters(['penjualans' => 'penjualan:no_penjualan']);
        Route::get('/penjualans/report', [PenjualanController::class, 'report'])->name('penjualans.report');

        // Pembelian Routes
        Route::resource('pembelians', PembelianController::class)->parameters(['pembelians' => 'pembelian:no_pembelian']);
    });
});
