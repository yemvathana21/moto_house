<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;

class ShopController extends Controller
{
    public function __invoke()
    {
        $query = Product::where('is_active', true);

        if (request('category_id')) {
            $categoryId = request('category_id');
            $category = Category::find($categoryId);
            if ($category) {
                $childIds = $category->children()->pluck('id')->toArray();
                $allIds = array_merge([$categoryId], $childIds);
                $query->whereIn('category_id', $allIds);
            } else {
                $query->where('category_id', $categoryId);
            }
        }

        if (request('brand')) {
            $query->where('brand', request('brand'));
        }

        if (request('search')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }

        $sortField = request('sort', 'created_at');
        $sortDir = request('direction', 'desc');
        $allowedSorts = ['name', 'price', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        $brands = Product::where('is_active', true)->distinct()->pluck('brand')->filter();

        return view('store.shop', compact('products', 'categories', 'brands'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $reviews = Review::where('product_id', $product->id)->where('is_approved', true)->latest()->get();
        $avgRating = $reviews->avg('rating');
        $reviewsCount = $reviews->count();
        return view('store.product-detail', compact('product', 'reviews', 'avgRating', 'reviewsCount'));
    }
}
