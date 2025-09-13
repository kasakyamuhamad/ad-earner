<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    /**
     * Display a listing of the ads.
     */
    public function index()
    {
        $ads = Ad::where('is_active', true)->get();
        return view('ads.index', compact('ads'));
    }

    /**
     * Credit user for viewing an ad (with anti-fraud protection)
     */
    public function credit(Ad $ad)
    {
        $user = Auth::user();
        
        // Check if user viewed this ad in last hour
        $recentView = AdView::where('user_id', $user->id)
                            ->where('ad_id', $ad->id)
                            ->where('created_at', '>', now()->subHour())
                            ->exists();

        if ($recentView) {
            return response()->json(['error' => 'Wait 1 hour between views'], 400);
        }

        // Record view with anti-fraud data
        AdView::create([
            'user_id' => $user->id,
            'ad_id' => $ad->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'earned_coins' => $ad->payout,

        ]);

        // Credit user balance
        $user->increment('balance', $ad->payout);
        
        return response()->json([
            'success' => true,
            'balance' => $user->fresh()->balance,
            'credited' => $ad->payout
        ]);
    }

    /**
     * Show user's ad viewing history
     */
    public function history()
    {
        $adViews = Auth::user()->adViews()->with('ad')->latest()->paginate(10);
        return view('ads.history', compact('adViews'));
    }

    public function view(Ad $ad, Request $request)
{
    $user = Auth::user();

    // Check if user already viewed this ad recently
    $lastView = AdView::where('user_id', $user->id)
        ->where('ad_id', $ad->id)
        ->where('created_at', '>', now()->subMinutes($ad->cooldown_minutes))
        ->exists();

    if ($lastView) {
        return response()->json([
            'success' => false,
            'message' => 'You can view this ad again in ' . $ad->cooldown_minutes . ' minutes.'
        ], 400);
    }

    // Record the ad view
    $adView = AdView::create([
        'user_id' => $user->id,
        'ad_id' => $ad->id,
        'earned_amount' => $ad->reward_amount,
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent()
    ]);

    // Credit user balance
    $user->increment('balance', $ad->reward_amount);

    // Record transaction
    Transaction::create([
        'user_id' => $user->id,
        'type' => 'ad_view',
        'amount' => $ad->reward_amount,
        'description' => 'Earned from viewing ad: ' . $ad->title
    ]);

    // Get updated balance
    $newBalance = $user->fresh()->balance;

    return response()->json([
        'success' => true,
        'earned' => $ad->reward_amount,
        'new_balance' => $newBalance,
        'message' => 'You earned ' . $ad->reward_amount . ' coins! New balance: ' . $newBalance . ' coins.'
    ]);
}
}