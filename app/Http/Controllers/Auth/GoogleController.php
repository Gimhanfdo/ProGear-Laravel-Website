<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Google_Client;

class GoogleController extends Controller
{
    /**
     * Redirect user to Google OAuth page
     */
    public function redirectToGoogle(Request $request)
    {
        $googleRedirect = Socialite::driver('google')->redirect();

        // For API/Flutter, return URL as JSON
        if ($request->expectsJson()) {
            return response()->json([
                'auth_url' => $googleRedirect->getTargetUrl()
            ]);
        }

        // For web, redirect normally
        return $googleRedirect;
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(Request $request)
    {
        // Just use ->user() — no stateless()
        $googleUser = Socialite::driver('google')->user();

        // Find or create user
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(16)), // random password
                'role' => 'user' // default role
            ]
        );

        // If API request → return token
        if ($request->expectsJson()) {
            $token = $user->createToken('auth_token', [$user->role . ':access'])->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        }

        // If web request → login and redirect
        Auth::guard('web')->login($user, true);
        return redirect('/dashboard');
    }

    public function mobileLogin(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        // Decode JWT manually without external package
        $jwtParts = explode('.', $request->id_token);
        if (count($jwtParts) != 3) {
            return response()->json(['message' => 'Invalid Google token'], 401);
        }

        // Decode payload
        $payload = json_decode(base64_decode(strtr($jwtParts[1], '-_', '+/')), true);

        if (!$payload || !isset($payload['email'])) {
            return response()->json(['message' => 'Invalid Google token'], 401);
        }

        $email = $payload['email'];
        $name = $payload['name'] ?? 'No Name';

        // Find or create user
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt(Str::random(16)),
                'role' => 'user',
            ]
        );

        // Create Sanctum token
        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
}
