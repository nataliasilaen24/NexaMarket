<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Route Halaman Utama
Route::get('/', function () {
    return view('home');
});

// Route Resource untuk Kategori (Memperbaiki error Route [categories.index] not defined)
Route::resource('categories', CategoryController::class);

// Route Resource untuk Produk
Route::resource('products', ProductController::class);