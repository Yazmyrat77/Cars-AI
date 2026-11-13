<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| AutoMarket Routes: Authentication gate, wrong-password OTP verification,
| multi-language switcher, full vehicle CRUD, categories, and reviews.
|
*/

// Entry Route: Login Gate on Entry (Redirect to Login if unauthenticated)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('cars.index');
    }

    return redirect()->route('login');
})->name('home');

// Multi-language switcher route (en, ru, tk)
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/verify-login', [AuthController::class, 'showVerifyLogin'])->name('auth.verify');
    Route::post('/verify-login', [AuthController::class, 'verifyCode'])->name('auth.verify.submit');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Vehicle CRUD Routes
    Route::get('/vehicles', [CarController::class, 'index'])->name('cars.index');
    Route::get('/vehicles/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/vehicles', [CarController::class, 'store'])->name('cars.store');
    Route::get('/vehicles/{car}', [CarController::class, 'show'])->name('cars.show');
    Route::get('/vehicles/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/vehicles/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/vehicles/{car}', [CarController::class, 'destroy'])->name('cars.destroy');

    // Vehicle Categories Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Vehicle Review Routes
    Route::post('/vehicles/{car}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
