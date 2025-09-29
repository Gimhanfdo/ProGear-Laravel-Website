<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification (web + mobile)
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Email already verified',
                    'user' => $user,
                ]);
            }
            return redirect()->intended(route('dashboard', false));
        }

        $user->sendEmailVerificationNotification();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Verification email resent',
                'email_verified' => $user->hasVerifiedEmail(),
            ]);
        }

        return back()->with('status', 'verification-link-sent');
    }
}
