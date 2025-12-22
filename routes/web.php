<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;     // alias
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;   // alias
use App\Http\Controllers\Admin\OrderController as AdminOrderController;         // tambahkan jika ada

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;         // untuk user biasa
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');
// Opsional: biar /home juga bisa diakses langsung
Route::get('/home', [HomeController::class, 'index']);

// Katalog Produk
Route::get('/products', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

Auth::routes();

// Routes yang butuh login (user biasa)
Route::middleware('auth')->group(function () {

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Pesanan Saya (user)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// ================================================
// ROUTE KHUSUS ADMIN
// ================================================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        // Produk CRUD
        Route::resource('products', AdminProductController::class);

        // Kategori CRUD (tanpa show)
        Route::resource('categories', AdminCategoryController::class)->except(['show']);

        // Manajemen Pesanan (admin)
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

// ================================================
// GOOGLE OAUTH ROUTES
// ================================================
Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('auth.google');
    Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
});
