<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdController extends Controller
{
    //// app/Http/Controllers/AdController.php
public function index()
{
    $ads = Ad::all();
    return view('ads.index', compact('ads'));
}

public function credit(User $user)
{
    if ($user->last_ad_view < now()->subHour()) {
        $user->increment('balance', 10);
        $user->update(['last_ad_view' => now()]);
        return response()->json(['success' => true]);
    }
    return response()->json(['error' => 'Ad limit reached'], 400);
}

// app/Http/Controllers/AdController.php
public function credit(Ad $ad)
{
    $user = auth()->user();
    
    // Check if user viewed this ad in last hour
    $recentView = AdView::where('user_id', $user->id)
                        ->where('ad_id', $ad->id)
                        ->where('created_at', '>', now()->subHour())
                        ->exists();

    if ($recentView) {
        return response()->json(['error' => 'Wait 1 hour between views'], 400);
    }

    // Record view
    AdView::create([
        'user_id' => $user->id,
        'ad_id' => $ad->id,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent()
    ]);

    $user->increment('balance', $ad->payout);
    return response()->json(['success' => true]);
}
}
