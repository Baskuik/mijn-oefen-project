<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AddToCart extends Component
{
    public int $productId;

    public bool $showVerificationModal = false;

    public function mount(int $productId): void
    {
        $this->productId = $productId;
    }

    public function addToCart(): void
    {
        // Block unverified users
        if (auth()->check() && ! auth()->user()->hasVerifiedEmail()) {
            $this->showVerificationModal = true;
            return;
        }

        $cart = session()->get('cart', []);

        $product = Product::find($this->productId);
        if (! $product) {
            return;
        }

        if (isset($cart[$this->productId])) {
            if (is_array($cart[$this->productId])) {
                $cart[$this->productId]['quantity'] = ($cart[$this->productId]['quantity'] ?? 0) + 1;
            } else {
                $oldQty = (int) $cart[$this->productId];
                $cart[$this->productId] = [
                    'name'     => $product->name,
                    'quantity' => $oldQty + 1,
                    'price'    => $product->price,
                    'image'    => $product->image,
                ];
            }
        } else {
            $cart[$this->productId] = [
                'name'     => $product->name,
                'quantity' => 1,
                'price'    => $product->price,
                'image'    => $product->image,
            ];
        }

        session()->put('cart', $cart);

        $totalItems = 0;
        foreach ($cart as $item) {
            $totalItems += is_array($item) ? (int) ($item['quantity'] ?? 0) : (int) $item;
        }
        session()->put('cart_count', $totalItems);

        $this->dispatch('cart-updated');
        $this->dispatch('product-added-to-cart', name: $product->name);
        session()->flash('success', 'Toegevoegd!');
    }

    public function closeModal(): void
    {
        $this->showVerificationModal = false;
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}