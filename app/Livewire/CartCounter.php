<?php

namespace App\Livewire;

use Livewire\Component;

class CartCounter extends Component
{
    public $count = 0;

    protected $listeners = ['cart-updated' => 'updateCount'];

    public function mount(): void
    {
        $this->updateCount();
    }

    public function updateCount(): void
    {
        $cart = session()->get('cart', []);
        $this->count = array_sum(array_column($cart, 'quantity'));
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
