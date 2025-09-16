<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($data, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Admin magic-link login: GET /admin/magic?token=...
     * Enabled only when config('admin.magic_token') is set.
     * Marks token as used for TTL to avoid reuse.
     */
    public function magic(Request $request)
    {
        $configured = (string) Config::get('admin.magic_token', '');
        if ($configured === '') {
            abort(404);
        }

        $token = (string) $request->query('token', '');
        // Constant-time comparison
        $valid = hash_equals($configured, $token);
        if (! $valid) {
            return abort(403, 'Invalid token');
        }

        // Single-use: prevent reuse for TTL
        $cacheKey = 'admin_magic_used:' . hash('sha256', $token);
        if (Cache::has($cacheKey)) {
            return abort(403, 'Token already used');
        }

        $ttl = (int) Config::get('admin.magic_token_ttl', 10);
        Cache::put($cacheKey, true, now()->addMinutes(max(1, $ttl)));

        $email = (string) Config::get('admin.email');
        $user = User::where('email', $email)->first();
        if (! $user) {
            // Auto-bootstrap admin if missing
            $user = User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Str::random(40), // hashed by model cast
            ]);
            Log::info('Magic login auto-created admin user', ['email' => $email, 'id' => $user->id]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }
}
