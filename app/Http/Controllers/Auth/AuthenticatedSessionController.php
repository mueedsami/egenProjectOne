<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /** USER LOGIN VIEW */
    public function create()
    {
        return view('auth.login');
    }

    /** USER LOGIN HANDLER */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->role_id == 1) {
            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /** LOGOUT */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /** ADMIN LOGIN VIEW */
    public function createAdmin()
    {
        return view('auth.admin-login');
    }

    /** ADMIN LOGIN HANDLER */
    public function storeAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role_id == 1) {
                $request->session()->regenerate();
                return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
            }
            Auth::logout();
            return back()->withErrors(['email' => 'Access denied: not an admin.']);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
}
