<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminRegisterController extends Controller
{
    /**
     * Show the admin registration form
     */
    public function create()
    {
        return Inertia::render('Admin/Auth/RegisterAdmin');
    }

    /**
     * Handle storing a new admin
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'phone'      => ['nullable', 'string', 'max:20'],
        ]);

        User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'is_admin'   => true, // important
            'phone'      => $data['phone'] ?? null,
            'referral_code' => 'ADMIN' . rand(1000, 9999),
        ]);

        // ✅ Redirect to the newly defined route
        return redirect()->route('admin.dashboard')->with('success', 'Admin created successfully.');
    }
}
