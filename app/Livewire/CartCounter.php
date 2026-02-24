<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On; 

class CartCounter extends Component
{
    // Deze functie luistert naar het 'cartUpdated' seintje van de knop
    #[On('cartUpdated')] 
    public function updateCount()
    {
        // Refresh de component
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