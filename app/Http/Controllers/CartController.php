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
            if (isset($cart[$productId])) {
                // Check of het nieuwe formaat is (array) of oude formaat (int)
                if (is_array($cart[$productId])) {
                    $cart[$productId]['quantity'] += $qty;
                } else {
                    // Converteer oude formaat naar nieuwe formaat
                    $oldQuantity = (int) $cart[$productId];
                    $cart[$productId] = [
                        'name' => $product->name,
                        'quantity' => $oldQuantity + $qty,
                        'price' => $product->price,
                        'image' => $product->image,
                    ];
                }
            } else {
                // Nieuw product - voeg toe in nieuwe formaat
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