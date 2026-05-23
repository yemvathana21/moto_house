<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WishlistCounter extends Component
{
    public $count = 0;

    protected $listeners = ['wishlist-updated' => 'updateCount'];

    public function mount(): void
    {
        $this->updateCount();
    }

    public function updateCount(): void
    {
        $customer = $this->getCustomer();
        if ($customer) {
            $this->count = Wishlist::where('customer_id', $customer->id)->count();
        } else {
            $this->count = 0;
        }
    }

    private function getCustomer(): ?Customer
    {
        $id = session('customer_id');
        if ($id) {
            return Customer::find($id);
        }

        $user = Auth::user();
        if ($user) {
            return Customer::firstOrCreate(
                ['email' => $user->email],
                ['name' => $user->name, 'phone' => '']
            );
        }

        return null;
    }

    public function render()
    {
        return view('livewire.wishlist-counter');
    }
}
