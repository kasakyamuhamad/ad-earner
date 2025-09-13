<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // For Blade:
        // return view('admin.auth.login');

        // For Inertia + Vue:
        return Inertia::render('Admin/Auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = Auth::user();

            // Check if the authenticated user is an admin
            if (auth()->user()->is_admin) {
                return redirect()->route('admin.dashboard');
            } else {
                auth()->logout();
                return back()->withErrors([
                    'email' => 'You do not have admin access.',
                ])->onlyInput('email');
            }
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('admin.login');
    }
}

