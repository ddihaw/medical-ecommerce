<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.signIn');
    Route::get('/register', [AuthController::class, 'register_index'])->name('auth.signUp');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/new', [CategoryController::class, 'newCategoryForm'])->name('categories.new');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/{category:id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('/update/{category:id}', [CategoryController::class, 'editCategoryForm'])->name('categories.edit');
        Route::put('/update/{category:id}', [CategoryController::class, 'update'])->name('categories.update');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
