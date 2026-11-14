<?php

use App\Http\Controllers\AdminPromoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'storeLogin'])
        ->middleware('throttle:5,1')
        ->name('login.store');
    Route::get('/register', [AuthController::class, 'register'])
        ->name('register');
    Route::post('/register', [AuthController::class, 'storeRegistration'])
        ->middleware('throttle:10,1')
        ->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::post('/payment/midtrans/notification', [CheckoutController::class, 'midtransNotification'])
    ->name('payment.midtrans.notification');

Route::middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'home'])
        ->name('home');
    Route::get('/profil', [ProfileController::class, 'show'])
        ->name('profile');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::view('/kontak', 'profile')
        ->name('contact');

    Route::get('/shop', [ProductController::class, 'shop'])
        ->name('shop');
    Route::get('/promo', [ProductController::class, 'promotions'])
        ->name('promotions.index');
    Route::get('/products', [ProductController::class, 'shop'])
        ->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('products.show');

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])
        ->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])
        ->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])
        ->name('cart.remove');

    Route::post('/checkout', [CheckoutController::class, 'start'])
        ->name('checkout.start');
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
        ->name('checkout.place');

    Route::get('/orders', [CheckoutController::class, 'orders'])
        ->name('orders.index');
    Route::get('/orders/{orderNumber}/payment', [CheckoutController::class, 'qrisPayment'])
        ->name('checkout.qris-payment');
    Route::get('/orders/{orderNumber}/qris-code', [CheckoutController::class, 'qrisCodeImage'])
        ->name('checkout.qris-code');
    Route::get('/orders/{orderNumber}', [CheckoutController::class, 'confirmation'])
        ->name('checkout.confirmation');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/products', [AdminPromoController::class, 'index'])
            ->name('products.index');
        Route::put('/products/{product}/promo', [AdminPromoController::class, 'update'])
            ->name('products.promo.update');
    });
});
