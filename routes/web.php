<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\AnalisaController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isLogin;

Route::get('/', function () {
    return redirect('/dashboard');
});

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

    Route::prefix('/penjualan')->group(function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('penjualan');
        Route::get('/create', [PenjualanController::class, 'create'])->name('create.penjualan');
        Route::post('/store', [PenjualanController::class, 'store'])->name('store.penjualan');
        Route::get('/edit/{id}', [PenjualanController::class, 'edit'])->name('edit.penjualan');
        Route::put('/update/{id}', [PenjualanController::class, 'update'])->name('update.penjualan');
        Route::delete('/delete/{id}', [PenjualanController::class, 'destroy'])->name('delete.penjualan');
    });

    Route::prefix('/analisa')->group(function () {
        Route::get('/backup', [AnalisaController::class, 'index'])->name('analisabackup');
        Route::get('/', [AnalisaController::class, 'indexAll'])->name('analisa');
        Route::post('/backup-store', [AnalisaController::class, 'calculate'])->name('store-backup.penjualan');
        Route::post('/store', [AnalisaController::class, 'calculateAll'])->name('store.penjualan');
        Route::post('/store-data', [AnalisaController::class, 'storeDataCalculated'])->name('store.data');
    });

    Route::prefix('/rekap')->group(function () {
        Route::get('/', [AnalisaController::class, 'rekap'])->name('rekap');
        Route::post('/detail', [AnalisaController::class, 'rekapDetail'])->name('rekap.detail');
    });
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
