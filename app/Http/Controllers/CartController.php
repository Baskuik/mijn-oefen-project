<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function store(Request $request)
    {
        // Block unverified users
        if (auth()->check() && ! auth()->user()->hasVerifiedEmail()) {
            if ($request->wantsJson()) {
                return response()->json(['needs_verification' => true], 403);
            }
            return back()->with('error', 'Verifieer eerst je e-mailadres.');
        }

        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'qty'        => ['nullable', 'integer', 'min:1'],
        ]);

        $qty       = $validated['qty'] ?? 1;
        $productId = $validated['product_id'];
        $cart      = session()->get('cart', []);
        $product   = Product::find($productId);

        if ($product) {
            if (isset($cart[$productId])) {
                if (is_array($cart[$productId])) {
                    $cart[$productId]['quantity'] += $qty;
                } else {
                    $oldQuantity           = (int) $cart[$productId];
                    $cart[$productId] = [
                        'name'     => $product->name,
                        'quantity' => $oldQuantity + $qty,
                        'price'    => $product->price,
                        'image'    => $product->image,
                    ];
                }
            } else {
                $cart[$productId] = [
                    'name'     => $product->name,
                    'quantity' => $qty,
                    'price'    => $product->price,
                    'image'    => $product->image,
                ];
            }
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'ok'           => true,
                'product_name' => $product?->name,
            ]);
        }

        return back()->with('status', 'Toegevoegd aan je winkelwagen!');
    }
}