<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController; 

Route::get('/', function () {
    return view('welcome');
});

// The new public shop route
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');

// New Dynamic Dashboard Route
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

// Checkout Routes (Must be logged in)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Admin Only Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/product/add', [AdminController::class, 'create'])->name('admin.product.create');
    Route::post('/product/store', [AdminController::class, 'store'])->name('admin.product.store');
    
    // New route for updating order status
    Route::put('/order/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.order.update');
});