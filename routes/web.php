<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isLogin;

Route::middleware([isLogin::class])->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('home');
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
