<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminRegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home / welcome
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Auth routes
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// User Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All admin routes are prefixed with 'admin', use the 'admin.' name
| prefix, and protected by 'auth' + 'admin' middleware where necessary.
|
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin auth
    Route::get('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'create'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'store'])->name('login.store');
    Route::post('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'destroy'])->name('logout');

    // Protected routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/ads', [\App\Http\Controllers\Admin\AdController::class, 'index'])->name('ads.index');
        Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
    });
Route::prefix('admin')->name('admin.')->group(function () {
        // Withdrawals
        Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('/withdrawals/{withdrawal}', [WithdrawalController::class, 'show'])->name('withdrawals.show');
        Route::post('/withdrawals/{withdrawal}/approve', [WithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject', [WithdrawalController::class, 'reject'])->name('withdrawals.reject');
    });

});


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ads
    Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
    Route::post('/ads/{ad}/view', [AdController::class, 'view'])->name('ads.view');
    Route::get('/ads/history', [AdController::class, 'history'])->name('ads.history');

    // Withdrawals
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/api/notifications', [NotificationController::class, 'getNotifications'])->name('api.notifications');
    Route::get('/api/notifications/count', [NotificationController::class, 'getCount'])->name('api.notifications.count');
    Route::post('/api/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('api.notifications.read');
    Route::post('/api/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('api.notifications.read-all');
    Route::delete('/api/notifications/{notification}', [NotificationController::class, 'destroy'])->name('api.notifications.delete');
    Route::delete('/api/notifications', [NotificationController::class, 'clearAll'])->name('api.notifications.clear-all');

});

require __DIR__.'/auth.php';
