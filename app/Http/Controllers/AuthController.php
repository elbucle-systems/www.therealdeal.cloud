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
            return back()->withErrors(['email' => __('app.flash.email_registered')])->withInput();
        }

        $verificationUrl = URL::temporarySignedRoute(
            'register.complete',
            now()->addHours(24),
            ['email' => $email]
        );

        Mail::to($email)->send(new RegistrationMail($verificationUrl));

        return back()->with('success', __('app.flash.verification_sent'));
    }

    public function showFinalRegistration(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('register')
                ->withErrors(['email' => __('app.flash.invalid_registration_link')]);
        }

        return view('auth.final-registration', ['email' => $request->query('email')]);
    }

    public function completeRegistration(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('register')
                ->withErrors(['email' => __('app.flash.invalid_registration_link')]);
        }

        $request->validate([
            'username' => ['required', 'string', 'min:3', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = $request->query('email');

        if (User::where('email', $email)->exists()) {
            return redirect()->route('register')
                ->withErrors(['email' => __('app.flash.registered_already')]);
        }

        $user = User::create([
            'username' => $request->input('username'),
            'email' => $email,
            'password' => $request->input('password'),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => __('app.flash.invalid_credentials')])->withInput();
    }

    public function logout(Request $request)
    {
        $locale = $request->session()->get('locale');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($locale) {
            $request->session()->put('locale', $locale);
        }

        return redirect()->route('login');
    }

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

        // Always respond the same way to avoid user enumeration.
        if (User::where('email', $email)->exists()) {
            $resetUrl = URL::temporarySignedRoute(
                'password.set',
                now()->addHour(),
                ['email' => $email]
            );

            Mail::to($email)->send(new PasswordResetMail($resetUrl));
        }

        return back()->with('success', __('app.flash.password_reset_sent'));
    }

    public function showSetPassword(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('password.request')
                ->withErrors(['email' => __('app.flash.invalid_reset_link')]);
        }

        return view('auth.set-password', ['email' => $request->query('email')]);
    }

    public function resetPassword(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('password.request')
                ->withErrors(['email' => __('app.flash.invalid_reset_link')]);
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = $request->query('email');

        User::where('email', $email)->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('login')->with('success', __('app.flash.password_reset'));
    }
}
