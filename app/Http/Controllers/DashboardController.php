<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ad;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // User dashboard stats
        return inertia('Dashboard', [
            'balance' => $user->balance ?? 0,
            'today_earnings' => $user->transactions()->whereDate('created_at', today())->sum('amount') ?? 0,
            'total_earnings' => $user->transactions()->where('type', 'ad_view')->sum('amount') ?? 0,
            'available_ads' => Ad::where('is_active', true)->count(),
        ]);
    }

    /**
     * Display the admin dashboard.
     * This should be in a separate AdminController but I'll fix it here for now.
     */
    public function adminIndex()
    {
        // Check if user is admin
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $stats = [
            'total_users' => User::count(),
            'total_ads' => Ad::count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'total_earnings' => User::sum('balance'),
        ];

        // Use Inertia for response since you're using Vue.js
        return inertia('Admin/Dashboard', compact('stats'));
    }
}