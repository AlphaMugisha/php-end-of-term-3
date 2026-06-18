<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /* =========================================================
     |  WEB (session-based) authentication
     |=========================================================*/

    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a web registration request.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:admins,email'],
            'phone'                 => ['required', 'string', 'max:20'],
            'national_id'           => ['required', 'string', 'max:50', 'unique:admins,national_id'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'],
            'national_id' => $data['national_id'],
            'password'    => Hash::make($data['password']),
        ]);

        Auth::login($admin);
        $request->session()->regenerate();
        $request->session()->flash('success', 'Welcome to Magerwa VTMS, ' . $admin->name . '!');

        // AJAX / fetch request — return the redirect target as JSON.
        if ($request->expectsJson()) {
            return response()->json([
                'message'  => 'Account created successfully.',
                'redirect' => route('dashboard'),
            ], 201);
        }

        return redirect()->route('dashboard')->with('success', 'Welcome to Magerwa VTMS, ' . $admin->name . '!');
    }

    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a web login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();
        $request->session()->flash('success', 'Welcome back, ' . Auth::user()->name . '!');

        // AJAX / fetch request — return the redirect target as JSON.
        if ($request->expectsJson()) {
            return response()->json([
                'message'  => 'Logged in successfully.',
                'redirect' => route('dashboard'),
            ], 200);
        }

        return redirect()->intended(route('dashboard'))->with('success', 'Logged in successfully.');
    }

    /**
     * Handle a web logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    /* =========================================================
     |  API (token-based) authentication
     |=========================================================*/

    /**
     * Register a new admin via the API and return a Sanctum token.
     */
    public function apiRegister(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:admins,email'],
            'phone'       => ['required', 'string', 'max:20'],
            'national_id' => ['required', 'string', 'max:50', 'unique:admins,national_id'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'],
            'national_id' => $data['national_id'],
            'password'    => Hash::make($data['password']),
        ]);

        $token = $admin->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Admin registered successfully.',
            'admin'   => $admin,
            'token'   => $token,
        ], 201);
    }

    /**
     * Log an admin in via the API and return a Sanctum token.
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        $token = $admin->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully.',
            'admin'   => $admin,
            'token'   => $token,
        ], 200);
    }

    /**
     * Revoke the current API token.
     */
    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ], 200);
    }
}
