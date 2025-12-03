<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string', // Changed from employee_id to login
            'password' => 'required',
        ], [
            'login.required' => 'Please enter your Employee ID or Email address.',
        ]);

        // Determine if login is email or employee_id
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'employee_id';

        // Additional validation for employee_id format
        if ($loginType === 'employee_id' && !preg_match('/^\d{12}$/', $request->login)) {
            return back()->withErrors([
                'login' => 'Employee ID must be exactly 12 digits.',
            ])->withInput($request->only('login'));
        }

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::guard('employees')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('login'));
    }

    public function logout(Request $request)
    {
        Auth::guard('employees')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('status', 'Logged out successfully!');
    }
}
