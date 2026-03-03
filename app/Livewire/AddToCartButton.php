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
        // Debug logging
        logger()->info('AddToCart clicked!', ['product_id' => $this->productId, 'auth' => auth()->check()]);
        
        if (! auth()->check()) {
            $this->showLoginModal = true;
            return;
        }

        $cart = session()->get('cart', []);
        
        // Haal product op uit database
        $product = Product::find($this->productId);
        
        if (!$product) {
            logger()->error('Product not found', ['product_id' => $this->productId]);
            session()->flash('error', 'Product niet gevonden!');
            return;
        }
        
        logger()->info('Product found', ['product' => $product->name]);
        
        if (isset($cart[$this->productId])) {
            if (is_array($cart[$this->productId])) {
                $cart[$this->productId]['quantity']++;
            } else {
                $oldQuantity = (int) $cart[$this->productId];
                $cart[$this->productId] = [
                    'name' => $product->name,
                    'quantity' => $oldQuantity + 1,
                    'price' => $product->price,
                    'image' => $product->image,
                ];
            }
        } else {
            $cart[$this->productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }
        
        session()->put('cart', $cart);
        logger()->info('Cart updated', ['cart' => $cart]);
        
        $this->dispatch('cart-updated');
        $this->dispatch('product-added-to-cart', name: $product->name);
        
        session()->flash('success', 'Product toegevoegd aan winkelwagen!');
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}