<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('store.cart', compact('cart', 'total'));
    }

    public function add(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->images[0] ?? null,
                'quantity' => 1,
            ];
        }

        if (auth()->check()) {
            session()->put('cart_email', auth()->user()->email);
        }

        session()->put('cart', $cart);
        $this->dispatchCartUpdated();

        return back()->with('success', $product->name . ' added to cart successfully!');
    }

    public function update(Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = max(1, (int) request('quantity'));

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        $this->dispatchCartUpdated();
        return back();
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        $this->dispatchCartUpdated();
        return back();
    }

    public function clear()
    {
        session()->forget('cart');
        $this->dispatchCartUpdated();
        return back();
    }

    public function buyNow(Product $product)
    {
        session()->put('cart', []);
        session()->put('cart.' . $product->id, [
            'id' => $product->id,
            'name' => $product->name,
            'price' => (float) $product->price,
            'image' => $product->images[0] ?? null,
            'quantity' => 1,
        ]);

        if (auth()->check()) {
            session()->put('cart_email', auth()->user()->email);
        }

        $this->dispatchCartUpdated();

        return redirect('/checkout');
    }

    private function dispatchCartUpdated(): void
    {
        if (class_exists(\Livewire\Livewire::class)) {
            event('cart-updated');
        }
    }
}
