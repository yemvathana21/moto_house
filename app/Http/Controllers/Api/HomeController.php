<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->take(6)
            ->get();

        $newProducts = Product::where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        $banners = Banner::where('is_active', true)
            ->where('position', 'hero')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'banners' => BannerResource::collection($banners),
            'categories' => CategoryResource::collection($categories),
            'featured_products' => ProductResource::collection($featuredProducts),
            'new_products' => ProductResource::collection($newProducts),
        ]);
    }
}
