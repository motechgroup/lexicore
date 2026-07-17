<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an SMS using configured Twilio details.
     */
    public function send(string $to, string $message): bool
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');

        if (empty($sid) || empty($token) || empty($from)) {
            Log::info("SMS Mock Dispatch to {$to}: {$message}");

            return true;
        }

        try {
            $response = Http::asForm()
                ->withBasicAuth($sid, $token)
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                    'To' => $to,
                    'From' => $from,
                    'Body' => $message,
                ]);

            if ($response->successful()) {
                Log::info("SMS successfully sent to {$to} via Twilio.");

                return true;
            }

            Log::error('Twilio SMS send error status: '.$response->status().' | Body: '.$response->body());

            return false;
        } catch (\Throwable $e) {
            Log::error('Twilio SMS dispatch exception: '.$e->getMessage());

            return false;
        }
    }
}
