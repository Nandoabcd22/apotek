<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Supplier Routes
Route::resource('suppliers', SupplierController::class)->parameters(['suppliers' => 'supplier:id_supplier']);

// Obat Routes
Route::resource('obats', ObatController::class)->parameters(['obats' => 'obat:id_obat']);

// Pelanggan Routes
Route::resource('pelanggans', PelangganController::class)->parameters(['pelanggans' => 'pelanggan:id_pelanggan']);

// Penjualan Routes
Route::resource('penjualans', PenjualanController::class)->parameters(['penjualans' => 'penjualan:no_penjualan']);

// Pembelian Routes
Route::resource('pembelians', PembelianController::class)->parameters(['pembelians' => 'pembelian:no_pembelian']);
