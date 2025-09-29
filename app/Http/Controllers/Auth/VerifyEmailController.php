<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified (web + mobile)
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Email already verified',
                    'user' => $user,
                    'email_verified' => $user->hasVerifiedEmail(),
                ]);
            }
            return redirect()->intended(route('dashboard', false).'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Email verified successfully',
                'user' => $user,
            ]);
        }

        return redirect()->intended(route('dashboard', false).'?verified=1');
    }
}
