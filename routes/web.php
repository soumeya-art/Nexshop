<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\Buyer\BuyerController;
use App\Http\Controllers\Web\Buyer\ProductController;
use App\Http\Controllers\Web\Buyer\CartController;
use App\Http\Controllers\Web\Buyer\OrderController;
use App\Http\Controllers\Web\Buyer\FavoriteController;
use App\Http\Controllers\Web\Buyer\ProfileController;
use App\Http\Controllers\Web\Admin\AdminController;
use App\Http\Controllers\Web\Admin\AdminUserController;
use App\Http\Controllers\Web\Admin\AdminModerationController;
use App\Http\Controllers\Web\Admin\AdminCategoryController;
use App\Http\Controllers\Web\Seller\SellerController;
use App\Http\Controllers\Web\Seller\SellerProductController;
use App\Http\Controllers\Web\Seller\SellerOrderController;

// Page d'accueil
Route::get('/', fn() => view('welcome'))->name('home');

// Authentification (invités uniquement)
Route::middleware('guest')->group(function () {
    Route::get('/login',    fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/login',    [AuthController::class, 'login'])->name('login.submit');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Interface Admin (admin uniquement) ─────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('home');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::post('/users/{user}/toggle-ban', [AdminUserController::class, 'toggleBan'])->name('users.toggleBan');

    Route::get('/moderation', [AdminModerationController::class, 'index'])->name('moderation');
    Route::post('/moderation/{avi}/approve', [AdminModerationController::class, 'approve'])->name('moderation.approve');
    Route::post('/moderation/{avi}/reject', [AdminModerationController::class, 'reject'])->name('moderation.reject');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});

// ── Interface Vendeur (vendeur uniquement) ──────────────────
Route::middleware(['auth', 'role:vendeur'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/', [SellerController::class, 'dashboard'])->name('home');

    Route::get('/products', [SellerProductController::class, 'index'])->name('products');
    Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders');
    Route::post('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.status');
});

// ── Interface Acheteur (client uniquement) ─────────────────────
Route::middleware(['auth', 'role:client'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/', [BuyerController::class, 'home'])->name('home');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products/{product}/review', [ProductController::class, 'storeReview'])->name('products.review');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/{cart}/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/{cart}/remove', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
