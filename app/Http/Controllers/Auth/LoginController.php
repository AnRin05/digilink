<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log in as an Admin
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        // Attempt to log in as a Driver
        if (Auth::guard('driver')->attempt($credentials, $request->boolean('remember'))) {
            $driver = Auth::guard('driver')->user();

            // Check if the driver is approved
            if ($driver->is_approved) {
                $request->session()->regenerate();
                return redirect()->intended('/driver/dashboard');
            }

            // If not approved, log them out and redirect
            Auth::guard('driver')->logout();
            return redirect()->route('driver.pending')->with('status', 'Your account is still pending approval. Please wait for an email.');
        }

        // Attempt to log in as a Passenger
        if (Auth::guard('passenger')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/passenger/dashboard');
        }

        // If none of the attempts were successful
        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('driver')->check()) {
            Auth::guard('driver')->logout();
        } elseif (Auth::guard('passenger')->check()) {
            Auth::guard('passenger')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}