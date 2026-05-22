<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __invoke()
    {
        if (request()->isMethod('post')) {
            $data = request()->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:5000',
            ]);

            try {
                Mail::raw("From: {$data['name']} ({$data['email']})\nSubject: {$data['subject']}\n\n{$data['message']}", function ($msg) use ($data) {
                    $msg->to(config('mail.from.address'))
                        ->subject('Contact Form: ' . $data['subject'])
                        ->replyTo($data['email'], $data['name']);
                });
            } catch (\Exception $e) {
            }

            return redirect('/contact')->with('success', 'Thank you for your message! We will get back to you soon.');
        }

        return view('store.contact');
    }
}
