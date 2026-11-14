<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;

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
| Halaman Profil dan Kontak
|--------------------------------------------------------------------------
*/

// Halaman Profil NexaMarket
Route::view('/profil', 'profile')
    ->name('profile');

// Halaman Kontak NexaMarket (disatukan dalam halaman profil)
Route::view('/kontak', 'profile')
    ->name('contact');


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
| Katalog Pelanggan
|--------------------------------------------------------------------------
*/

// Katalog produk, detail produk, dan kategori untuk pelanggan
Route::get('/products', [ProductController::class, 'shop'])
    ->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');


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

// Memperbarui jumlah produk di keranjang
Route::patch('/cart/update/{id}', [CartController::class, 'update'])
    ->name('cart.update');

// Menghapus produk dari keranjang
Route::delete('/cart/remove', [CartController::class, 'remove'])
    ->name('cart.remove');

// Ringkasan checkout untuk produk yang dipilih pelanggan
Route::post('/checkout', [CheckoutController::class, 'start'])
    ->name('checkout.start');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
    ->name('checkout.place');

Route::get('/orders/{orderNumber}', [CheckoutController::class, 'confirmation'])
    ->name('checkout.confirmation');