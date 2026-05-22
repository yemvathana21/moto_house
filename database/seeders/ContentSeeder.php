<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Review;
use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCategories();
        $this->seedProducts();
        $this->seedReviews();
        $this->seedPages();
        $this->seedBanners();
        $this->seedCoupons();
    }

    protected function seedCategories(): void
    {
        $categories = [
            ['name' => 'Helmets', 'description' => 'Premium motorcycle helmets for every ride'],
            ['name' => 'Gloves', 'description' => 'Riding gloves for comfort and protection'],
            ['name' => 'Jackets', 'description' => 'Motorcycle jackets for style and safety'],
            ['name' => 'Parts & Accessories', 'description' => 'Performance parts and riding accessories'],
        ];

        foreach ($categories as $i => $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'is_active' => true,
                ]
            );
        }

        $subcategories = [
            ['name' => 'Full Face', 'parent' => 'Helmets'],
            ['name' => 'Modular', 'parent' => 'Helmets'],
            ['name' => 'Open Face', 'parent' => 'Helmets'],
            ['name' => 'Summer Gloves', 'parent' => 'Gloves'],
            ['name' => 'Winter Gloves', 'parent' => 'Gloves'],
            ['name' => 'Textile Jackets', 'parent' => 'Jackets'],
            ['name' => 'Leather Jackets', 'parent' => 'Jackets'],
        ];

        foreach ($subcategories as $sub) {
            $parent = Category::where('slug', Str::slug($sub['parent']))->first();
            if ($parent) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($sub['name'])],
                    [
                        'name' => $sub['name'],
                        'parent_id' => $parent->id,
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    protected function seedProducts(): void
    {
        $products = [
            ['name' => 'AGV Sportmod Helmet', 'category' => 'Full Face', 'price' => 599.99, 'compare_price' => 699.99, 'stock' => 15, 'sku' => 'AGV-SPT-001', 'featured' => true, 'brand' => 'AGV', 'desc' => 'Premium racing helmet with carbon fiber shell, aerodynamic design, and advanced ventilation system. ECE 22.06 certified.'],
            ['name' => 'Shoei RF-1400 Helmet', 'category' => 'Full Face', 'price' => 499.99, 'stock' => 8, 'sku' => 'SHO-RF-001', 'featured' => true, 'brand' => 'Shoei', 'desc' => 'Industry-leading full-face helmet with superior noise isolation, pinlock-ready visor, and multi-density EPS liner.'],
            ['name' => 'Alpinestars SP-8 Gloves', 'category' => 'Summer Gloves', 'price' => 149.99, 'stock' => 25, 'sku' => 'ALP-SP8-001', 'featured' => true, 'brand' => 'Alpinestars', 'desc' => 'Perforated leather racing gloves with knuckle protection, palm slider, and touchscreen compatible fingertips.'],
            ['name' => 'Dainese Racing 3 Gloves', 'category' => 'Summer Gloves', 'price' => 179.99, 'stock' => 12, 'sku' => 'DAI-R3-001', 'brand' => 'Dainese', 'desc' => 'Top-tier racing gloves with carbon knuckle protection, kangaroo palm, and ergonomic pre-curved fingers.'],
            ['name' => 'Akrapovic Slip-On Exhaust', 'category' => 'Parts & Accessories', 'price' => 899.99, 'stock' => 3, 'sku' => 'AKR-SLP-001', 'featured' => true, 'brand' => 'Akrapovic', 'desc' => 'Titanium slip-on exhaust system with carbon fiber end cap. Weight reduction and deep, rich sound.'],
            ['name' => 'Brembo Brake Kit', 'category' => 'Parts & Accessories', 'price' => 349.99, 'stock' => 7, 'sku' => 'BRM-BRK-001', 'brand' => 'Brembo', 'desc' => 'High-performance brake kit with dual pistons, sintered pads, and stainless steel braided lines.'],
            ['name' => 'Oxford Heated Grips', 'category' => 'Parts & Accessories', 'price' => 89.99, 'stock' => 30, 'sku' => 'OXF-HTG-001', 'brand' => 'Oxford', 'desc' => 'Premium heated grips with 3 temperature settings, LED indicator, and universal fit for most handlebars.'],
            ['name' => 'R&G Racing Frame Sliders', 'category' => 'Parts & Accessories', 'price' => 119.99, 'stock' => 0, 'sku' => 'RNG-FSD-001', 'brand' => 'R&G', 'desc' => 'CNC-machined aluminum frame sliders with replaceable nylon pucks. Essential protection for your bike.'],
            ['name' => 'Kriega Backpack 20L', 'category' => 'Parts & Accessories', 'price' => 169.99, 'stock' => 18, 'sku' => 'KRI-BKP-001', 'featured' => true, 'brand' => 'Kriega', 'desc' => 'Waterproof motorcycle backpack with roll-top closure, quad-lock harness system, and 20L capacity.'],
            ['name' => 'Quad Lock Phone Mount', 'category' => 'Parts & Accessories', 'price' => 69.99, 'stock' => 45, 'sku' => 'QLD-MNT-001', 'brand' => 'Quad Lock', 'desc' => 'Secure smartphone mounting system with vibration dampener. Compatible with all Quad Lock cases.'],
            ['name' => 'Rev It Sand 4 Jacket', 'category' => 'Textile Jackets', 'price' => 379.99, 'compare_price' => 429.99, 'stock' => 10, 'sku' => 'RVT-SND-001', 'featured' => true, 'brand' => "Rev'it", 'desc' => 'Adventure touring jacket with hydratex laminate, detachable thermal liner, and CE-level 2 armor.'],
            ['name' => 'Dainese Avro 4 Jacket', 'category' => 'Leather Jackets', 'price' => 699.99, 'stock' => 5, 'sku' => 'DAI-AVR-001', 'brand' => 'Dainese', 'desc' => 'Legendary leather jacket with titanium shoulder inserts, microelastic inserts, and CE-certified armor.'],
        ];

        foreach ($products as $p) {
            if (Product::where('sku', $p['sku'])->exists()) continue;

            $slug = Str::slug($p['name']);
            $category = null;
            if ($p['category'] === 'Parts & Accessories') {
                $category = Category::where('slug', 'parts-accessories')->first();
            } else {
                $cat = Category::where('slug', Str::slug($p['category']))->first();
                if (!$cat) {
                    $cat = Category::where('slug', Str::slug($p['category']))->first();
                }
                $category = $cat;
            }

            $specs = [
                'weight' => rand(1, 5) . '.' . rand(0, 9) . ' kg',
                'material' => 'Premium ' . (in_array($p['brand'], ['AGV', 'Shoei']) ? 'Composite' : 'Grade-A'),
                'warranty' => '2 Years',
            ];

            if (!Storage::disk('public')->exists('products')) {
                Storage::disk('public')->makeDirectory('products');
            }

            $imgPath = 'products/' . $slug . '.svg';
            if (!Storage::disk('public')->exists($imgPath)) {
                $colors = ['ea580c', '1f2937', 'dc2626', '2563eb', '7c3aed', '059669', 'd97706', 'db2777'];
                $color = $colors[array_rand($colors)];
                $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400"><rect width="400" height="400" fill="#' . $color . '"/><text x="200" y="180" text-anchor="middle" font-family="Arial" font-size="28" fill="#fff" font-weight="bold">' . htmlspecialchars($p['name']) . '</text><text x="200" y="230" text-anchor="middle" font-family="Arial" font-size="18" fill="#ffffffcc">$' . number_format($p['price']) . '</text><circle cx="200" cy="300" r="40" fill="none" stroke="#ffffff33" stroke-width="4"/><path d="M180 300 l15 15 l25-30" fill="none" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                Storage::disk('public')->put($imgPath, $svg);
            }

            Product::create([
                'name' => $p['name'],
                'slug' => $slug,
                'description' => $p['desc'],
                'price' => $p['price'],
                'compare_price' => $p['compare_price'] ?? null,
                'stock_quantity' => $p['stock'],
                'sku' => $p['sku'],
                'category_id' => $category?->id ?? 1,
                'images' => [$imgPath],
                'is_active' => true,
                'is_featured' => $p['featured'] ?? false,
                'brand' => $p['brand'],
                'specifications' => $specs,
            ]);
        }
    }

    protected function seedReviews(): void
    {
        $products = Product::all();
        $names = ['John D.', 'Sarah M.', 'Mike R.', 'Emma L.', 'Alex K.', 'Chris P.', 'Lisa N.', 'Tom W.'];
        $comments = [
            'Excellent quality! Fits perfectly and feels very durable. Highly recommend!',
            'Great product for the price. Shipping was fast and packaging was secure.',
            'Exactly as described. Very comfortable and looks amazing on the bike.',
            'Good quality but runs a bit small. Order one size up if unsure.',
            'Outstanding customer service! Had an issue and they resolved it immediately.',
            'Best purchase I\'ve made this year. The quality exceeds my expectations.',
            'Solid construction. Been using it for 2 months now and holding up great.',
            'Amazing product! My riding buddies are jealous of my new gear.',
            'Very happy with this purchase. The fit and finish are top-notch.',
            'Decent quality for the price point. Would buy again from Moto House.',
        ];

        foreach ($products as $product) {
            $numReviews = rand(2, 5);
            for ($i = 0; $i < $numReviews; $i++) {
                Review::firstOrCreate(
                [
                    'product_id' => $product->id,
                    'customer_name' => $names[array_rand($names)],
                ],
                [
                    'customer_email' => 'customer' . rand(1, 100) . '@example.com',
                    'rating' => rand(3, 5),
                    'comment' => $comments[array_rand($comments)],
                    'is_approved' => true,
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }
    }

    protected function seedPages(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'content' => '<h2>Welcome to Moto House</h2><p>We are passionate riders dedicated to providing the best motorcycle accessories and gear. Since our founding, we have served thousands of riders across the country with premium products at competitive prices.</p><p>Our team of experienced riders personally tests and selects every product we sell, ensuring you get only the best gear for your rides.</p><h3>Our Mission</h3><p>To equip every rider with high-quality, affordable gear that enhances safety, comfort, and style on every ride.</p>',
                'meta_title' => 'About Moto House',
            ],
            [
                'title' => 'Shipping Information',
                'content' => '<h2>Shipping Policy</h2><p>We offer free shipping on all orders over $100 within the continental United States. Orders are processed within 1-2 business days.</p><h3>Delivery Times</h3><ul><li>Standard Shipping: 5-7 business days</li><li>Express Shipping: 2-3 business days</li><li>Overnight: Next business day (order before 2 PM EST)</li></ul><h3>International Shipping</h3><p>We ship worldwide. International orders typically arrive in 7-14 business days. Customs fees may apply.</p>',
                'meta_title' => 'Shipping Policy',
            ],
            [
                'title' => 'Returns & Exchanges',
                'content' => '<h2>Return Policy</h2><p>We want you to be completely satisfied with your purchase. If you\'re not happy, we accept returns within 30 days of delivery.</p><h3>Conditions</h3><ul><li>Items must be unused and in original packaging</li><li>Helmets cannot be returned if used</li><li>Electronics must be unopened</li></ul><h3>Process</h3><p>Contact our support team to initiate a return. We\'ll provide a prepaid return label. Refunds are processed within 5-7 business days after we receive the item.</p>',
                'meta_title' => 'Returns & Exchanges',
            ],
            [
                'title' => 'Privacy Policy',
                'content' => '<h2>Privacy Policy</h2><p>At Moto House, we take your privacy seriously. This policy describes how we collect, use, and protect your personal information.</p><h3>Information We Collect</h3><ul><li>Name and contact information</li><li>Shipping and billing addresses</li><li>Payment information (processed securely)</li><li>Order history</li></ul><h3>How We Use Your Information</h3><p>We use your information to process orders, provide customer support, and send relevant product updates with your consent.</p>',
                'meta_title' => 'Privacy Policy',
            ],
            [
                'title' => 'Terms of Service',
                'content' => '<h2>Terms of Service</h2><p>By using the Moto House website and purchasing our products, you agree to these terms of service.</p><h3>General</h3><p>All products are subject to availability. We reserve the right to modify or discontinue products without notice.</p><h3>Pricing</h3><p>Prices are subject to change. We strive for accuracy but errors may occur. In case of pricing errors, we will contact you before processing.</p><h3>Limitation of Liability</h3><p>Moto House shall not be liable for any indirect, incidental, or consequential damages arising from the use of our products.</p>',
                'meta_title' => 'Terms of Service',
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => Str::slug($page['title'])],
                [
                    'title' => $page['title'],
                    'content' => $page['content'],
                    'meta_title' => $page['meta_title'],
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedBanners(): void
    {
        $banners = [
            ['title' => 'Gear Up for Adventure', 'subtitle' => 'New Arrivals', 'link' => '/shop', 'sort' => 1],
            ['title' => 'Premium Riding Gear', 'subtitle' => 'Top Brands', 'link' => '/shop', 'sort' => 2],
            ['title' => 'Safety First', 'subtitle' => 'Helmets & Protection', 'link' => '/shop?category_id=1', 'sort' => 3],
        ];

        foreach ($banners as $i => $b) {
            $slug = Str::slug($b['title']);
            $imgPath = 'banners/' . $slug . '.svg';

            if (!Storage::disk('public')->exists('banners')) {
                Storage::disk('public')->makeDirectory('banners');
            }

            if (!Storage::disk('public')->exists($imgPath)) {
                $gradients = [
                    'linear-gradient(135deg, #1f2937 0%, #ea580c 100%)',
                    'linear-gradient(135deg, #0f172a 0%, #7c3aed 100%)',
                    'linear-gradient(135deg, #1e3a5f 0%, #059669 100%)',
                ];
                $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="500" viewBox="0 0 1200 500"><defs><style>.t{font-family:Arial;font-weight:bold;fill:#fff}.s{font-family:Arial;fill:#ffffffcc}</style></defs><rect width="1200" height="500" fill="#1f2937"/><circle cx="900" cy="250" r="250" fill="#ea580c" opacity="0.15"/><circle cx="1000" cy="150" r="150" fill="#ea580c" opacity="0.1"/><text x="80" y="220" class="t" font-size="52">' . htmlspecialchars($b['title']) . '</text><text x="80" y="280" class="s" font-size="20">' . htmlspecialchars($b['subtitle']) . '</text><rect x="80" y="320" width="160" height="50" rx="12" fill="#ea580c"/><text x="160" y="352" text-anchor="middle" class="s" font-size="16">Shop Now</text></svg>';
                Storage::disk('public')->put($imgPath, $svg);
            }

            Banner::firstOrCreate(
                ['title' => $b['title']],
                [
                    'subtitle' => $b['subtitle'],
                    'image' => $imgPath,
                    'link' => $b['link'],
                    'position' => 'hero',
                    'sort_order' => $b['sort'],
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedCoupons(): void
    {
        $coupons = [
            ['code' => 'WELCOME10', 'type' => 'percentage', 'value' => 10, 'min' => 50, 'uses' => 100],
            ['code' => 'SAVE20', 'type' => 'percentage', 'value' => 20, 'min' => 100, 'uses' => 50],
            ['code' => 'FLAT25', 'type' => 'fixed', 'value' => 25, 'min' => 75, 'uses' => 30],
            ['code' => 'FREESHIP', 'type' => 'percentage', 'value' => 10, 'min' => 0, 'uses' => 200],
        ];

        foreach ($coupons as $c) {
            Coupon::firstOrCreate(
                ['code' => $c['code']],
                [
                    'type' => $c['type'],
                    'value' => $c['value'],
                    'min_order_amount' => $c['min'],
                    'max_uses' => $c['uses'],
                    'used_count' => 0,
                    'is_active' => true,
                ]
            );
        }
    }
}
