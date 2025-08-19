<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdController as AdminAdController;

// Public Ad Routes
Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
Route::post('/ads/{ad}/credit', [AdController::class, 'credit'])->name('ads.credit');

// Payment Routes
Route::post('/withdraw', [PaymentController::class, 'withdraw'])->name('payments.withdraw');

// Admin Routes (requires auth + admin middleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('ads', Admin\AdController::class);
});

