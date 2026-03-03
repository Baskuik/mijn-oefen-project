<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AddToCartButton extends Component
{
    public $productId;
    public bool $showLoginModal = false;
    public bool $isAdding = false;
    public bool $justAdded = false;

    public function mount($productId)
    {
        $this->productId = (int) $productId;
    }

    public function addToCart()
    {
        // Start loading state
        $this->isAdding = true;
        
        // Debug logging
        logger()->info('AddToCart clicked!', ['product_id' => $this->productId, 'auth' => auth()->check()]);
        
        if (! auth()->check()) {
            $this->isAdding = false;
            $this->showLoginModal = true;
            return;
        }

        $cart = session()->get('cart', []);
        
        // Haal product op uit database
        $product = Product::find($this->productId);
        
        if (!$product) {
            logger()->error('Product not found', ['product_id' => $this->productId]);
            session()->flash('error', 'Product niet gevonden!');
            $this->isAdding = false;
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
        
        // 🔥 NIEUW: Update cart count in session
        $totalItems = 0;
        foreach ($cart as $item) {
            if (is_array($item)) {
                $totalItems += $item['quantity'];
            } else {
                $totalItems += (int) $item;
            }
        }
        session()->put('cart_count', $totalItems);
        
        logger()->info('Cart updated', ['cart' => $cart, 'cart_count' => $totalItems]);
        
        // Simulate slight delay for better UX (optional, remove if you want instant feedback)
        usleep(300000); // 0.3 second delay
        
        $this->isAdding = false;
        $this->justAdded = true;
        
        $this->dispatch('cart-updated');
        $this->dispatch('product-added-to-cart', name: $product->name);
        
        session()->flash('success', 'Product toegevoegd aan winkelwagen!');
        
        // Reset the success state after 2 seconds
        $this->dispatch('reset-button-state')->self();
    }
    
    public function resetButtonState()
    {
        $this->justAdded = false;
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}