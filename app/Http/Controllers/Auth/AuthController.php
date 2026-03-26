<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = trim($request->login);

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field => $login,
            'password' => $request->password,
        ];

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('login'))
                ->with('error', 'Login gagal, silahkan coba lagi');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->is_active) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Akun tidak aktif');
        }

        $redirectMap = [
            'adm_tracer' => 'admin.dashboard',
            'educ'       => 'admin.dashboard',
            'it'         => 'admin.dashboard',

            'mhs'        => 'mahasiswa.dashboard',
            'bm'         => 'bm.dashboard',
        ];


        if (!array_key_exists($user->role, $redirectMap)) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Role tidak dikenali');
        }

        return redirect()->route($redirectMap[$user->role])
            ->with('success', 'Login berhasil');
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
