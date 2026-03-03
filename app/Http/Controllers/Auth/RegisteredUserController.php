<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            // In User model staat 'password' => 'hashed' cast, dus plain wordt veilig gehashed
            'password'    => $validated['password'],
            'is_admin'    => false,
            'user_active' => true,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->intended(route('dashboard'));
    }
}