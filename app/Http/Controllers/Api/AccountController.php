<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function show(Request $request)
    {
        $customer = $request->user();

        if (!$customer->profile_photo) {
            $user = \App\Models\User::where('email', $customer->email)->first();
            if ($user && $user->profile_photo) {
                $customer->profile_photo = $user->profile_photo;
            }
        }

        return response()->json($customer);
    }

    public function update(Request $request)
    {
        $customer = $request->user();

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($customer->profile_photo) {
                \Storage::disk('public')->delete($customer->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $customer->update($data);

        return response()->json([
            'customer' => $customer->fresh(),
            'message' => 'Account updated successfully.',
        ]);
    }
}
