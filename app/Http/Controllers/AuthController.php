<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function storeLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi tidak sesuai.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if (Auth::user()->is_admin) {
            $intendedUrl = $request->session()->pull('url.intended');
            $intendedPath = is_string($intendedUrl) ? parse_url($intendedUrl, PHP_URL_PATH) : null;

            if (is_string($intendedPath) && ($intendedPath === '/admin' || str_starts_with($intendedPath, '/admin/'))) {
                $intendedQuery = parse_url($intendedUrl, PHP_URL_QUERY);
                $destination = url($intendedPath).($intendedQuery ? '?'.$intendedQuery : '');

                return redirect()->to($destination);
            }

            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home'));
    }

    public function storeRegistration(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $user = User::create($validated + ['is_admin' => false]);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
