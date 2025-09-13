<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Notifications\WithdrawalApproved;
use App\Notifications\WithdrawalRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    /**
     * Display user's withdrawal history
     */
    public function index()
    {
        $withdrawals = Auth::user()->withdrawals()->latest()->get();
        
        return inertia('Withdrawals/Index', [
            'withdrawals' => $withdrawals,
            'balance' => Auth::user()->balance,
            'min_withdrawal' => 5000 // 5000 coins = 5000 UGX
        ]);
    }

    /**
     * Store a new withdrawal request
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'amount' => [
                'required', 
                'integer', 
                'min:5000',
                function ($attribute, $value, $fail) use ($user) {
                    if ($value > $user->balance) {
                        $fail('Insufficient balance.');
                    }
                }
            ],
            'phone' => ['required', 'string', 'regex:/^\+256[0-9]{9}$/'],
            'network' => ['required', 'string', 'in:MTN,Airtel']
        ]);

        // Create withdrawal record
        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'phone' => $validated['phone'],
            'network' => $validated['network'],
            'status' => Withdrawal::STATUS_PENDING
        ]);

        // Deduct amount from user balance immediately
        $user->decrement('balance', $validated['amount']);

        // Record transaction
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdrawal',
            'amount' => -$validated['amount'], // Negative amount for withdrawal
            'description' => 'Withdrawal request to ' . $validated['phone']
        ]);

        return redirect()->back()->with('success', 'Withdrawal request submitted! It will be processed within 24 hours.');
    }

    /**
     * ADMIN: List all withdrawals for approval
     */
    public function adminIndex(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $withdrawals = Withdrawal::with('user')
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return inertia('Admin/Withdrawals/Index', [
            'withdrawals' => $withdrawals,
            'status' => $status,
            'stats' => [
                'pending' => Withdrawal::where('status', 'pending')->count(),
                'approved' => Withdrawal::where('status', 'approved')->count(),
                'rejected' => Withdrawal::where('status', 'rejected')->count(),
                'total' => Withdrawal::count(),
            ]
        ]);
    }

    /**
     * ADMIN: Approve a withdrawal
     */
    public function adminApprove(Withdrawal $withdrawal)
    {
        $withdrawal->update([
            'status' => Withdrawal::STATUS_APPROVED,
            'reason' => null
        ]);

        // Send notification to user
        $withdrawal->user->notify(new WithdrawalApproved($withdrawal));

        return redirect()->back()->with('success', 'Withdrawal approved successfully! Notification sent.');
    }

    /**
     * ADMIN: Reject a withdrawal
     */
    public function adminReject(Request $request, Withdrawal $withdrawal)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $withdrawal->update([
            'status' => Withdrawal::STATUS_REJECTED,
            'reason' => $validated['reason']
        ]);

        // Refund the amount to user's balance
        $withdrawal->user->increment('balance', $withdrawal->amount);

        // Record refund transaction
        Transaction::create([
            'user_id' => $withdrawal->user_id,
            'type' => 'withdrawal_refund',
            'amount' => $withdrawal->amount,
            'description' => 'Withdrawal refund: ' . $validated['reason']
        ]);

        // Send notification to user
        $withdrawal->user->notify(new WithdrawalRejected($withdrawal, $validated['reason']));

        return redirect()->back()->with('success', 'Withdrawal rejected and amount refunded! Notification sent.');
    }

    /**
     * ADMIN: View withdrawal details
     */
    public function adminShow(Withdrawal $withdrawal)
    {
        $withdrawal->load('user');
        
        return inertia('Admin/Withdrawals/Show', [
            'withdrawal' => $withdrawal
        ]);
    }

    /**
     * Process withdrawal (legacy method - kept for compatibility)
     */
    public function processWithdrawal(Withdrawal $withdrawal)
    {
        // This will be called by admin to process the withdrawal
        // We'll integrate with Flutterwave here later
        
        return response()->json(['message' => 'Withdrawal processing will be implemented']);
    }
}