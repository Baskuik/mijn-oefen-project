<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->count = array_sum(array_column(session()->get('cart', []), 'quantity'));
    }

    #[On('cart-updated')]
    public function refresh(): void
    {
        $this->count = array_sum(array_column(session()->get('cart', []), 'quantity'));
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}