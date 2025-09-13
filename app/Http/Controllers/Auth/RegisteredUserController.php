<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // ← Add this import
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): InertiaResponse
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        // Use the correct Validator facade
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required', 
                'string', 
                'max:15', 
                'unique:users',
                'regex:/^\+256[0-9]{9}$/'
            ],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Required email
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'referral_code' => ['sometimes', 'string', 'exists:users,referral_code', 'nullable']
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Generate referral code
        $referralCode = $this->generateReferralCode();
        
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'], // Required email
            'password' => Hash::make($validated['password']),
            'referral_code' => $referralCode,
            'referred_by' => $validated['referral_code'] ?? null,
            'balance' => 0,
            'last_ad_view' => null
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Handle referral bonus
        if (!empty($validated['referral_code'])) {
            $this->handleReferralBonus($validated['referral_code']);
        }

        return redirect()->route('dashboard');
    }

    private function generateReferralCode()
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    private function handleReferralBonus($referralCode)
    {
        $referrer = User::where('referral_code', $referralCode)->first();
        
        if ($referrer) {
            $referrer->increment('balance', 100);
            
            // Optional: Create transaction record
            if (class_exists(\App\Models\Transaction::class)) {
                \App\Models\Transaction::create([
                    'user_id' => $referrer->id,
                    'type' => 'referral_bonus',
                    'amount' => 100,
                    'description' => 'Referral bonus for new user registration'
                ]);
            }
        }
    }
}