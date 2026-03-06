<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * If someone manually visits /verify-email, just send them home.
     * Email verification is only required for adding to cart (handled in CartController).
     */
    public function __invoke(Request $request): RedirectResponse
    {
        return redirect()->route('home');
    }
}