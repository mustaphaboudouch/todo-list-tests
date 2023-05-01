<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'handleRegister'])->name('register.handle');
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'handleLogin'])->name('login.handle');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
});
