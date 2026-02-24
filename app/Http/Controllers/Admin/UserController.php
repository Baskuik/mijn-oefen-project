<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // De index() functie mag je hier weghalen als je de lijst op de centrale /admin pagina toont.

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => $data['is_admin'],
        ]);

        // AANGEPAST: We sturen de gebruiker terug naar de centrale admin pagina
        return redirect('/admin')->with('success', 'Gebruiker succesvol aangemaakt!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'required|boolean',
        ]);

        $user->update($data);

        // AANGEPAST: We sturen de gebruiker terug naar de centrale admin pagina
        return redirect('/admin')->with('success', 'Gebruiker succesvol bijgewerkt!');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Je kunt jezelf niet verwijderen!');
        }
        
        $user->delete();
        
        // AANGEPAST: Redirect naar /admin
        return redirect('/admin')->with('success', 'Gebruiker verwijderd.');
    }
}