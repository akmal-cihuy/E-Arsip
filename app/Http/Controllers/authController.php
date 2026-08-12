<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function showLogin() {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            if (!Auth::user()->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi Admin.']);
            }
            $request->session()->regenerate();
            ActivityLog::log('Login', 'Pengguna masuk ke dalam sistem');
            return redirect()->intended(route('dashboard'))->with('success', 'Selamat Datang, ' . Auth::user()->name);
        }

        return back()->withErrors(['email' => 'Kombinasi email dan password tidak sesuai.'])->onlyInput('email');
    }

    public function logout(Request $request) {
        ActivityLog::log('Logout', 'Pengguna keluar dari sistem');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil keluar dari sistem.');
    }
}