<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class Cart extends Component
{
    public function increaseQuantity($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            // Check of het nieuwe formaat is (array) of oude formaat (int)
            if (is_array($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                // Converteer oude formaat naar nieuwe formaat
                $product = Product::find($productId);
                if ($product) {
                    $oldQuantity = (int) $cart[$productId];
                    $cart[$productId] = [
                        'name' => $product->name,
                        'quantity' => $oldQuantity + 1,
                        'price' => $product->price,
                        'image' => $product->image,
                    ];
                }
            }
            session()->put('cart', $cart);
            $this->dispatch('cart-updated');
        }
    }

    public function decreaseQuantity($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            // Check of het nieuwe formaat is (array) of oude formaat (int)
            if (is_array($cart[$productId])) {
                if ($cart[$productId]['quantity'] > 1) {
                    $cart[$productId]['quantity']--;
                } else {
                    unset($cart[$productId]);
                }
            } else {
                // Oude formaat - verlaag of verwijder
                $oldQuantity = (int) $cart[$productId];
                if ($oldQuantity > 1) {
                    $cart[$productId] = $oldQuantity - 1;
                } else {
                    unset($cart[$productId]);
                }
            }
            session()->put('cart', $cart);
            $this->dispatch('cart-updated');
        }
    }

    public function removeItem($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            $this->dispatch('cart-updated');
        }
    }

    public function render()
    {
        $cart = session()->get('cart', []);
        
        // Converteer oude formaat items naar nieuwe formaat voor weergave
        $normalizedCart = [];
        foreach ($cart as $productId => $item) {
            if (is_array($item)) {
                // Nieuwe formaat - gebruik zoals het is
                $normalizedCart[$productId] = $item;
            } else {
                // Oude formaat - converteer naar nieuwe formaat
                $product = Product::find($productId);
                if ($product) {
                    $normalizedCart[$productId] = [
                        'name' => $product->name,
                        'quantity' => (int) $item,
                        'price' => $product->price,
                        'image' => $product->image,
                    ];
                }
            }
        }
        
        // Update session met genormaliseerde cart
        if ($normalizedCart !== $cart) {
            session()->put('cart', $normalizedCart);
        }
        
        $total = 0;
        foreach ($normalizedCart as $item) {
            if (isset($item['price']) && isset($item['quantity'])) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        
        return view('livewire.cart', [
            'cart' => $normalizedCart,
            'total' => $total,
        ]);
    }
}