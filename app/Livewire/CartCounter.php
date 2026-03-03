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
            $count += $item['quantity'];
        }

        return view('livewire.cart-counter', ['count' => $count]);
    }
}