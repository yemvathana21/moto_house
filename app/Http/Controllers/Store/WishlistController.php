<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
class WishlistController extends Controller
{
    public function index()
    {
        $customerId = session('customer_id');
        $wishlistItems = collect();
        if (!$customerId) {
            $user = Auth::user();
            if ($user) {
                $customer = Customer::firstOrCreate(
                    ['email' => $user->email],
                    ['name' => $user->name, 'phone' => '']
                );
                $customerId = $customer->id;
            }
        }
        if ($customerId) {
            $wishlistItems = Wishlist::with('product')
                ->where('customer_id', $customerId)
                ->latest()
                ->get();
        }

        return view('store.wishlist', compact('wishlistItems'));
    }
}
