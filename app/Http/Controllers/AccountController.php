<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    public function show(Request $request)
    {
        return view('account.index', ['user' => $request->user()]);
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required','string','email','max:255',
                Rule::unique('users')->ignore($request->user()->id),
            ],
        ]);

        $user = $request->user();
        $user->email = $request->email;
        $user->email_verified_at = null; // force re-verification
        $user->save();

        return Redirect::route('account.index')->with('status', 'email-updated');
    }
}