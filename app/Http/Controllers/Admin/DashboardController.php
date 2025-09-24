<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ad;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_ads' => Ad::count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'total_earnings' => User::sum('balance'),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}