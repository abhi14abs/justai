<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show Login Page.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle Login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }

    /**
     * Show Register Page.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register', [
            'refCode' => Cookie::get('postryx_ref_code')
        ]);
    }

    /**
     * Handle Registration with Automatic Referral Binding.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        // Check if referral cookie exists
        $refCode = Cookie::get('postryx_ref_code');
        $referredById = null;

        if (!empty($refCode)) {
            $affiliate = Affiliate::whereRaw('LOWER(affiliate_code) = ?', [strtolower($refCode)])->first();
            if ($affiliate) {
                $referredById = $affiliate->user_id;
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'plan' => 'free',
            'credits_remaining' => 5,
            'referred_by_id' => $referredById,
            'affiliate_code' => Str::slug($validated['name'] . '-' . Str::random(4))
        ]);

        // Automatically create Affiliate account for the user
        Affiliate::create([
            'user_id' => $user->id,
            'affiliate_code' => $user->affiliate_code,
            'commission_rate' => 30.00
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', '🎉 Welcome to Postryx AI! Your 5 free daily credits are ready.');
    }

    /**
     * Handle Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
