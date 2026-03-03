<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['nullable','integer','min:1'],
        ]);

        $qty = $validated['qty'] ?? 1;
        $productId = $validated['product_id'];

        $cart = session()->get('cart', []);
        
        // Haal product op
        $product = Product::find($productId);
        
        if ($product) {
            if (isset($cart[$productId]) && is_array($cart[$productId])) {
                // Product bestaat al in nieuwe formaat
                $cart[$productId]['quantity'] += $qty;
            } else {
                // Nieuw product of conversie van oud formaat
                $cart[$productId] = [
                    'name' => $product->name,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'image' => $product->image,
                ];
            }
        }
        
        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'cart' => $cart]);
        }

        return back()->with('status', 'Toegevoegd aan je winkelwagen!');
    }
}