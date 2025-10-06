<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Public / Guest routes
Route::middleware('guest')->group(function () {

    // Login
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Registration 
    Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

    // Mobile Google login
    Route::post('/login/google', [GoogleController::class, 'mobileLogin']);
});

// Authenticated routes 
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user/email-status', function (Request $request) {
        return response()->json([
            'email_verified' => $request->user()->hasVerifiedEmail(),
            'user' => $request->user(),
        ]);
    });

    Route::get('/me', function(Request $request) {
        return $request->expectsJson() 
            ? response()->json($request->user()) 
            : view('profile.edit', ['user' => $request->user()]);
    });

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // User profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    // Products
    Route::get('/products', [ProductController::class, 'getAllProducts']); // all products
    Route::get('/products/discounted', [ProductController::class, 'getDiscountedProducts']);
    Route::get('/products/category/{category}', [ProductController::class, 'getProductsByCategory']);
    Route::get('/products/{id}', [ProductController::class, 'getProductById']); // single product

    //Review functionaliity
    Route::get('/reviews/{productid}', [ReviewController::class, 'mobileindex']);
    Route::post('/reviews/{productid}', [ReviewController::class, 'mobilestore']);

    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/update/{item}', [CartController::class, 'update']);
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove']);
    Route::delete('/cart/clear', [CartController::class, 'clear']);

    //Checkout functionality
    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout', [CheckoutController::class, 'mobilestore']);
});
