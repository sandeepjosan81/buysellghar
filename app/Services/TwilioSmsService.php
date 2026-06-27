<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioSmsService
{
    protected Client $client;
    protected string $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $this->from = config('services.twilio.from');
    }

    public function sendOtp(string $phone, string $otp)
    {
            try {
                return $this->client->messages->create($phone, [
                    'from' => $this->from,
                    'body' => "Your OTP is {$otp}. It is valid for 10 minutes.",
                ]);
            \Log::info('Twilio Message SID: ' . $message->sid);
            } catch (\Twilio\Exceptions\TwilioException $e) {
                // Catch invalid API request data, routing problems, or account restriction issues
                \Log::error('Twilio API Exception Occurred: ' . $e->getMessage());
                \Log::error('Twilio Error Code: ' . $e->getCode());
            }
    }
}