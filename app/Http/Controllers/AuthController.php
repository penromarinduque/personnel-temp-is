<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string'
        ], [
            'email.required' => 'Username is required',
            'password.required' => 'Password is required'
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt([
            "username" => $credentials['email'],
            "password" => $credentials['password']
        ])) {
            $request->session()->regenerate();
            return redirect(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}