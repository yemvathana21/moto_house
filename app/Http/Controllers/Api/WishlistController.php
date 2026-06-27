<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlist = $request->user()->wishlists()
            ->with('product.category')
            ->get()
            ->pluck('product')
            ->filter();

        return response()->json([
            'products' => ProductResource::collection($wishlist),
        ]);
    }

    public function toggle(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $existing = Wishlist::where('customer_id', $request->user()->id)
            ->where('product_id', $data['product_id'])
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['wishlisted' => false, 'message' => 'Removed from wishlist']);
        }

        Wishlist::create([
            'customer_id' => $request->user()->id,
            'product_id' => $data['product_id'],
        ]);

        return response()->json(['wishlisted' => true, 'message' => 'Added to wishlist'], 201);
    }

    public function destroy(Request $request, Product $product)
    {
        Wishlist::where('customer_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return response()->json(['message' => 'Removed from wishlist']);
    }
}
