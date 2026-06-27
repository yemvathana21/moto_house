<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with('category')
            ->withCount('reviews');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        $sortField = match ($request->sort) {
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'name_asc' => ['name', 'asc'],
            'name_desc' => ['name', 'desc'],
            'newest' => ['created_at', 'desc'],
            default => ['created_at', 'desc'],
        };
        $query->orderBy($sortField[0], $sortField[1]);

        $products = $query->paginate($request->per_page ?? 12);

        return response()->json([
            'products' => ProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'reviews' => function ($q) {
                $q->approved()->parentOnly()->with('replies');
            }])
            ->firstOrFail();

        return response()->json([
            'product' => new ProductResource($product),
        ]);
    }

    public function quickView(Product $product)
    {
        return response()->json([
            'product' => new ProductResource($product),
        ]);
    }

    public function liveSearch(Request $request)
    {
        $search = $request->get('q', '');

        $products = Product::where('is_active', true)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            })
            ->take(10)
            ->get();

        return response()->json([
            'products' => ProductResource::collection($products),
        ]);
    }

    public function storeReview(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::create([
            'product_id' => $product->id,
            'customer_id' => $request->user()->id,
            'customer_name' => $request->user()->name,
            'customer_email' => $request->user()->email,
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'is_approved' => false,
        ]);

        return response()->json([
            'review' => new ReviewResource($review),
            'message' => 'Review submitted and pending approval.',
        ], 201);
    }

    public function brands()
    {
        $brands = Product::where('is_active', true)
            ->whereNotNull('brand')
            ->select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        return response()->json(['brands' => $brands]);
    }
}
