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
            $cart[$productId]['quantity']++;
            session()->put('cart', $cart);
            $this->dispatch('cart-updated');
        }
    }

    public function decreaseQuantity($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            } else {
                unset($cart[$productId]);
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
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('livewire.cart', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }
}