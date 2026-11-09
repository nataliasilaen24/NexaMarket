<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

// Route Halaman Utama Toko (Memanggil method home di ProductController)
Route::get('/', [ProductController::class, 'home']);

// Route Resource untuk Kategori
Route::resource('categories', CategoryController::class);

// Route Resource untuk Produk
Route::resource('products', ProductController::class);

// Route Keranjang Belanja
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');