<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|digits:12',
            'password' => 'required',
        ]);

        $credentials = [
            'employee_id' => $request->employee_id,
            'password' => $request->password,
        ];

        if (Auth::guard('employees')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'employee_id' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('employee_id'));
    }

    public function logout(Request $request)
    {
        Auth::guard('employees')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
