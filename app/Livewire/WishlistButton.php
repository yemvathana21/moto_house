<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Wishlist;
use Livewire\Component;

class WishlistButton extends Component
{
    public int $productId;
    public bool $isWishlisted = false;

    public function mount(int $productId): void
    {
        $this->productId = $productId;
        $customer = $this->getCustomer();
        if ($customer) {
            $this->isWishlisted = Wishlist::where('customer_id', $customer->id)
                ->where('product_id', $productId)
                ->exists();
        }
    }

    public function toggle(): void
    {
        $customer = $this->getCustomer();
        if (!$customer) {
            $this->dispatch('notify', message: 'Please place an order first to save wishlist items');
            return;
        }

        if ($this->isWishlisted) {
            Wishlist::where('customer_id', $customer->id)
                ->where('product_id', $this->productId)
                ->delete();
            $this->isWishlisted = false;
            $this->dispatch('notify', message: 'Removed from wishlist');
        } else {
            Wishlist::create([
                'customer_id' => $customer->id,
                'product_id' => $this->productId,
            ]);
            $this->isWishlisted = true;
            $this->dispatch('notify', message: 'Added to wishlist');
        }
    }

    private function getCustomer(): ?Customer
    {
        $id = session('customer_id');
        return $id ? Customer::find($id) : null;
    }

    public function render()
    {
        return view('livewire.wishlist-button');
    }
}
