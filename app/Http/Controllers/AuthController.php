<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── Show Registration Form ────────────────────────────────────

    public function showRegister()
    {
        return view('registration');
    }

    // ── Handle Registration ───────────────────────────────────────

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name'   => ['required', 'string', 'max:120'],
            'email'       => ['required', 'email', 'max:180', 'unique:users,email'],
            'phone'       => ['required', 'string', 'max:30'],
            'kingschat'   => ['required', 'string', 'max:80'],
            'group'       => ['required', 'string', 'max:120'],
            'church'      => ['required', 'string', 'max:120'],
            'password'    => ['required', 'confirmed', Password::min(8)],
            'prayer_time' => ['nullable', 'date_format:H:i'],
        ], [
            'email.unique'     => 'An account with this email already exists.',
            'password.min'     => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'full_name'   => $validated['full_name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'kingschat'   => $validated['kingschat'],
            'group'       => $validated['group'],
            'church'      => $validated['church'],
            'password'    => Hash::make($validated['password']),
            'prayer_time' => $validated['prayer_time'] ?? '06:00',
            'is_admin'    => false,
            'last_login_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('login')
            ->with('success', "Welcome, {$user->full_name}! Your Centurion journey begins now. 🏆");
    }

    // ── Show Login Form ───────────────────────────────────────────

    public function showLogin()
    {
        return view('login');
    }

    // ── Handle Login ──────────────────────────────────────────────

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            Auth::user()->update(['last_login_at' => now()]);

            return redirect()->route('home')
                ->with('success', 'Welcome back, ' . Auth::user()->full_name . '! 🔥');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    // ── Logout ────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been signed out. Keep walking in excellence! 🙏');
    }
}
