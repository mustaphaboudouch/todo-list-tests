<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'adult'])->group(function () {
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
});

Route::middleware('auth')->group(function () {
    Route::view('/fallback', 'items.fallback')->name('items.fallback');
});

require __DIR__ . '/auth.php';
