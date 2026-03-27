<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\Buyer\BuyerController;
use App\Http\Controllers\Web\Buyer\ProductController;
use App\Http\Controllers\Web\Buyer\CartController;
use App\Http\Controllers\Web\Buyer\OrderController;
use App\Http\Controllers\Web\Buyer\FavoriteController;
use App\Http\Controllers\Web\Buyer\ProfileController;

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

// Pages protégées (connecté uniquement)
Route::middleware('auth')->group(function () {
    Route::get('/seller', fn() => view('seller.seller'))->name('seller.home');
    Route::get('/admin',  fn() => view('admin.admin'))->name('admin.home');
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
