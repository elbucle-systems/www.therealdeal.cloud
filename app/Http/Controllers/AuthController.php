<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Mail\RegistrationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    // ─── Register: Step 1 ────────────────────────────────────────────────────

    public function showRegisterEmail()
    {
        return view('auth.register-email');
    }

    public function registerEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $request->input('email');

        if (User::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'Email is already registered.'])->withInput();
        }

        $verificationUrl = URL::temporarySignedRoute(
            'register.complete',
            now()->addHours(24),
            ['email' => $email]
        );

        Mail::to($email)->send(new RegistrationMail($verificationUrl));

        return back()->with('success', 'Verification email sent. Check your inbox — the link is valid for 24 hours.');
    }

    // ─── Register: Step 2 ────────────────────────────────────────────────────

    public function showFinalRegistration(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Invalid or expired registration link. Please register again.']);
        }

        return view('auth.final-registration', ['email' => $request->query('email')]);
    }

    public function completeRegistration(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Invalid or expired registration link. Please register again.']);
        }

        $request->validate([
            'username' => ['required', 'string', 'min:3', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = $request->query('email');

        if (User::where('email', $email)->exists()) {
            return redirect()->route('register')
                ->withErrors(['email' => 'This email has already been registered.']);
        }

        $user = User::create([
            'username'         => $request->input('username'),
            'email'            => $email,
            'password'         => $request->input('password'),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    // ─── Login / Logout ───────────────────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ─── Forgot Password ─────────────────────────────────────────────────────

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $request->input('email');

        // Always respond the same way to avoid user enumeration
        if (User::where('email', $email)->exists()) {
            $resetUrl = URL::temporarySignedRoute(
                'password.set',
                now()->addHour(),
                ['email' => $email]
            );

            Mail::to($email)->send(new PasswordResetMail($resetUrl));
        }

        return back()->with('success', 'If that email exists, a reset link has been sent. The link is valid for 1 hour.');
    }

    // ─── Reset Password ───────────────────────────────────────────────────────

    public function showSetPassword(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid or expired reset link. Please request a new one.']);
        }

        return view('auth.set-password', ['email' => $request->query('email')]);
    }

    public function resetPassword(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid or expired reset link. Please request a new one.']);
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = $request->query('email');

        User::where('email', $email)->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('login')->with('success', 'Password reset successfully. You can now log in.');
    }
}
