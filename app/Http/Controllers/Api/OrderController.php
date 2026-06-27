<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with('items')
            ->latest()
            ->paginate(10);

        return response()->json([
            'orders' => OrderResource::collection($orders),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = $request->user()->orders()
            ->with('items')
            ->findOrFail($id);

        return response()->json([
            'order' => new OrderResource($order),
        ]);
    }

    public function track(Request $request)
    {
        $data = $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::where('order_number', $data['order_number'])
            ->with('items')
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return response()->json([
            'order' => new OrderResource($order),
        ]);
    }
}
