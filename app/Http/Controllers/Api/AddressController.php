<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'addresses' => $request->user()->addresses,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'nullable|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'is_default' => 'boolean',
        ]);

        $customer = $request->user();

        if ($data['is_default'] ?? false) {
            $customer->addresses()->update(['is_default' => false]);
        }

        $address = $customer->addresses()->create($data);

        return response()->json([
            'address' => $address,
            'message' => 'Address created successfully.',
        ], 201);
    }

    public function show(Request $request, Address $address)
    {
        if ($address->customer_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json(['address' => $address]);
    }

    public function update(Request $request, Address $address)
    {
        if ($address->customer_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'label' => 'nullable|string|max:255',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'is_default' => 'boolean',
        ]);

        if (($data['is_default'] ?? false)) {
            $request->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($data);

        return response()->json([
            'address' => $address->fresh(),
            'message' => 'Address updated successfully.',
        ]);
    }

    public function destroy(Request $request, Address $address)
    {
        if ($address->customer_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $address->delete();

        return response()->json(['message' => 'Address deleted successfully.']);
    }
}
