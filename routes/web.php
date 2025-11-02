<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class,'index'])->name('signIn');
    Route::get('/register', [AuthController::class,'register_index'])->name('signUp');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class,'me'])->name('me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});