<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('inventaris')->group(function () {
    Route::get('/daftar-barang', [ProdukController::class, 'daftarBarang'])->name('inventaris.daftar-barang');
    Route::get('/tambah-produk', [ProdukController::class, 'tambahProduk'])->name('inventaris.tambah-produk');
    Route::post('/store', [ProdukController::class, 'store'])->name('inventaris.store');
    Route::get('/informasi', [ProdukController::class, 'informasi'])->name('inventaris.informasi');
    Route::get('/{produk}/edit', [ProdukController::class, 'edit'])->name('inventaris.edit');
    Route::put('/{produk}', [ProdukController::class, 'update'])->name('inventaris.update');
    Route::delete('/{produk}', [ProdukController::class, 'destroy'])->name('inventaris.destroy');
});