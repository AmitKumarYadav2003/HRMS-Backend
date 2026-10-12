<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
        ]);

        // Check if admin exists with role = admin
        $admin = \App\Models\User::where('email', $credentials['email'])
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'No admin account found with this email']);
        }

        // Verify password
        if (!\Hash::check($credentials['password'], $admin->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['password' => 'Invalid credentials']);
        }

        // Login admin (session-based)
        Auth::login($admin, $request->boolean('remember'));

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Welcome, ' . $admin->name);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'You have been logged out');
    }
}