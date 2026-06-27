<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:5000',
        ]);

        $adminEmail = Setting::getValue('contact_email', config('mail.from.address'));

        // For now just log it - in production you'd send an email or store in DB
        \Illuminate\Support\Facades\Log::info('Contact form submission', $data);

        // Create a notification or store in DB if needed
        // ContactSubmission::create($data);

        return response()->json([
            'message' => 'Your message has been received. We will get back to you soon!',
        ]);
    }
}
