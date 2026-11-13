<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('cars.index');
        }

        return view('auth.login');
    }

    /**
     * Handle user login attempt and trigger OTP on wrong password.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $loginInput = $request->validated('login');
        $passwordInput = $request->validated('password');
        $remember = $request->boolean('remember');

        // Look up user by email or username
        $user = User::where('email', $loginInput)
            ->orWhere('username', $loginInput)
            ->first();

        // If user does not exist, standard authentication failure
        if (! $user) {
            return back()->withErrors([
                'login' => __('auth.failed'),
            ])->onlyInput('login');
        }

        // If password is correct, log in directly
        if (Hash::check($passwordInput, $user->password)) {
            Auth::login($user, $remember);
            $user->update([
                'login_code' => null,
                'login_code_expires_at' => null,
            ]);
            $request->session()->regenerate();

            return redirect()->intended(route('cars.index'))
                ->with('success', __('market.login_success', ['name' => $user->name]));
        }

        // WRONG PASSWORD FLOW: Trigger OTP verification code recovery
        $verificationCode = (string) random_int(100000, 999999);
        $user->update([
            'login_code' => $verificationCode,
            'login_code_expires_at' => now()->addMinutes(15),
        ]);

        // In a live production system, dispatch Mail::to($user->email)->send(new LoginCodeMail($verificationCode));
        Log::info("OTP Login verification code generated for {$user->email}: {$verificationCode}");

        session([
            'otp_email' => $user->email,
            'demo_code' => $verificationCode,
        ]);

        return redirect()->route('auth.verify')
            ->with('warning', __('market.otp_alert_code_sent', ['email' => $user->email]));
    }

    /**
     * Display the OTP verification screen.
     */
    public function showVerifyLogin(): View|RedirectResponse
    {
        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('login');
        }

        $demoCode = session('demo_code');

        return view('auth.verify-code', compact('email', 'demoCode'));
    }

    /**
     * Validate the OTP code and log the user in.
     */
    public function verifyCode(VerifyCodeRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (
            $user &&
            $user->login_code === $request->validated('code') &&
            $user->login_code_expires_at &&
            $user->login_code_expires_at->isFuture()
        ) {
            Auth::login($user);

            $user->update([
                'login_code' => null,
                'login_code_expires_at' => null,
            ]);

            session()->forget(['otp_email', 'demo_code']);
            $request->session()->regenerate();

            return redirect()->route('cars.index')
                ->with('success', __('market.otp_login_success', ['name' => $user->name]));
        }

        return back()->withErrors([
            'code' => __('market.otp_invalid_or_expired'),
        ])->withInput();
    }

    /**
     * Display the user registration page.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('cars.index');
        }

        return view('auth.register');
    }

    /**
     * Process new user registration.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->validated('name'),
            'username' => $request->validated('username'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('cars.index')
            ->with('success', __('market.register_success', ['name' => $user->name]));
    }

    /**
     * Log out current user session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', __('market.logout_success'));
    }
}
