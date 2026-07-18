<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'address' => '',
            'city' => '',
        ]);

        $token = $customer->createToken('mobile')->plainTextToken;

        return response()->json([
            'customer' => $customer,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $data['email'])->first();

        if (!$customer || !Hash::check($data['password'], $customer->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$customer->profile_photo) {
            $user = \App\Models\User::where('email', $customer->email)->first();
            if ($user && $user->profile_photo) {
                $customer->profile_photo = $user->profile_photo;
            }
        }

        $token = $customer->createToken('mobile')->plainTextToken;

        return response()->json([
            'customer' => $customer,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
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

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $customer = $request->user();

        if (!Hash::check($data['current_password'], $customer->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }

        $customer->update(['password' => Hash::make($data['new_password'])]);

        return response()->json(['message' => 'Password changed successfully.']);
    }
}
