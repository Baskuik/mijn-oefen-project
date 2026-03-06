<?php

namespace App\Livewire;

use Livewire\Component;

class CartCounter extends Component
{
    public int $count = 0;

    protected $listeners = ['cart-updated' => 'refresh'];

    public function mount(): void
    {
        $this->count = array_sum(
            array_column(session()->get('cart', []), 'quantity')
        );
    }

    public function refresh(): void
    {
        $this->count = array_sum(
            array_column(session()->get('cart', []), 'quantity')
        );
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}