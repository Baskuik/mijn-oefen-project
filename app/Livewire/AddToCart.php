<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AddToCart extends Component
{
    public int $productId;

    public function mount(int $productId): void
    {
        // Ensure the ID is available before any action
        $this->productId = $productId;
    }

    public function addToCart(): void
    {
        $cart = session()->get('cart', []);

        // Always fetch the product first
        $product = Product::find($this->productId);
        if (! $product) {
            // No product found; bail early
            return;
        }

        // Normalize and increment quantity
        if (isset($cart[$this->productId])) {
            if (is_array($cart[$this->productId])) {
                $cart[$this->productId]['quantity'] = ($cart[$this->productId]['quantity'] ?? 0) + 1;
            } else {
                // Legacy integer format -> convert to array
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

        // Recompute cart_count for convenience (also used server-side in some places)
        $totalItems = 0;
        foreach ($cart as $item) {
            $totalItems += is_array($item) ? (int) ($item['quantity'] ?? 0) : (int) $item;
        }
        session()->put('cart_count', $totalItems);

        // Notify listeners/UI
        $this->dispatch('cart-updated');
        $this->dispatch('product-added-to-cart', name: $product->name);
        session()->flash('success', 'Toegevoegd!');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}