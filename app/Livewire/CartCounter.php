<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CartCounter extends Component
{
    // Luister naar 'cart-updated' event (kebab-case)
    #[On('cart-updated')] 
    public function updateCount()
    {
        // Refresh de component automatisch
    }

    public function render()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach($cart as $item) {
            // Check of item in nieuwe formaat is (array) of oude formaat (int)
            if (is_array($item) && isset($item['quantity'])) {
                $count += $item['quantity'];
            } elseif (is_numeric($item)) {
                // Oude formaat - tel het getal op
                $count += (int) $item;
            }
        }

        return view('livewire.cart-counter', ['count' => $count]);
    }
}