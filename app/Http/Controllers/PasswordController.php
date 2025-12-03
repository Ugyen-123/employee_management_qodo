<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Employee;

class PasswordController extends Controller
{
    // Show forgot password form
    public function requestForm()
    {
        return view('auth.passwords.email');
    }

    // Send reset link email
    public function emailLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:employees,email'
        ], [
            'email.exists' => 'We could not find an employee with that email address.'
        ]);

        $status = Password::broker('employees')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Password reset link sent to your email!')
            : back()->withErrors(['email' => 'Unable to send reset link. Please try again.']);
    }

    // Show reset password form
    public function resetForm($token)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => request('email')
        ]);
    }

    // Reset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:employees,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('employees')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($employee, $password) {
                $employee->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                
                $employee->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password reset successfully! You can now login.')
            : back()->withErrors(['email' => 'Unable to reset password. The link may have expired.']);
    }
}
