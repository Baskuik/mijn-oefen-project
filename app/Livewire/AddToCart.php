<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AddToCart extends Component
{
    public $productId;

    public function addToCart()
    {
        // Haal het huidige mandje op uit de sessie, of begin met een lege lijst
        $cart = session()->get('cart', []);

        // Als het product al in het mandje zit, doe er +1 bij
        if(isset($cart[$this->productId])) {
            $cart[$this->productId]['quantity']++;
        } else {
            // Zoek het product op in de database
            $product = Product::find($this->productId);
            
            if ($product) {
                $cart[$this->productId] = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->image
                ];
            }
        }

        // Sla het nieuwe mandje weer op in de sessie
        session()->put('cart', $cart);

        // Stuur een seintje dat de winkelwagen is bijgewerkt (voor de teller later)
        $this->dispatch('cartUpdated');
        
        // Toon een tijdelijke succesmelding
        session()->flash('success', 'Toegevoegd!');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}