<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AddToCartButton extends Component
{
    public $productId;
    public bool $showLoginModal = false;

    public function mount($productId)
    {
        $this->productId = (int) $productId;
    }

    public function addToCart()
    {
        if (! auth()->check()) {
            $this->showLoginModal = true;
            return;
        }

        $cart = session()->get('cart', []);
        
        // Haal product op uit database
        $product = Product::find($this->productId);
        
        if ($product) {
            if (isset($cart[$this->productId])) {
                // Check of het oude formaat is (scalar/nummer) of nieuwe formaat (array)
                if (is_array($cart[$this->productId])) {
                    // Nieuwe formaat - gewoon quantity verhogen
                    $cart[$this->productId]['quantity']++;
                } else {
                    // Oude formaat (scalar) - converteer naar nieuwe formaat
                    $oldQuantity = (int) $cart[$this->productId];
                    $cart[$this->productId] = [
                        'name' => $product->name,
                        'quantity' => $oldQuantity + 1,
                        'price' => $product->price,
                        'image' => $product->image,
                    ];
                }
            } else {
                // Nieuw product - voeg toe in nieuwe formaat
                $cart[$this->productId] = [
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                    'image' => $product->image,
                ];
            }
            
            session()->put('cart', $cart);
            $this->dispatch('cart-updated');
            $this->dispatch('product-added-to-cart', name: $product->name);
        }
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}