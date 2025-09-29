<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view (web only).
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request (web + mobile API).
     */
    public function store(LoginRequest $request)
    {
        // Web login via Breeze session guard
        $request->authenticate();
        

        $user = $request->user();

        // Create a token for API requests
        $token = $user->createToken('app_session', [$user->role.':access'])->plainTextToken;

        if ($request->expectsJson()) {
            // Mobile/API login → return JSON + token
            return response()->json([
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // Web login → optionally store token in session 
        $request->session()->regenerate();
        session(['auth_token' => $token]);

        // Role-based redirect for web
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/dashboard');
    }

    /**
     * Destroy an authenticated session (web + mobile API).
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($request->expectsJson()) {
            // Mobile/API logout → revoke only the current token
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logged out successfully',
            ]);
        }

        // Web logout → revoke all tokens + logout session
        $user->tokens()->delete();

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Logged out successfully');
    }
}
