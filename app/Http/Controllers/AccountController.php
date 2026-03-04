<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Display the user's account information.
     */
    public function index(Request $request): View
    {
        return view('account.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's email address with confirmation.
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'confirmed', 'unique:users,email,' . $request->user()->id],
        ]);

        $user = $request->user();
        $user->email = $validated['email'];
        $user->email_verified_at = null; // Reset email verification
        $user->save();

        // Send verification email
        $user->sendEmailVerificationNotification();

        return Redirect::route('account.index')->with('status', 'email-updated');
    }

    /**
     * Send password reset link to user's email.
     */
    public function sendPasswordResetEmail(Request $request): RedirectResponse
    {
        // Send password reset link
        $status = Password::sendResetLink(
            ['email' => $request->user()->email]
        );

        return $status === Password::RESET_LINK_SENT
            ? Redirect::route('account.index')->with('status', 'password-reset-link-sent')
            : Redirect::route('account.index')->withErrors(['email' => __($status)]);
    }
}