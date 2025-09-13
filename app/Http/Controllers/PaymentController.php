<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Handle withdrawal request
     */
    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => [
                'required', 
                'integer', 
                'min:5000',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->user()->balance) {
                        $fail('Insufficient balance.');
                    }
                }
            ],
            'phone' => ['required', 'string', 'regex:/^\+256[0-9]{9}$/']
        ]);

        try {
            $user = Auth::user();

            // Create withdrawal record
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'phone' => $validated['phone'],
                'status' => 'pending'
            ]);

            // Process via Flutterwave
            $response = Http::withToken(env('FLW_SECRET_KEY'))
                ->post('https://api.flutterwave.com/v3/payouts', [
                    'account_bank' => 'MTN',
                    'account_number' => substr($validated['phone'], 4), // Remove +256
                    'amount' => $validated['amount'],
                    'currency' => 'UGX',
                    'reference' => 'WD-' . $withdrawal->id,
                    'narration' => 'Withdrawal from AdEarn'
                ]);

            if ($response->successful()) {
                // Deduct from user balance
                $user->decrement('balance', $validated['amount']);
                
                // Update withdrawal status
                $withdrawal->update(['status' => 'paid']);

                // Record transaction
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'withdrawal',
                    'amount' => -$validated['amount'],
                    'description' => 'Mobile money withdrawal to ' . $validated['phone']
                ]);

                return redirect()->back()->with('success', 'Withdrawal processed successfully!');
            } else {
                // Log the error
                Log::error('Flutterwave payout failed', [
                    'response' => $response->json(),
                    'user_id' => $user->id
                ]);

                return redirect()->back()->with('error', 'Withdrawal failed. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error('Withdrawal error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during withdrawal.');
        }
    }

    /**
     * Show withdrawal history
     */
    public function transactions()
    {
        $withdrawals = Auth::user()->withdrawals()->latest()->get();
        $transactions = Auth::user()->transactions()->latest()->get();

        return inertia('Transactions/Index', [
            'withdrawals' => $withdrawals,
            'transactions' => $transactions
        ]);
    }

    /**
     * API endpoint for withdrawal (for Vue components)
     */
    public function withdrawRequest(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:5000',
            'phone' => 'required|string|regex:/^\+256[0-9]{9}$/'
        ]);

        // Same logic as withdraw() but return JSON response
        try {
            $user = Auth::user();

            if ($user->balance < $validated['amount']) {
                return response()->json([
                    'error' => 'Insufficient balance.'
                ], 422);
            }

            // ... rest of withdrawal logic ...

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal processed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Withdrawal failed: ' . $e->getMessage()
            ], 500);
        }
    }
}