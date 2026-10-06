<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Buyer;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::post('/locale', [LocaleController::class, 'update'])->name('locale.update');
Route::get('/commodities', [CatalogController::class, 'index'])->name('commodities.index');
Route::get('/commodities/{product:slug}', [CatalogController::class, 'show'])->name('commodities.show');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
Route::prefix('buyer')->name('buyer.')->middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/dashboard', Buyer\DashboardController::class)->name('dashboard');
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
    Route::get('/stock', Buyer\StockController::class)->name('stock');
    Route::get('/products/{product:slug}', [CatalogController::class, 'show'])->name('products.show');
    Route::get('/cart', [Buyer\CartController::class, 'index'])->name('cart');
    Route::post('/cart/{product}', [Buyer\CartController::class, 'store'])->block(10, 10)->name('cart.store');
    Route::delete('/cart/{product}', [Buyer\CartController::class, 'destroy'])->block(10, 10)->name('cart.destroy');
    Route::get('/orders', [Buyer\OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [Buyer\OrderController::class, 'store'])->block(10, 10)->name('orders.store');
    Route::get('/orders/{order}', [Buyer\OrderController::class, 'show'])->name('orders.show');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', Admin\DashboardController::class)->name('dashboard');
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [Admin\OrderController::class, 'update'])->name('orders.update');
    Route::get('/products', [Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [Admin\ProductController::class, 'destroy'])->name('products.destroy');
});
