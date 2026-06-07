<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function liveSearch()
    {
        $query = request('q');
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }
        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('brand', 'like', "%{$query}%");
            })
            ->limit(6)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'brand' => $p->brand,
                'price' => (float) $p->price,
                'compare_price' => (float) $p->compare_price,
                'image' => $p->images[0] ?? null,
                'stock' => $p->stock_quantity,
            ]);

        return response()->json($products);
    }

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

    public function quickView(Product $product)
    {
        $avgRating = $product->reviews()->approved()->avg('rating') ?? 0;
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'brand' => $product->brand,
            'price' => (float) $product->price,
            'compare_price' => (float) $product->compare_price,
            'stock_quantity' => $product->stock_quantity,
            'images' => $product->images ?? [],
            'description' => $product->description,
            'specifications' => $product->specifications ?? [],
            'avgRating' => round($avgRating, 1),
            'reviewsCount' => $product->reviews()->approved()->count(),
            'category' => $product->category?->name,
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $reviews = Review::where('product_id', $product->id)
            ->where('is_approved', true)
            ->whereNull('parent_id')
            ->with(['replies' => fn ($q) => $q->where('is_approved', true)->latest()])
            ->latest()
            ->get();
        $avgRating = $reviews->avg('rating');
        $reviewsCount = $reviews->count();

        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $recentlyViewed = session()->get('recently_viewed', []);
        $recentlyViewed = array_filter($recentlyViewed, fn ($id) => $id !== $product->id);
        array_unshift($recentlyViewed, $product->id);
        session()->put('recently_viewed', array_slice($recentlyViewed, 0, 8));

        $recentProducts = Product::whereIn('id', session()->get('recently_viewed', []))
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('store.product-detail', compact('product', 'reviews', 'avgRating', 'reviewsCount', 'relatedProducts', 'recentProducts'));
    }

    public function storeReview(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:2000',
        ]);

        $user = Auth::user();
        $customerName = $user->name;
        $customerEmail = $user->email;

        Review::create([
            'product_id' => $product->id,
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => true,
        ]);

        return back()->with('success', __('Thank you for your review!'));
    }

    public function storeReply(Request $request, string $slug, Review $review)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $validated = $request->validate([
            'comment' => 'required|string|min:5|max:2000',
        ]);

        $user = Auth::user();

        $review->replies()->create([
            'product_id' => $product->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'rating' => 0,
            'comment' => $validated['comment'],
            'is_approved' => true,
        ]);

        return back()->with('success', __('Your reply has been posted.'));
    }
}
