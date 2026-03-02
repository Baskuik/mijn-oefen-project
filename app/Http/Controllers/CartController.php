<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['nullable','integer','min:1'],
        ]);

        $qty = $validated['qty'] ?? 1;

        $cart = session()->get('cart', []);
        $cart[$validated['product_id']] = ($cart[$validated['product_id']] ?? 0) + $qty;
        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'cart' => $cart]);
        }

        return back()->with('status', 'Toegevoegd aan je winkelwagen!');
    }
}