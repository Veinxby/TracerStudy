<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        $lockKey = 'login_lock|' . $request->ip();

        // CEK APAKAH MASIH TERKUNCI
        if (RateLimiter::tooManyAttempts($lockKey, 1)) {

            return view('auth.login', [
                'throttle' => true,
                'retry_after' => RateLimiter::availableIn($lockKey)
            ]);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ], [
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $login = trim($request->login);
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field => $login,
            'password' => $request->password,
        ];

        $remember = $request->boolean('remember');



        // KEY UNTUK RATE LIMIT
        $maxAttempts = 3;
        $lockSeconds = 30;

        $attemptsKey = 'login_attempts|' . $request->ip();
        $lockKey     = 'login_lock|' . $request->ip();


        // 🚫 CEK SEDANG DI LOCK
        if (RateLimiter::tooManyAttempts($lockKey, 1)) {

            return back()->with([
                'throttle' => true,
                'retry_after' => RateLimiter::availableIn($lockKey)
            ]);
        }


        if (!Auth::attempt($credentials, $remember)) {

            RateLimiter::hit($attemptsKey);

            $attempts = RateLimiter::attempts($attemptsKey);

            // kalau sudah 3x gagal
            if ($attempts >= $maxAttempts) {

                // reset attempt counter
                RateLimiter::clear($attemptsKey);

                // lock full 30 detik
                RateLimiter::hit($lockKey, $lockSeconds);

                return back()->with([
                    'throttle' => true,
                    'retry_after' => $lockSeconds
                ]);
            }

            $remaining = $maxAttempts - $attempts;

            return back()
                ->withInput($request->only('login'))
                ->with(
                    'authError',
                    'Login gagal, sisa percobaan: ' . $remaining
                );
        }

        // LOGIN BERHASIL → RESET LIMIT
        RateLimiter::clear($attemptsKey);
        RateLimiter::clear($lockKey);

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->is_active) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'authError',
                    'Akun tidak aktif'
                );
        }

        $redirectMap = [
            'adm_tracer' => 'admin.dashboard',
            'educ'       => 'admin.dashboard',
            'it'         => 'admin.dashboard',

            'mhs'        => 'mhs.dashboard',
            'bm'         => 'bm.dashboard',
        ];


        if (!array_key_exists($user->role, $redirectMap)) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'authError',
                    'Role tidak dikenali'
                );
        }

        return redirect()->route($redirectMap[$user->role])
            ->with('successLogin', 'Login berhasil');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout');
    }
}
