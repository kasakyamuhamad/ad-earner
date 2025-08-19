<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //// app/Http/Controllers/PaymentController.php
public function withdraw(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:5000',
        'phone' => 'required|string'
    ]);

    $user = Auth::user();
    
    if ($user->balance < $request->amount) {
        return back()->with('error', 'Insufficient balance');
    }

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY')
    ])->post('https://api.flutterwave.com/v3/payouts', [
        'account_bank' => 'MTN',
        'account_number' => $request->phone,
        'amount' => $request->amount,
        'currency' => 'UGX'
    ]);

    if ($response->successful()) {
        $user->decrement('balance', $request->amount);
        return back()->with('success', 'Withdrawal processing');
    }

    return back()->with('error', 'Withdrawal failed');
}

public function withdraw(Request $request)
{
    $validated = $request->validate([
        'amount' => "required|integer|min:5000|max:{$request->user()->balance}",
        'phone' => 'required|regex:/^\+256[0-9]{9}$/'
    ]);

    // Create withdrawal record
    $withdrawal = $request->user()->withdrawals()->create([
        'amount' => $validated['amount'],
        'phone' => $validated['phone']
    ]);

    // Process via Flutterwave
    $response = Http::withToken(env('FLW_SECRET_KEY'))
        ->post('https://api.flutterwave.com/v3/payouts', [
            'account_bank' => 'MTN',
            'account_number' => substr($validated['phone'], 4), // Remove +256
            'amount' => $validated['amount'],
            'currency' => 'UGX',
            'reference' => 'WD-' . $withdrawal->id
        ]);

    if ($response->successful()) {
        $request->user()->decrement('balance', $validated['amount']);
        $withdrawal->update(['status' => 'paid']);
        return back()->with('success', 'Withdrawal processed');
    }

    return back()->with('error', 'Withdrawal failed');
}
}
