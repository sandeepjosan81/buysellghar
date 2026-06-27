<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioVerifyService
{
    protected Client $client;
    protected string $verifySid;
    protected string $channel;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $this->verifySid = config('services.twilio.verify_sid');
        $this->channel   = config('services.twilio.verify_channel', 'sms');
    }

    public function sendOtp(string $phone)
    {
        return $this->client->verify->v2
            ->services($this->verifySid)
            ->verifications
            ->create($phone, $this->channel);
    }

    public function verifyOtp(string $phone, string $otp)
    {
        return $this->client->verify->v2
            ->services($this->verifySid)
            ->verificationChecks
            ->create([
                'to'   => $phone,
                'code' => $otp,
            ]);
    }
}