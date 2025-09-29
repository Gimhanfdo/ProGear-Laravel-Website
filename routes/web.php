<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Livewire\CartPage;

// ------------------------
// Public / Guest routes
// ------------------------
Route::middleware('guest')->group(function () {

    // Google OAuth
    Route::get('login/google', [GoogleController::class, 'redirectToGoogle']);
    Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

});

// ------------------------
// Protected routes (web + mobile)
// ------------------------
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/', function () {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login'); // or welcome page
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard'); // user dashboard
    });

    // User dashboard → render Blade view
    Route::get('/dashboard', function () {
        return view('dashboard'); // your regular user dashboard
    })->name('dashboard');

    // Admin dashboard → render Blade view
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // your admin dashboard
    })->name('admin.dashboard');

    Route::prefix('products')->group(function () {
        Route::get('/category/{category}', [ProductController::class, 'category'])->name('products.category');
        Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/discounted', [ProductController::class, 'discounted'])->name('products.discounted');
    });

    // ------------------------
    // Profile CRUD
    // ------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Cart functionality
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    //Checkout functionality
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    //Review functionaliity
    Route::get('/reviews/{productid}', [ReviewController::class, 'index'])->name('review.index');
    Route::post('/reviews/{productid}', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/confirmation', function () {
        return view('confirmation');
    })->name('confirmation');
});

// ------------------------
// Admin routes
// ------------------------
Route::middleware(['auth:sanctum', 'admin', 'verified'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Admin products
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Admin users
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users.index');

    // Admins
    Route::get('/admin/admins', [AdminController::class, 'admins'])->name('admin.admins.index');
    Route::get('/admin/admins/create', [AdminController::class, 'create'])->name('admin.admins.create');
    Route::post('/admin/admins', [AdminController::class, 'store'])->name('admin.admins.store');
    Route::get('/admin/admins/{id}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admin/admins/{id}', [AdminController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admin/admins/{id}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');

    // Delete regular users
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});

// Include auth.php for Breeze routes (login/register, password, email verification)
require __DIR__ . '/auth.php';
