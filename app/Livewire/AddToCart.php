<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AddToCart extends Component
{
    public $productId;

    public function addToCart()
    {
        $cart = session()->get('cart', []);

        // ✅ FIX: Haal het product ALTIJD op, vóór de if/else check
        $product = Product::find($this->productId);

        if (!$product) {
            return; // Product bestaat niet, stop hier
        }

        // Als het product al in het mandje zit, doe er +1 bij
        if (isset($cart[$this->productId])) {
            $cart[$this->productId]['quantity']++;
        } else {
            // Voeg nieuw product toe aan het mandje
            $cart[$this->productId] = [
                "name"     => $product->name,
                "quantity" => 1,
                "price"    => $product->price,
                "image"    => $product->image,
            ];
        }

        // Sla het nieuwe mandje op in de sessie
        session()->put('cart', $cart);

        // Update cart count voor de navbar badge
        $totalItems = 0;
        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
        }
        session()->put('cart_count', $totalItems);

        // Stuur events voor toast notificatie en cart teller
        $this->dispatch('cart-updated');
        $this->dispatch('product-added-to-cart', name: $product->name);

        // Toon een tijdelijke succesmelding
        session()->flash('success', 'Toegevoegd!');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}