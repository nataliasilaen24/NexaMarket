<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

// Homepage NexaMarket
Route::get('/', [ProductController::class, 'home'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| Katalog Produk Pelanggan
|--------------------------------------------------------------------------
*/

// Menampilkan katalog dan pencarian produk
Route::get('/shop', [ProductController::class, 'shop'])
    ->name('shop');


/*
|--------------------------------------------------------------------------
| Manajemen Kategori
|--------------------------------------------------------------------------
*/

// Tambah, tampilkan, edit, dan hapus kategori
Route::resource('categories', CategoryController::class);


/*
|--------------------------------------------------------------------------
| Manajemen Produk
|--------------------------------------------------------------------------
*/

// Daftar produk, tambah, detail, edit, dan hapus produk
Route::resource('products', ProductController::class);


/*
|--------------------------------------------------------------------------
| Keranjang Belanja
|--------------------------------------------------------------------------
*/

// Menampilkan keranjang
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

// Menambahkan produk ke keranjang
Route::post('/cart/add/{id}', [CartController::class, 'add'])
    ->name('cart.add');

// Menghapus produk dari keranjang
Route::delete('/cart/remove', [CartController::class, 'remove'])
    ->name('cart.remove');