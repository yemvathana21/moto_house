<?php

namespace App\Console\Commands;

use App\Mail\AbandonedCart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendAbandonedCartEmails extends Command
{
    protected $signature = 'cart:abandoned';
    protected $description = 'Send reminder emails for abandoned carts';

    public function handle()
    {
        $sessions = DB::table('sessions')
            ->where('last_activity', '<', now()->subHours(2)->timestamp)
            ->where('last_activity', '>', now()->subDays(2)->timestamp)
            ->get();

        $sent = 0;
        foreach ($sessions as $session) {
            $payload = @unserialize(base64_decode($session->payload));
            if (!$payload || !isset($payload['cart']) || empty($payload['cart'])) continue;

            $email = $payload['cart_email'] ?? null;
            if (!$email) continue;

            try {
                Mail::to($email)->queue(new AbandonedCart($payload['cart']));
                $sent++;
                $this->info("Sent to {$email}");
            } catch (\Exception $e) {
                $this->error("Failed for {$email}: {$e->getMessage()}");
            }
        }

        $this->info("Sent {$sent} abandoned cart emails");
    }
}
