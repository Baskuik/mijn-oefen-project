<?php

namespace App\Livewire;

use Livewire\Component;

class AddToCartButton extends Component
{
    public int|string $productId;
    public bool $showLoginModal = false;

    public function mount(int|string $productId): void
    {
        $this->productId = $productId;
    }

    public function addToCart(): void
    {
        if (! auth()->check()) {
            $this->showLoginModal = true;
            return;
        }

        $cart = session()->get('cart', []);
        $cart[$this->productId] = ($cart[$this->productId] ?? 0) + 1;
        session()->put('cart', $cart);

        $this->dispatch('cart-updated');
        session()->flash('status', 'Product toegevoegd aan je winkelwagen!');
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}