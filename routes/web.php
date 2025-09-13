<?php

use App\Http\Controllers\DashboardController; // ✅ ADD THIS
use App\Http\Controllers\AdController; // ✅ ADD THIS
use App\Http\Controllers\WithdrawalController; // ✅ ADD THIS
use App\Http\Controllers\Admin\Auth\LoginController; // ✅ ADD THIS
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::get('/ads', [App\Http\Controllers\Admin\AdController::class, 'index']);
    Route::get('/withdrawals', [App\Http\Controllers\Admin\WithdrawalController::class, 'index']);
    Route::post('/withdrawals/{withdrawal}/approve', [WithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [WithdrawalController::class, 'reject'])->name('admin.withdrawals.reject');
    Route::get('/withdrawals/{withdrawal}', [WithdrawalController::class, 'show'])->name('admin.withdrawals.show');
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/ads', [AdController::class, 'index'])->name('ads.index')->middleware('auth');
Route::post('/ads/{ad}/view', [AdController::class, 'view'])->name('ads.view')->middleware('auth');
Route::get('/ads/history', [AdController::class, 'history'])->name('ads.history');

// Add to your existing routes
Route::middleware('auth')->group(function () {
    // Withdrawal routes
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');

    // Notification routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', function () {
        return response()->json([
            'notifications' => Auth::user()->notifications()->latest()->take(20)->get(),
            'unread_count' => Auth::user()->unreadNotifications()->count()
        ]);
    });
    
    Route::post('/notifications/{notification}/read', function ($id) {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    });
    
    Route::post('/notifications/read-all', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    });
});
});
// Notification routes
Route::middleware('auth')->group(function () {
    // Page routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    // API routes
    Route::get('/api/notifications', [NotificationController::class, 'getNotifications'])->name('api.notifications');
    Route::get('/api/notifications/count', [NotificationController::class, 'getCount'])->name('api.notifications.count');
    Route::post('/api/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('api.notifications.read');
    Route::post('/api/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('api.notifications.read-all');
    Route::delete('/api/notifications/{notification}', [NotificationController::class, 'destroy'])->name('api.notifications.delete');
    Route::delete('/api/notifications', [NotificationController::class, 'clearAll'])->name('api.notifications.clear-all');
});
require __DIR__.'/auth.php';
