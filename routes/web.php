<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\AdminProductController;

Route::get('/', function () {
    return view('welcome');
});

// The new public shop route
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');

// Dynamic Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout Routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Admin Only Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Admin Product CRUD Routes
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    // Routes for editing products
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    
    // FIXED: Changed to POST and pluralized the name to match the form
    Route::post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update');
    // Customer Accounts Route
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
});