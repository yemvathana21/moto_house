<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $customerId = session('customer_id');
        $wishlistItems = collect();

        if ($customerId) {
            $wishlistItems = Wishlist::with('product')
                ->where('customer_id', $customerId)
                ->latest()
                ->get();
        }

        return view('store.wishlist', compact('wishlistItems'));
    }
}
