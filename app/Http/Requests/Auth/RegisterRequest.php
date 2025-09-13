public function rules()
{
    return [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'phone' => [
            'required', 
            'string', 
            'max:15', 
            'unique:users',
            'regex:/^\+256[0-9]{9}$/'
        ],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'referral_code' => ['sometimes', 'string', 'exists:users,referral_code', 'nullable']
    ];
}