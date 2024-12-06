<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isLogin;

Route::middleware([isLogin::class])->prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    // Admin
    Route::prefix('/admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin');
        Route::get('/create', [UserController::class, 'create'])->name('create.admin');
        Route::post('/store', [UserController::class, 'store'])->name('store.admin');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit.admin');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update.admin');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete.admin');
    });
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
