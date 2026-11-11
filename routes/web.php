<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

// Homepage
Route::get('/', [ProductController::class, 'home'])
    ->name('home');

// Katalog dan pencarian produk
Route::get('/shop', [ProductController::class, 'shop'])
    ->name('shop');

// Kategori
Route::resource('categories', CategoryController::class);

// Produk
Route::resource('products', ProductController::class);

// Keranjang belanja
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{id}', [CartController::class, 'add'])
    ->name('cart.add');

Route::delete('/cart/remove', [CartController::class, 'remove'])
    ->name('cart.remove');