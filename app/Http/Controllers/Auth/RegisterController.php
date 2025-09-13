<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    // your logic
}

    /**
     * Where to redirect users after registration.
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone' => [
                'required', 
                'string', 
                'max:15', 
                'unique:users',
                'regex:/^\+256[0-9]{9}$/' // Ugandan phone format: +256XXXXXXXXX
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referral_code' => ['sometimes', 'string', 'exists:users,referral_code', 'nullable']
        ], [
            'phone.regex' => 'Please enter a valid Ugandan phone number format: +256XXXXXXXXX',
            'phone.unique' => 'This phone number is already registered.',
            'referral_code.exists' => 'Invalid referral code.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        // Generate unique referral code
        $referralCode = $this->generateReferralCode();
        
        return User::create([
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'referral_code' => $referralCode,
            'referred_by' => $data['referral_code'] ?? null,
            'balance' => 0,
            'last_ad_view' => null
        ]);
    }

    /**
     * Generate unique referral code
     */
    private function generateReferralCode()
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Handle a registration request for the application.
     * Override default to use phone instead of email
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        // Handle referral bonus if applicable
        if ($request->has('referral_code')) {
            $this->handleReferralBonus($request->referral_code);
        }

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }

    /**
     * Handle referral bonus for referrer
     */
    protected function handleReferralBonus($referralCode)
    {
        $referrer = User::where('referral_code', $referralCode)->first();
        
        if ($referrer) {
            // Add bonus to referrer (e.g., 100 coins)
            $referrer->increment('balance', 100);
            
            // You can also log this transaction
            \App\Models\Transaction::create([
                'user_id' => $referrer->id,
                'type' => 'referral_bonus',
                'amount' => 100,
                'description' => 'Referral bonus for new user'
            ]);
        }
    }

    /**
     * Get the login username to be used by the controller.
     * Override to use phone instead of email
     */
    public function username()
    {
        return 'phone';
    }
}