<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AbandonedCart extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public array $cart;

    public function __construct(array $cart)
    {
        $this->cart = $cart;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You left something in your cart!!! - Moto House',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.abandoned-cart',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
