<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\AdminResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Generic response to avoid email enumeration
        $generic = back()->with('status', 'If an account exists for that email, a password reset link has been sent.');

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return $generic;
        }

        $token = Str::random(64);
        DB::table('admin_password_resets')->updateOrInsert(
            ['email' => $admin->email],
            [
                'email' => $admin->email,
                'token' => Hash::make($token), // store hashed token
                'created_at' => now(),
            ]
        );

        // send notification with plain token
        Notification::route('mail', $admin->email)
            ->notify(new AdminResetPassword($token, $admin->email));

        return $generic;
    }

    public function showResetForm(Request $request, string $token)
    {
        $email = $request->query('email');
        return view('admin.auth.passwords.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $row = DB::table('admin_password_resets')->where('email', $request->email)->first();
        if (!$row) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        // TTL 60 minutes
        if (Carbon::parse($row->created_at)->addMinutes(60)->isPast()) {
            DB::table('admin_password_resets')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token has expired. Please request a new reset link.']);
        }

        // check token
        if (!Hash::check($request->token, $row->token)) {
            return back()->withErrors(['token' => 'Invalid token.']);
        }

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return back()->withErrors(['email' => 'Admin not found.']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        // Invalidate token(s)
        DB::table('admin_password_resets')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')->with('status', 'Password has been reset. You can now log in.');
    }
}
