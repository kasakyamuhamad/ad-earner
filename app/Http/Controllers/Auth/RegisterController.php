// app/Http/Controllers/Auth/RegisterController.php
protected function validator(array $data)
{
    return Validator::make($data, [
        'phone' => ['required', 'string', 'max:15', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
}

protected function create(array $data)
{
    return User::create([
        'phone' => $data['phone'],
        'password' => Hash::make($data['password']),
    ]);
}