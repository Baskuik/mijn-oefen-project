<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CartCounter extends Component
{
    #[On('cart-updated')]
    public function updateCount()
    {
        // Re-render to update count
    }

    public function render()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach ($cart as $item) {
            if (is_array($item) && isset($item['quantity'])) {
                $count += (int) $item['quantity'];
            } elseif (is_numeric($item)) {
                $count += (int) $item;
            }
        }

        return view('livewire.cart-counter', ['count' => $count]);
    }
}